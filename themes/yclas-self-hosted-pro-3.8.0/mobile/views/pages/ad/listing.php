<?php defined('SYSPATH') or die('No direct script access.');?>

<?$slider_ads = ($featured != NULL)? $featured: $ads?>
<?if (core::count($slider_ads) > 0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
    <ul data-role="listview" data-transition="slide" data-inset="true"  data-split-icon="edit" class="slider_list">
        <?foreach($slider_ads as $ad):?>
            <li class="list_slider_item" data-theme="<?=Theme::get('theme_list_elements');?>">
                <a class="list_slider_element" data-transition="slide" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                    <?if($ad->get_first_image()!== NULL):?>
                        <img src="<?=Core::imagefly($ad->get_first_image(),80,80)?>" alt="<?= HTML::chars($ad->title)?>">
                    <?endif?>
                    <h3><?=$ad->title?></h3>
                    <p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
                </a>
            </li>
        <?endforeach?>
    </ul>
<?endif?>

<ul data-role="listview" data-transition="slide" data-inset="true"  data-split-icon="edit" class="list_table">
	<?if(core::count($ads)):

        //random ad
        $position = NULL;
        $i = 0;
        if (strlen(Theme::get('listing_ad'))>0)
            $position = rand(0,core::count($ads));?>

            <?if(Model_Category::current()->loaded()):?>
                <li data-role="list-divider" data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_parent_list_cat"><?=__('Category')?>: <?=Model_Category::current()->name?> </li>
            <?endif?>
            
	    <?foreach($ads as $ad ):?>
	   	<? $cat_name = $ad->category->seoname; ?>
	       	<?if($ad->featured >= Date::unix2mysql(time())):?>
		    	<li data-icon="star" data-theme="<?=Theme::get('theme_featured_elements');?>" class="ui_child_list_cat ui_featured"><a data-transition="slide" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>"  >
		    <?else:?>
		    	<li data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_child_list_cat"><a data-transition="slide" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>"  >
		    <?endif?>
		    	<?if($ad->get_first_image() !== NULL):?>
					<img src="<?=Core::imagefly($ad->get_first_image(),80,80)?>" alt="<?= HTML::chars($ad->title)?>">
		    	<?endif?>
				
				<h3><?=$ad->title;?></h3>
		    	<?if ($ad->price!=0){?>
		    		<p class="c-wh"><strong><?=__('Price');?>:</strong> <?=i18n::money_format( $ad->price, $ad->currency())?></p>
		    	<?}?>
                <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                    <p class="c-wh"><strong><?=__('Price');?>:</strong> <?=__('Free');?></p>
                <?}?>
                <?if(core::config('advertisement.description')!=FALSE):?>
			        <p class="c-wh"><?=Text::limit_chars(Text::removebbcode($ad->description), 255, NULL, TRUE);?></p>
                <?endif?>
                <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                    <?if($value=='checkbox_1'):?>
                        <p><b><?=$name?></b>: √</p>
                    <?elseif($value=='checkbox_0'):?>
                        <p><b><?=$name?></b>: &times;</p>
                    <?else:?>
                        <p class="c-wh"><strong><?=$name?></strong>: <?=$value?></p>
                    <?endif?>
                <?endforeach?>
			    
		    <?=Alert::show()?>
		    </a></li>

            <?if($i===$position):?>
            <li data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_child_list_cat">
                <?=Theme::get('listing_ad')?>
            </li>
            <?endif?>
	    <?
        $i++;
        endforeach?>
</ul>
   	<?=$pagination?>
   	<?elseif (core::count($ads) == 0):?>
   	<!-- Case when we dont have ads for specific category / location -->
   		<div class="page-header descr_content at_c">
		<h3><?=__('We do not have any advertisements in this category')?></h3>
	</div>
  
  <?endif?>
