<?php

namespace Goldfinch\Youtube\Models;

use Carbon\Carbon;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Goldfinch\JSONEditor\ORM\FieldType\DBJSONText;
use Goldfinch\Youtube\Configs\YoutubeConfig;

class YoutubeVideo extends DataObject
{
    private static $table_name = 'YoutubeVideo';
    private static $singular_name = 'youtube';
    private static $plural_name = 'youtubes';

    private static $db = [
      'VideoID' => 'Varchar',
      'PublishDate' => 'Datetime',
      'Data' => DBJSONText::class,
    ];

    private static $summary_fields = [
        'summaryThumbnail' => 'Image',
        'videoTitle' => 'Title',
        'videoDescription' => 'Description',
        'videoDateAgo' => 'Published at',
    ];

    // private static $many_many = [];
    // private static $many_many_extraFields = [];
    // private static $owns = [];
    // private static $has_one = [];
    // private static $belongs_to = [];
    // private static $has_many = [];
    // private static $belongs_many_many = [];
    // private static $default_sort = null;
    // private static $indexes = null;
    // private static $casting = [];
    // private static $defaults = [];
    // private static $field_labels = [];
    // private static $searchable_fields = [];

    // private static $cascade_deletes = [];
    // private static $cascade_duplicates = [];

    // * goldfinch/helpers
    private static $field_descriptions = [];
    private static $required_fields = [];

    private static $default_sort = 'PublishDate DESC';

    public function summaryThumbnail()
    {
        $img = $this->videoImage();

        $link = '<a onclick="window.open(\''.$this->videoLink().'\');" href="'.$this->videoLink().'" target="_blank">';

        if ($img)
        {
            $img = $link . '<img class="action-menu__toggle" src="'. $img. '" alt="Post image" width="140" height="140" style="object-fit: cover" /></a>';
        }
        else
        {
            $img = $link . '(no image)</a>';
        }

        $html = DBHTMLText::create();
        $html->setValue($img);

        return $html;
    }

    public function videoTitle()
    {
        $dr = $this->videoData();

        return $dr->snippet->title;
    }

    public function videoDescription()
    {
        $dr = $this->videoData();

        return $dr->snippet->description;
    }

    public function videoDate($format = 'Y-m-d H:i:s')
    {
        $dr = $this->videoData();

        return Carbon::parse($dr->snippet->publishedAt)->timezone(date_default_timezone_get())->format($format);
    }

    public function videoDateAgo()
    {
        $dr = $this->videoData();

        return Carbon::parse($dr->snippet->publishedAt)->timezone(date_default_timezone_get())->diffForHumans();
    }

    public function videoData()
    {
        return new ArrayData($this->dbObject('Data')->getStoreAsArray());
    }

    public function videoLink()
    {
        $dr = $this->videoData();

        return 'https://youtube.com/watch?v=' . $dr->id->videoId;
    }

    /**
     * $thumb (default 120x90 | medium 320x180 | high 480x360)
     */
    public function videoImage($thumb = 'default')
    {
        $dr = $this->videoData();

        $cfg = YoutubeConfig::current_config();

        $return = $dr->snippet->thumbnails->{$thumb}->url;

        if($return && is_array(@getimagesize($return)))
        {
            return $return;
        }
        else if($cfg->DefaultVideoImage()->exists())
        {
            return $cfg->DefaultVideoImage()->getURL();
        }
        else
        {
            return null;
        }
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // ..

        return $fields;
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
