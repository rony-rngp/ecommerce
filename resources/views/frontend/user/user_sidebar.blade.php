<ul class="nav nav-tabs mb-6" role="tablist">
    <li class="nav-item">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.deposit_list') }}" class="nav-link {{ request()->is('user/deposits') ? 'active' : '' }}">Deposits</a>
    </li>
    <li class="nav-item">
        <a href="" class="nav-link">Orders</a>
    </li>
    <li class="nav-item">
        <a href="" class="nav-link">Addresses</a>
    </li>
    <li class="nav-item">
        <a href="" class="nav-link">Account details</a>
    </li>
    <li class="link-item">
        <a href="">Wishlist</a>
    </li>
    <li class="link-item">
        <a href="{{ route('user.dashboard') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
