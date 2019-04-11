<?php
/**
 * Created by PhpStorm.
 * User: Kimbriel
 * Date: 4/11/2019
 * Time: 1:01 AM
 */

namespace App\Http\Controllers;


use App\Models\Todo;
use App\Repositories\Todo\TodoInterface;
use App\Repositories\Todo\TodoRepository;
use Illuminate\Http\Request;

class TodoController extends BaseController
{
    private $todo;

    public function __construct(TodoInterface $todo)
    {
        $this->todo = $todo;
    }

    public function index()
    {
        return $this->todo->index();
    }

    public function show($id)
    {
        return $this->show($id);
    }

    public function store(Request $request)
    {
        return $this->todo->store($request->all());
    }

    public function update(Request $request, $id)
    {

        return $this->todo->update($request->all(), $id);;
    }

    public function delete($id)
    {
        return $this->todo->delete($id);;
    }

    public function _search(){

    }

    public function loadWithRelatedModel(){
        $this->model = $this->model->with([]); //lazy loader
    }
}