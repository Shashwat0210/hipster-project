<form method="POST" action="/customer/register">
    @csrf

    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

    <button type="submit">Customer Register</button>

   
    @error('name')<p>{{ $message }}</p>@enderror
    @error('email')<p>{{ $message }}</p>@enderror
    @error('password')<p>{{ $message }}</p>@enderror
</form>

