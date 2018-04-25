<?php

use SilverStripe\Security\PasswordValidator;
use SilverStripe\Security\Member;
use SilverStripe\Core\Environment;

// remove PasswordValidator for SilverStripe 5.0
$validator = new PasswordValidator();

$validator->minLength(8);
$validator->checkHistoricalPasswords(6);
Member::set_password_validator($validator);

if (Environment::getEnv('SS_ENVIRONMENT_TYPE') === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
