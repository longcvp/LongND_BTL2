@extends('_layout.layout')
@section('title')
Tạo ví
@endsection
@section('content')
    <div class="conten-wrapper">
        <section class="content container-fluid">
            <div class="container">
                <h2>Tạo ví cá nhân</h2>
                <form class="form-horizontal" method="POST" action="{{ route('wallets.store') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Tên ví <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>   
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="col-md-4 control-label">Mã bí mật <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="code" type="password" class="form-control" name="code" value="{{ old('code') }}" required autofocus>

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group{{ $errors->has('re_code') ? ' has-error' : '' }}">
                        <label for="re_code" class="col-md-4 control-label">Nhập lại mã bí mật <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="re_code" type="password" class="form-control" name="re_code" value="{{ old('re_code') }}" required autofocus>

                            @if ($errors->has('re_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('re_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
                        <label for="money" class="col-md-4 control-label">Số tiền trong ví <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="money" type="number" mim = "0" step="10000" class="form-control" name="money" value="{{ old('money') }}" required autofocus>

                            @if ($errors->has('money'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('money') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                                      
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Tạo ví
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
