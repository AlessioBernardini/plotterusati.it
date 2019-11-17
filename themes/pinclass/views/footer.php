<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<div class="clear"></div>
<?if(Theme::get('bannergroup')==1):?>
    <section class="bannergroup">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8">
                    <h1><?=Theme::get('maintitle_bannergroup')?></h1>
                    <h4><?=Theme::get('subtitle_bannergroup')?></h4>
                </div>
                <?if(strtolower(Request::current()->action())!='index' OR strtolower(Request::current()->controller())!='new'):?>
	                <div class="col-xs-12 col-sm-4 text-right">
	                    <a href="<?=Route::url('post_new')?>" class="btn btn-inverse"><?=_e('Place new ad')?></a>
	                </div>
                <?endif?>
            </div>
        </div>
    </section>
<?endif?>
<footer>
    <button class="footer-toggle" id="togglefooter"></button>
    <div class="footerwrapper">
        <div class="container">
            <div class="row">
                <?foreach ( Widgets::render('footer') as $widget):?>
                    <div class="col-xs-12 col-sm-3">
                        <?=$widget?>
                    </div>
                <?endforeach?>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <? if (Core::config('general.multilingual')) : ?>
                            <div class="dropdown dropup pull-right">
                                <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-language"></i> <?= i18n::get_display_language(i18n::$locale) ?> <span class="caret"></span>
                                </button>
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
                        <?=(Theme::get('footer_ad')!='')?Theme::get('footer_ad'):''?>
                        <nav class="pages pull-right">
                            <ul>
                                <?if(Core::config('appearance.theme_mobile')!=''):?>
                                    <li>
                                        <a href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme_mobile')?>"><?=_e('Mobile Version')?></a>
                                    </li>
                                <?endif?>
                                <?if(Cookie::get('user_location')):?>
                                    <li>
                                        <a href="<?=Route::url('default')?>?user_location=0"><?=_e('Change Location')?></a>
                                    </li>
                                <?endif?>
                                <?if (Theme::get('footer_pages') != 1) :?>
                                    <?
                                        $pages = new Model_Content();
                                        $pages = $pages ->select('seotitle','title')
                                            ->where('type','=', 'page')
                                            ->where('status','=', 1)
                                            ->order_by('order','asc')
                                            ->cached()
                                            ->find_all();
                                    ?>
                                    <?foreach ($pages as $page):?>
                                        <?if (  core::config('payment.alternative')!=$page->seotitle AND
                                                core::config('general.alert_terms')!=$page->seotitle AND
                                                core::config('advertisement.tos')!=$page->seotitle AND
                                                core::config('advertisement.thanks_page')!=$page->seotitle AND
                                                core::config('general.contact_page')!=$page->seotitle AND
                                                core::config('general.private_site_page')!=$page->seotitle): ?>
                                            <li><a href="<?=Route::url('page',array('seotitle'=>$page->seotitle))?>" title="<?=HTML::chars($page->title)?>">
                                                <?=$page->title?></a>
                                            </li>
                                        <?endif?>
                                    <?endforeach?>
                                <?endif?>
                            </ul>
                        </nav>
                        <p class="pull-left">&copy; <?=core::config('general.site_name')?> <?=date('Y')?></p>
                    </div>
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