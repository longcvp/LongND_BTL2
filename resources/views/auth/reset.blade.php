@extends('_layout.layout')
@section('title')
Đặt lại mật khẩu
@endsection
@section('content')
	<div class="conten-wrapper">
        <section class="content container-fluid">
			<div class="container">
				<h2>Đặt lại mật khẩu</h2>
				@if($errors->has('errorlogin'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ $errors->first('errorlogin') }}
					</div>
				@endif
                <div class="panel panel-default">
                    <div class="panel-heading">Đặt lại mật khẩu</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('reset') }}" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <p style="text-align: center;"><span class="error">* required field</span></p>
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
                            <div class="form-group{{ $errors->has('re_email') ? ' has-error' : '' }}">
                                <label for="re_email" class="col-md-4 control-label">Nhập lại email <span class="error">*</span></label>

                                <div class="col-md-6">
                                    <input id="re_email" type="email" class="form-control" name="re_email" value="{{ old('re_email') }}" required autofocus>

                                    @if ($errors->has('re_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('re_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>                                    
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Đặt lại mật khẩu
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