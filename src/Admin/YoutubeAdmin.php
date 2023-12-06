<?php

namespace Goldfinch\Youtube\Admin;

use Goldfinch\Youtube\Models\YoutubeVideo;
use Goldfinch\Youtube\Blocks\YoutubeBlock;
use Goldfinch\Youtube\Configs\YoutubeConfig;
use SilverStripe\Admin\ModelAdmin;
use JonoM\SomeConfig\SomeConfigAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;

class YoutubeAdmin extends ModelAdmin
{
    use SomeConfigAdmin;

    private static $url_segment = 'youtube';
    private static $menu_title = 'YouTube';
    private static $menu_icon_class = 'bi-youtube';
    // private static $menu_priority = -0.5;

    private static $managed_models = [
        YoutubeVideo::class => [
            'title'=> 'Videos',
        ],
        YoutubeBlock::class => [
            'title'=> 'Blocks',
        ],
        YoutubeConfig::class => [
            'title'=> 'Settings',
        ],
    ];

    // public $showImportForm = true;
    // public $showSearchForm = true;
    // private static $page_length = 30;

    public function getList()
    {
        $list = parent::getList();

        // ..

        return $list;
    }

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        // ..

        return $config;
    }

    public function getSearchContext()
    {
        $context = parent::getSearchContext();

        // ..

        return $context;
    }

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // ..

        return $form;
    }

    // public function getExportFields()
    // {
    //     return [
    //         // 'Name' => 'Name',
    //         // 'Category.Title' => 'Category'
    //     ];
    // }
}
