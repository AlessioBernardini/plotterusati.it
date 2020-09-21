<?php defined('SYSPATH') or die('No direct script access.');?>
<footer>
    <div class="container">
        <?=(Theme::get('footer_ad')!='')?Theme::get('footer_ad'):''?>
        <hr>
            <p>
                <?
                $pages = new Model_Content();
                $pages = $pages->select('seotitle', 'title')
                    ->where('type', '=', 'page')
                    ->where('status', '=', 1)
                    ->order_by('order', 'asc')
                    ->cached()
                    ->find_all();
                ?>
                <? foreach ($pages as $page) : ?>
                    <? if (core::config('payment.alternative') != $page->seotitle and
                        core::config('general.alert_terms') != $page->seotitle and
                        core::config('advertisement.tos') != $page->seotitle and
                        core::config('advertisement.thanks_page') != $page->seotitle and
                        core::config('general.contact_page') != $page->seotitle and
                        core::config('general.private_site_page') != $page->seotitle) : ?>
                        <a href="<?= Route::url('page', array('seotitle' => $page->seotitle)) ?>" title="<?= HTML::chars($page->title) ?>">
                            <?= $page->title ?>
                        </a>
                         |
                    <? endif ?>
                <? endforeach ?>
                <a href="<?= Route::url('contact') ?>" title="<?= __('Contact') ?>">
                    <?= _e('Contact') ?>
                </a>
            </p>
        <hr>
        <?if (core::count(Widgets::render('footer')) > 0) :?>
            <div class="clearfix"></div>
            <div class="col-lg-12">
                <div class="row">
                    <?foreach ( Widgets::render('footer') as $widget):?>
                        <div class="col-lg-3">
                            <?=$widget?>
                        </div>
                    <?endforeach?>
                </div>
            </div>
        <?endif?>

        <div class="center-block">
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
            <p>&copy;
                <?=core::config('general.site_name')?> <?=date('Y')?>
                <?if(Core::config('appearance.theme_mobile')!=''):?>
                    - <a href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme_mobile')?>"><?=__('Mobile Version')?></a>
                <?endif?>
                <?if(Cookie::get('user_location')):?>
                    - <a href="<?=Route::url('default')?>?user_location=0"><?=__('Change Location')?></a>
                <?endif?>
            </p>
        </div>
        <hr>
    </div>
</footer>
