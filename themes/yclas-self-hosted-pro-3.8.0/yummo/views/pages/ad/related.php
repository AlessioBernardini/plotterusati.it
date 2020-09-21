<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::count($ads)):?>
    <h2><?=_e('Related ads')?></h2>
    <div class="row">
        <ul>
        <?foreach($ads as $ad ):?>
            <li class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="latest_ads">
                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        <?if($ad->get_first_image()!== NULL):?>
                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 368, 'h' => 280], ['1200px' => ['w' => '368', 'h' => '280'], '992px' => ['w' => '468', 'h' => '350'], '768px' => ['w' => '360', 'h' => '275'], '480px' => ['w' => '765', 'h' => '510'], '320px' => ['w' => '480', 'h' => '300']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                        <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                            <?=HTML::picture($icon_src, ['w' => 368, 'h' => 280], ['1200px' => ['w' => '368', 'h' => '280'], '992px' => ['w' => '468', 'h' => '350'], '768px' => ['w' => '360', 'h' => '275'], '480px' => ['w' => '765', 'h' => '510'], '320px' => ['w' => '480', 'h' => '300']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                        <?else:?>
                            <img data-src="holder.js/360x275?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
                        <?endif?>
                    </a>
                    <div class="caption">
                        <h5><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h5>
                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 120, NULL, TRUE)?></p>
                    </div>
                    <div class="extra_info">
                        <?if ($ad->price!=0){?>
                            <div class="price pull-left">
                                <i class="fa fa-money"></i><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                            </div>
                        <?}?>
                        <div class="location pull-left">
                            <?if(Theme::get('listing_extra_info')=='views'):?>
                                <i class="fa fa-eye"></i><?=$ad->count_ad_hit()?>
                            <?elseif(Theme::get('listing_extra_info')=='location'):?>
                                <i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?>
                            <?elseif(Theme::get('listing_extra_info')=='user'):?>
                                <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="fa fa-user"></i><?=$ad->user->name?></a>
                            <?endif?>
                        </div>
                        <a class="more-link pull-right hvr-icon-forward" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('more')?></a>
                    </div>
                </div>
            </li>
        <?endforeach?>
        </ul>
    </div>
<?endif?>
