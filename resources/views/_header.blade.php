<div class="header py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ url('/') }}">
                <img src="https://tabler.io/img/tabler.svg" class="header-brand-img" alt="Logo">
                This is dashboard
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <!-- <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-bell"></i>
                        <span class="nav-unread"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/male/41.jpg)"></span>
                            <div>
                                <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                                <div class="small text-muted">10 minutes ago</div>
                            </div>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                    </div>
                </div> -->
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar" style="background-image: url({{ asset('images/user.jpg') }})"></span>
                        <span class="ml-2 d-none d-lg-block">
                            <span class="text-default">{{ Auth::user()->email }}</span>
                            <small class="text-muted d-block mt-1">{{ title_case(Auth::user()->type) }}</small>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="#">
                            <i class="dropdown-icon fe fe-user"></i> Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="float-right"><span class="badge badge-primary">6</span></span>
                            <i class="dropdown-icon fe fe-mail"></i> Inbox
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('logout') }}">
                            <i class="dropdown-icon fe fe-log-out"></i> Sign out
                        </a>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>