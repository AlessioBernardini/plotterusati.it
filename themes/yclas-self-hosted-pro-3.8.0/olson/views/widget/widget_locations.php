<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($widget->locations_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->locations_title?></h3>
    </div>
<?endif?>

<div class="panel-body">
    <div class="sidey">
        <ul class="nav">
            <?if($widget->loc_breadcrumb !== NULL):?>
                <?if($widget->loc_breadcrumb['id_parent'] != 0):?>
                    <li>
                        <a href="<?=Route::url('list',array('location'=>$widget->loc_breadcrumb['parent_seoname'],'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($widget->loc_breadcrumb['parent_translate_name'])?>"><?=$widget->loc_breadcrumb['parent_translate_name']?></a>
                    </li>
                    <li>
                        <span class="active">
                            <?=$widget->loc_breadcrumb['translate_name']?>
                        </span>
                    </li>
                <?else:?>
                    <li>
                        <a href="<?=Route::url('list',array('location'=>$widget->loc_breadcrumb['parent_seoname'],'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($widget->loc_breadcrumb['parent_translate_name'])?>"><?=_e('Home')?></a>
                    </li>
                    <?if($widget->loc_breadcrumb['id'] != 1):?>
                        <li>
                            <span class="active">
                                <?=$widget->loc_breadcrumb['translate_name']?>
                            </span>
                        </li>
                    <?endif?>
                <?endif?>
            <?endif?>
            <?foreach($widget->loc_items as $loc):?>
                <?if ($widget->loc_breadcrumb['name'] != $loc->name):?>
                    <li>
                        <a class="<?=($widget->loc_breadcrumb !== NULL) ? 'sub' : NULL?>" href="<?=Route::url('list',array('location'=>$loc->seoname,'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($loc->translate_name())?>">
                            <?=$loc->translate_name()?>
                        </a>
                    </li>
                <?endif?>
            <?endforeach?>
        </ul>
    </div>
</div>