@extends('_layout.layout')
@section('title')
Đăng kí tài khoản
@endsection
@section('content')
	<div class="conten-wrapper">
        <section class="content container-fluid">
			<div class="container">
				<h2>Đăng kí tài khoản</h2>
				@if($errors->has('errorlogin'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ $errors->first('errorlogin') }}
					</div>
				@endif
                <div class="panel panel-default">
                    <div class="panel-heading">Đăng kí tài khoản</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('signup') }}" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <p style="text-align: center;"><span class="error">* required field</span></p>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Tên <span class="error">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email <span class="error">*</span></label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Tên đăng nhập <span class="error">*</span></label>

                                <div class="col-md-6">
                                    <input id="username" type="string" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Mật khẩu <span class="error">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                <label for="confirm_password" class="col-md-4 control-label">Nhập lại mật khẩu <span class="error">*</span></label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="confirm_password" required>

                                    @if ($errors->has('confirm_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('confirm_password') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                            </div>                                       
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Đăng kí
                                    </button>
                                    <a href="{{ route("login.index") }}" type="button" class="btn btn-info">Quay lại</a>
                                </div>

                            </div>
                            </form>
                            </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('css')
	<style type="text/css">
        body {
          margin: 0;
          padding: 0;
          background-color: #17a2b8;
          height: 100vh;
        }
		h2 {
			text-align: center;
		}
        .error {
            color: red;
        }
	</style>
@endsection