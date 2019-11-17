<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<div class="clear"></div>
<?if(Theme::get('footer-visual')==1):?>
	<section id="footer-visual" <?= (Theme::get('footer_visual_bg_url') != '') ? 'style="background-image: url(\'' . Theme::get('footer_visual_bg_url') . '\')"' : NULL ?>></section>
<?endif?>
<footer>
    <?if (Theme::get('footer_ad_possible')!=''):?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 footer-ad-room">
                    <?=(Theme::get('footer_ad_possible')!='')?Theme::get('footer_ad_possible'):''?>
                </div>
            </div>
        </div>
    <?endif?>
    <?if (core::count($footer_widgets = Widgets::render('footer'))>0):?>
    <div class="container footer-widgets">
        <div class="row">
        <?$i=0; foreach ( $footer_widgets as $widget):?>
            <div class="col-xs-12 col-md-4">
                <?=$widget?>
            </div>
            <? $i++; if ($i%4 == 0) echo '<div class="clearfix"></div>';?>
        <?endforeach?>
    	</div>
    </div>
    <?endif?>
    <div class="copyright">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-12">
                    <p class="pull-left">
                        &copy; <?=core::config('general.site_name')?> <?=date('Y')?>. <?=_e('All rights reserved')?>
                        <?if(Core::config('appearance.theme_mobile')!=''):?>
                            - <a href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme_mobile')?>"><?=_e('Mobile Version')?></a>
                        <?endif?>
                        <?if(Cookie::get('user_location')):?>
                            - <a href="<?=Route::url('default')?>?user_location=0"><?=_e('Change Location')?></a>
                        <?endif?>
                    </p>
	    			<a id="toptop" href="#totop"><i class="pull-right fa fa-arrow-up"></i></a>
                    <? if (Core::config('general.multilingual')) : ?>
                        <div class="dropdown dropup pull-left">
                            &nbsp; -
                            <a href="#" data-toggle="dropdown">
                                <i class="fa fa-language"></i> <?= i18n::get_display_language(i18n::$locale) ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <? foreach (i18n::get_selectable_languages() as $locale => $language) : ?>
                                    <? if (i18n::$locale != $locale) : ?>
                                        <li>
                                            <a href="<?= Route::url('default') ?>?language=<?= $locale ?>">
                                            <?= $language ?></a>
                                        </li>
                                    <? endif ?>
                                <? endforeach ?>
                            </ul>
                        </div>
                    <? endif ?>
    			</div>
    		</div>
    	</div>
	</div>
</footer>

<?else:?>
<section class="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <p>&copy; <a href="<?=Route::url('default')?>"><?=core::config('general.site_name')?></a> <?=date('Y')?></p>
            </div>
        </div>
    </div>
</section>
<?endif?>
