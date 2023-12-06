<?php

namespace Goldfinch\Youtube\Configs;

use JonoM\SomeConfig\SomeConfig;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\TemplateGlobalProvider;

class YoutubeConfig extends DataObject implements TemplateGlobalProvider
{
    use SomeConfig;

    private static $table_name = 'YoutubeConfig';

    private static $db = [];

    private static $field_descriptions = [];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // ..

        return $fields;
    }
}
