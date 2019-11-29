<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    private $resource_path = 'upload';

    public function index(){
        return view('upload.index',
        [
            'public_path' => public_path()
        ]);
    }

    public  function uploadFile(Request $request){
        $imageName = $request->file->getClientOriginalName();
        $request->file->move(public_path('upload'), $imageName);
    	return response()->json(['uploaded' => '/upload/'.$imageName]);
    }
 
}
