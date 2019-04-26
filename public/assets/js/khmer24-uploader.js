	$(document).ready(function(){
		var csrf = $('#csrf').val();
		var counter=1;
		var image=[];
		var limit = 8;
		var max_size = 10;
		var base_url = document.getElementById('base_url').value;
		var maxRes = 1000000;
		var multi_uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button: ["browse-1","browse-2","browse-3","browse-4","browse-5","browse-6","browse-7","browse-8"],
			url: '/action'',
			max_file_size : max_size+'mb',
			unique_names : true,
			chunk_size: '1mb',
			resize : {width : 1500, height : 1400, quality : 90, crop: false},
			filters : {
				mime_types :[
				{title : "Image files", extensions : "jpg,gif,png,jpeg"}
				],
				check_image_size: 100
			},
			drop_element : 'multi-upload',
			flash_swf_url : '/assets/lib/plupload/js/Moxie.swf',
			silverlight_xap_url : '/assets/lib/plupload/js/Moxie.xap',
		});
		multi_uploader.init();

	// FilesAdded
		multi_uploader.bind('FilesAdded', function(up, files) {
			$('#multi-upload').removeClass('drag-over');
			var i = counter;
			var j = 1;
			plupload.each(files, function(file) {
				if(i>limit) {
					multi_uploader.files.splice(j-1);
				} else {
					for (k = j; k <= limit; k++) {
						if( image['item-'+k] == undefined || image['item-'+k]=='' ) {
							image['item-'+k] = 'loading';
							$('#item-'+k).append('<div class="loading"></div>');
							$('#item-'+k).find('a.btn-browse').hide();
							break;
						}
					}
				}
				i++;
				j++;
			});
			if(counter>limit) {
				$('#console').append('<div class="error alert alert-danger">Cannot upload more image. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				multi_uploader.stop();
			} else {
				multi_uploader.start();
			}
		});
	// BeforeUpload
		multi_uploader.bind('BeforeUpload', function (up, file) {
			up.settings.multipart_params = {'csrf_test_name': csrf}
		});
	// UploadProgress
		multi_uploader.bind('UploadProgress', function(up, file) {
			$('#multi-upload').removeClass('drag-over');
			for (k = 1; k <= limit; k++) {
				if(image['item-'+k]== undefined || image['item-'+k]=='' || image['item-'+k]=='loading') {
					if($('#item-'+k).find('div.loading').length == 0) {
						$('#item-'+k).append('<div class="loading"></div>');
						$('#item-'+k).find('a.btn-browse').hide();
					}
					if($('#item-'+k).find('div.upload_percent').length != 0) {
						$('#item-'+k).find('div.percent').css( "width", file.percent+'%');
					} else {
						$('#item-'+k).append('<div class="upload_percent"><div class="percent" style="width:'+file.percent+'%"></div></div>');
					}
					break;
				}
			}
		});
	// Error
		multi_uploader.bind('Error', function(up, err) {
			$('#multi-upload').removeClass('drag-over');
			var f_size = (err.file.origSize/1024)/1024;
			var message = '';
			if(err.message) {
				if(err.file.type != "image/png" && err.file.type != "image/jpg" && err.file.type != "image/jpeg" && err.file.type != "image/gif") {
					message = 'The <strong>'+err.file.name+'</strong> wrong extension.';
				} else {
					message = err.message;
				}
				$('#console').append('<div class="error alert alert-danger">'+message+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}
			multi_uploader.refresh();
		});
	// UploadComplete
		multi_uploader.bind('UploadComplete', function(upldr, file) {
			multi_uploader.splice();
			$('.list-image').find('.upload_percent').remove();
			$('.list-image').find('.loading').remove();
			for (k = 1; k <= limit; k++) {
				if(image['item-'+k] == 'loading') {
					image['item-'+k] = '';
				}
				if(image['item-'+k] == undefined || image['item-'+k] == '') {
					$('body').find('div#item-'+k).find('a.btn-browse').show();
				}
			}
			multi_uploader.refresh();
		});
	// FileUploaded
		multi_uploader.bind('FileUploaded', function(upldr, file, object) {
			var myData;
			try {
				myData = eval(object.response);
			} catch(err) {
				myData = eval('(' + object.response + ')');
			}
			if(myData.status=='success') {
				for (k = 1; k <= limit; k++) {
					if(image['item-'+k]==undefined || image['item-'+k]=='loading' || image['item-'+k]=='') {
						$('#item-'+k).append('<div class="img"><a href="javascript:;" class="delete remove" data-img="'+myData.image+'">Delete</a><a href="javascript:;" class="image_rotate" data-img="'+myData.image+'">Rotate</a><div class="img-view"><img class="img-contain" src="'+base_url+'tmp/'+myData.thumb+'"><input name="pl_file['+k+']" type="hidden" value="'+myData.image+'" style="display:none"></div></div>');
						$('#item-'+k).find('.loading').remove();
						$('#item-'+k).find('.upload_percent').remove();
						image['item-'+k] = myData.image;
						break;
					}
				}
				if(counter>=limit) {
					multi_uploader.disableBrowse(true);
					multi_uploader.stop();
					multi_uploader.splice();
				}
				counter++;
			} else {
				$('#console').append('<div class="error alert alert-danger">'+myData.info+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				multi_uploader.splice();
				for (k = 1; k <= limit; k++) {
					if(image['item-'+k] == undefined || image['item-'+k] == '' ) {
						$('body').find('div#item-'+k).find('a.btn-browse').show();
					}
				}
			}
			$('#multi-upload').removeClass('drag-over');
			$('#current_uploads').html(counter-1);
			multi_uploader.refresh();
		});
	// check_image_size
		plupload.addFileFilter('check_image_size', function(minRes, file, cb) {
			var self = this, img = new o.Image();
			function finalize(result) {
				var msg = "Please upload image at less "+minRes+"px width and "+minRes+"px height.";
				if(img.width > 6500 || img.height > 6500) {
					msg = "Image <strong>"+img.name+"</strong> too big.";
				}
        // cleanup
        img.destroy();
        img = null;
        // if rule has been violated in one way or another, trigger an error
        if (!result) {
        	self.trigger('Error', {
        		code : plupload.IMAGE_DIMENSIONS_ERROR,
        		message : msg,
        		file : file
        	});
        }
        	cb(result);
      }
        if(file.type!="image/gif") {
        	img.onload = function() {
            // check if resolution cap is not exceeded
            finalize((img.width > minRes && img.height > minRes) && (img.width < 6500 && img.height < 6500));
        	};
        	img.onerror = function() {
        		finalize(false);
        	};
        img.load(file.getSource());
    		} else {
    		finalize(1);
	    }
		});

		$('body').on('click','.remove',function(e){
			e.preventDefault();
			var btn = $(this);
			var btn_id = btn.closest('div.item').attr('id');
			var img = $(this).attr('data-img');
			$('#console').html('');
			$('#'+btn_id).find('div.img').remove();
			$('#'+btn_id).find('div.loading').remove();
			$('#'+btn_id).find('div.upload_percent').remove();
			$('#'+btn_id).find('a.btn-browse').show();
			if(img) {
				image[btn_id] = '';
				counter--;
				if(counter<=limit) {
					multi_uploader.disableBrowse(false);
				}
				$.post(base_url+'upload/delete-image.html',{'image':img, 'csrf_test_name':csrf},function(data){
					if(data.csrf) {
						set_csrf(data.csrf);
					}
				});
			}
			for (k = 1; k <= limit; k++) {
				if(image['item-'+k] == undefined || image['item-'+k]=='') {
					$('#item-'+k).find('a.btn-browse').show();
				} else {
					// j++;
				}
			}
			$('#current_uploads').html(counter-1);
			multi_uploader.refresh();
		});

		$('body').on('click','.remove_uploaded',function(e){
			e.preventDefault();
			var btn = $(this);
			var btn_id = btn.closest('div.item').attr('id');
			var img = $(this).attr('data-img');
			var id = btn.attr('data-ad');
			if(img) {
				$('#'+btn_id).find('div.img').remove();
				$('#'+btn_id).find('div.loading').remove();
				$('#'+btn_id).find('div.upload_percent').remove();
				$('#'+btn_id).find('a.btn-browse').show();
				image[btn_id] = '';
				counter--;
				if(counter<=limit) {
					multi_uploader.disableBrowse(false);
				}
				multi_uploader.refresh();
			}
		});

		$('body').on('click','.image_rotate',function(e){
			e.preventDefault();
			var btn = $(this);
			var btn_id = btn.closest('div.item').attr('id');
			var img = $(this).attr('data-img');
			btn.closest('div.item').find('div.img-view').hide();
			btn.closest('div.item').find('a.image_rotate').hide();
			btn.closest('div.item').find('a.remove').hide();
			btn.closest('div.item').append('<div class="loading"></div>');
			$.post(base_url+'upload/image-rotate.html',{'image':img, 'csrf_test_name':csrf},function(data){
				btn.closest('div.item').find('div.img-view').show();
				btn.closest('div.item').find('a.image_rotate').show();
				btn.closest('div.item').find('a.remove').show();
				if(data.status=='success') {
					var d = new Date();
					$('#'+btn_id).find('img').attr('src',data.thumb+"?"+d.getTime());
				} else {
					$('#console').append('<div class="error alert alert-danger">'+data.in+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
				}
				$('#'+btn_id).find('div.loading').remove();
				if(data.csrf) {
					set_csrf(data.csrf);
				}
			},'json');
		});

		$('body').on('click','#console .remove',function(e){
			var msg = $(this);
			msg.closest('div.error').slideUp(function(){
				msg.closest('div.error').remove();
			});
		});
		var timer;
		$('#multi-upload').bind('dragover', function(){
			$(this).addClass('drag-over');
			$('#multi-upload').find('div.error').remove();
		});

		$('#multi-upload').bind('dragleave mouseleave', function(){
			var t = 300;
			clearTimeout(timer);
			timer = setTimeout( function() { removeDragDrop(); },t);
		});

		function removeDragDrop() {
			$('#multi-upload').removeClass('drag-over');
		}

		function set_csrf(csrf) {
			csrf = csrf;
			$('input[name="csrf_test_name"]').val(csrf);
		}   $('#csrf').val(csrf);

		function check_file() {
			$('input.pl_file_uploaded').each(function(index){
				image['item-'+(index+1)] = $(this).val();
			});
			counter = $('input.pl_file_uploaded').length+1;
		}
		check_file();

		$('.btn-close-modal').click(function(e){
			e.preventDefault();
			$('#account-question').modal('hide');
		});

    $(".number").keypress(function(evt) {
            if (evt.keyCode != 8) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault)
                        theEvent.preventDefault();
                }
            }
        });
        $('.phone a').click(function(e) {
            e.preventDefault();
            // $(this).closest('div').addClass('d-none');
            // $(this).closest('div').find('input').val('');
            if($(this).attr('data-id') == 'add') {
                if($( "body" ).find('div.phone-2').hasClass( "d-none" )) {
                    $('.phone-2').removeClass('d-none');
                } else {
                    $('.phone-3').removeClass('d-none');
                    $('a.add_phone').addClass('d-none');
                }
            } else {
                if ($(this).attr('data-id') == 'phone-2') {
                    if($('input[name="phone-3"]').val()) {
                        $('input[name="phone-2"]').val($('input[name="phone-3"]').val());
                        $('input[name="phone-3"]').val('');
                    } else {
                        if($('input[name="phone-2"]').val()) {
                            $('input[name="phone-2"]').val('');
                        } else {
                            if(!$('input[name="phone-2"]').val()) {
                                $('.phone-2').addClass('d-none');
                            }
                            $('.phone-3').addClass('d-none');
                            $('a.add_phone').removeClass('d-none');
                        }

                    }
                }

                if ($(this).attr('data-id') == 'phone-3') {
                    if($('input[name="phone-3"]').val()) {
                        $('input[name="phone-3"]').val('');
                    } else {
                        $('a.add_phone').removeClass('d-none');
                        $('.phone-3').addClass('d-none');
                        $('input[name="phone-3"]').val('');
                    }
                }
            }
        });
        $('.phone input').on('keypress keyup focus change', function() {
            if ($(this).val()) {
                var input_name = $(this).attr('name');
                if (input_name == 'phone-1') {
                    $('.phone-2').removeClass('d-none');
                }
                if (input_name == 'phone-2') {
                    $('.phone-3').removeClass('d-none');
                }
            }
        });
	});
