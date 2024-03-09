<?php

namespace Goldfinch\Youtube\Blocks;

use DNADesign\Elemental\Models\BaseElement;
use Goldfinch\Helpers\Traits\BaseElementTrait;

class YoutubeBlock extends BaseElement
{
    use BaseElementTrait;

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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields()->initFielder($this);

        $fielder = $fields->getFielder();

        if ($fielder && $fielder->datafield('VideoLimit')) {
            $fielder
                ->datafield('VideoLimit')
                ->displayIf('ContentType')
                ->isEqualTo('videos')
                ->end();
        }

        return $fields;
    }
}
