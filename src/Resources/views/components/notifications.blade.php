@if (count($errors) > 0 || request()->input('testnotify') === 'error')
    <div class="notification danger animated fadeInLeft">
        @foreach ($errors->all() as $error)
            {{ $error }}<br />
        @endforeach
    </div>
@endif

@if (Session::has('status') || request()->input('testnotify') === 'success')
    <div class="notification success animated fadeInLeft">
        {{ Session::get('status') }}<br />
    </div>
@endif