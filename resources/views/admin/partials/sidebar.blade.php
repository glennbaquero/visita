<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link bg-danger">
        @include('partials.brand')
    </a>

    <div class="sidebar">
        @if (auth()->check())
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ $self->renderAvatar() }}" class="img-circle elevation-2" style="width: 35px; height: 35px;">
                </div>
                <div class="info">
                    <a href="{{ route('admin.profiles.show') }}" class="d-block">
                        {{ $self->renderName() }}
                    </a>
                </div>
            </div>
        @endif

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.dashboard',
                    ]) }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if ($self->hasAnyPermission(['admin.destinations.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.destinations.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.destinations.*',
                    ]) }}">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            Destination
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.experiences.crud']))
                 <li class="nav-item">
                    <a href="{{ route('admin.experiences.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.experiences.*',
                    ]) }}">
                        <i class="nav-icon fas fa-hiking"></i>
                        <p>
                            Experience
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.inquiries.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.inquiries.*',
                    ]) }}">
                        <i class="nav-icon fas fa-at"></i>
                        <p>
                            Inquiries
                        </p>
                    </a>
                </li>
                @endif


                {{-- @if ($self->hasAnyPermission(['admin.annual_incomes.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.annual_incomes.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.annual_incomes.*',
                    ]) }}">
                        <i class="nav-icon fas fa-at"></i>
                        <p>
                            Annual Income
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.survey_experiences.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.survey-experiences.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.survey-experiences.*',
                    ]) }}">
                        <i class="nav-icon fas fa-at"></i>
                        <p>
                            Survey Experience
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.allocations.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.allocations.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.allocations.*',
                    ]) }}">
                        <i class="nav-icon fas fa-hiking"></i>
                        <p>
                            Allocation
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.add_ons.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.add-ons.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.add-ons.*',
                    ]) }}">
                        <i class="nav-icon fas fa-plus-square"></i>
                        <p>
                            Add Ons
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.visitor_types.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.visitor-types.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.visitor-types.*',
                    ]) }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Visitor Types
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.special_fees.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.fees.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.fees.*',
                    ]) }}">
                        <i class="nav-icon fas fa-comment-dollar"></i>
                        <p>
                            Special Fees
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.calendar.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.calendar.*',
                    ]) }}">
                        <i class="nav-icon fas fa-at"></i>
                        <p>
                            Calendar
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.blocked-dates.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.blocked-dates.*',
                    ]) }}">
                        <i class="nav-icon fas fa-at"></i>
                        <p>
                            Blocked Dates
                        </p>
                    </a>
                </li> --}}
                
                @if ($self->hasAnyPermission(['admin.pages.crud', 'admin.page-items.crud', 'admin.articles.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                            'admin.articles.index','admin.articles.create','admin.articles.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                            'admin.articles.index','admin.articles.create','admin.articles.show',
                        ]) }}">
                            <i class="nav-icon fas fa-feather"></i>
                            <p>
                                Content Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.pages.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.pages.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.pages.index','admin.pages.create','admin.pages.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Pages
                                        </p>
                                    </a>
                                </li>
                            @endif
                            
                            @if ($self->hasAnyPermission(['admin.page-items.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.page-items.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Page Items
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.articles.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.articles.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.articles.index','admin.articles.create','admin.articles.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Articles
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.home-banners.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.home-banners.index','admin.home-banners.create','admin.home-banners.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.home-banners.index','admin.home-banners.create','admin.home-banners.show',
                        ]) }}">
                            <i class="nav-icon far fa-images"></i>
                            <p>
                                Carousels
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.home-banners.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.home-banners.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.home-banners.index','admin.home-banners.create','admin.home-banners.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>

                                            Home Banners

                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.home-banners.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.about-infos.index','admin.about-infos.create','admin.about-infos.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.about-infos.index','admin.about-infos.create','admin.about-infos.show',
                        ]) }}">
                            <i class="nav-icon far fa-bookmark"></i>
                            <p>
                                Tabbings
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.about-infos.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.about-infos.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.about-infos.index','admin.about-infos.create','admin.about-infos.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>

                                            About Info

                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="nav-header">Admin Management</li>

                @if ($self->hasAnyPermission(['admin.admin-users.crud', 'admin.roles.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                            'admin.roles.index', 'admin.roles.create', 'admin.roles.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                            'admin.roles.index', 'admin.roles.create', 'admin.roles.show',
                        ]) }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                Admin Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.admin-users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.admin-users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Admins
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.roles.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.roles.index', 'admin.roles.create', 'admin.roles.show'
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Roles & Permissions
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.users.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.users.index','admin.users.create','admin.users.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.users.index','admin.users.create','admin.users.show',
                        ]) }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.users.index','admin.users.create','admin.users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('admin.managements.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.managements.index','admin.managements.create','admin.managements.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Frontliners
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.activity-logs.crud']))
                    <li class="nav-item">
                        <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.activity-logs.index',
                        ]) }}">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>
                                Activity Logs
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>
</aside>