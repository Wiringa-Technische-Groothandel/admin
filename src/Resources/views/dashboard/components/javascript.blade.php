<script type="text/javascript">
    function setProgressBar ($el, percentage, value, max) {
        $el.width(percentage + '%');
        $el.prop('aria-valuenow', value);
        $el.prop('aria-valuemax', max);

        if (percentage < 40) { $el.prop('class', 'progress-bar progress-bar-info'); }
        else if (percentage >= 40 && percentage < 60) { $el.prop('class', 'progress-bar progress-bar-success'); }
        else if (percentage >= 60 && percentage < 85) { $el.prop('class', 'progress-bar progress-bar-warning'); }
        else if (percentage >= 85) { $el.prop('class', 'progress-bar progress-bar-danger'); }
    }

    var chartColors = {{ $orders->keys() }}.map(randomColor);
    var averageColor = randomColor();

    // Get the context of the canvas element we want to select
    var orderChart = makeChart(
        document.getElementById('order-chart'),
        'bar',
        {
            labels: window.months,
            datasets: [
                @foreach($orders as $year => $orderGroup)
                    @if ($orderGroup !== null)
                        {
                            label: "Orders {{ $year }}",
                            backgroundColor: chartColors[{{ $loop->index }}],
                            borderColor: chartColors[{{ $loop->index }}],
                            hoverBackgroundColor: chartColors[{{ $loop->index }}],
                            hoverBorderColor: chartColors[{{ $loop->index }}],
                            data: [
                                @for($i = 0; $i < 12; $i++)
                                    {{ $orderGroup->get($i+1) }},
                                @endfor
                            ]
                        },
                    @endif
                @endforeach
                {
                    type: 'line',
                    label: 'Gemiddelde',
                    backgroundColor: 'transparent',
                    borderColor: averageColor,
                    hoverBackgroundColor: 'transparent',
                    hoverBorderColor: averageColor,
                    data: {{ $averagePerMonth }}
                }
            ]
        },
        {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    );
</script>

<script type="text/javascript">
    /**
     * Parse the CPU load.
     */
    function parseCpuLoad (data) {
        var load = (data.load > data.max ? data.max : data.load);
        var width = (load / data.max) * 100;
        var $cpuProgressBar = $("#progress-bar-cpu");

        setProgressBar($cpuProgressBar, width, load, data.max);
    }

    /**
     * Parse the RAM load.
     */
    function parseRamLoad (data) {
        var width = 100 - data.freePercentage;
        var used = data.total - data.free;
        var $ramProgressBar = $("#progress-bar-ram");

        setProgressBar($ramProgressBar, width, used, data.total);
    }

    /**
     * Parse the disk usage.
     */
    function parseDiskUsage (data) {
        var width = (data.free / data.total) * 100;
        var used = data.total - data.free;
        var $diskProgressBar = $("#progress-bar-disk");

        setProgressBar($diskProgressBar, width, used, data.total);
    }

    /**
     * Get the server stats
     */
    function getServerStats () {
        $.ajax({
            url: "{{ route('admin::dashboard.stats') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                parseCpuLoad(data.cpu);
                parseRamLoad(data.ram);
                parseDiskUsage(data.disk);
            }
        });
    }

    setInterval(getServerStats, 5000);
    getServerStats();
</script>