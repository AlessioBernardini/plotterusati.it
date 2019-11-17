<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="categories-module">
    <h3 class="h3"><?=$widget->categories_title?></h3>	
    <ul>
    <?foreach($widget->cat_items as $cat):?>
        <li>
            <a href="<?=Route::url('list',array('category'=>$cat->seoname,'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($cat->name)?>">
                <? $icon_src = new Model_Category($cat->id_category); $icon_src = $icon_src->get_icon(); if(( $icon_src )!==FALSE ):?>
                    <img src="<?=$icon_src?>" class="icon img-responsive" alt="<?=HTML::chars($cat->name)?>">
                <?elseif (file_exists(DOCROOT.'images/categories/'.$cat->seoname.'_icon.png')):?> 
                    <img src="<?=URL::base().'images/categories/'.$cat->seoname.'_icon.png'?>" class="icon" alt="<?=HTML::chars($cat->name)?>">
                <?endif?>
                <p><?=$cat->name?></p>
            </a>
        </li>
    <?endforeach?>
    </ul>
</div>