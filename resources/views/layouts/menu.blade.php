<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
    data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-item">
        <a href="{{ route(\App\Alias\Routes::DASHBOARD) }}" class="nav-link {{ Route::is(\App\Alias\Routes::DASHBOARD) ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route(\App\Alias\Routes::COMPANIES) }}" class="nav-link {{ Route::is('company*') ? 'active' : ''}}">
            <i class="nav-icon far fa-building"></i>
            <p>
                Companies
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route(\App\Alias\Routes::EMPLOYEES) }}" class="nav-link {{ Route::is('employee*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Employees
            </p>
        </a>
    </li>
</ul>

