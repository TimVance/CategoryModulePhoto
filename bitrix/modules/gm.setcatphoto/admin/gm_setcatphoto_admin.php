<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

/*********************************************************************************************
 *                                Handle
 *********************************************************************************************/

use Bitrix\Main\Context;
CModule::IncludeModule("iblock");
IncludeModuleLangFile(__FILE__);
CJSCore::Init();


$aTabs = array(
    array("DIV" => "edit1", "TAB" => 'Входные параметры', "ICON"=>"main_user_edit", "TITLE"=>'Входные параметры'),
    array("DIV" => "edit2", "TAB" => 'Обработка', "ICON"=>"main_user_edit", "TITLE"=>'Обработка'),
    array("DIV" => "edit3", "TAB" => 'Результат', "ICON"=>"main_user_edit", "TITLE"=>'Результат'),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs, false, true);

$request = Context::getCurrent()->getRequest();
print_r($_POST);

$step = 1;
$block_id = '';
$cat_id = '';
$message = '';
$action = 'settings';
$step_count = 50;
$delay = 5;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($request["action"] == 'settings') {
        if (!empty($request["step"])) $step = intval($request["step"]);
        if (!empty($request["IBLOCK_ID"])) $block_id = intval($request["IBLOCK_ID"]);
            else $message = 'Не выбран инфоблок';
        if (!empty($request["cat_id"])) $cat_id = $request["cat_id"];
        if (!empty($request["step_count"])) $step_count = intval($request["step_count"]);
        if (!empty($request["delay"])) $delay = intval($request["delay"]);
        if (strlen($message) == 0) {
            $all_count = CIBlockSection::GetCount(array("GLOBAL_ACTIVE" => 'Y', "IBLOCK_ID" => $block_id));
            $step++;
        }
    }
    elseif ($request["action"] == 'start' || $request["action"] == 'run') {
        $APPLICATION->RestartBuffer();
        if(ob_get_contents()) ob_end_clean();

        if (!empty($request["step"])) $step = intval($request["step"]);
        if (!empty($request["action"])) $action = $request["action"];
        if (!empty($request["block_id"])) $block_id = intval($request["block_id"]);
        if (!empty($request["cat_id"])) $cat_id = $request["cat_id"];
        if (!empty($request["step_count"])) $step_count = intval($request["step_count"]);
        if (!empty($request["delay"])) $delay = intval($request["delay"]);

        $all_count = CIBlockSection::GetCount(array("GLOBAL_ACTIVE" => 'Y', "IBLOCK_ID" => $block_id));
        $left_count = CIBlockSection::GetCount(array("GLOBAL_ACTIVE" => 'Y', "IBLOCK_ID" => $block_id, ">ID" => $cat_id));

        $arFilter = Array('IBLOCK_ID'=>$block_id, 'GLOBAL_ACTIVE'=>'Y');
        if ($action == 'run' && !empty($cat_id)) $arFilter[">ID"] = $cat_id;

        $db_list = CIBlockSection::GetList(Array("ID" => "ASC"), $arFilter, true, array("ID"), array("nTopCount" => $step_count));
        while($ar_result = $db_list->GetNext()) {
            $image = '';
            $cat_id = $ar_result["ID"];
            $elSelect = Array("ID", "DETAIL_PICTURE");
            $elFilter = Array("IBLOCK_ID" => $block_id, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "SECTION_ID" => $cat_id, "INCLUDE_SUBSECTIONS" => "Y", "!DETAIL_PICTURE" => false);
            $res = CIBlockElement::GetList(Array("ID" => "ASC"), $elFilter, false, Array("nTopCount" => 1), $elSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                $image = $arFields["DETAIL_PICTURE"];
            }
            if (!empty($image)) {
                $arImage = CFile::GetFileArray($image);
                $arImage = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$arImage["SRC"]);
                $bs = new CIBlockSection;
                $sectionField = array("PICTURE" => $arImage);
                $resChangeImage = $bs->Update($cat_id, $sectionField);
            }
        }
        //print_r($_POST);
        //print_r($arFilter);

        $progress = ($all_count - $left_count) / $all_count * 100;
        if ($left_count == 0) {
            $action = 'finish';
            $step = 3;
        }

        ?>


        <div id="resut_ajax_form">
            <?=bitrix_sessid_post()?>
            <input type="hidden" class="step" name="step" value="<?=$step?>">
            <input type="hidden" class="action" name="action" value="<?=$action?>">
            <input type="hidden" class="block_id" name="block_id" value="<?=$block_id?>">
            <input type="hidden" class="cat_id" name="cat_id" value="<?=$cat_id?>">
            <input type="hidden" class="step_count" name="step_count" value="<?=$step_count?>">
            <input type="hidden" class="delay" name="delay" value="<?=$delay?>">
        </div>

        <?

        echo 'Обработано '.($all_count - $left_count).' категорий';

        echo '<Br /><img height="120" src="https://rmets.onlinelibrary.wiley.com/ux3/widgets/publication-content/images/spinner.gif">';

        CAdminMessage::ShowMessage(array(
            "MESSAGE"=>"Обработка",
            "DETAILS"=> "#PROGRESS_BAR#",
            "HTML"=>true,
            "TYPE"=>"PROGRESS",
            "PROGRESS_TOTAL" => 100,
            "PROGRESS_VALUE" => $progress,
        ));

        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
        die();
    }
    elseif ($request["action"] == 'result') {
        if (!empty($request["step"])) $step = intval($request["step"]);
        if (!empty($request["IBLOCK_ID"])) $block_id = intval($request["IBLOCK_ID"]);
        if (!empty($request["cat_id"])) $cat_id = $request["cat_id"];
    }
}

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php';

