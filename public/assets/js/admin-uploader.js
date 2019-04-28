var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'btn-select', // Set the button for selecting pictures
    container: document.getElementById('container'), // Set the ID that covers the image selection button and the upload button
    url : '/', // Set the path to send to upload pictures
		flash_swf_url : '/assets/lib/plupload/js/Moxie.swf',
		silverlight_xap_url : '/assets/lib/plupload/js/Moxie.xap',
    filters : {
        max_file_size : '10mb',
        mime_types: [
            {title : "Image files", extensions : "jpg,gif,png,jpeg,bmp,svg"},
            {title : "Zip files", extensions : "zip"}
        ]
    },
    init: {
        PostInit: function() {
            document.getElementById('btn-upload').onclick = function() {
                uploader.start();
                return false;
            };
        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                preview.showImagePreview( file ,file.id);
            });
            preview.removeImagePreview();
        },

        UploadProgress: function(up, file) {
            console.log('File ID : '+file.id);
            document.getElementById('thumbs-'+file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },

        Error: function(up, err) {
            document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
        },

        UploadComplete: function(up, files) {
            display();
            $('#gallery .preview').html('');
            console.log('Upload Complete');
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

uploader.init();
