<?php

namespace Goldfinch\Youtube\Blocks;

use Goldfinch\Fielder\Fielder;
use Goldfinch\Fielder\Traits\FielderTrait;
use DNADesign\Elemental\Models\BaseElement;
use Goldfinch\Helpers\Traits\BaseElementTrait;

class YoutubeBlock extends BaseElement
{
    use FielderTrait, BaseElementTrait;

    private static $table_name = 'YoutubeBlock';
    private static $singular_name = 'YouTube';
    private static $plural_name = 'YouTubes';

    private static $db = [
        'ContentType' => 'Enum("videos,channel_info", "videos")',
        'VideoLimit' => 'Int',
    ];

    private static $inline_editable = false;
    private static $description = 'YouTube block handler';
    private static $icon = 'font-icon-block-video';

    private static $field_labels = [
        'ContentType' => 'Type',
        'VideoLimit' => 'Video limit',
    ];

    public function fielder(Fielder $fielder): void
    {
        $fielder
            ->datafield('VideoLimit')
            ->displayIf('ContentType')
            ->isEqualTo('videos')
            ->end();
    }
}
