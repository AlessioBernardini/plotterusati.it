<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($widget->categories_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->categories_title?></h3>
    </div>
<?endif?>

<div class="panel-body">
    <div class="list-group categories">
        <?if($widget->cat_breadcrumb !== NULL):?>
            <?if($widget->cat_breadcrumb['id_parent'] != 0):?>
                <a class="list-group-item active" href="<?=Route::url('list',array('category'=>$widget->cat_breadcrumb['parent_seoname'],'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($widget->cat_breadcrumb['parent_translate_name'])?>"><?=$widget->cat_breadcrumb['parent_translate_name']?> /
                    <?=$widget->cat_breadcrumb['translate_name']?>
                </a>
            <?else:?>
                <a class="list-group-item active" href="<?=Route::url('list',array('category'=>$widget->cat_breadcrumb['parent_seoname'],'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($widget->cat_breadcrumb['parent_translate_name'])?>"><?=_e('Home')?> /
                    <?=$widget->cat_breadcrumb['translate_name']?>
                </a>
            <?endif?>
        <?endif?>
        <?foreach($widget->cat_items as $cat):?>
            <a class="list-group-item" href="<?=Route::url('list',array('category'=>$cat->seoname,'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($cat->translate_name())?>">
                <?=$cat->translate_name()?></a>
        <?endforeach?>
    </div>
</div>