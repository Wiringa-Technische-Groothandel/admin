<div class="notification danger animated fadeInLeft template" id="danger-notification-template"></div>
<div class="notification success animated fadeInLeft template" id="success-notification-template"></div>

<div id="notification-wrapper"></div>

<script>
    var dangerText = "";
    var successText = "{{ session('status') }}<br />";

    @foreach ($errors->all() as $error)
        dangerText = dangerText + "{{ $error }}<br />";
    @endforeach

    setTimeout(function () {
        if (dangerText.length > 0) {
            notification.show(dangerText, "danger");
        }

        if (successText !== "<br />") {
            notification.show(successText);
        }
    }, 100);
</script>