<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<footer>
    <div class="container">
        <div class="row">
            <?foreach ( Widgets::render('footer') as $widget):?>
            <div class="col-md-3">
                <?=$widget?>
            </div>
            <?endforeach?>
        </div>
    </div>
    <!--This is the license for Open Classifieds, do not remove -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
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
                    - <a href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme_mobile')?>"><?=_e('Mobile Version')?></a>
                    <?endif?>
                    <?if(Cookie::get('user_location')):?>
                        - <a href="<?=Route::url('default')?>?user_location=0"><?=_e('Change Location')?></a>
                    <?endif?>
                    </p>
                </div>
            </div>
            <?=method_exists('Core','yclas_url') ? View::factory('banners/footer') : NULL?>
        </div>
    </div>
</footer>

<?else:?>
<section class="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <p>&copy; <a href="<?=Route::url('default')?>"><?=core::config('general.site_name')?></a> <?=date('Y')?></p>
            </div>
        </div>
    </div>
</section>
<?endif?>
