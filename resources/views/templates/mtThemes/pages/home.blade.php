@extends('templates.'.$themes.'.index')
@section('titlepage', $titlePage)
@include('templates.'.$themes.'.blocks.webstyles')
@section('content')
    <div class="main-content">
        @if(isset($pageType) && $pageType == 'list')
            <div class="show-body">
                <div class="body-container">
                    @include('templates.'.$themes.'.blocks.breadcrumb')
                </div>
            </div>
        @endif
        @if(isset($layout_data))
            @foreach ($layout_data as $key=>$items)
                <div class="show-body body-line{{ ($key+1) }}">
                    <div class="body-container">
                        @foreach ($items as $detail_data)
                            <div class="{{ $detail_data['class'] }}">
                                @foreach ($detail_data['layout'] as $layout_items)
                                    @if(is_array($layout_items))
                                    {{-- @php print_r($layout_items); @endphp --}}
                                        @foreach ($layout_items as $layout_detail)
                                            @if($layout_detail['type'] == 'columns')
                                                <h2 class="widget-title">OK fine</h2>
                                                {{-- @if($layout_detail['title'] != '')
                                                    <div class="widgetTitle">
                                                        <h2 class="widget-title">{{ $layout_detail['title'] }}</h2>
                                                    </div>
                                                @endif
                                                @if($layout_detail['content'] != '')
                                                    <div class="widgetContent">
                                                        <div class="widget-content">@include($layout_detail['content'])</div>
                                                    </div>
                                                @endif --}}
                                            @endif
                                            @if($layout_detail['type'] == 'default')
                                                @if($layout_detail['title'] != '')
                                                    <div class="widgetTitle">
                                                        <h2 class="widget-title">{{ $layout_detail['title'] }}</h2>
                                                    </div>
                                                @endif
                                                @if($layout_detail['content'] != '')
                                                    <div class="widgetContent">
                                                        <div class="widget-content">@include($layout_detail['content'])</div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($layout_detail['type'] == 'contents')
                                                @if($layout_detail['title'] != '')
                                                    <div class="widgetTitle">
                                                        <h2 class="widget-title">{{ $layout_detail['title'] }}</h2>
                                                    </div>
                                                @endif
                                                @if(!empty($layout_detail['content']))
                                                    <div class="widgetContent">
                                                        <div class="grid-layout  {{ $layout_detail['column'] }}">
                                                            @foreach ($layout_detail['content'] as $items)
                                                                <div class="article-items">
                                                                    @if(in_array('content_image', $layout_detail['info']))
                                                                        <div class="article-image"><img src="{{ isset($items['image']) ? asset($items['image']) : '' }}" /></div>
                                                                    @endif
                                                                    @if(in_array('content_title', $layout_detail['info']))
                                                                        <h4 class="article-title"><a href="{{ $items['art_link'] }}"><span>{{ isset($items['title']) ? $items['title'] : '' }}</span></a></h4>
                                                                    @endif
                                                                    @if(in_array('content_update', $layout_detail['info']))
                                                                        <ul class="article-post">
                                                                            <li class="author">Bởi: {{ $items['author'] }}</li>
                                                                            <li class="datetime">Lúc: {{ $items['date_post'] }}</li>
                                                                        </ul>
                                                                    @endif
                                                                    @if(in_array('content_intro', $layout_detail['info']))
                                                                        <p class="article-intro">{{ $items['intro'] }}</p>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($layout_detail['type'] == 'widget')
                                                @if($layout_detail['title'] != '')
                                                    <div class="widgetTitle">
                                                        <h2 class="widget-title">{{ $layout_detail['title'] }}</h2>
                                                    </div>
                                                @endif
                                                @if($layout_detail['content'] != '')
                                                    <div class="widgetContent">
                                                        <div class="widget-content">{!! $layout_detail['content'] !!}</div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        @if($layout_items['type'] == 'default')
                                            @if($layout_items['title'] != '')
                                                <div class="widgetTitle">
                                                    <h2 class="widget-title">{{ $layout_items['title'] }}</h2>
                                                </div>
                                            @endif
                                            @if($layout_items['content'] != '')
                                                <div class="widgetContent">
                                                    <div class="widget-content">@include($layout_items['content'])</div>
                                                </div>
                                            @endif
                                        @endif
                                        @if($layout_items['type'] == 'contents')
                                            @if($layout_items['title'] != '')
                                                <div class="widgetTitle">
                                                    <h2 class="widget-title">{{ $layout_items['title'] }}</h2>
                                                </div>
                                            @endif
                                            @if(!empty($layout_items['content']))
                                                <div class="widgetContent">
                                                    <div class="grid-layout">
                                                        @foreach ($layout_items['content'] as $items)
                                                            <div class="article">
                                                                <div class="article-image"><img src="{{ asset($items['image']) }}" /></div>
                                                                <h4 class="article-title"><a href="{{ $items['link'] }}">{{ $items['title'] }}</a></h4>
                                                                <p class="article-intro">{{ $items['intro'] }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        @if($layout_items['type'] == 'widget')
                                            @if($layout_items['title'] != '')
                                                <div class="widgetTitle">
                                                    <h2 class="widget-title">{{ $layout_items['title'] }}</h2>
                                                </div>
                                            @endif
                                            @if($layout_items['content'] != '')
                                                <div class="widgetContent">
                                                    <div class="widget-content">{!! $layout_items['content'] !!}</div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection