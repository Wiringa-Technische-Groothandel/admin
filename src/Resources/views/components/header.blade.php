<div id="header-wrapper">
    @yield('before-header')

    <header id="header">
        <div class="container-fluid">
            <div class="pull-left">
                <ul class="nav nav-pills">
                    <li role="presentation">
                        <a href="#" title="Toggle navigation" id="toggle-navigation"><i class="fa fa-align-justify"></i></a>
                    </li>
                </ul>
            </div>

            <div class="pull-right">
                <form action="{{ route('auth::logout') }}" method="post" id="logout-form">
                    {{ csrf_field() }}

                    <ul class="nav nav-pills">
                        <li role="presentation">
                            <a href="{{ url('/') }}" title="Home"><i class="fa fa-fw fa-home"></i></a>
                        </li>
                        <li role="presentation">
                            <a href="{{ route('admin::dashboard') }}" title="Dashboard"><i class="fa fa-fw fa-dashboard"></i></a>
                        </li>
                        <li role="presentation">
                            <a href="#" data-target="#resetCacheModal" data-toggle="modal" title="Reset cache"><i class="fa fa-fw fa-microchip"></i></a>
                        </li>
                        <li role="presentation">
                            <a href="#" onclick="document.getElementById('logout-form').submit()" title="Logout"><i class="fa fa-fw fa-power-off"></i></a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </header>

    @yield('after-header')
</div>