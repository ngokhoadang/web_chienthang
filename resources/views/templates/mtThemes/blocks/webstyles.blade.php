@section('webstyles')
    @if(isset($webstyle) && !empty($webstyle))
        @foreach ($webstyle as $items)
            @if(isset($items['style_file']) && $items['style_file'] != '')
                <link rel="stylesheet" href="{!! url($items['style_file']) !!}">
            @endif
        @endforeach
    @endif
@endsection