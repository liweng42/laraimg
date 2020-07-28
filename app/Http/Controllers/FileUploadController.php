<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    //
    private $accessId;
    private $accessKey;
    private $allowedfileExtension;
    private $uploadRootPath;

    public function __construct(){
        $this->accessId = config('accessauth.accessId');
        $this->accessKey = config('accessauth.accessKey');
        $this->allowedfileExtension = config('accessauth.allowedfileExtension');
        $this->uploadRootPath = config('accessauth.uploadRootPath');    
    }

    public function index(){
        return view('upload.index');
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
            //destPath 需要带 / 前缀，指向上传文件的根目录
            $destPath = $request->destPath;
            //默认是不产生新文件名，不传值认为是false
            if ($request->generateNewFileName) {
                $generateNewFileName = $request->generateNewFileName;
            }
            else {
                $generateNewFileName = false;
            }
        return $this->uploadFile($accessId, $accessKey, $destPath, $generateNewFileName, $request);

    }

    private function uploadFile($accessId, $accessKey, $destPath, $generateNewFileName, $request){
        //校验参数合法性，自动带上 / 前缀
        $destPath = '/' . ltrim($destPath, '/');
        // $destPath = dirname($destPath);
        $imgUrls = array();
        if (!$this->checkAccessIdAndKey($accessId, $accessKey)){
            return response()->json(['code' => '401','msg' => 'accessKey error.']);
        }        
        else {
            if($request->hasFile('photos')){
                Log::info('upload file');
                $files = $request->file('photos');
                if (is_array($files)) {                    
                    foreach($files as $file){
                        $imgUrls[] = $this->moveToFile($file, $destPath, $generateNewFileName);
                    }
                    return response()->json(['code' => '200','msg' => 'success', 'uploaded' => $imgUrls ]);  
                }
                else {
                    $file = $request->file('photos');
                    Log::info('file: '.$file);
                    $imgUrls[] = $this->moveToFile($file, $destPath, $generateNewFileName);
                    return response()->json(['code' => '200','msg' => 'success', 'uploaded' => $imgUrls ]);  
                }
            }
        }        
    }

    private function moveToFile($file, $destPath, $generateNewFileName){
        $filename = $file->getClientOriginalName();       
        Log::info('filename: '. $filename);             
        $extension = $file->getClientOriginalExtension();
        $check=in_array($extension, $this->allowedfileExtension);
        //dd($check);
        if($check){
            //校验目录以及不存在创建，上传的服务器真实路径
            $realPath = public_path($this->uploadRootPath);                            
            $path = $realPath.$destPath;
            Log::info('path: '. $path);
            File::isDirectory($path) or mkdir(iconv("UTF-8", "GBK", $path), 0777, true); 
            
            if ($generateNewFileName == 'true') {
                $imageName = md5($filename.uniqid(mt_rand().microtime(true),true)).'.'.$extension;
            }
            else {
                $imageName = $file->getClientOriginalName();     
            }
            
            $file->move($path, $imageName);
            $url = $this->uploadRootPath.$destPath;
            $imgUrl = URL::to($url, $imageName, true);        

            Log::info('imgUrl: '. $imgUrl);    
            return $imgUrl;
        }
        else{
            //扩展名限制不允许上传
            // return response()->json(['code' => '403','msg' => 'forbidden, only for '. implode(',', $this->allowedfileExtension) ]);       
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

    public function img(){
        return view('upload.img');
    }

    public function imgUpload(Request $request){
        //destPath 需要带 / 前缀，指向上传文件的根目录
        $destPath = '/upload/image/'.date("Y").date("m"); //需要创建的文件夹目录;
        Log::info('destPath: '. $destPath);
        //默认是不产生新文件名，不传值认为是false
        $generateNewFileName = true;
        return $this->uploadFile($this->accessId, $this->accessKey, $destPath, $generateNewFileName, $request);
    }
 
}
