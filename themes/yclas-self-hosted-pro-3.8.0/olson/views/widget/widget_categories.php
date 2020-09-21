<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($widget->categories_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->categories_title?></h3>
    </div>
<?endif?>

<div class="panel-body">
    <div class="sidey">
        <ul class="nav">
            <?if($widget->cat_breadcrumb !== NULL):?>
                <?if($widget->cat_breadcrumb['id_parent'] != 0):?>
                    <li>
                        <a href="<?=Route::url('list',array('category'=>$widget->cat_breadcrumb['parent_seoname'],'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($widget->cat_breadcrumb['parent_translate_name'])?>"><?=$widget->cat_breadcrumb['parent_translate_name']?></a>
                    </li>
                    <li>
                        <span class="active">
                            <?=$widget->cat_breadcrumb['translate_name']?>
                        </span>
                    </li>
                <?else:?>
                    <li>
                        <a href="<?=Route::url('list',array('category'=>$widget->cat_breadcrumb['parent_seoname'],'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($widget->cat_breadcrumb['parent_translate_name'])?>"><i class="fa fa-home"></i> <?=_e('Home')?></a>
                    </li>
                    <li>
                        <span class="active">
                            <?=$widget->cat_breadcrumb['translate_name']?>
                        </span>
                    </li>
                <?endif?>
            <?endif?>
            <?foreach($widget->cat_items as $cat):?>
                <?if ($widget->cat_breadcrumb['name'] != $cat->name):?>
                    <li>
                        <a class="<?=($widget->cat_breadcrumb !== NULL) ? 'sub' : NULL?>" href="<?=Route::url('list',array('category'=>$cat->seoname,'location'=>$widget->loc_seoname))?>" title="<?=HTML::chars($cat->translate_name())?>">
                            <?=$cat->translate_name()?>
                        </a>
                    </li>
                <?endif?>
            <?endforeach?>
        </ul>
    </div>
</div>