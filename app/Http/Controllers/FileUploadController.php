<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;



class FileUploadController extends Controller
{
    //
    private $accessId;
    private $accessKey;
    private $allowedfileExtension;

    public function __construct(){
        $this->accessId = config('accessauth.accessId');
        $this->accessKey = config('accessauth.accessKey');
        $this->allowedfileExtension = config('accessauth.allowedfileExtension');
    }

    public function index(){
        return view('upload.index',
        [
            'public_path' => public_path()
        ]);
    }

    public function upload(Request $request){
        $this->validate($request, [
            'accessId' => 'required',
            'accessKey' => 'required',
            'destPath' => 'required',
            'photos'=>'required',
            ]);
            $accessId = $request->accessId;
            // dd($request->accessId);
            $accessKey = $request->accessKey;
            $destPath = $request->destPath;
            $imgUrls = array();
            if (!$this->checkAccessIdAndKey($accessId, $accessKey)){
                return response()->json(['code' => '401','msg' => 'accessKey error.']);
            }
            else {
                if($request->hasFile('photos')){
                    $files = $request->file('photos');
                    foreach($files as $file){
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $check=in_array($extension, $this->allowedfileExtension);
                        //dd($check);
                        if($check){
                            foreach ($request->photos as $photo) {
                                //校验目录以及不存在创建
                                $path = public_path($destPath);
                                File::isDirectory($path) or mkdir(iconv("UTF-8", "GBK", $path), 0777, true); 
                                $imageName = $photo->getClientOriginalName();     
                                $photo->move($path, $imageName);
                                $imgUrl = URL::to($destPath, $imageName,true);        
                                $imgUrls[] = $imgUrl;                                                     
                            }
                            return response()->json(['code' => '200','msg' => 'success', 'uploaded' => $imgUrls ]);     
                        }
                        else{
                            return response()->json(['code' => '403','msg' => 'forbidden, only for '. implode(',', $this->allowedfileExtension) ]);    
                        }
                    }
                }
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