$APPLICATION->SetTitle('Изображения категорий');?>


<form id="gm_setcatphoto_form" method="POST" action="<?=$APPLICATION->GetCurPage();?>?lang=<?=LANGUAGE_ID; ?>" ENCTYPE="multipart/form-data" name="dataload">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="step" value="<?=$step?>">
    <input type="hidden" name="action" value="<?=$action?>">
    <? if ($step > 1) { ?>
        <input type="hidden" class="block_id" name="block_id" value="<?=$block_id?>">
        <input type="hidden" name="cat_id" value="<?=$cat_id?>">
        <input type="hidden" class="step_count" name="step_count" value="<?=$step_count?>">
        <input type="hidden" class="delay" name="delay" value="<?=$delay?>">
    <? } ?>


    <?

    /*********************************************************************************************
     *                                First Tab
     *********************************************************************************************/


    $tabControl->Begin();
    $tabControl->BeginNextTab();

    ?>

    <tr>
        <td width="40%">Информационный блок</td>
        <td width="60%"><? echo GetIBlockDropDownList(array(), 'IBLOCK_TYPE_ID', 'IBLOCK_ID', false, 'class="adm-detail-iblock-types"', 'class="adm-detail-iblock-list"')?></td>
    </tr>
    <tr>
        <td width="40%">Шаг</td>
        <td width="60%"><input type="text" size="3" value="50"> шт.</td>
    </tr>
    <tr>
        <td width="40%">Задержка</td>
        <td width="60%"><input type="text" size="3" value="5"> сек.</td>
    </tr>
    <tr>
        <td width="40%">Перезаписывать установленные изображения</td>
        <td width="60%"><input type="checkbox"></td>
    </tr>
    <tr>
        <td width="40%">Размеры изображения</td>
        <td width="60%">
            <div><label><input class="gm__photo-size" type="radio" value="1" checked name="photo_size"> Не менять</label></div>
            <div><label><input class="gm__photo-size" type="radio" value="2" name="photo_size"> Использовать настройки инфоблока</label></div>
            <div>
                <label><input class="gm__photo-size" type="radio" value="3" name="photo_size"> Задать размеры изображений</label>
                <div id="gm__photo-size-inputs">
                    <div>Максималная ширина: <input type="text" size="4"></div>
                    <div>Максималная высота: <input type="text" size="4"></div>
                </div>
            </div>
        </td>
    </tr>
    <?

    /*********************************************************************************************
     *                                Second Tab
     *********************************************************************************************/


    $tabControl->BeginNextTab();

    echo '
    <tr>
        <td>Всего найдено категорий</td><td>'.$all_count.' </td>
     </tr>
    ';
    ?>

    <tr>
        <td width="40%">Из какого свойства товара брать изображение</td>
        <td><?

            $dbRes = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$block_id));
            while($arr = $dbRes->Fetch()) {
                $arProperties[] = array(
                    "value" => "IP_PROP".$arr["ID"],
                    "name" => $arr["NAME"].' ['.$arr["CODE"].']',
                    "uid" => ($bUid ? "Y" : "N"),
                    "wdesc" => (bool)($arr["WITH_DESCRIPTION"]=='Y' || ($arr['PROPERTY_TYPE']=='E' && $arr['USER_TYPE'] && !(in_array($arr['USER_TYPE'], array('SKU', 'EList', 'EAutocomplete'))))),
                    "forsum" => (bool)(($arr["PROPERTY_TYPE"]=='S' || $arr["PROPERTY_TYPE"]=='N') && !$arr['USER_TYPE'] && $arr['MULTIPLE']=='N')
                );
            }
            ?>
            <select name="" id="">
                <option value="DETAIL_PICTURE">Детальная картинка [DETAIL_PICTURE]</option>
                <option value="PREVIEW_PICTURE">Картинка для анонса [PREVIEW_PICTURE]</option>
                <?php
                foreach ($arProperties as $property) {?>
                    <option data="" value="<?=$property["value"] ?>"><?=$property["name"] ?></option>
                <?}
                ?>
            </select>
        </td>
    </tr>

    <?
    echo '<div id="setcatphoto_result"></div>';

    /*********************************************************************************************
     *                                Third Tab
     *********************************************************************************************/

    $tabControl->BeginNextTab();

    echo 'Результат';


    /*********************************************************************************************
     *                                Buttons
     *********************************************************************************************/


    $tabControl->Buttons();

    if ($step == 1) echo '<input type="submit" value="Далее >>" class="adm-btn-save">';
    if ($step == 2) echo '<input id="stop_setcatphoto" type="button" value="<< Назад">
                            <input class="adm-btn-save" id="start_setcatphoto" type="button" value="Старт!">';
    if ($step == 3) echo '<input type="button" value="<< В начало" id="stop_setcatphoto">';

    $tabControl->End();



    CAdminMessage::ShowMessage($message);


    /*********************************************************************************************
     *                                JS
     *********************************************************************************************/

    ?>


    <script language="JavaScript">
        BX.ready(function() {
            <?if ($step == 1):?>
            tabControl.SelectTab("edit1");
            tabControl.DisableTab("edit2");
            tabControl.DisableTab("edit3");
            <?elseif ($step == 2):?>
            tabControl.DisableTab("edit1");
            tabControl.SelectTab("edit2");
            tabControl.DisableTab("edit3");
            <?elseif ($step == 3):?>
            tabControl.DisableTab("edit1");
            tabControl.DisableTab("edit2");
            tabControl.SelectTab("edit3");
            <?endif;?>

            function sendRequest(post) {
                node = BX('setcatphoto_result');
                BX.ajax.post(
                    window.location.href,
                    post,
                    function (data) {
                        node.innerHTML = data;
                        console.log('success');
                        setTimeout(generateImagesRun, 5000);
                    }
                );
            }

            function generateImagesStart() {
                var block_id = document.querySelector('.block_id').value;

                console.log('start');

                var post = {};
                post['action'] = 'run';
                post['step'] = '2';
                post['block_id'] = block_id;

                sendRequest(post);
            }

            function generateImagesRun() {
                console.log('run');

                var result = document.getElementById('resut_ajax_form');
                console.log(result);
                var action = result.querySelector('.action').value;
                var step = result.querySelector('.step').value;
                var block_id = result.querySelector('.block_id').value;
                var cat_id = result.querySelector('.cat_id').value;

                var post = {};
                post['action'] = action;
                post['step'] = step;
                post['block_id'] = block_id;
                post['cat_id'] = cat_id;
                console.log(post);

                if (action != 'finish') sendRequest(post);
                    else {
                        result.querySelector('.action').value = 'result';
                        result.querySelector('.step').value = '3';
                        document.getElementById('gm_setcatphoto_form').submit();
                    }
            }

            function generateImagesStop() {
                window.location.href = window.location.href;
            }

            function toggleSizeInputs() {
                console.log("toggleSize");
                var inputs = document.getElementById('gm__photo-size-inputs');
                var elements = document.querySelectorAll('.gm__photo-size');
                for (var i = 0; i < elements.length; i++) {
                    console.log(elements[i].value);
                    if(elements[i].value == 3) {
                        if (elements[i].checked) inputs.classList.add("visible");
                            else inputs.classList.remove("visible");
                    }
                }
            }

            BX.bind(BX('start_setcatphoto'), 'click', generateImagesStart);
            BX.bind(BX('stop_setcatphoto'), 'click', generateImagesStop);
            var gm_photo_size = document.querySelectorAll('.gm__photo-size');
            for(var i = 0; i < gm_photo_size.length; i++) {
                gm_photo_size[i].addEventListener("change", toggleSizeInputs);
            }

        });
    </script>

    <style>
        #gm__photo-size-inputs {
            opacity: 0;
            visibility: hidden;
            max-height: 0;
            padding-left: 25px;
            padding-top: 5px;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            -ms-transition: all .3s;
            -o-transition: all .3s;
            transition: all .3s;
        }
        #gm__photo-size-inputs.visible {
            opacity: 1;
            visibility: visible;
            max-height: 100px;
        }
        #gm__photo-size-inputs > * {
            margin-bottom: 5px;
        }
    </style>

</form>

<? require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php'; ?>
