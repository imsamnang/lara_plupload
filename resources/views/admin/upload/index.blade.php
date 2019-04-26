@extends('admin.layouts.template')
@section('stylesheet')
	<link href="{{asset('/assets/css/admin-upload.css')}}" rel="stylesheet" type="text/css"/>

@stop
@section('content')
<form action="{{url('/admin/upload/action')}}" method="post" enctype="multipart/form-data">
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
	<div class="row page-header multiupload" id="gallery">
		<div class="col-sm-12">
			<h1 class="">Multi Ajax Uploader</h1>
		</div>
		<div class="col-sm-6 text-right padding-top-20">
			<ul class="preview"></ul>
		</div>
		<div class="col-sm-6 text-right padding-top-20" id="container">
			<button class="btn btn-success" type="button" id="btn-select" name="btn-select" title="Upload image"><i class="fa fa-picture-o" ></i> Select Image</button>
			<button class="btn btn-primary" type="button" id="btn-upload"  name="btn-upload" title="Upload file"><i class="fa fa-upload" ></i> Upload</button>
		</div>
		<!-- /.col-lg-12 -->
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row image-view">

				</div>
			</div>
			{{-- Photo --}}
			{{-- <div class="form-group">
				<label for="ad_text" class="col control-label">Ad Photos <i class="red">*</i></label>
				<div id="plupload" class="col-8">
					<div class="row plupload_block">
						<div class="pl fleft col-12">
						<span class="drop_file_hear"></span>
							<div id="multi-upload">
							<div id="console"></div>
								<ul class="list-image list-unstyled">
									<li>
										<div id="item-1" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-1">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-2" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-2">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-3" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-3">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-4" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-4">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-5" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-5">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-6" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-6">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-7" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-7">Add Image</a>
										</div>
									</li>
									<li>
										<div id="item-8" class="item">
											<a href="javascript:;" class="btn-browse" id="browse-8">Add Image</a>
										</div>
									</li>
								</ul>
								<div class="drop_box" id="drop-image">
									<span class="image_placeholder"></span>
									<p>Drop your photo hear.</p>
								</div>
								<div class="total_status">
									<span class="current_uploads" id="current_uploads">0</span> of
									<span class="total">8</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div style="display:none;">
						<input type="hidden" id="count" value="1">
						<input type="hidden" id="csrf" value="{{csrf_field()}}">
						<input type="hidden" id="browser" value="">
					</div>
				</div>
			</div> --}}
		</div>
	</div>
</form>

@stop
@section('scripts')
	<script type="text/javascript" src="{{asset('/assets/lib/plupload/js/plupload.full.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/assets/js/admin-uploader.js') }}"></script>
@stop
