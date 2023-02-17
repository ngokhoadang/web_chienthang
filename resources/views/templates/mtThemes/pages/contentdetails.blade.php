@extends('templates.'.$themes.'.index')
@section('titlepage', $titlePage)
@section('content')
    <div class="main-content">
        <div class="show-body">
            <div class="body-container">
                @include('templates.'.$themes.'.blocks.breadcrumb')
            </div>
            <div class="body-container">
                <div class="showcontent-body">
                    <!-- SHOW TITLE CONTENT -->
                    @if(isset($data['title']))
                        <div class="showcontent-title">Post By: {{ $data['title'] }}</div>
                    @endif
                    <!-- SHOW AUTHOR, POST TIME -->
                    <div class="showcontent-update">
                        @if(isset($data['author']))
                            <span class="author">Post By: {{ $data['author'] }}</span>
                        @endif
                        @if(isset($data['date_post']))
                            <span class="datetime">Post time: {{ $data['date_post'] }}</span>
                        @endif
                    </div>
                    <!-- SHOW CONTENT INTRO IF CONFIG -->
                    @if(isset($data['intro']))
                        <div class="showcontent-intro">{!! $data['intro'] !!}</div>
                    @endif
                    <!-- SHOW CONTENT DETAIL -->
                    @if(isset($data['content']))
                        <div class="showcontent-content">{!! $data['content'] !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection