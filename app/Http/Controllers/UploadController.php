<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;



class UploadController extends Controller
{
    //
    private $resource_path = 'upload';
    private $accessId = '1';
    private $accessKey = 'abc';

    public function index(){
        return view('upload.index',
        [
            'public_path' => public_path()
        ]);
    }

    public function uploadFile(Request $request){
        $accessId = $request['accessId'];
        $accessKey = $request['accessKey'];
        $destPath = $request['destPath'];
        
        if (!$this->checkAccessIdAndKey($accessId, $accessKey)){
            return response()->json(['code' => '401','msg' => '$accessKey error.']);
        }
        else {
            //校验目录以及不存在创建
            $path = public_path($destPath);
            File::isDirectory($path) or mkdir(iconv("UTF-8", "GBK", $path), 0777, true); 
            
            $imageName = $request->file->getClientOriginalName();     
            $request->file->move($path, $imageName);
            $imgUrl = URL::to($destPath, $imageName,true);
            return response()->json(['code' => '200','msg' => 'success', 'uploaded' => $imgUrl ]);
        }
    }

    public function checkAccessIdAndKey($accessId, $accessKey)
    {
        if ($accessId == $this->accessId && $accessKey == $this->accessKey) {
            return true;
        }
        else {
            return false;
        }
    }

 
}
