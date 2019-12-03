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
            //校验参数合法性，自动带上 / 前缀
            $destPath = '/' . ltrim($destPath, '/');
            $destPath = dirname($destPath);
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
                                //校验目录以及不存在创建，上传的服务器真实路径
                                $realPath = public_path($this->uploadRootPath);                            
                                $path = $realPath.$destPath;
                                // dd($path);
                                File::isDirectory($path) or mkdir(iconv("UTF-8", "GBK", $path), 0777, true); 
                               
                                if ($generateNewFileName == 'true') {
                                    $imageName = md5($filename.uniqid(mt_rand().microtime(true),true)).'.'.$extension;
                                }
                                else {
                                    $imageName = $photo->getClientOriginalName();     
                                }
                                
                                $photo->move($path, $imageName);
                                $url = $this->uploadRootPath.$destPath;
                                $imgUrl = URL::to($url, $imageName,true);        
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
