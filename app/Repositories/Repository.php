<?php

namespace App\Repositories;

interface Repository
{
    public function get($key);
    public function create($data);
    public function delete($data);
    public function update($data);
}