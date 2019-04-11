<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;

abstract class BaseController extends Controller
{

    protected $paginate_limit = 30;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function response($data, $message = '', $code = 200)
    {
        $response = array(
            'data' => $data,
            'message' => $message,
            'status_code' => $code,
            'status' => true,
        );

        return response($response, $code);
    }

    protected function getResultList($model)
    {
        if (request()->has('showAll')) {
            if (request()->get('showAll') == '1') {
                $data = $model->get();
                return $this->response($data, 'Returned ' . $data->count() . ' results');
            }
        }
        if (request()->has('limit')) {
            $this->setPaginateLimit((int)request()->get('limit'));
        }

        $data = $model->paginate($this->paginate_limit)->appends(array_merge(request()->all(), ['limit' => $this->paginate_limit]));

        return $this->response($data, 'Returned ' . $data->count() . ' results');
    }

    public function setPaginateLimit($paginate_limit)
    {
        $this->paginate_limit = $paginate_limit;
    }

    protected function enableSearch($allowedField, $model)
    {
        if (request()->has('searchBy') && request()->has('search')) {

            if (in_array(request()->get('searchBy'), $allowedField)) {

                return $model->where(request('searchBy'), 'like', "%" . \trim(request('search')) . "%");
            }
        }

        return $model;
    }
    protected function enableSorting($sortableFields, $model)
    {
        if (request()->has('sort_by')) {
            $order = request('order') ?: 'ASC';
            if (in_array(request()->get('sort_by'), $sortableFields)) {
                return $model->orderBy(request('sort_by'), $order);
            }
        }
        return $model;
    }

    protected function enableExactSearch($allowedField, $model)
    {
        if (request()->has('searchBy') && request()->has('search')) {
            if (in_array(request()->get('searchBy'), $allowedField)) {
                return $model->where(request('searchBy'), request('search'));
            }
        }

        return $model;
    }

    protected function enableDateFilter($field, $model)
    {
        if (request()->get('searchBy') == $field) {
            return $this->filterByDate(request()->get('dateFrom'), request()->get('dateTo'), $model, $field);
        }
        return $model;
    }

    protected function enableDateMonthFilter($field, $model)
    {
        if (request()->get('searchBy') == $field) {
            $model = $model->whereRaw('MONTH('.$field.') = '.request()->get('search'));
        }
        return $model;
    }

    protected function filterByDate($dateFrom, $dateTo, $model, $field = 'created_at')
    {
        if (strtotime($dateFrom) != false)
            $model = $model->whereDate($field, '>=', (new Carbon($dateFrom))->toDateString());

        if (strtotime($dateTo) != false)
            $model = $model->whereDate($field, '<=', (new Carbon($dateTo))->toDateString());

        return $model;
    }

    protected function searchInRelatedModel($table, $model, $allowedField)
    {
        if (request()->has('searchBy') && request()->has('search')) {

            if (in_array(request()->get('searchBy'), $allowedField)) {

                $model = $model->whereHas($table, function ($query) {
                    $query->where(request()->get('searchBy'), 'like', "%".request()->get('search')."%");
                });
                return $model;
            }
        }

        return $model;

    }



}
