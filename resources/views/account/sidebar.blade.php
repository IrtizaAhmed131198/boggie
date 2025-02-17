<div class="close-modal">
    <div class="side-moda" id="openshow">
        <div class="mian-nav">
            <div class="headerlogo">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/imgs/logo.png') }}" class="img-fluid" alt=""></a>
            </div>
            <ul class="nav-tabs">
                <li {{ request()->routeIs('account') ? 'class=active' : '' }}>
                    <a href="{{ route('account') }}">Home</a>
                </li>
                <li {{ request()->routeIs('accountDetail') ? 'class=active' : '' }}>
                    <a href="{{ route('accountDetail') }}">Profile</a>
                </li>
                <li {{ request()->routeIs('orders') ? 'class=active' : '' }}>
                    <a href="{{ route('orders') }}">Orders</a>
                </li>

                <li {{ request()->routeIs('log_out') ? 'class=active' : '' }}>
                    <a href="{{ url('signout') }}">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</div>
