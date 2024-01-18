<?php

namespace Goldfinch\Youtube\Views;

use SilverStripe\View\ViewableData;
use Goldfinch\Youtube\Models\YoutubeVideo;
use Goldfinch\Youtube\Configs\YoutubeConfig;

class Youtube extends ViewableData
{
    public function YoutubeVideos($limit = null)
    {
        if (!$this->authorized('YoutubeAPI')) {
            return;
        }

        if ($limit === null || $limit === '') {
            $cfg = $this->getCfg();
            $limit = $cfg->dbObject('YoutubeLimit')->getValue() ?? 10;
        }

        return YoutubeVideo::get()->limit($limit);
    }

    public function YoutubeFeed($limit = null)
    {
        if (!$this->authorized('YoutubeAPI')) {
            return;
        }

        $cfg = $this->getCfg();

        if ($limit === null || $limit === '') {
            $limit = $cfg->dbObject('YoutubeLimit')->getValue() ?? 10;
        }

        return $this->customise(['cfg' => $cfg, 'limit' => $limit])->renderWith(
            'Views/YoutubeFeed',
        );
    }

    public function YoutubeChannel($limit = null)
    {
        if (!$this->authorized('YoutubeAPI')) {
            return;
        }

        $cfg = $this->getCfg();

        return $this->customise(['cfg' => $cfg])->renderWith(
            'Views/YoutubeChannel',
        );
    }

    public function forTemplate()
    {
        if (!$this->authorized('YoutubeAPI')) {
            return;
        }

        return $this->renderWith('Views/YoutubeFeed');
    }

    private function authorized($state)
    {
        $cfg = YoutubeConfig::current_config();

        if ($cfg->$state) {
            return true;
        }

        return false;
    }

    private function getCfg()
    {
        return YoutubeConfig::current_config();
    }
}
