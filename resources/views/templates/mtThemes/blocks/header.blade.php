@php
    $header_footer   = Session::has('header_footer') ? Session::get('header_footer') : [];
    // Session::forget('header_footer');
@endphp
@if(isset($header_footer['header']))
            @foreach ($header_footer['header'] as $key=>$items)
                <div class="show-header header-line{{ ($key+1) }}">
                    <div class="header-container">
                        @foreach ($items as $detail_data)
                            <div class="{{ $detail_data['class'] }}">
                                @foreach ($detail_data['layout'] as $layout_items)
                                    {{-- @php print_r($layout_items);  exit(); @endphp --}}
                                    @if(is_array($layout_items))
                                        @foreach ($layout_items as $layout_detail)
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
                                                        <div class="grid-layout">
                                                            @foreach ($layout_detail['content'] as $items)
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
