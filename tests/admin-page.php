<?php

use WebTheory\Form\Fields\Email;
use WebTheory\Form\Fields\Select;
use WebTheory\Form\Fields\Tel;
use WebTheory\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use WebTheory\WordPress\AdminPage\SettingsSection;
use WebTheory\WordPress\AdminPage\SettingsField;
use WebTheory\WordPress\AdminPage\SettingsPage;
use WebTheory\WordPress\SettingManager;
use Respect\Validation\Validator as v;

$group1 = 'ba-test';

/**
 * register settings
 */
$setting1 = (new SettingManager($group1, 'ba-test-1'))
    ->setType('string')
    ->setDescription('this is a test setting')
    ->addRule('email', v::optional(v::email()), 'Invalid thing provided')
    ->hook();

$setting2 = (new SettingManager($group1, 'ba-test-2'))
    ->setType('string')
    ->setDescription('this is another test setting')
    ->addRule('phone', v::optional(v::phone()), 'Another invalid thing provided')
    ->hook();

$setting3 = (new SettingManager($group1, 'ba-test-3'))
    ->setType('string')
    ->setDescription('this is a whole nother test setting')
    ->hook();


/**
 * add page
 */
$page1 = (new SettingsPage('company_info'))
    ->setMenuTitle('Company')
    ->setPageTitle('Company Info')
    ->setIcon('dashicons-store')
    ->setShowInMenu(true)
    ->setDescription('this is a test page')
    ->setPosition(100)
    ->setSubMenuName('Basic Info')
    ->addFieldGroups($group1)
    ->hook()
    ->getMenuSlug();


/**
 * register sections
 */
$section1 = (new SettingsSection('test-section-1', 'Test Section', $page1))
    ->setDescription('this is a test section')
    ->hook();


/**
 * register settings fields
 */
$settingField1 = (new SettingsField('ba-test-one', 'Test Setting 1', $page1))
    ->setSetting($setting1->getOptionName())
    ->setField((new Email)->addClass('regular-text'))
    ->setSection($section1->getId())
    ->hook();

$settingField2 = (new SettingsField('ba-test-two', 'Test Setting 2', $page1))
    ->setSetting($setting2->getOptionName())
    ->setSection($section1->getId())
    ->setField((new Tel))
    ->hook();

$settingField3 = (new SettingsField('ba-test-three', 'Test Setting 3', $page1))
    ->setSetting($setting3->getOptionName())
    ->setSection($section1->getId())
    ->setField((new Select)->setOptions(UsStatesAndTerritories::states('Select State')))
    ->hook();
