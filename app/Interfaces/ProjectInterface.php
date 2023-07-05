<?php

namespace App\Interfaces;

interface ProjectInterface{
    public function getAll();
    public function findById($id);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}
