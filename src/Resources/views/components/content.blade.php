<div id="content-wrapper">
    @yield('before-content')

    <div id="content" class="animated fadeIn">
        @yield('content')
    </div>

    @yield('after-content')
</div>