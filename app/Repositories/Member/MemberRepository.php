<?php
/**
 * Created by PhpStorm.
 * User: Kimbriel
 * Date: 4/2/2019
 * Time: 2:57 PM
 */

namespace App\Repositories\Member;


use App\Http\Controllers\BaseController;
use App\Models\Member;

class MemberRepository extends BaseController implements MemberInterface
{
    private $model;

    public function __construct(Member $model)
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

    }

    public function update(array $request, $id)
    {

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