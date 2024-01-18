<?php

namespace Goldfinch\Youtube\Tasks;

use Goldfinch\Youtube\Services\Youtube;
use SilverStripe\Dev\BuildTask;

class YoutubeSyncBuildTask extends BuildTask
{
    private static $segment = 'YoutubeSync';

    protected $enabled = true;

    protected $title = 'Youtube - sync';

    protected $description = 'Fetch/sync videos and channel information from Youtube';

    public function run($request)
    {
        $service = new Youtube();

        $service->YoutubeFeed();
        $service->YoutubeChannel();
    }
}
