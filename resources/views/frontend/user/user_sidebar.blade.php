<ul class="nav nav-tabs mb-6" role="tablist">
    <li class="nav-item">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.deposit_list') }}" class="nav-link {{ request()->is('user/deposits') ? 'active' : '' }}">Deposits</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.order_list') }}" class="nav-link {{ request()->is('user/orders*') ? 'active' : '' }}">Orders</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.my_refer') }}" class="nav-link {{ request()->is('user/my-refer*') ? 'active' : '' }}">My Refers</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.withdraw_list') }}" class="nav-link {{ request()->is('user/withdraws') ? 'active' : '' }}">Withdraw</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.transactions') }}" class="nav-link {{ request()->is('user/transactions*') ? 'active' : '' }}">Transactions</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.my_reviews') }}" class="nav-link {{ request()->is('user/my-reviews*') ? 'active' : '' }}">My Reviews</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.account_details') }}" class="nav-link {{ request()->is('user/account-details*') ? 'active' : '' }}">Account details</a>
    </li>
    <li class="link-item">
        <a href="{{ route('user.dashboard') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
