<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::count($ads)):?>
<h3 class="c-bl"><?=__('Related ads')?></h3>
<ul data-role="listview" data-transition="slide" data-inset="true"  data-split-icon="edit" class="list_table">
    <?foreach($ads as $ad ):?>
    <li data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_child_list_cat"><a data-transition="slide" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"  >
        <?if($ad->get_first_image() !== NULL):?>
            <img src="<?=$ad->get_first_image()?>">
        <?endif?>
        <h3><?=$ad->title;?></h3>
                <?if ($ad->price!=0){?>
                    <p class="c-wh"><strong><?=__('Price');?>:</strong> <?=i18n::money_format( $ad->price, $ad->currency())?></p>
                <?}?>  
                <p class="c-wh"><?=Text::limit_chars(Text::removebbcode($ad->description), 255, NULL, TRUE);?></p>
    </a></li>
    <?endforeach?>
</ul>
<?endif?>