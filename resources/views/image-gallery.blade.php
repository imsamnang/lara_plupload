<!DOCTYPE html>
<html>
<head>
  <title>Image Gallery Example</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- References: https://github.com/fancyapps/fancyBox -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

  <style type="text/css">
    .gallery {
      display: inline-block;
      margin-top: 20px;
    }
    .close-icon {
    	border-radius: 50%;
      position: absolute;
      right: 5px;
      top: -10px;
      padding: 5px 8px;
    }
    .form-image-upload{
      background: #e8e8e8 none repeat scroll 0 0;
      padding: 15px;
    }
    input[type=file]{
      display: inline;
    }
    #image_preview{
      border: 1px solid black;
      padding: 10px;
    }
    #image_preview img{
      width: 100px;
      padding: 5px;
    }    
  </style>

</head>
<body>


<div class="container">

  <h3>Laravel - Image Gallery CRUD Example</h3>
  <form action="{{ url('image-gallery') }}" class="form-image-upload" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
      </div>
    @endif

    <div class="row">
      <div class="col-md-5">
        <strong>Title:</strong>
        <input type="text" name="title" class="form-control" placeholder="Title">
      </div>
      <div class="col-md-5">
        <strong>Image:</strong>
        <input type="file" name="image[]" id="uploadFile" class="form-control" multiple="true">
      </div>
      <div class="col-md-2">
        <br/>
        <button type="submit" class="btn btn-success" id="btn-upload">Upload</button>
      </div>
    </div>
  </form> 
{{-- display image gallery --}}
  <div class="row">
    <div class='list-group gallery'>
      @if($images->count())
      @foreach($images as $image)
      <div class='col-sm-2 col-xs-2 col-md-2 col-lg-2'>
        <a class="thumbnail fancybox" rel="ligthbox" href="/images/gallery/{{ $image->image }}">
          <img class="img-responsive" alt="{{ $image->image }}" src="/images/gallery/{{ $image->image }}" />
        </a>
        <form action="{{ url('image-gallery',$image->id) }}" method="POST">
          <input type="hidden" name="_method" value="delete">
          {!! csrf_field() !!}
          <button type="submit" class="close-icon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
        </form>
      </div> <!-- col-6 / end -->     
      @endforeach
      @endif
    </div> <!-- list-group / end -->
  <div id="image_preview"></div>    
  </div> <!-- row / end -->
</div> <!-- container / end -->

</body>
<script type="text/javascript">
  $(document).ready(function(){
    $('#image_preview').hide();
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
  });
</script>

<script type="text/javascript">
  $("#uploadFile").change(function(){
    $('#image_preview').show();
    $('#image_preview').html("");
    var total_file=document.getElementById("uploadFile").files.length;
    for(var i=0;i<total_file;i++)
    {
      // $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
      $('#image_preview').append("<a class='thumbnail fancybox' rel='ligthbox' href='"+URL.createObjectURL(event.target.files[i])+"'");
      $('#image_preview').append("<img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"' />");
      $('#image_preview').append("</a>");
      $('#image_preview').append("<button type='submit' class='close-icon btn btn-danger'><i class='glyphicon glyphicon-remove'></i></button>");
    }
  });

  $('#btn-upload').on('click',function(){
    $('#image_preview').hide();
  });
</script>
</html>


