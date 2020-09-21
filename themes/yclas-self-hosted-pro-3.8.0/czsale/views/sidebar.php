<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="col-md-3 col-sm-12 col-xs-12 content-left">
    <?=method_exists('Core','yclas_url') ? View::factory('banners/sidebar') : NULL?>
    <h4><?=_e('Search')?></h4>
    <div class="well well-sm">
        <?if(Core::config('general.algolia_search') == 1):?>
            <div class="navbar-form">
                <fieldset>
                    <?=View::factory('pages/algolia/autocomplete')?>
                    <small><a href="<?=Route::url('search')?>" class="btn-advanced-search"><?=_e('Advanced Search')?></a></small>
                </fieldset>
            </div>
        <?else:?>
            <?= FORM::open(Route::url('search'), array('class'=>'navbar-form '.(Theme::get('short_description')!='')?'no-margin':'',
                'method'=>'GET', 'action'=>''))?>
                <fieldset>
                    <input type="text" name="search" class="form-control">
                    <small><a href="<?=Route::url('search')?>" class="btn-advanced-search"><?=_e('Advanced Search')?></a></small>
                    <input type="submit" class="btn btn-danger btn-sm btn-search" value="<?=__('Search')?>" />
                </fieldset>
            <?= FORM::close()?>
        <?endif?>
    </div>
    <?foreach ( Widgets::render('sidebar') as $widget):?>
        <div class="panel panel-sidebar <?=get_class($widget->widget)?>">
            <?=$widget?>
        </div>
    <?endforeach?>
</div>
