<?php
use SilverStripe\Admin\ModelAdmin;

class TeamAdmin extends ModelAdmin {
    private static $managed_models = ['Team'];
    private static $url_segment = 'teams';
    private static $menu_title = 'Teams';

    public function getExportFields() {
        if (method_exists(singleton($this->modelClass), 'exportFields')) {
            return singleton($this->modelClass)->exportFields();
        }
        return parent::getExportFields();
    }
}
