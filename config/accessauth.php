<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Access Authentication
    |--------------------------------------------------------------------------
    |
    | accessId
    | 
    | accessKey
    |
    */    
 'accessId' => env('ACCESSID', "yKr6a8XifzM9eYPs"),
 'accessKey' => env('ACCESSKEY', "JpQxByjX1xFMuM96A4rgupvHxBx6QkVF"),
 'allowedfileExtension' => ['jpg','png','jpeg','gif'],
 //上传文件的根目录，默认为空，指向网站当前的根目录，即 /public
 'uploadRootPath' => ''
];