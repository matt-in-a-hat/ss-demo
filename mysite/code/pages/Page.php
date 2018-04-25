<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;

class Page extends SiteTree
{
    private static $db = [];

    private static $has_one = [];

    public function IsSiteUnderMaintenance() {
        $config = SiteConfig::current_site_config();
        return $config->ShowDownForMaintenanceMessage;
    }
}
