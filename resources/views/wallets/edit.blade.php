@extends('_layout.layout')
@section('title')
Sửa thông tin ví
@endsection
@section('content')
    <div class="conten-wrapper">
        <section class="content container-fluid">
            <div class="container">
                <h2>Sửa thông tin ví</h2>
                <form class="form-horizontal" method="POST" action="{{ route('wallets.update', $wallet->id) }}" enctype="multipart/form-data" >
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="id" value="{{ $wallet->id }}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Tên ví <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $wallet->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>   
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="col-md-4 control-label">Mã bí mật (Nhập mã để thay đổi thông tin) <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="re_code" type="password" class="form-control" name="code" value="{{ old('re_code') }}" required autofocus>

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                                 
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Thay đổi
                            </button>
                            <a href="{{ route("wallets.index") }}" type="button" class="btn btn-info">Quay lại</a>
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
