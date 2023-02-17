<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>Thông Tin Khách Hàng</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form>
            <div class="input_field"> <span><i class="fa-solid fa-user"></i></i></span>
                <input type="text" id="contactName" placeholder="Họ và Tên" required />
            </div>
            <div class="input_field"> <span><i class="fa-solid fa-phone"></i></span>
                <input type="text" id="contactPhoneNum" placeholder="Số Điện Thoại" required />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                <input type="text" id="contactEmail" placeholder="Email" required />
            </div>
            <div class="input_field"> <span><i class="fa-solid fa-pen"></i></i></span>
              <input type="text" id="contactNote" placeholder="Ghi chú" required />
            </div>
            <input type="hidden" id="c_id" value="{{ $id }}">
            <input class="button save-contact" type="submit" value="Gửi Thông Tin" />
          </form>
        </div>
      </div>
    </div>
</div>
