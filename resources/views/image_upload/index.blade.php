<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('assets\bower_components\bootstrap\dist\css\bootstrap.min.css')}}">
  <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('assets/js/popper.min.js')}}"></script>
  <script src="{{asset('assets\bower_components\bootstrap\dist\js\bootstrap.min.js')}}"></script>
  <link rel="stylesheet" href="{{asset('css/upload.css')}}">
</head>
<body>
<div class="container">
  <form action="{{route('image.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group">
    <label for="ad_text" class="col control-label">Ad Photos <i class="red">*</i></label>
    <div class="col-8">
      <div class="row plupload_block">
        <div class="pl fleft col-12">
        <!-- Code Begins -->
          <input style="display:none;" type="file" name="imageGalleries[]" id="vpb-data-file" onchange="vpb_image_preview(this)" multiple="multiple" />
          <div align="center" style="width:300px;">
            <!-- Browse File Button -->
            <span class="vpb_browse_file" onclick="document.getElementById('vpb-data-file').click();"></span>
          </div>
        </div>
        <div style="width:710px; margin-top:5px;" align="center" id="vpb-display-preview">
          @if (isset($images))
            @foreach ($images as $image)
              <div id="selector_{{$image->id}}" class="vpb_wrapper">
                <img class="vpb_image_style" class="img-thumbnail" src="{{asset('uploads/Image_Crud/'.$image->image)}}"
                alt="{{$image->image}}" /><br />
                <a style="cursor:pointer;padding-top:5px;" title="Click here to remove"
                onclick="vpb_remove_selected()">Remove</a>
              </div>
            @endforeach
          @endif
        </div>
      <!-- Code Begins -->
      </div>
      <div class="clear"></div>
    </div>
  </div>
    <div class="form-group">
      <input type="submit" name="btnsave" value="Upload" class="btn btn-primary">
    </div>
</form>
</div>
  @include('image_upload.script')
</body>
</html>
