<div class="frm-search">
    <form action="{{ url('tim-kiem.html') }}" name="frmSearch" id="frmSearch" method="GET">
        <div class="search-box">
            <input type="hidden" name="module" value="articles" />
            <div class="search-input">
                <input type="text" name="keys" value="{{ isset($_GET['keys']) ? $_GET['keys'] : '' }}" placeholder="Tìm kiếm gì đó....">
                <button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>
            </div>
        </div>
    </form>
</div>