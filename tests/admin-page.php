<?php

use Backalley\Form\Fields\Select;
use Respect\Validation\Validator as v;
use Backalley\Wordpress\AdminPage\AdminPage;
use Backalley\Wordpress\AdminPage\SettingsField;
use Backalley\Wordpress\AdminPage\SettingManager;
use Backalley\WordPress\AdminPage\SettingsSection;
use Backalley\Support\SelectOptions\UsStatesAndTerritories;

$setting1 = (new SettingManager('ba-test', 'ba-test-1'))
    ->setType('string')
    ->setDescription('this is a test setting')
    ->addRule('email', v::optional(v::email()), 'Invalid thing provided')
    ->hook();

$setting2 = (new SettingManager('ba-test', 'ba-test-2'))
    ->setType('string')
    ->setDescription('this is another test setting')
    ->addRule('phone', v::optional(v::phone()), 'Another invalid thing provided')
    ->hook();

$setting3 = (new SettingManager('ba-test', 'ba-test-3'))
    ->setType('string')
    ->setDescription('this is a whole nother test setting')
    ->hook();



$settingField1 = (new SettingsField('ba-test-one', 'Test Setting 1'))
    ->setSetting('ba-test-1')
    ->hook();

$settingField2 = (new SettingsField('ba-test-two', 'Test Setting 2'))
    ->setSetting('ba-test-2')
    ->setSection('test-section-1')
    ->hook();

$settingField3 = (new SettingsField('ba-test-three', 'Test Setting 3'))
    ->setSetting('ba-test-3')
    ->setSection('test-section-1')
    ->setField((new Select)->setOptions(UsStatesAndTerritories::states('Select State')))
    ->hook();



$section = (new SettingsSection('test-section-1', 'Test Section'))
    ->setDescription('this is a test section')
    ->addSetting($settingField1)
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
    ->addSetting($settingField2)
    ->addSetting($settingField3)
    ->hook();
