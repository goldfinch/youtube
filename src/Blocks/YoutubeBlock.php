<?php

namespace Goldfinch\Youtube\Blocks;

use Goldfinch\Fielder\Fielder;
use Goldfinch\Fielder\Traits\FielderTrait;
use DNADesign\Elemental\Models\BaseElement;

class YoutubeBlock extends BaseElement
{
    use FielderTrait;

    private static $table_name = 'YoutubeBlock';
    private static $singular_name = 'YouTube';
    private static $plural_name = 'YouTubes';

    private static $db = [
        'ContentType' => 'Enum("videos,channel_info", "videos")',
        'VideoLimit' => 'Int',
        // 'BlockTitle' => 'Varchar',
        // 'BlockSubTitle' => 'Varchar',
        // 'BlockText' => 'HTMLText',
    ];

    private static $inline_editable = false;
    private static $description = '';
    private static $icon = 'font-icon-block-video';

    private static $field_labels = [
        'ContentType' => 'Type',
        'VideoLimit' => 'Video limit',
    ];

    public function fielder(Fielder $fielder)
    {
        $fielder
            ->datafield('VideoLimit')
            ->displayIf('ContentType')
            ->isEqualTo('videos')
            ->end();
    }

    public function getSummary()
    {
        return $this->getDescription();
    }

    public function getType()
    {
        $default = $this->i18n_singular_name() ?: 'Block';

        return _t(__CLASS__ . '.BlockType', $default);
    }
}
