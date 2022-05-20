<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="/images/user/{{Auth::user()->profile_pic}}"
                         width="60px"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{Auth::user()->name}}<br>
                            <smal> @if(getAdminNameFromId(Auth::user()->user_type)=="Supplier")

                                    Volunteer

                                @elseif(Auth::user()->user_type==getModeratorId())
                                    Coordinator
                                @else
                                    {{getAdminNameFromId(Auth::user()->user_type)}}

                                @endif</smal></span>
                        @if(Auth::user()->user_type==getModeratorId())

                            {{getDivisionFromId(Auth::user()->district_id)}}
                        @endif
                    </a>

                </div>
                <div class="logo-element">
                    NP
                </div>
            </li>

            @if(Auth::user()->user_type==1 || Auth::user()->user_type==2 || Auth::user()->user_type==5 || Auth::user()->user_type==getSupplierId())


                <li>
                    <a href="/admin/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
                </li>

                @if(Auth::user()->user_type==getAdminId() || Auth::user()->user_type==5|| Auth::user()->user_type==getAgentId())

                    <li>
                        <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Volunteer</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">

                            @if(Auth::user()->user_type==getAdminId() ||Auth::user()->user_type==getAgentId() || Auth::user()->user_type==5)
                                <li>
                                    <a href="/admin/suppliers"><i class="fa fa-th-large"></i> <span
                                                class="nav-label">Volunteer List</span></a>
                                </li>
                            @endif


                            <li>
                                <a href="/admin/shops"><i class="fa fa-shopping-bag"></i> <span
                                            class="nav-label">Shop List</span></a>
                            </li>

                        </ul>
                    </li>


                @endif


                @if(Auth::user()->user_type!=getSupplierId() && Auth::user()->user_type!=getModeratorId())


                    <li>
                        <a href="#"><i class="fa fa-shopping-bag"></i> <span class="nav-label">Order</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">


                            <li><a href="/admin/order/create">New Order</a></li>
                            @if(Auth::user()->user_type==getAdminId())
                                <li><a href="/admin/orders/All">View Order</a></li>
                                <li><a href="/admin/order-release">Release Order</a></li>
                            @else
                                <li><a href="/admin/order-request-view">Orders</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- @if(Auth::user()->user_type==getModeratorId())

                     <li>
                         <a href="/admin/order/create"><i class="fa fa-list"></i> <span
                                     class="nav-label">New Order</span></a>
                     </li>

                 @endif
 --}}
                @if(Auth::user()->user_type==getSupplierId() || Auth::user()->user_type==getModeratorId())

                    @if( Auth::user()->user_type!=getModeratorId())
                        <li>
                            <a href="/admin/shops"><i class="fa fa-list"></i> <span
                                        class="nav-label">Shop List</span></a>
                        </li>
                    @endif

                    <li>
                        <a href="/supplier/shop/All"><i class="fa fa-list"></i> <span
                                    class="nav-label">Order</span></a>
                    </li>

                @endif

                @if(Auth::user()->user_type==getAdminId())

                    <li>
                        <a href="/admin/deliverymans"><i class="fa fa-car"></i> <span
                                    class="nav-label">Transport</span></a>
                    </li>


                    {{--  <li>
                          <a href="#"><i class="fa fa-car"></i> <span class="nav-label">Transport</span><span
                                      class="fa arrow"></span></a>
                          <ul class="nav nav-second-level collapse">
                              <li><a href="/admin/deliveryman/create">New Transport</a></li>
                              <li><a href="/admin/deliverymans">View Transport</a></li>
                          </ul>
                      </li>--}}
                @endif

                {{--    @if(Auth::user()->user_type==2 )--}}

                @if(Auth::user()->user_type==1)

                    <li>
                        <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">Setting</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="/admin/agents">Agent</a></li>

                            <li><a href="/admin/moderators">Coordinator</a></li>
                            <li><a href="/admin/upazilas">Upazila</a></li>
                            <li><a href="/admin/unions">Union</a></li>
                        </ul>
                    </li>

                @endif

            @else

                <li>
                    <a href="/supplier/dashboard"><i class="fa fa-th-large"></i> <span
                                class="nav-label">Dashboards</span></a>
                </li>

                <li>
                    <a href="/supplier/orders"><i class="fa fa-th-large"></i> <span
                                class="nav-label">Orders</span></a>
                </li>


            @endif
            @if(Auth::user()->user_type==getAdminId())

                <li>
                    <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Report</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        {{-- <li>
                             <a href="/admin/agent-wise-report"><i class="fa fa-user"></i> <span
                                         class="nav-label">Agent Wise Report</span></a>
                         </li>
                         <li>
                             <a href="/admin/status-wise-report"><i class="fa fa-id-card"></i> <span
                                         class="nav-label">Status Wise Report</span></a>
                         </li>--}}
                        <li>
                            <a href="/admin/tran-report"><i class="fa fa-id-card"></i> <span
                                        class="nav-label">Relief</span></a>
                        </li>
                        <li>
                            <a href="/admin/agent-report"><i class="fa fa-id-card"></i> <span
                                        class="nav-label">Agent Report</span></a>
                        </li>
                        <li>
                            <a href="/admin/order-report"><i class="fa fa-id-card"></i> <span
                                        class="nav-label">Order Export</span></a>
                        </li>
                        <li>
                            <a href="/admin/shop-report"><i class="fa fa-id-card"></i> <span
                                        class="nav-label">Shop Export</span></a>
                        </li>


                    </ul>
                </li>
            @endif
            @if(Auth::user()->user_type==getAgentId())
                <li>
                    <a href="/supplier/report/{{Auth::user()->id}}"><i class="fa fa-sticky-note"></i> <span
                                class="nav-label">Report</span></a>
                </li>
            @endif
            <li>
                <a href="/supplier/notices"><i class="fa fa-sticky-note"></i> <span
                            class="nav-label">Notice</span></a>
            </li>


            <li>
                <a href="/admin/profile"><i class="fa fa-diamond"></i> <span class="nav-label">Profile</span></a>
            </li>
        </ul>

    </div>
</nav>