<?php

namespace WTG\Admin\Services;

use Illuminate\Support\Collection;

class Stats
{
    /**
     * Return the disk usage.
     *
     * @return array
     */
    public function disk(): array
    {
        return [
            'total' => disk_total_space('/'),
            'free' => disk_free_space('/'),
        ];
    }

    /**
     * Return the CPU load.
     *
     * @return array
     */
    public function cpu(): array
    {
        $uptime = exec('uptime');
        $load = array_slice(explode(' ', str_replace(',', '', $uptime)), -3);
        $max = exec('grep "model name" /proc/cpuinfo | wc -l');

        return [
            'load' => $load[0],
            'max' => $max,
        ];
    }

    /**
     * Return the RAM usage.
     *
     * @return array
     */
    public function ram(): array
    {
        $total = preg_replace("/\D/", '', exec("grep 'MemTotal' /proc/meminfo"));
        $free = preg_replace("/\D/", '', exec("grep 'MemFree' /proc/meminfo"));

        $freePercentage = exec("free -t | grep 'buffers/cache' | awk '{print $4/($3+$4) * 100}'");

        return [
            'total' => $total,
            'freePercentage' => $freePercentage,
            'free' => $free,
        ];
    }
}