<?php

namespace Goldfinch\Youtube\Providers;

use Goldfinch\Youtube\Views\Youtube;
use SilverStripe\View\TemplateGlobalProvider;

class YoutubeTemplateProvider implements TemplateGlobalProvider
{
    /**
     * @return array|void
     */
    public static function get_template_global_variables(): array
    {
        return ['YoutubeService'];
    }

    /**
     * @return boolean
     */
    public static function YoutubeService(): Youtube
    {
        return Youtube::create();
    }
}
