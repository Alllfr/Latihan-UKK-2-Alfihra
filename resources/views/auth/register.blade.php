<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>

<body>

<h2>Register</h2>

@if ($errors->any())
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ route('register') }}">
@csrf

<div>
<label>Nama</label>
<input type="text" name="name" required>
</div>

<div>
<label>Email</label>
<input type="email" name="email" required>
</div>

<div>
<label>Password</label>
<input type="password" name="password" required>
</div>

<div>
<label>Konfirmasi Password</label>
<input type="password" name="password_confirmation" required>
</div>

<button type="submit">
Register
</button>

</form>

<a href="{{ route('login') }}">
Sudah punya akun? Login
</a>

</body>
</html>