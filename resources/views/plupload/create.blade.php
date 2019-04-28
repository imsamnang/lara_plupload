
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet" position="1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/purify.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" type="text/javascript"></script>

  <!-- the main fileinput plugin file -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fa/theme.js"></script>
  <!-- <script <s></s>rc="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/locales/(lang).js"></script> -->
</head>
<body>

<div class="container">
  <div class="col-lg-12 col-sm-12 col-l1 main-section">
    <h1> Upload Image </h1>
      <form enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group">
              <div class="file-loading">
                  <input id="input-zone" name="file" type="file" multiple="" tabindex="-1" class="file-no-browse" data-overwrite-initial="false" data-min-file-count="2" data-theme="fa">
              </div>
          </div>
      </form>
  </div>
</div>
<script>
  jQuery(function ($) {
    $("#input-zone").fileinput({
        uploadUrl: "/image-submit",
        showBrowse: false,
        browseOnZoneClick: true,
        uploadExtraData:function(){
         return{
          _token:$("input[name='_token']").val()
         };
        },
        allowedFileExtensions:['jpg','jpeg','png','gif'],
        overwriteInitial:false,
        maxFileSize:2000,
        maxFileCount: 8,
        slugCallback:function(filename){
         return filename.replace('(','_').replace(']','_');
        }        
    });
  });
</script>


</body>
</html>
