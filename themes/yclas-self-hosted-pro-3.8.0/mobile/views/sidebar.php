<?php defined('SYSPATH') or die('No direct script access.');?>
<?foreach ( Widgets::render('sidebar') as $widget):?>
    <div class="span3">
        <div class="category_box_title custom_box">
        </div>
        <div class="well custom_box_content" style="padding: 8px 0;">
            <?=$widget?>
        </div>
    </div>
<?endforeach?>