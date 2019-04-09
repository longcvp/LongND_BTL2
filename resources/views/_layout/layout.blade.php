<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id = "csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản lý tài chính cá nhân')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- jquery ui -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
          @yield('css')
    <style type="text/css">
        .img-head {
            width:32px; 
            height:32px; 
            position: absolute; 
            top: 10px; 
            left: 10px; 
            border-radius:50%;
        }

        
        
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    @guest 
    @elseif(Auth::user()->reset_password == 1 && url()->current() !=  route('password.show', Auth::id()) )
    <script>
        alert('Bạn cần đổi mật khẩu trước !');
        window.location = "{{ route('password.show', Auth::id()) }}";
    </script>
    @endguest
</head>
<body>

    <div id="topheader">
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="{{ route('users.index') }}">Quản lý tài chính cá nhân</a>
                </div>
                @guest           
                @else
                <ul class="nav navbar-nav">
                  <li><a data-toggle="tab" href="{{ route('users.index') }}">Thông tin cá nhân</a></li>
                  <li><a data-toggle="tab"  href="{{ route('wallets.index') }}">Quản lý ví</a></li>
                  <li><a data-toggle="tab"  href="#">Danh mục chi tiêu</a></li>
                  <li><a data-toggle="tab"  href="#">Quản lý giao dịch</a></li>
                </ul>             
                @endguest
                <ul class="nav navbar-nav navbar-right">
                    
                        @guest
                        <li class="dropdown navbar-nav">
                            <a class="dropdown-toggle" href="{{ route('login.index') }}">Đăng nhập</span></a>
                        </li>
                         <li class="dropdown navbar-nav">
                            <a class="dropdown-toggle" href="{{ route('signup.index') }}">Đăng kí</span></a>
                        </li>              
                        @else
                        <li class="dropdown navbar-nav">
                            <a href="{{ route('users.index') }}" class="dropdown-toggle" data-toggle="dropdown" style="position: relative; padding-left:50px;">
                                <img src="{{ asset(Auth::user()->infomation->avatar) }}" class="img-head">
                                {{ Auth::user()->infomation->name }} 
                                <span class="caret">
                            </a>    
                        </li>
                        <li class="dropdown navbar-nav">
                            <a href="{{ route('logout') }}" ><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a>
                        </li>
                        @endguest

                  
                </ul>
              </div>
            </nav>
        </div>
	<div class="container">
		<div class="row">
				    <!-- /.content-wrapper -->
	    	@yield('content')		

		</div>
	</div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select-js').select2();
        });
    </script>
    @yield('js')
</body>
</html>