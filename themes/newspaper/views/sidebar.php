<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="col-xs-12 col-md-4">
    <?=method_exists('Core','yclas_url') ? View::factory('banners/sidebar') : NULL?>
    <div id="sidebar">
        <div class="row">
            <?foreach (Widgets::render('sidebar') as $widget): ?>
                <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12">
                    <div class="panel panel-sidebar">
                        <?=$widget?>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>
