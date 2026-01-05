<h1>Customer Dashboard</h1>

<p>Welcome, {{ auth('customer')->user()->name }}</p>

<form method="POST" action="/customer/logout">
    @csrf
    <button type="submit">Logout</button>
</form>
