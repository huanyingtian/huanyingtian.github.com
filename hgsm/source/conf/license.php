<?php
define('LICENSE', 1);
$api = load::load_class('api','source/model');
$api->setCacheTime(2592000);
$api->licenseControl();
