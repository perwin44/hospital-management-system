<?php

namespace App\Interfaces\Sections;

interface SectionRepositoryInterface
{
    //get all sections
public function index();

//store sections
public function store($request);


//update sections
public function update($request);


//destroy sections
public function destroy($request);

//show sections
public function show($id);
}
