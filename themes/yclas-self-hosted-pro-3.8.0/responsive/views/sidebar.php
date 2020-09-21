<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="col-md-3 <?=(Theme::get('sidebar_position')=='left')?'col-md-pull-9':''?>" id="sidebar">
    <?=method_exists('Core','yclas_url') ? View::factory('banners/footer') : NULL?>
    <?foreach ( Widgets::render('sidebar') as $widget):?>
        <ul class="list-unstyled widget <?=get_class($widget->widget)?>">
            <li class="widget-header"></li>
            <li class="whitebox">
                <?=$widget?>
            </li>
        </ul>
    <?endforeach?>
</div>
