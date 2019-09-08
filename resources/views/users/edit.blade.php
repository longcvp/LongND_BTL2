@extends('_layout.layout')
@section('title')
Sửa thông tin cá nhân
@endsection
@section('content')
    <div class="conten-wrapper">
        <section class="content container-fluid">
            <div class="container">
                <h2>Cập nhật thông tin cá nhân</h2>
                <form class="form-horizontal" method="POST" action="{{ route('users.update', Auth::user()->id) }}" enctype="multipart/form-data" >
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Tên <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->infomation->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group" >
                        <label for="avatar" class="col-md-4 control-label">Ảnh đại diện</label>
                        <div class="col-md-2">
                            <img src="{{ asset(Auth::user()->infomation->avatar) }}" style="width: 150px; height: 100px;">
                        </div>
                        <div class="col-md-1">
                            <label for="avatar" class="control-label">Thay đổi</label>
                        </div>                        
                        <div class="col-md-3">
                            <input type="file" class="form-control" id="avatar" accept="image/*" name="avatar">
                        </div>

                    </div>   
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address" class="col-md-4 control-label">Địa chỉ<span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="address" type="string" class="form-control" name="address" value="{{ Auth::user()->infomation->address }}" required autofocus>

                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Số điện thoại <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="phone" type="string" class="form-control" name="phone" value="{{ '0'.Auth::user()->infomation->phone }}" required autofocus>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Email <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group" {{ $errors->has('gender') ? ' has-error' : '' }}>
                        <label for="gender" class="col-md-4 control-label">Giới tính <span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="gender" id="gender" required>
                                <option selected value="">Chọn</option>
                                <option value="1" @if (Auth::user()->infomation->gender == 1) selected @endif>Nam</option>
                                <option value="2" @if (Auth::user()->infomation->gender == 2) selected @endif>Nữ</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label for="birthday" class="col-md-4 control-label">Ngày tháng năm sinh<span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="birthday" type="date" class="form-control" name="birthday" value="{{ Auth::user()->infomation->birthday }}" required autofocus>

                            @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                                       
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Thay đổi
                            </button>
                            <a href="{{ route("users.index") }}" type="button" class="btn btn-info">Quay lại</a>
                        </div>

                    </div>
                 </form>
            </div>
        </section>  
    </div>
@endsection
@section('css')
<style type="text/css">
    h2 {
        text-align: center;
    }
    .error {
        color: red;
    }
</style>
@endsection
