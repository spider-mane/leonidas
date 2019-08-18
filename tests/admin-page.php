<?php

use Backalley\Wordpress\AdminPage\AdminPage;
use Backalley\Wordpress\AdminPage\AdminSetting;
use Backalley\WordPress\AdminPage\SettingsSection;

$setting1 = (new AdminSetting)
    ->setType('string')
    ->setOptionGroup('ba-test')
    ->setOptionName('ba-test-1')
    ->setId('ba-test-one')
    ->setTitle('Test Setting 1')
    ->setDescription('this is a test setting')
    ->hook();

$setting2 = (new AdminSetting)
    ->setType('string')
    ->setOptionGroup('ba-test')
    ->setOptionName('ba-test-2')
    ->setId('ba-test-two')
    ->setTitle('Test Setting 2')
    ->setSection('test-section-1')
    ->setDescription('this is another test setting')
    ->hook();

$section = (new SettingsSection('test-section-1', 'Test Section'))
    ->setDescription('this is a test section')
    ->addSetting($setting1)
    ->hook();

$page = (new AdminPage('company_info', 'manage_options'))
    ->setMenuTitle('Company')
    ->setPageTitle('Company Info')
    ->setIcon('dashicons-store')
    ->setShowInMenu(true)
    ->setDescription('this is a test page')
    ->setPosition(100)
    ->setSubMenuName('Basic Info')
    ->setFieldGroups('ba-test')
    ->addSection($section)
    ->addSetting($setting2)
    ->hook();
