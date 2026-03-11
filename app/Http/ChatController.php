<?php

namespace App\Http\Controllers;

class ChatController extends Controller
{

public function index()
{

$messages=[];

return view('chat.index',compact('messages'));

}

}