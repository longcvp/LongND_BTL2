<!DOCTYPE html>
<html>
<head>
	<title>Activation Email - Quanlytaichinh.test</title>
</head>
<body>
	<p>
		Chào mừng {{ $name }} đã đăng ký thành viên tại Quanlytaichinh.test. Bạn hãy click vào đường link sau đây để hoàn tất việc đăng ký.
		</br>
		<a href="{{ $active_link }}">{{ $active_link }}</a>
	</p>
</body>
</html>