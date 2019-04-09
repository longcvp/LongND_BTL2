	<h2>Thông tin cá nhân</h2>
	<hr>
    <div class="row">
        <div class="col-sm-s col-md-3">
            <img src="{{ asset(Auth::user()->infomation->avatar) }}"
            alt="" class="img-rounded img-responsive" />
        </div>
        <div class="col-sm-6 col-md-6">
            <blockquote>
                <p>{{ Auth::user()->infomation->name }}</p> 
                <small>
                	<cite title="Source Title">{{ Auth::user()->infomation->address }} 
                		<i class="glyphicon glyphicon-map-marker"></i>
                	</cite>
                </small>
            </blockquote>
            <p> 
            	<i class="glyphicon glyphicon-user"></i> Thông tin cơ bản
            	<hr>
            	<i class="glyphicon glyphicon-gift"></i> {{ date('d-m-Y', strtotime(Auth::user()->infomation->birthday)) }}
            	<br/>
            	<i class="glyphicon glyphicon-phone"></i> {{ '+84' . Auth::user()->infomation->phone }}
            	<br/>
            	<i class="glyphicon glyphicon-search"></i> {{ (Auth::user()->infomation->gender == 1) ? 'Nam' : 'Nữ'}}
            	<br/>
            	<i class="glyphicon glyphicon-envelope"></i> {{ Auth::user()->email }}             
            </p>
            <hr>
            <a href="{{ route('users.edit', Auth::id()) }}" type="button" class="btn btn-success">Sửa thông tin cá nhân</a>
            <a href="{{ route('password.show', Auth::id()) }}" type="button" class="btn btn-danger">Đổi mật khẩu</a>

        </div>
    </div>
