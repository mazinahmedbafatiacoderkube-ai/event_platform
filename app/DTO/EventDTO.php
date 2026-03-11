<?php

namespace App\DTO;

class EventDTO
{

public $title;
public $description;
public $start_time;
public $end_time;

public function __construct($request)
{

$this->title = $request->title;
$this->description = $request->description;
$this->start_time = $request->start_time;
$this->end_time = $request->end_time;

}

}