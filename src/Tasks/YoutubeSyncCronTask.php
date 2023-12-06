<?php

namespace Goldfinch\Youtube\Tasks;

use Goldfinch\Youtube\Services\Youtube;
use SilverStripe\CronTask\Interfaces\CronTask;

class YoutubeSyncCronTask implements CronTask
{
    /**
     * run this task every 60 minutes
     *
     * @return string
     */
    public function getSchedule()
    {
        return "*/60 * * * *";
    }

    /**
     *
     * @return void
     */
    public function process()
    {
        $service = new Youtube;

        $service->YoutubeFeed();
        $service->YoutubeChannel();
    }
}
