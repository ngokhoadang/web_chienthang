@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.admin.blocks.webaction')
@section('content')
<script>
	$(function(){
		var baseurl	= parse_url([app_url, app_page, app_module, 'list-json']);
		loadServerSideAjax('#autoload-girdview-table', baseurl, [
			@if(isset($modules_config['cols']) && !empty($modules_config['cols']))
				@foreach($modules_config['cols'] as $k=>$items)
					{width: {{ $items['width'] }}, targets: [{{$k}}], class: "{{$items['class']}}", data: '{{$items["keys"]}}'},
				@endforeach
			@endif
		]
		@if(isset($modules_config['config']) && !empty($modules_config['config']))
			@foreach($modules_config['config'] as $config_items)
				@if(is_array($config_items))
					,[
						@foreach($config_items  as $k=>$items)
							@if($k < count($config_items)-1)
								@if(intval($items) > 0) {{$items}} @else '{{$items}}' @endif,
							@else
									@if(intval($items) > 0) {{$items}} @else '{{$items}}' @endif
							@endif
						@endforeach
					]
				@else
					,{{ $config_items }}
				@endif
			@endforeach
		@endif
		);
	});
</script>
<div class="main-content">
	<div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table id="autoload-girdview-table" class="table table-bordered table-hover">
                    @include('templates.'.$themes.'.admin.blocks.datatable')
                </table>
            </div>
        </div>
    </div>
</div>
<div class="clr"></div>
@include('templates.'.$themes.'.admin.blocks.modalbox')
@endsection