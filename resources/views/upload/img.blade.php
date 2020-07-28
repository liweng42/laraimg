<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Access-Control-Allow-Origin" content="*">
        <title>HTML5 File Drag and Drop Upload with jQuery and PHP | liuyanwei</title>
        
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="/css/styles.css" />
        
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    
    <body>



		<header>
			<h1>ImagesUploadWebSite</h1><i>html5+php</i>
		</header>


		<div id="dropbox">
			<span class="message">拖拽图片至区域后完成上传<br /><i>上传成功后会弹出图片地址</i></span>
		</div>
		
        <footer>
	        || <h2>jumppo 图床 </h2> ||
            <a href="http://liuyanwei.jumppo.com">作者:刘彦玮</a> ||
            <a href="https://github.com/coolnameismy/ImagesUploadWebSite">代码地址：github</a> ||
        </footer>

        <div class="succeed">
            <!--<div class="message">上传成功</div>-->
            <div class="imgmarkdown row"></div>
        </div>

        <!-- 用户配置文件 -->
        <script src="/js/config.js"></script>

        <!-- Including The jQuery Library -->
		<script src="/js/jquery-1.6.3.min.js"></script>
		
		<!-- Including the HTML5 Uploader plugin -->
		<script src="/js/jquery.filedrop.js"></script>
		
		<!-- The main script file -->
        <script src="/js/script.js"></script>



    </body>
</html>

