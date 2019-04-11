<?php
/**
 * Created by PhpStorm.
 * User: Kimbriel
 * Date: 4/2/2019
 * Time: 2:57 PM
 */

namespace App\Repositories\Todo;


use App\Http\Controllers\BaseController;
use App\Models\Todo;

class TodoRepository extends BaseController implements TodoInterface
{
    private $model;

    public function __construct(Todo $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $this->loadWithRelatedModel();
        $this->_search();
        return $this->getResultList($this->model->latest());
    }

    public function show($id)
    {
        $this->loadWithRelatedModel();
        $this->model = $this->model->find($id);
        return $this->response($this->model);
    }

    public function store(array $request)
    {
        $this->model->create([
            'date'          => $request['date'],
            'title'         => $request['title'],
            'description'   => $request['description'],
        ]);

        return $this->response($request, 200);
    }

    public function update(array $request, $id)
    {
        $this->model->find($id)->update([
            'date'          => $request['date'],
            'title'         => $request['title'],
            'description'   => $request['description'],
        ]);
        return $this->response($request, 200);;
    }

    public function delete($id)
    {
        $this->model = $this->model->find($id);
        $data =  $this->model;
        $this->model->delete();
        return $this->response($data,200);
    }

    public function _search(){

    }

    public function loadWithRelatedModel(){
        $this->model = $this->model->with([]); //lazy loader
    }
}