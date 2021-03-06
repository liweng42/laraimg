<!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>多图片上传</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
    .container {
    margin-top:2%;
    }
    </style>
    </head>
    <body>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8"><h2>多文件上传</h2>
                </div>
            </div>
            <br>
            <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <form action="{{ route('file_upload') }}" method="post" enctype="multipart/form-data">                    
                    <div class="form-group">
                        <label for="accessId">accessId</label>
                        <input type="text" name="accessId" class="form-control"  placeholder="accessId" >
                    </div>
                    <div class="form-group">
                        <label for="accessKey">accessKey</label>
                        <input type="text" name="accessKey" class="form-control"  placeholder="accessKey" >
                    </div>
                    <div class="form-group">
                        <label for="destPath">destPath</label>
                        <input type="text" name="destPath" class="form-control"  placeholder="destPath" >
                    </div>
                    <div class="form-group">
                        <label for="generateNewFileName">generateNewFileName</label>
                        <input type="text" name="generateNewFileName" class="form-control"  placeholder="generateNewFileName: true or false" >
                    </div>                    
                    <label for="destPath">选择文件（可以选择多个）</label>
                    <br />
                    <input type="file" class="form-control" name="photos[]" multiple />
                    <br /><br />
                    <input type="submit" class="btn btn-primary" value="Upload" />
                </form>
            </div>
            </div>
        </div>
    </body>
    </html>