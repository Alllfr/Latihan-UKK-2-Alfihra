<h1>Dashboard User</h1>

<p>Nama: {{ auth()->user()->name }}</p>

<p>Role: {{ auth()->user()->role }}</p>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit">Logout</button>
</form>