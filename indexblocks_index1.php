<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?global $arMainPageOrder; //global array for order blocks?>
<?global $arTheme, $dopBodyClass;?>
<?if($arMainPageOrder && is_array($arMainPageOrder)):?>
	<?foreach($arMainPageOrder as $key => $optionCode):?>
		<?$strTemplateName = $arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_'.$optionCode.'_TEMPLATE']['VALUE'];?>
		<?$subtype = strtolower($optionCode);?>
		
		<?$dopBodyClass .= ' '.$optionCode.'_'.$strTemplateName;?>

		<?//BIG_BANNER_INDEX?>
		<?if($optionCode == "BIG_BANNER_INDEX"):?>
			<?global $bShowBigBanners, $bBigBannersIndexClass;?>
			<?if($bShowBigBanners):?>
				<?$bIndexLongBigBanner = ($strTemplateName != "type_1" && $strTemplateName != "type_4")?>
				<?if(!$bIndexLongBigBanner):?>
					<?$dopBodyClass .= ' right_mainpage_banner';?>
				<?endif;?>

				<?if($bIndexLongBigBanner):?>
					<?ob_start();?>
						<div class="middle">
				<?endif;?>

				<div class="drag-block grey container <?=$optionCode?> <?=$bBigBannersIndexClass?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
                    <div class="inner-banner-content">
                        <div class="maxwidth-theme">
                            <div class="inner-banner-content-inner">
                                <a onclick="let banner = document.querySelector('.mega_fixed_menu'); banner.style.display = 'block'; return false;" href="<?=$arItem["PROPERTIES"]["BUTTON1LINK"]["VALUE"]?>" class="<?=!empty($arItem["PROPERTIES"]["BUTTON1CLASS"]["VALUE"]) ? $arItem["PROPERTIES"]["BUTTON1CLASS"]["VALUE"] : "btn btn-default btn-lg"?>" <?=(strlen($target) ? 'target="'.$target.'"' : '')?>>Каталог</a>
                                <div class="smartsearch-field-main">
                                    <style>
                                        .smartsearch-field-main {
                                            display: inline-block;
                                            vertical-align: middle;
                                            margin-top: -10px;
                                            max-width: 450px;
                                            width: 100%;
                                        }
                                        .smartsearch-field-main .bx-searchtitle .bx-input-group .bx-form-control,
                                        .smartsearch-field-main .bx-searchtitle .bx-input-group-btn button {
                                            height: 41px;
                                        }
                                        .bx_searche {
                                            background: #fff;
                                        }
                                        .title-search-result .top_big_one_banner {
                                            display: none !important;
                                        }
                                        .main-slider__item .left .banner_title {
                                            margin-top: -30px;
                                        }
                                        .inner-banner-content-inner {
                                            position: absolute;
                                            width: 100%;
                                            z-index: 2;
                                            margin-left: 90px;
                                            bottom: 80px;
                                        }
                                        .inner-banner-content-inner .btn-lg {
                                            padding: 12px 21px 11px !important;
                                            height: 41px;
                                            margin-right: 10px;
                                        }
                                        .inner-banner-content-inner .bx-input-group {
                                            width: 90%;
                                        }
                                        @media screen and (max-width: 720px) {
                                            .inner-banner-content-inner .bx-input-group {
                                                width: 60%;
                                            }
                                        }
                                        @media screen and (max-width: 980px) {
                                            .inner-banner-content-inner .btn-lg {
                                                display: none;
                                            }
                                            .inner-banner-content-inner {
                                                margin-left: auto;
                                                left: 50%;
                                                transform: translateX(-30%);
                                            }
                                        }
                                    </style>
                                    <?$APPLICATION->IncludeComponent(
                                        "arturgolubev:search.title",
                                        ".default",
                                        array(
                                            "ANIMATE_HINTS" => array(
                                                0 => "234234",
                                                1 => "23423423423",
                                                2 => "",
                                            ),
                                            "ANIMATE_HINTS_SPEED" => "1",
                                            "CATEGORY_0" => array(
                                                0 => "iblock_aspro_max_catalog",
                                            ),
                                            "CATEGORY_0_TITLE" => "",
                                            "CHECK_DATES" => "N",
                                            "CONTAINER_ID" => "smart-title-search",
                                            "CONVERT_CURRENCY" => "N",
                                            "FILTER_NAME" => "",
                                            "INPUT_ID" => "smart-title-search-input",
                                            "INPUT_PLACEHOLDER" => "",
                                            "NUM_CATEGORIES" => "1",
                                            "ORDER" => "rank",
                                            "PAGE" => '',
                                            "PRICE_CODE" => array(
                                                0 => "BASE",
                                            ),
                                            "PRICE_VAT_INCLUDE" => "Y",
                                            "SHOW_HISTORY" => "Y",
                                            "SHOW_INPUT" => "Y",
                                            "SHOW_LOADING_ANIMATE" => "Y",
                                            "SHOW_PREVIEW" => "Y",
                                            "SHOW_PREVIEW_TEXT" => "N",
                                            "SHOW_PROPS" => array(
                                            ),
                                            "TOP_COUNT" => "5",
                                            "USE_LANGUAGE_GUESS" => "Y",
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PREVIEW_WIDTH_NEW" => "34",
                                            "PREVIEW_HEIGHT_NEW" => "34",
                                            "CATEGORY_0_iblock_aspro_max_catalog" => array(
                                                0 => "26",
                                            )
                                        ),
                                        $component
                                    );?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>

				<?if($bIndexLongBigBanner):?>
						</div>
					<?$html = ob_get_contents();
					ob_end_clean();?>
					<?$APPLICATION->AddViewContent('front_top_big_banner',$html);?>
				<?endif;?>
			<?endif;?>
		<?endif;?>

		<?//STORIES?>
		<?if($optionCode == "STORIES"):?>
			<?global $bShowStories, $bStoriesIndexClass;?>
			<?if($bShowStories):?>
				<div class="drag-block container <?=$optionCode?> <?=$bStoriesIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//TIZERS_INDEX?>
		<?if($optionCode == "TIZERS"):?>
			<?global $bShowTizers, $bTizersIndexClass;?>
			<?if($bShowTizers):?>
				<div class="drag-block container <?=$optionCode?> <?=$bTizersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//CATALOG_SECTIONS?>
		<?if($optionCode == "CATALOG_SECTIONS"):?>
			<?global $bShowCatalogSections, $bCatalogSectionsIndexClass;?>
			<?if($bShowCatalogSections):?>
				<div class="drag-block container <?=$optionCode?> <?=$bCatalogSectionsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//CATALOG_TAB?>
		<?if($optionCode == "CATALOG_TAB"):?>
			<?global $bShowCatalogTab, $bCatalogTabIndexClass;?>
			<?if($bShowCatalogTab):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bCatalogTabIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//MIDDLE_ADV?>
		<?if($optionCode == "MIDDLE_ADV"):?>
			<?global $bShowMiddleAdvBottomBanner, $bMiddleAdvIndexClass;?>
			<?if($bShowMiddleAdvBottomBanner):?>
				<div class="drag-block container <?=$optionCode?> <?=$bMiddleAdvIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//FLOAT_BANNERS?>
		<?if($optionCode == "FLOAT_BANNERS"):?>
			<?global $bShowFloatBanners, $bFloatBannersIndexClass;?>
			<?if($bShowFloatBanners):?>
				<div class="drag-block container <?=$optionCode?> <?=$bFloatBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//SALE?>
		<?if($optionCode == "SALE"):?>
			<?global $bShowSale, $bSaleIndexClass;?>
			<?if($bShowSale):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bSaleIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//COLLECTIONS?>
		<?if($optionCode == "COLLECTIONS"):?>
			<?global $bShowCollection, $bCollectionIndexClass;?>
			<?if($bShowCollection):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bCollectionIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//LOOKBOOKS?>
		<?if($optionCode == "LOOKBOOKS"):?>
			<?global $bShowLookbook, $bLookbookIndexClass;?>
			<?if($bShowLookbook):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bLookbookIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//REVIEWS?>
		<?if($optionCode == "REVIEWS"):?>
			<?global $bShowReview, $bReviewIndexClass;?>
			<?if($bShowReview):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bReviewIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//NEWS?>
		<?if($optionCode == "NEWS"):?>
			<?global $bShowNews, $bNewsIndexClass;?>
			<?if($bShowNews):?>
				<div class="drag-block container grey <?=$optionCode?> <?=$bNewsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BLOG?>
		<?if($optionCode == "BLOG"):?>
			<?global $bShowBlog, $bBlogIndexClass;?>
			<?if($bShowBlog):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBlogIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BOTTOM_BANNERS?>
		<?if($optionCode == "BOTTOM_BANNERS"):?>
			<?global $bShowBottomBanner, $bBottomBannersIndexClass;?>
			<?if($bShowBottomBanner):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBottomBannersIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//COMPANY_TEXT?>
		<?if($optionCode == "COMPANY_TEXT"):?>
			<?global $bShowCompany, $bCompanyTextIndexClass;?>
			<?if($bShowCompany):?>
				<div class="drag-block container <?=$optionCode?> <?=$bCompanyTextIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//MAPS?>
		<?if($optionCode == "MAPS"):?>
			<?global $bShowMaps, $bMapsIndexClass;?>
			<?if($bShowMaps):?>
				<div class="drag-block container <?=$optionCode?> <?=$bMapsIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//FAVORIT_ITEM?>
		<?if($optionCode == "FAVORIT_ITEM"):?>
			<?global $bShowFavoritItem, $bFavoritItemIndexClass;?>
			<?if($bShowFavoritItem):?>
				<div class="drag-block container <?=$optionCode?> <?=$bFavoritItemIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//BRANDS?>
		<?if($optionCode == "BRANDS"):?>
			<?global $bShowBrands, $bBrandsIndexClass;?>
			<?if($bShowBrands):?>
				<div class="drag-block container <?=$optionCode?> <?=$bBrandsIndexClass;?>" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName, true);?>
				</div>
			<?endif;?>
		<?endif;?>

		<?//INSTAGRAMM?>
		<?if($optionCode == "INSTAGRAMM"):?>
			<?global $bShowInstagramm, $bInstagrammIndexClass;?>
			<?if($bShowInstagramm):?>
				<div class="drag-block container <?=$optionCode?> <?=$bInstagrammIndexClass;?> js-load-block loader_circle" data-class="<?=$subtype?>_drag" data-order="<?=++$key;?>" data-file="<?=SITE_DIR;?>include/mainpage/components/<?=$subtype;?>/<?=$strTemplateName;?>.php">
					<?=CMax::ShowPageType('mainpage', $subtype, $strTemplateName);?>
				</div>
			<?endif;?>
		<?endif;?>

	<?endforeach;?>
<?endif;?>