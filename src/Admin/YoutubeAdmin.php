<?php

namespace Goldfinch\Youtube\Admin;

use SilverStripe\Admin\ModelAdmin;
use JonoM\SomeConfig\SomeConfigAdmin;
use Goldfinch\Youtube\Blocks\YoutubeBlock;
use Goldfinch\Youtube\Models\YoutubeVideo;
use Goldfinch\Youtube\Configs\YoutubeConfig;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;

class YoutubeAdmin extends ModelAdmin
{
    use SomeConfigAdmin;

    private static $url_segment = 'youtube';
    private static $menu_title = 'YouTube';
    private static $menu_icon_class = 'font-icon-block-video';
    // private static $menu_priority = -0.5;

    private static $managed_models = [
        YoutubeVideo::class => [
            'title' => 'Videos',
        ],
        YoutubeBlock::class => [
            'title' => 'Blocks',
        ],
        YoutubeConfig::class => [
            'title' => 'Settings',
        ],
    ];

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        if ($this->modelClass == YoutubeVideo::class) {
            $config->removeComponentsByType(GridFieldAddNewButton::class);
            $config->removeComponentsByType(GridFieldEditButton::class);
        }

        return $config;
    }

    public function getManagedModels()
    {
        $models = parent::getManagedModels();

        if (!class_exists('DNADesign\Elemental\Models\BaseElement')) {
            unset($models[YoutubeBlock::class]);
        }

        return $models;
    }
}
