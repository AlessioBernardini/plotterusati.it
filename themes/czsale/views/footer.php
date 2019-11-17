<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Theme::landing_single_ad() == FALSE):?>
<div class="footer">
    <?=(Theme::get('footer_ad')!='')?Theme::get('footer_ad'):''?>
    <div class="well well-sm">
        <?if (Core::config('advertisement.only_admin_post')!=1 AND strtolower(Request::current()->controller()) != 'new' AND strtolower(Request::current()->controller()) != 'myads'):?>
            <div class="pull-left">
                <ul class="nav nav-pills">
                    <li><a href="<?=Route::url('post_new')?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;<?=_e('Publish new')?></a></li>
                </ul>
            </div>
        <?endif?>
        <? if (Core::config('general.multilingual')) : ?>
            <div class="dropdown dropup pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <?if(Core::config('appearance.theme_mobile')!=''):?>
            <div class="pull-right">
                <ul class="nav nav-pills">
                    <li>
                        <a href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme_mobile')?>"><?=_e('Mobile Version')?></a>
                    </li>
                </ul>
            </div>
        <?endif?>
        <?if(Cookie::get('user_location')):?>
            <div class="pull-right">
                <ul class="nav nav-pills">
                    <li>
                        <a href="<?=Route::url('default')?>?user_location=0"><?=_e('Change Location')?></a>
                    </li>
                </ul>
            </div>
        <?endif?>
        <div class="clearfix">&nbsp;</div>
    </div>
    <div class="pull-right">
        <p class="text-muted">
            <small><?=core::config('general.site_name')?> <?=date('Y')?></small>
        </p>
    </div>
</div>

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

<?=method_exists('Core','yclas_url') ? View::factory('banners/footer') : NULL?>
