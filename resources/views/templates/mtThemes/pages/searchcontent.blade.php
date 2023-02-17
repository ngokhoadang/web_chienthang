@extends('templates.'.$themes.'.index')
@section('titlepage', $titlePage)
@section('content')
    <div class="main-content">
        <div class="show-body">
            <div class="body-container">
                <div class="showcontent-header">
                    <div class="breadchume">SITEMAP TO HERE > Category</div>
                </div>
            </div>
            <div class="body-container">
                <div class="showcontent-body">
                    @if(isset($data) && !empty($data))
                    <div class="grid-layout  grap3column">
                        @foreach ($data as $items)
                            <div class="article-items">
                                <div class="article-image"><img src="{{ asset($items['image']) }}" alt="{{ $items['title'] }}" /></div>
                                <h4 class="article-title"><a href="{{ isset($items['art_link']) ? $items['art_link'] : '#' }}">{{ $items['title'] }}</a></h4>
                                <div class="article-intro">{{ $items['intro'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <div class="">Content is update</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection