<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$menu = array(
    array(
        'parent_menu' => 'global_menu_services',
        'sort' => 1500,
        'icon' => 'smile_menu_icon',
        'text' => Loc::getMessage('GM_SETCATPHOTO_MENU_TITLE'),
        'title' => Loc::getMessage('GM_SETCATPHOTO_MENU_TITLE'),
        'url' => 'gm_setcatphoto_admin.php',
    ),
);

return $menu;
