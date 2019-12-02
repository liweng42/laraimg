<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index(){
        return response()->json(['code' => '200','msg' => 'success']);   
    }

    public function post(){
        return response()->json(['code' => '200','msg' => 'post']);   
    }
}
