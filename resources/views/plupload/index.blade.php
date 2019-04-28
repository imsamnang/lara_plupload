<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <title>Bootstrap File Field Plugin Examples</title>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/css/bootstrap_file_field.css') }}">
  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/fileinput.css') }}" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="col-md-12">
        <h3>Bootstrap File Field Plugin Examples</h3>
        <hr>
        <form role="form" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="sample3[]"
                       data-field-type="bootstrap-file-filed"
                       data-label="Select Image Files"
                       data-btn-class="btn-primary"
                       data-file-types="image/jpeg,image/png,image/gif"
                       data-preview="on"
                       multiple
                >
            </div>
        </form>

    </div>

    <p class="clearfix"></p><hr>


</div> <!-- /container -->



<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/src/js/bootstrap_file_field.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('.smart-file').bootstrapFileField({
          maxNumFiles: 2,
          fileTypes: 'image/jpeg,image/png',
          maxFileSize: 800000 // 80kb in bytes
      });
  });
</script>

</body>
</html>
