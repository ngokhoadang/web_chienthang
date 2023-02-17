@php
	// Session::forget('banner_slide');
    $bannerSlide   = Session::has('banner_slide') ? Session::get('banner_slide') : [];
@endphp
<div class="banner-slide">
	<div class="swiper-bannerslide" style="position: relative; overflow: hidden;">
		<div class="swiper-wrapper">
            @if(isset($bannerSlide) && !empty($bannerSlide))
                @foreach ($bannerSlide as $banners)
                    @if(isset($bannerSlide) && !empty($bannerSlide))
                        @foreach ($bannerSlide as $banners)
                            <div class="swiper-slide">
                                <a href="{{ isset($banners['lien_ket']) ? $banners['lien_ket'] : '' }}">
                                    <img src="{{ isset($banners['hinh_anh']) ? asset($banners['hinh_anh']) : '' }}" alt="{{ isset($banners['tieu_de']) ? asset($banners['tieu_de']) : '' }}" />
                                </a>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
		</div>
		<!-- Add Arrows -->
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>
</div>
<script>
	var swiper = new Swiper('.swiper-bannerslide', {
		autoplay: {
		    delay: 2500,
		},
		pagination: {
	        el: '.swiper-pagination',
	    },
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
</script>