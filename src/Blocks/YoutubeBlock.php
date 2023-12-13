<?php

namespace Goldfinch\Youtube\Blocks;

use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBHTMLText;
use DNADesign\Elemental\Models\BaseElement;

class YoutubeBlock extends BaseElement
{
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
    // private static $disable_pretty_anchor_name = false;
    // private static $displays_title_in_template = true;

    // private static $has_one = [];
    // private static $belongs_to = [];
    // private static $has_many = [];
    // private static $many_many = [];
    // private static $many_many_extraFields = [];
    // private static $belongs_many_many = [];

    // private static $default_sort = null;
    // private static $indexes = null;
    // private static $owns = [];
    // private static $casting = [];
    // private static $defaults = [];

    // private static $summary_fields = [];
    private static $field_labels = [
        'ContentType' => 'Type',
        'VideoLimit' => 'Video limit',
    ];
    // private static $searchable_fields = [];

    // private static $cascade_deletes = [];
    // private static $cascade_duplicates = [];

    // * goldfinch/helpers
    // private static $field_descriptions = [];
    private static $required_fields = [];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('VideoLimit')->displayIf('ContentType')->isEqualTo('videos')->end();

        return $fields;
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

    // public function validate()
    // {
    //     $result = parent::validate();

    //     // $result->addError('Error message');

    //     return $result;
    // }

    // public function onBeforeWrite()
    // {
    //     // ..

    //     parent::onBeforeWrite();
    // }

    // public function onBeforeDelete()
    // {
    //     // ..

    //     parent::onBeforeDelete();
    // }

    // public function canView($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canEdit($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canDelete($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canCreate($member = null, $context = [])
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }
}
