@if($images)
	@foreach($images as $img)
		<div class="col-xs-2 gallery">
			<img src="{{asset('images/uploads/plupload/'.$img->image_name)}}" />
		</div>
	@endforeach
@endif
