@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<script>
	$(function(){
		loadServerSideAjax('#autoload-girdview-table', app_url+'/'+app_page+'/cartorder/load-list-json?config_key={{ isset($_GET['config_key']) ? $_GET['config_key'] : '' }}&st={{ isset($_GET['st']) ? $_GET['st'] : '' }}&search_st={{ isset($_GET['search_st']) ? $_GET['search_st'] : '' }}&date_start={{ isset($_GET['date_start']) ? $_GET['date_start'] : '' }}&date_end={{ isset($_GET['date_end']) ? $_GET['date_end'] : '' }}', [
			@if(isset($modules_config['cols']) && !empty($modules_config['cols']))
				@foreach($modules_config['cols'] as $k=>$items)
					{width: {{$items->width}}, targets: [{{$k}}], class: '{{$items->class}}', data: '{{$items->key}}' @if($items->type == 'number') ,render: $.fn.dataTable.render.number(',', '.', 0, '') @endif},
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
@endsection