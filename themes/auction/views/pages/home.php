<?php defined('SYSPATH') or die('No direct script access.');?>
<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
	<?=View::factory('pages/map/home')?>
<?endif?>

<?if (Core::Config('appearance.map_active')):?>
    <section class="categories clearfix">
        <h2><?=_e('Map')?></h2>
        <?=Core::Config('appearance.map_jscode')?>
    </section>
<?endif?>

<?=View::factory('pages/home_latest_ads',array('ads'=>$ads, 'user_location'=> $user_location))?>

<?=View::factory('pages/home_categories',array('categs'=> $categs, 'hide_categories'=>$hide_categories, 'user_location'=> $user_location))?>

<?=View::factory('pages/home_sold_ads')?>

<?if(core::config('advertisement.homepage_map') == 2):?>
	<?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('general.auto_locate') AND ! Cookie::get('user_location') AND Core::is_HTTPS()):?>
    <input type="hidden" name="auto_locate" value="<?=core::config('general.auto_locate')?>">
    <?if(core::count($auto_locats) > 0):?>
        <div class="modal fade" id="auto-locations" tabindex="-1" role="dialog" aria-labelledby="autoLocations" aria-hidden="true">
            <div class="modal-dialog	modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="autoLocations" class="modal-title text-center"><?=_e('Please choose your closest location')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <?foreach($auto_locats as $loc):?>
                                <a href="<?=Route::url('default')?>" class="list-group-item" data-id="<?=$loc->id_location?>"><span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span> <?=$loc->name?> (<?=i18n::format_measurement($loc->distance)?>)</a>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
<?endif?>