<h1>Admin Dashboard</h1>

<p>Welcome, {{ auth('admin')->user()->name }}</p>

<form method="POST" action="/admin/logout">
    @csrf
    <button type="submit">Logout</button>
</form>

<hr>

<h3>Online Users</h3>

<ul id="online-users">
    @forelse($onlineUsers as $presence)
        <li data-user="{{ $presence->user_type }}-{{ $presence->user_id }}">
            {{ ucfirst($presence->user_type) }}
            #{{ $presence->user_id }}
            (online)
        </li>
    @empty
        <li>No users online</li>
    @endforelse
</ul>

<script>
    const list = document.getElementById('online-users');

    window.Echo.join('presence.online')
        .here((users) => {
            console.log('Presence snapshot:', users);
        })
        .joining((user) => {
            const id = `${user.type}-${user.id}`;

            if (!document.querySelector(`[data-user="${id}"]`)) {
                const li = document.createElement('li');
                li.dataset.user = id;
                li.innerText = `${user.type.toUpperCase()} #${user.id} (online)`;
                list.appendChild(li);
            }
        })
        .leaving((user) => {
            const id = `${user.type}-${user.id}`;
            const el = document.querySelector(`[data-user="${id}"]`);
            if (el) el.remove();
        });
</script>
