<div>
<form method="POST" action="/customer/login">
    @csrf

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Customer Login</button>

    @error('email')<p>{{ $message }}</p>@enderror
</form>
</div>
