<?php

namespace Goldfinch\Youtube\Configs;

use Carbon\Carbon;
use SilverStripe\Assets\Image;
use JonoM\SomeConfig\SomeConfig;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use LeKoala\Encrypt\EncryptHelper;
use SilverStripe\Forms\FieldGroup;
use LeKoala\Encrypt\EncryptedDBText;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\CompositeField;
use PhpTek\JSONText\ORM\FieldType\JSONText;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\AssetAdmin\Forms\UploadField;

class YoutubeConfig extends DataObject implements TemplateGlobalProvider
{
    use SomeConfig;

    private static $table_name = 'YoutubeConfig';

    private static $db = [
        'YoutubeAPI' => 'Boolean',
        'YoutubeLimit' => 'Varchar',
        'APIKey' => EncryptedDBText::class,
        'ChannelID' => EncryptedDBText::class,
        'YoutubeOAuth2' => 'Boolean',
        'ClientID' => EncryptedDBText::class,
        'ClientSecret' => EncryptedDBText::class,
        'YoutubeAPILastSync' => 'Datetime',
        'ChannelData' => JSONText::class,
        'SaveImageToAssets' => 'Boolean',
    ];

    private static $has_one = [
        'DefaultVideoImage' => Image::class,
    ];

    private static $owns = [
        'DefaultVideoImage',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'YoutubeAPI',
            'YoutubeLimit',
            'APIKey',
            'ChannelID',
            'YoutubeOAuth2',
            'ClientID',
            'ClientSecret',
            'YoutubeAPILastSync',
            'ChannelData',
            'SaveImageToAssets',
        ]);

        $fields->addFieldsToTab(
          'Root.Main',
          [
            UploadField::create(
              'DefaultVideoImage',
              'Default video image',
            )->setDescription('for videos that do not have an image, or by some reason return nothing'),

            CompositeField::create(

              CheckboxField::create('SaveImageToAssets', 'Save image to assets'),
              CheckboxField::create('YoutubeAPI', 'Youtube API'),
              Wrapper::create(

                  TextField::create('YoutubeLimit', 'Limit'),
                  TextField::create('APIKey', 'API Key'),
                  LiteralField::create('APIKeyHelp', '<a href="https://console.cloud.google.com/apis/credentials" target="_blank">Where to get key?</a><br/><br/>'),
                  TextField::create('ChannelID', 'Channel ID'),
                  LiteralField::create('ChannelIDHelp', '<a href="https://commentpicker.com/youtube-channel-id.php" target="_blank">How to get ID?</a><br/><br/>'),

                  FieldGroup::create(

                    DatetimeField::create('YoutubeAPILastSync', 'Last Videos Sync')->setReadonly(true),
                    LiteralField::create('YoutubeAPILastSync_Btn', '<a href="#" class="btn action btn-primary font-icon-sync" style="margin-bottom: 23px;height: 38px;padding-top: 8px;"><span class="btn__title">Sync</span></a>'),

                  )->setDescription(
                    ($this->YoutubeAPILastSync ? ('Videos synced ' . Carbon::parse($this->YoutubeAPILastSync)->diffForHumans() . '') : '<div></div>')
                  ),

                  CheckboxField::create('YoutubeOAuth2', 'OAuth 2.0'),
                  Wrapper::create(

                      LiteralField::create('YoutubeOAuth2Help', '<a href="https://developers.google.com/youtube/v3/guides/authentication" target="_blank">Implementing OAuth 2.0 Authorization</a><br/><br/>'),
                      TextField::create('ClientID', 'Client ID'),
                      TextField::create('ClientSecret', 'Client Secret'),

                  )->displayIf('YoutubeOAuth2')->isChecked()->end(),

              )->displayIf('YoutubeAPI')->isChecked()->end(),

            ),
          ]
        );

        $fields->dataFieldByName('DefaultVideoImage')->setFolderName('youtube');

        // Set Encrypted Data
        $this->nestEncryptedData($fields);

        return $fields;
    }

    public function channelData($full = false)
    {
        $data = $this->dbObject('ChannelData')->getStoreAsArray();

        if (!$full)
        {
            $data = $data['items'][0];
        }

        return new ArrayData($data);
    }

    /**
     * $thumb (default 88x88 | medium 240x240 | high 800x800)
     */
    public function channelImage($thumb = 'default')
    {
        $dr = $this->channelData();

        $return = $dr->snippet->thumbnails->{$thumb}->url;

        if($return && is_array(@getimagesize($return)))
        {
            return $return;
        }
        else
        {
            return null;
        }
    }

    public function channelLink()
    {
        $dr = $this->channelData();

        return 'https://youtube.com/' . $dr->snippet->customUrl;
    }

    protected function nestEncryptedData(FieldList &$fields)
    {
        foreach($this::$db as $name => $type)
        {
            if (EncryptHelper::isEncryptedField(get_class($this->owner), $name))
            {
                $this->$name = $this->dbObject($name)->getValue();
            }
        }
    }
}
