<div class="col-md-3 col-sm-12 col-xs-12">

    <?= method_exists('Core', 'yclas_url') ? View::factory('banners/sidebar') : null ?>

    <?foreach ( Widgets::render('sidebar') as $widget):?>
        <div class="panel panel-default <?=get_class($widget->widget)?>">
            <?=$widget?>
        </div>
    <?endforeach?>
</div>
