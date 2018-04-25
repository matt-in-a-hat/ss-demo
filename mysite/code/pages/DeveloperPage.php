<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms;

class DeveloperPage extends RolePage
{
    private static $ProficiencyOptions = ['PHP', 'js', 'python', 'ruby', '.NET', 'lisp'];
    private static $db = [
        'LanguageProficiencies' => 'Text',
    ];

    private static $icon = 'images/code.png';

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Main', array(
            Forms\ListboxField::create(
                'LanguageProficiencies',
                'Language Proficiencies',
                self::$ProficiencyOptions
            ),
        ), 'Content');
        return $fields;
    }

    public function DisplayProficiencies() {
        $results = [];
        $profs = json_decode($this->LanguageProficiencies);
        if (!$profs) {
            return '';
        }
        foreach ($profs as $index) {
            $results[] = self::$ProficiencyOptions[$index];
        }
        return implode(', ', $results);
    }
}
