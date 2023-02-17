<div class="center">
    <ul class="crumb1">
        <li><a href="http://web.chienthang.net/">Trang Chủ</a></li>
        <li ><a href="" id="link">
            @php
            echo $titlePage ;
            @endphp
        </a></li>

    </ul><br>
</div>


<script type="text/javascript">
    var curURL = '<?php echo url()->current(); ?>';
    document.getElementById("link").href = curURL;
</script>
