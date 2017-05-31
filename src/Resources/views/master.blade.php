<!DOCTYPE html>
<html lang="nl">
    <head>
        @yield('head_start')

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sinds 1956 uw inkoop gemak van bodem tot dak. Uw partner voor leidingsystemen, centrale verwarming, sanitair, non-ferro, dakbedekking en appendages.">
        <meta name="keywords" content="Sanitair,Dakbedekking,Non-ferro materiaal,Riolering/HWA systemen,Fittingen,Afsluiters,Gereedschap,Bevestigingsmateriaal,lijm,Rookgasafvoermateriaal">
        <meta name="author" content="Thomas Wiringa">

        <title>WTG {{ isset($pagetitle) ? " | " . $pagetitle : '' }}</title>

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="{{ mix('assets/admin/css/app.css') }}">

        @yield('head_end')
    </head>
    <body>
        @yield('document_start')

        @include('admin::cache.components.modal')

        <div class="container-fluid">
            @include('admin::components.navigation')

            <div id="page-wrapper">
                @yield('before-page')

                <div id="page">
                    @include('admin::components.header')

                    @include('admin::components.content')
                </div>

                @yield('after-page')
            </div>
        </div>

        @include('admin::components.notifications')

        <script src="{{ mix('assets/admin/js/app.js') }}"></script>
        <script>
            function makeChart (context, type, data, options) {
                options = options ? options : {};

                return new Chart(context, {
                    type: type,
                    data: data,
                    options: options
                });
            }
        </script>

        @yield('document_end')
    </body>
</html>