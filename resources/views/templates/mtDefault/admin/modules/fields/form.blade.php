@extends('templates.'.$themes.'.admin.index')
@section('titlepage', $titlePage)
@section('content')
<div class="main-content">
	<div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    <form name="frmFormUpdate" id="frmFormUpdate" action="" method="POST">
                        <input type="text" name="txtId" value="{{ isset($data['id']) ? $data['id'] : '' }}" />
                        <input type="text" name="txtModule" value="fields" />
                        <div class="autoload-modules-content">
                            <div class="form-group">
                                <label>Customer fields</label>
                                <input type="text" value="pages" />
                                <select name="" id="">
                                    <option value="">Trang</option>
                                    <option value="">Modules</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection