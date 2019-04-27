<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <form action="{{route('image-upload.store')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <input type="file" id="image-upload" name="image_upload[]" enctype="multipart/form-data" multiple>
      <button type="submit">save</button>
    </form>

    <script type="text/javascript">
  $(document).ready(function() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

   $('#image-upload').change(function () {
       event.preventDefault();
       var image_upload = new FormData();
       var TotalImages = $('#image-upload')[0].files.length;  //Total Images
       var images = $('#image-upload')[0];
       // for (let i = 0; i < TotalImages; i++) {
       //     image_upload.append('images' + i, images.files[i]);
       // }
       for (let i = 0; i < TotalImages; i++) {
           image_upload.append('images[]', images.files[i]);
       }
          image_upload.append('TotalImages', TotalImages);
       $.ajax({
           method: 'POST',
           url: '/ajax_upload',
           data: image_upload,
           contentType: false,
           processData: false,
           success: function (images) {
              console.log('ok ${images}');
           },
           error: function () {
             console.log('Failed')
           }
       })
     })
  });
</script>
  </body>
</html>
