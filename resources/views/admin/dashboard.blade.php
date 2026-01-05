<h1>Admin Dashboard</h1>

<p>Welcome, {{auth('admin')->user()->name }}</p>

<form method="POST" action="/admin/logout">
    @csrf
    <button type="submit">Logout</button>
</form>