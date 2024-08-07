<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard.index') }}" target="_blank">
            <img src="/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">SIARAN</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class=" w-auto ">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard.index' ? 'active' : '' }}"
                    href="{{ route('admin.dashboard.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fa fa-users" style="color: #f4645f;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">User Management</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}"
                    href="{{ route('profile.show') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-circle-o text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>

            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-bullet-list-67" style="color: #f4645f;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Features</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sarpras*') ? 'active' : '' }}"
                    href="{{ route('admin.sarpras.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-pin-3 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Facility</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/lost-item*') ? 'active' : '' }}"
                    href="{{ route('admin.lost-item.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-box-2 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Lost Item Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/status*') ? 'active' : '' }}"
                    href="{{ route('admin.status.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-compass-04 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Status</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/bullying-report*') ? 'active' : '' }}"
                    href="{{ route('admin.bullying-report.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bullying Report</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/items-report*') ? 'active' : '' }}"
                    href="{{ route('admin.items-report.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-square-pin text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Lost Item Report</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sarana-report*') ? 'active' : '' }}"
                    href="{{ route('admin.sarana-report.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-building text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Facility Report</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'sexual-report') == true ? 'active' : '' }}"
                    href="{{ route('admin.sexual-report.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-notification-70 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sexual Report</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- <div class="sidenav-footer mx-3 ">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="/img/illustrations/icon-documentation-warning.svg"
                alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Please check our docs</p>
                </div>
            </div>
        </div>
        <a href="/docs/bootstrap/overview/argon-dashboard/index.html" target="_blank"
            class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
        <a class="btn btn-primary btn-sm mb-0 w-100"
            href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank"
            type="button">Upgrade to PRO</a>
    </div> -->
</aside>