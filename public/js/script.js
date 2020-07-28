

$(function(){

	var dropbox = $('#dropbox'),
		message = $('.message', dropbox);

	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'photos',

		maxfiles: 5,
    	maxfilesize: 2,
		url: '/img_upload',
		// uploadFinished:function(i,file,response){
		// 	$.data(file).addClass('done');
		// 	// response is the JSON object that post_file.php returns
		// 	// alert(response.filename);
        //     uploadSucceed(response.filename);
		// },

		uploadFinished: function(i,file,res){  
			console.log(res);    
			var code = res.code;
			console.log('code:'+code);
			console.log('msg:'+res.msg);       
			if (code == 200){       
				$.data(file).addClass('done');
				uploadSucceed(res.uploaded);
			}
			else {
				// s_msg = res.msg;
				// nowStatus = false;
				showMessage(res.msg);
			}
		},

    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					break;
			}
		},

		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');

				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},

		uploadStarted:function(i, file, len){
			createImage(file);
		},

		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		}

	});

	var template = '<div class="preview">'+
						'<span class="imageHolder">'+
							'<img />'+
							'<span class="uploaded"></span>'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
						'</div>'+
					'</div>';


	function createImage(file){

		var preview = $(template),
			image = $('img', preview);

		var reader = new FileReader();

		image.width = 100;
		image.height = 100;

		reader.onload = function(e){

			// e.target.result holds the DataURL which
			// can be used as a source of the image:

			image.attr('src',e.target.result);
		};

		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);

		message.hide();
		preview.appendTo(dropbox);

		// Associating a preview container
		// with the file, using jQuery's $.data():

		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}
});



//显示图片上传成功
var uploadSucceed = function(urls){
    // var imageUrl = domain + "/"+ name;
    // var wwwUrl = "http://"+ imageUrl;
    $(".succeed").show();
    // $(".imgname").find("b").text(name);
    // $(".imgurl").find("b").html("<a href='"+wwwUrl+"' target='_blank'>"+wwwUrl+"</a>");
	// $(".imghtml").find("b").text("<img src="+ wwwUrl +"/>");
	var str = '';
	for(j = 0; j < urls.length; j++) {
		console.log(urls[j]);
		str += "![]("+ urls[j]  +")" + "<br/>";		
	}
	// $(".imgmarkdown").find("b").text();		
	$(".imgmarkdown").append(str);
    
}
