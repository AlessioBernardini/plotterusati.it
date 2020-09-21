<?php defined('SYSPATH') or die('No direct script access.');?>

<?= FORM::open(Route::url('search'), array('method'=>'GET'))?>
    <input type="text" name="search" placeholder="<?=__('Search')?>">
<?= FORM::close()?>
<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('advertisement.ads_in_home') != 3):?>
<?if(Theme::get('slider_in_home') != FALSE):?>
    <?foreach($ads as $ad):?>
    <!-- If featured used , show slider with fitured and latest ads dropdown. Else show only slider with latest ads -->
            <div data-role="collapsible" class="slider_title" data-theme="<?=Theme::get('theme_headers');?>">
                <?if(core::config('advertisement.ads_in_home') == 0):?>
                <h3><?=__('Latest Ads')?></h3>
                <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
                <h3><?=__('Featured Ads')?></h3>
                <?elseif(core::config('advertisement.ads_in_home') == 2):?>
                <h3><?=__('Popular Ads last month')?></h3>
                <?endif?>

                <ul data-role="listview" data-inset="true" class="slider_list">
                    <?foreach($ads as $ad):?>
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
            </div>
    <?endforeach?>
<?endif?>
<?endif?>

<form>

<h3 class="c-bl"><?=__("Categories")?></h3>
<ul data-role="listview" data-inset="true" data-divider-theme="b">
    <?foreach($categs as $c):?>
        <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
            <li data-role="list-divider" class="ui_parent_list_cat" data-theme="<?=Theme::get('theme_headers');?>">

                    <a title="<?=HTML::chars($c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname']))?>"><?=($c['translate_name']);?>
                        <span class="count_ads">
                            <span class="ui-li-count"><?=number_format($c['count'])?></span>
                        </span>
                    </a>

            </li>
            <?foreach($categs as $chi):?>
                <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                <li class="ui_child_list_cat"><a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname']))?>"><?=$chi['translate_name'];?></a>
                    <span class="count_ads">
                        <span class="ui-li-count"><?=number_format($chi['count'])?></span>
                    </span>
                </li>
                <?endif?>
            <?endforeach?>
        <?endif?>
    <?endforeach?>
</ul>
</form>

<?if(core::config('advertisement.homepage_map') == 2):?>
    <?=View::factory('pages/map/home')?>
<?endif?>