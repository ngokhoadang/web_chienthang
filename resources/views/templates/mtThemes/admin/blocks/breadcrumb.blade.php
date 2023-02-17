<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
  <div class="header-buttons">
    @isset($header_buttons)
      @foreach($header_buttons as $bItems)
        <a href="{{ isset($bItems['url']) ? $bItems['url'] : '' }}" class="{{ isset($bItems['class']) ? $bItems['class'] : 'btn btn-primary btn-sm' }}">{!! isset($bItems['icon']) ? $bItems['icon'] : '' !!} {{ isset($bItems['name']) ? $bItems['name'] : '' }}</a>
      @endforeach
    @endisset
  </div>
  <div style="clear:both"></div>
</section>