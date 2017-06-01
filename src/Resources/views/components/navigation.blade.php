<div id="navigation-wrapper">
    <div id="navigation">
        <div class="title">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" />
            </a>
        </div>

        <ul class="nav nav-pills nav-stacked animated fadeIn">
            <li class="{{ Route::is('admin::dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin::dashboard') }}">
                    <i class="fa fa-fw fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="{{ Route::is('admin::import') ? 'active' : '' }}">
                <a href="{{ route('admin::import') }}">
                    <i class="fa fa-fw fa-download"></i> Importeren
                </a>
            </li>
            <li class="{{ Route::is('admin::manager') ? 'active' : '' }}">
                <a href="{{ route('admin::manager') }}">
                    <i class="fa fa-fw fa-users"></i> Gebruikersbeheer
                </a>
            </li>
            {{--<li class="{{ Route::is('admin::carousel') ? 'active' : '' }}">--}}
                {{--<a href="{{ route('admin::carousel') }}">--}}
                    {{--<i class="fa fa-fw fa-image"></i> Carousel--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="{{ Route::is('admin::export') ? 'active' : '' }}">
                <a href="{{ route('admin::export') }}">
                    <i class="fa fa-fw fa-cogs"></i> Genereren
                </a>
            </li>
            <li class="{{ Route::is('admin::content') ? 'active' : '' }}">
                <a href="{{ route('admin::content') }}">
                    <i class="fa fa-fw fa-pencil"></i> Contentbeheer
                </a>
            </li>
            <li class="{{ Route::is('admin::packs') ? 'active' : '' }}">
                <a href="{{ route('admin::packs') }}">
                    <i class="fa fa-fw fa-star"></i> Actiepaketten
                </a>
            </li>
            <li class="{{ Route::is('admin::cache') ? 'active' : '' }}">
                <a href="{{ route('admin::cache') }}">
                    <i class="fa fa-fw fa-microchip"></i> Cache
                </a>
            </li>
            <li class="{{ Route::is('admin::email') ? 'active' : '' }}">
                <a href="{{ route('admin::email') }}">
                    <i class="fa fa-fw fa-envelope"></i> E-Mail
                </a>
            </li>
        </ul>
    </div>
</div>