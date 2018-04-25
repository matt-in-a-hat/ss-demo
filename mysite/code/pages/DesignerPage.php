<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Image;
use SilverStripe\Forms;
use SilverStripe\AssetAdmin\Forms\UploadField;

class DesignerPage extends RolePage
{
    private static $many_many = [
        'DesignFragments' => Image::class,
    ];

    private static $icon = 'images/photoshop.png';

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', UploadField::create('DesignFragments'), 'Content');
        // $fields->addFieldsToTab('Root.Main', array(
        // ), 'Content');
        return $fields;
    }
}
