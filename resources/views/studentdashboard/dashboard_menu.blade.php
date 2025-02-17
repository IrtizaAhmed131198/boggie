<div class="close-modal">
    <div class="side-moda" id="openshow">
        <div class="mian-nav">
            <div class="headerlogo">
                <img src="{{ asset('assets/imgs/logo.png') }}" class="img-fluid" alt="">
            </div>
            <ul class="nav-tabs">
                <li {{ request()->routeIs('student_dashboard*') ? 'class=active' : '' }}>
                    <a href="{{ route('student_dashboard') }}">Home</a>
                </li>
                <li {{ request()->routeIs('student_profile*') ? 'class=active' : '' }}>
                    <a href="{{ route('student_profile') }}">Profile</a>
                </li>
                <li {{ request()->routeIs('order*') ? 'class=active' : '' }}>
                    <a href="{{ route('order') }}">Orders</a>
                </li>

                <li {{ request()->routeIs('log_out*') ? 'class=active' : '' }}>
                    <a href="javascript:;">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</div>
