<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

class CustomSiteConfig extends DataExtension {
    private static $db = [
        'ShowDownForMaintenanceMessage' => 'Boolean',
    ];

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('ShowDownForMaintenanceMessage', 'Show site under maintenance message'),
        ]);
    }
}
