<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="col-md-3 col-sm-12 col-xs-12 pull-right"> 
<?=method_exists('Core','yclas_url') ? View::factory('banners/sidebar') : NULL?>
<?foreach ( Widgets::render('sidebar') as $widget):?>
    <div class="well sidebar-nav" >
    	<div class="inner">
        	<?=$widget?>
        </div>
    </div>
<?endforeach?>
</div>