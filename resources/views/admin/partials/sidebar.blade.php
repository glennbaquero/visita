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

                
                @if ($self->hasAnyPermission(['admin.calendar.crud']))
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
                @endif

                @if ($self->hasAnyPermission(['admin.agencies.crud']))
                <li class="nav-item">
                    <a href="{{ route('admin.agencies.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.agencies.*',
                    ]) }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Agencies
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


                @if ($self->hasAnyPermission(['admin.destinations.crud', 'admin.experiences.crud', 'admin.allocations.crud', 'admin.capacities.crud', 'admin.managements.crud']))
                <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                        'admin.destinations.index','admin.destinations.create','admin.destinations.show',
                        'admin.experiences.index','admin.experiences.create','admin.experiences.show',
                        'admin.allocations.index','admin.allocations.create','admin.allocations.show',
                        'admin.capacities.index','admin.capacities.create','admin.capacities.show',
                        'admin.managements.index','admin.managements.create','admin.managements.show',
                    ]) }}">
                    <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.destinations.index','admin.destinations.create','admin.destinations.show',
                        'admin.experiences.index','admin.experiences.create','admin.experiences.show',
                        'admin.allocations.index','admin.allocations.create','admin.allocations.show',
                        'admin.capacities.index','admin.capacities.create','admin.capacities.show',
                        'admin.managements.index','admin.managements.create','admin.managements.show',
                    ]) }}">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            Destination Management
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($self->hasAnyPermission(['admin.destinations.crud']))
                        <li class="nav-item">
                            <a href="{{ route('admin.destinations.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                'admin.destinations.index','admin.destinations.create','admin.destinations.show',
                            ]) }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Destination
                                </p>
                            </a>
                        </li>
                        @endif

                        @if ($self->hasAnyPermission(['admin.experiences.crud']))
                         <li class="nav-item">
                            <a href="{{ route('admin.experiences.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                'admin.experiences.index','admin.experiences.create','admin.experiences.show',
                            ]) }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Experience
                                </p>
                            </a>
                        </li>
                        @endif

                        @if ($self->hasAnyPermission(['admin.allocations.crud']))
                        <li class="nav-item">
                            <a href="{{ route('admin.allocations.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                'admin.allocations.index','admin.allocations.create','admin.allocations.show',
                            ]) }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Allocation
                                </p>
                            </a>
                        </li>
                        @endif

                        @if ($self->hasAnyPermission(['admin.capacities.crud']))
                        <li class="nav-item">
                            <a href="{{ route('admin.capacities.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                'admin.capacities.index','admin.capacities.create','admin.capacities.show',
                            ]) }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Capacities
                                </p>
                            </a>
                        </li>
                        @endif

                        @if ($self->hasAnyPermission(['admin.managements.crud']))
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
                        @endif

                    </ul>
                </li>
                @endif 

                
                @if ($self->hasAnyPermission(['admin.pages.crud', 'admin.page-items.crud', 'admin.articles.crud', 'admin.annual_incomes.crud', 'admin.survey_experiences.crud', 'admin.feedbacks.crud', 'admin.add_ons.crud','admin.visitor_types.crud', 'admin.special_fees.crud', 'admin.blocked-dates.crud', 'admin.training-modules.crud', 'admin.faqs.crud', 'admin.religions.crud', 'admin.announcements.crud', 'admin.remarks.crud','admin.violations.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                            'admin.articles.index','admin.articles.create','admin.articles.show',
                            'admin.annual_incomes.index','admin.annual_incomes.create','admin.annual_incomes.show',
                            'admin.survey-experiences.index','admin.survey-experiences.create','admin.survey-experiences.show',
                            'admin.feedbacks.index','admin.feedbacks.create','admin.feedbacks.show',
                            'admin.add-ons.index','admin.add-ons.create','admin.add-ons.show',
                            'admin.visitor-types.index','admin.visitor-types.create','admin.visitor-types.show',
                            'admin.fees.index','admin.fees.create','admin.fees.show',
                            'admin.blocked-dates.index','admin.blocked-dates.create','admin.blocked-dates.show',
                            'admin.training-modules.index','admin.training-modules.create','admin.training-modules.show',
                            'admin.faqs.index','admin.faqs.create','admin.faqs.show',
                            'admin.religions.index','admin.religions.create','admin.religions.show',
                            'admin.announcements.index','admin.announcements.create','admin.announcements.show',
                            'admin.remarks.index','admin.remarks.create','admin.remarks.show',
                            'admin.violations.index','admin.violations.create','admin.violations.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                            'admin.articles.index','admin.articles.create','admin.articles.show',
                            'admin.annual_incomes.index','admin.annual_incomes.create','admin.annual_incomes.show',
                            'admin.survey-experiences.index','admin.survey-experiences.create','admin.survey-experiences.show',
                            'admin.feedbacks.index','admin.feedbacks.create','admin.feedbacks.show',
                            'admin.add-ons.index','admin.add-ons.create','admin.add-ons.show',
                            'admin.visitor-types.index','admin.visitor-types.create','admin.visitor-types.show',
                            'admin.fees.index','admin.fees.create','admin.fees.show',
                            'admin.blocked-dates.index','admin.blocked-dates.create','admin.blocked-dates.show',
                            'admin.training-modules.index','admin.training-modules.create','admin.training-modules.show',
                            'admin.faqs.index','admin.faqs.create','admin.faqs.show',
                            'admin.religions.index','admin.religions.create','admin.religions.show',
                            'admin.announcements.index','admin.announcements.create','admin.announcements.show',
                            'admin.remarks.index','admin.remarks.create','admin.remarks.show',
                            'admin.violations.index','admin.violations.create','admin.violations.show',
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

                            @if ($self->hasAnyPermission(['admin.annual_incomes.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.annual_incomes.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.annual_incomes.index','admin.annual_incomes.create','admin.annual_incomes.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Annual Income
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.survey_experiences.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.survey-experiences.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.survey-experiences.index','admin.survey-experiences.create','admin.survey-experiences.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Survey Experience
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.feedbacks.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.feedbacks.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.feedbacks.index','admin.feedbacks.create','admin.feedbacks.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Feedback
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.add_ons.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.add-ons.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.add-ons.index','admin.add-ons.create','admin.add-ons.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Add Ons
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.visitor_types.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.visitor-types.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.visitor-types.index','admin.visitor-types.create','admin.visitor-types.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Visitor Types
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.special_fees.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.fees.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.fees.index','admin.fees.create','admin.fees.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Special Fees
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.blocked-dates.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.blocked-dates.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.blocked-dates.index','admin.blocked-dates.create','admin.blocked-dates.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Blocked Dates
                                    </p>
                                </a>
                            </li>
                            @endif  

                            @if ($self->hasAnyPermission(['admin.training-modules.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.training-modules.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.training-modules.index','admin.training-modules.create','admin.training-modules.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Training Modules
                                    </p>
                                </a>
                            </li>
                            @endif 

                            @if ($self->hasAnyPermission(['admin.faqs.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.faqs.index','admin.faqs.create','admin.faqs.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        FAQs
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.religions.crud']))
                             <li class="nav-item">
                                <a href="{{ route('admin.religions.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.religions.index','admin.religions.create','admin.religions.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Religions
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.announcements.crud']))
                             <li class="nav-item">
                                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.announcements.index','admin.announcements.create','admin.announcements.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Announcements
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.remarks.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.remarks.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.remarks.index','admin.remarks.create','admin.remarks.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Remarks
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.violations.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.violations.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.violations.index','admin.violations.create','admin.violations.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Violations
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