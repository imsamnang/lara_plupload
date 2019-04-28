<script type="text/javascript">
  var csrf = $('#csrf').val();
  var counter=1;
  var image=[];
  var limit = 8;
  var max_size = 10;
  var maxRes = 1000000;
  var multi_uploader = new plupload.Uploader({    
      runtimes : 'html5,flash,silverlight,html4',
      // browse_button : 'btn-select', // Set the button for selecting pictures
      browse_button: ["browse-1","browse-2","browse-3","browse-4","browse-5","browse-6","browse-7","browse-8"],
      container: document.getElementById('plupload'), // Set the ID that covers the image selection button and the upload button
      url : '/pl_action', // Set the path to send to upload pictures
          flash_swf_url : '/assets/lib/plupload/js/Moxie.swf',
          silverlight_xap_url : '/assets/lib/plupload/js/Moxie.xap',
      filters : {
          max_file_size : '10mb',
          mime_types: [
              {title : "Image files", extensions : "jpg,gif,png"},
              {title : "Zip files", extensions : "zip"}
          ]
      },
      init: {
          // PostInit: function() {
          //     document.getElementById('btn-upload').onclick = function() {
          //         uploader.start();
          //         return false;
          //     };
          // },

          FilesAdded: function(up, files) {
            // plupload.each(files, function(file) {
            //     preview.showImagePreview( file ,file.id);
            // });
            // preview.removeImagePreview();
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
          },

          UploadProgress: function(up, file) {
              // console.log('File ID : '+file.id);
              // document.getElementById('thumbs-'+file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
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
          },

          Error: function(up, err) {
              // document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
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
          },

          UploadComplete: function(up, files) {
              // display();
              // $('#gallery .preview').html('');
              // console.log('Upload Complete');
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
          }
      },
         //Attach variable values
      multipart_params: {
          _token : $("#_token").val(),'btn-multiupload':''
      },

  });

  // function For displaying images before uploading
  var preview = {
      showImagePreview   : function( file , id) {
          var item = $( '<li id="thumbs-'+ id + '"><b></b><a href="'+ id +'" class="color-red del-preview glyphicon glyphicon-off"></a></li>' ).prependTo( '#gallery .preview' );
          var image = $( new Image() ).appendTo(item);
          var preloader = new mOxie.Image();
          preloader.onload = function() {
              preloader.downsize( 100, 100 );
              image.prop({ "src": preloader.getAsDataURL(),'id':id,'class':'img-preview'} );
          };
          preloader.load( file.getSource() );
      },

      removeImagePreview  :   function (){
          $('.del-preview').on('click',function(e){
              e.preventDefault();
              var thumb  = $('#thumbs-' + $(this).attr('href'));
              thumb.remove();
          });
      }
  }

  // Ajax Display all images
  var display = function(){
      $('.image-view').html('Loading...');
      $.ajax({url : '/preview',
        success : function(data){
        $('.image-view').html(data);
        }
      });
  }
  display();

  multi_uploader.init();
    
</script>