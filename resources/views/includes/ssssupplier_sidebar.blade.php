<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="/images/user/{{Auth::user()->profile_pic}}"
                         width="60px"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{Auth::user()->name}}</span>
                    </a>

                </div>
                <div class="logo-element">
                    UT
                </div>
            </li>
            <li>
                <a href="/supplier/dashboard"><i class="fa fa-th-large"></i> <span
                            class="nav-label">Dashboards</span></a>
            </li>

            <li>
                <a href="/supplier/orders"><i class="fa fa-th-large"></i> <span
                            class="nav-label">Orders</span></a>
            </li>


            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Manage Deliveryman</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/supplier/deliveryman/create">New Deliveryman</a></li>
                    <li><a href="/supplier/deliverymans">View Deliveryman</a></li>
                </ul>
            </li>


            <li>
                <a href="/admin/profile"><i class="fa fa-diamond"></i> <span class="nav-label">Profile</span></a>
            </li>
        </ul>

    </div>
</nav>