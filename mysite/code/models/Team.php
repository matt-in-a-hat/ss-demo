<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;

class Team extends DataObject {

    private static $db = [
        'Name' => 'Varchar(255)',
        'Velocity' => 'Int',
    ];

    private static $has_one = [
        'Badge' => Image::class,
    ];

    private static $owns = [
        'Badge',
    ];

    private static $many_many = [
        'MemberBots' => RolePage::class,
    ];

    private static $summary_fields = ['ID', 'Name', 'Velocity', 'LastEdited', 'getBadgePreview' => 'Badge'];

    private static $searchable_fields = [
        'ID',
        'Name',
    ];

    public function exportFields() {
        return [
            'ID', 'Created', 'LastEdited', 'Name', 'Velocity',
        ];
    }

    public function getBadgePreview() {
        return $this->Badge()->FitMax(120, 120);
    }

    public function getCMSFields() {
        $config = GridFieldConfig_RelationEditor::create();
        $fields = [
            Forms\LiteralField::create('Note1', '<h3>You can have any component you want in this form, including html like this heading...</h3>'),
            Forms\TextField::create('Name'),
            Forms\NumericField::create('Velocity'),
            UploadField::create('Badge'),
            GridField::create('MemberBots', 'Member Bots', $this->MemberBots(), $config),
        ];
        return Forms\FieldList::create($fields);
    }

    public function canView($member = null, $context = array()) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null, $context = array()) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null, $context = array()) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = array()) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
}
