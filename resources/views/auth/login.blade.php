@extends('_layout.layout')
@section('title')
Đăng nhập hệ thống quản lý tài chính cá nhân
@endsection
@section('content')
    <div class="conten-wrapper">
        <section class="content container-fluid">
            <div class="container">
                <h2>Đăng nhập</h2>
                @if($errors->has('errorlogin'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $errors->first('errorlogin') }}
                    </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                      <p>{{ session('success') }}</p>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                      <p>{{ session('error') }}</p>
                </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Đăng nhập</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">Tên đăng nhập</label>

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
                                    <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" value="" required autofocus>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>                                                     
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Đăng nhập
                                            </button>                                            
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('signup.index') }}" class="btn btn-success" type="button">Đăng kí</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('reset.index') }}" tabindex="5" class="forgot-password">Quên mật khẩu?</a>
                                        </div>
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
        .forgot-password {
            text-decoration: underline;
            color: red;
            font-style : italic;
        }
        .forgot-password:hover,
        .forgot-password:focus {
            text-decoration: underline;
            color: #666;
        }
    </style>
@endsection