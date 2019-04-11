<?php
/**
 * Created by PhpStorm.
 * User: Kimbriel
 * Date: 4/2/2019
 * Time: 2:56 PM
 */

namespace App\Repositories\Todo;


interface TodoInterface
{
    public function index();
    public function show($id);
    public function store(Array $request);
    public function update(Array $request, $id);
    public function delete($id);
}