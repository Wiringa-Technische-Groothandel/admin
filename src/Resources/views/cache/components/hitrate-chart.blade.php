<h3>Cache hitrate {{ round(($opcache_stats->get('hits') / ($opcache_stats->get('hits') + $opcache_stats->get('misses'))) * 100, 1) }}%</h3>

<hr />

<div style="height: 200px;">
    <canvas id="hitsChart"></canvas>
</div>