{{-- @php print_r($data); exit(); @endphp --}}
@if(isset($data) && !empty($data))
<div class="grid-layout  grap3column">
    @foreach ($data as $items)
        <div class="article-items">
            <div class="article-image"><img src="{{ asset($items['image']) }}" alt="{{ $items['title'] }}" /></div>
            <h4 class="article-title"><a href="{{ isset($items['art_link']) ? $items['art_link'] : '#' }}"><span>{{ $items['title'] }}</span></a></h4>
            <ul class="article-post">
                <li>Bởi: <span class="author">{{ $items['author'] }}<span></li>
                <li class="datetime">Lúc: {{ $items['date_post'] }}</li>
            </ul>
            <div class="article-intro">{{ $items['intro'] }}</div>
        </div>
    @endforeach
</div>
@else
    <div class="">Content is update</div>
@endif