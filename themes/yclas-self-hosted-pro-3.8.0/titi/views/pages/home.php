<?php defined('SYSPATH') or die('No direct script access.');?>

<?
// get user location if any
$user_location = NULL;
if (is_numeric($user_id_location = Cookie::get('user_location')))
{
    $user_location = new Model_Location($user_id_location);

    if ( ! $user_location->loaded())
        $user_location = NULL;
}

// featured ads
$featured_ads = new Model_Ad();
$featured_ads->where('status','=', Model_Ad::STATUS_PUBLISHED);

if ($user_location)
    $featured_ads->where('id_location', 'in', $user_location->get_siblings_ids());

$featured_ads->where('featured','IS NOT', NULL)
    ->where('featured', '>=', Date::unix2mysql())
    ->order_by(DB::expr('RAND()'));

$featured_ads = $featured_ads->limit(Theme::get('num_home_latest_ads', 4))->cached()->find_all();

// latest ads
$latest_ads = new Model_Ad();
$latest_ads->where('status','=', Model_Ad::STATUS_PUBLISHED);

if ($user_location)
    $latest_ads->where('id_location', 'in', $user_location->get_siblings_ids());

$latest_ads->order_by('published','desc');

$latest_ads = $latest_ads->limit(Theme::get('num_home_latest_ads', 4))->cached()->find_all();

// Blog posts
$posts = new Model_Post();
$posts = $posts->where('status','=', Model_Post::STATUS_ACTIVE)
    ->where('id_forum','IS',NULL)
    ->order_by('created','desc')
    ->limit(4)
    ->find_all();
?>

<div class="container">
    <div class="alert alert-warning off-line" style="display:none;"><strong><?=__('Warning')?>!</strong> <?=__('We detected you are currently off-line, please connect to gain full experience.')?></div>
    <?=Alert::show()?>
</div>

<?=View::factory('pwa/_alert')?>

<?= Theme::get('homepage_html') != '' ? Theme::get('homepage_html') : '' ?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if($ads_count = core::count($featured_ads)):?>
    <div class="home-section">
        <div class="container">
            <div class="home-section-header">
                <h2 class="text-center"><?=__('Featured Ads')?></h2>
            </div>
            <div id="carousel-featured" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="row">
                            <?$i = 0; foreach($featured_ads as $ad):?>
                                <div class="col-xs-12 col-sm-4 col-md-3 grid-item">
                                    <div class="box-card box-item-card">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <div class="box-card-header">
                                                <img src="<?=$ad->user->get_profile_image()?>" class="profile img-thumbnail">
                                                <?if (isset($ad->user->cf_verified) AND $ad->user->cf_verified) :?>
                                                    <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                                <?endif?>
                                                <?=($ad->user->id_user == 15 AND isset($ad->cf_milname))?$ad->cf_milname:$ad->user->name?>
                                            </div>
                                            <div class="box-card-images">
                                                <?if($ad->get_first_image()!== NULL):?>
                                                    <img width="1067" height="1067" src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?else:?>
                                                    <img width="1067" height="1067" data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?endif?>
                                            </div>
                                            <div class="box-card-footer">
                                                <div class="box-card-footer-title">
                                                    <div class="box-card-footer-title-wrapper">
                                                        <div class="headline">
                                                            <h4>
                                                                <?if (isset($ad->cf_verified) AND $ad->cf_verified) :?>
                                                                    <span class="text-verified">
                                                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                    </span>
                                                                <?endif?>
                                                                <?=$ad->title?>
                                                            </h4>
                                                        </div>
                                                        <div class="excerpt">
                                                            <p>
                                                                <?if ($ad->price!=0):?>
                                                                    <span class="price"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                                                <?endif?>
                                                                <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                                                    <span class="label label-danger"><?=_e('Free');?></span>
                                                                <?endif?>
                                                                <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                                            </p>
                                                            <?if(core::config('advertisement.location') AND $ad->id_location != 1):?>
                                                                <p><?=_e('Location')?>: <?=$ad->location->translate_name() ?></p>
                                                            <?endif?>
                                                            <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                                                <?if($value=='checkbox_1'):?>
                                                                    <p><?=$name?>: <i class="fa fa-check"></i></p>
                                                                <?elseif($value=='checkbox_0'):?>
                                                                    <p><?=$name?>: <i class="fa fa-times"></i></p>
                                                                <?else:?>
                                                                    <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                                        <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                                        <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?else:?>
                                                                        <?if(is_string($name)):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?else:?>
                                                                            <p><?=$value?></p>
                                                                        <?endif?>
                                                                    <?endif?>
                                                                <?endif?>
                                                            <?endforeach?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?$i++; if($i > 0 AND $ads_count > $i AND $i % 4 === 0):?>
                                    </div></div><div class="item"><div class="row">
                                <?endif?>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-featured" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="right carousel-control" href="#carousel-featured" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
            <div class="home-section-footer">
                <a class="btn btn-default btn-lg" href="<?=Route::url('list')?>"><?=_e('See all')?> <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
<?endif?>

<?if($ads_count = core::count($latest_ads)):?>
    <div class="home-section odd">
        <div class="container">
            <div class="home-section-header">
                <h2 class="text-center"><?=__('Latest Ads')?></h2>
            </div>
            <div id="carousel-featured" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="row">
                            <?$i = 0; foreach($latest_ads as $ad):?>
                                <div class="col-xs-12 col-sm-4 col-md-3 grid-item">
                                    <div class="box-card box-item-card">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <div class="box-card-header">
                                                <img src="<?=$ad->user->get_profile_image()?>" class="profile img-thumbnail">
                                                <?if (isset($ad->user->cf_verified) AND $ad->user->cf_verified) :?>
                                                    <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                                <?endif?>
                                                <?=($ad->user->id_user == 15 AND isset($ad->cf_milname))?$ad->cf_milname:$ad->user->name?>
                                            </div>
                                            <div class="box-card-images">
                                                <?if($ad->get_first_image()!== NULL):?>
                                                    <img width="1067" height="1067" src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?else:?>
                                                    <img width="1067" height="1067" data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?endif?>
                                            </div>
                                            <div class="box-card-footer">
                                                <div class="box-card-footer-title">
                                                    <div class="box-card-footer-title-wrapper">
                                                        <div class="headline">
                                                            <h4>
                                                                <?if (isset($ad->cf_verified) AND $ad->cf_verified) :?>
                                                                    <span class="text-verified">
                                                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                    </span>
                                                                <?endif?>
                                                                <?=$ad->title?>
                                                            </h4>
                                                        </div>
                                                        <div class="excerpt">
                                                            <p>
                                                                <?if ($ad->price!=0):?>
                                                                    <span class="price"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                                                <?endif?>
                                                                <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                                                    <span class="label label-danger"><?=_e('Free');?></span>
                                                                <?endif?>
                                                                <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                                            </p>
                                                            <?if(core::config('advertisement.location') AND $ad->id_location != 1):?>
                                                                <p><?=_e('Location')?>: <?=$ad->location->translate_name() ?></p>
                                                            <?endif?>
                                                            <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                                                <?if($value=='checkbox_1'):?>
                                                                    <p><?=$name?>: <i class="fa fa-check"></i></p>
                                                                <?elseif($value=='checkbox_0'):?>
                                                                    <p><?=$name?>: <i class="fa fa-times"></i></p>
                                                                <?else:?>
                                                                    <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                                        <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                                        <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?else:?>
                                                                        <?if(is_string($name)):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?else:?>
                                                                            <p><?=$value?></p>
                                                                        <?endif?>
                                                                    <?endif?>
                                                                <?endif?>
                                                            <?endforeach?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?$i++; if($i > 0 AND $ads_count > $i AND $i % 4 === 0):?>
                                    </div></div><div class="item"><div class="row">
                                <?endif?>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-featured" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="right carousel-control" href="#carousel-featured" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
            <div class="home-section-footer">
                <a class="btn btn-default btn-lg" href="<?=Route::url('list')?>"><?=_e('See all')?> <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
<?endif?>

<?if(core::count($posts)):?>
    <div class="home-section odd">
        <div class="container">
            <div class="home-section-header">
                <h2 class="text-center"><?= _e('Blog posts') ?></h2>
            </div>
            <div class="home-section-content">
                <div class="row" data-masonry='{ "itemSelector": ".grid-item" }'>
                    <?foreach($posts as $post):?>
                        <div class="col-xs-12 col-sm-4 col-md-3 grid-item">
                            <div class="box-card">
                                <a href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>">
                                    <?if(preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->description, $post_images)):// First image used as post thumb?>
                                        <div class="box-card-images">
                                            <img width="1067" height="1067" alt="<?=HTML::chars($post->title)?>" src="<?=$post_images[1]?>">
                                        </div>
                                    <?endif?>
                                    <div class="box-card-footer">
                                        <div class="box-card-footer-title">
                                            <div class="box-card-footer-title-wrapper">
                                                <div class="headline"><h4><?=$post->title?></h4></div>
                                                <div class="excerpt"><p><?=Text::truncate_html(strip_tags($post->description), 255, NULL)?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?endforeach?>
                </div>
            </div>
            <div class="home-section-footer">
                <a class="btn btn-default btn-lg" href="<?=Route::url('blog')?>"><?= _e('See all') ?> <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
<?endif?>

<?if(core::config('general.auto_locate') AND ! Cookie::get('user_location') AND Core::is_HTTPS()):?>
    <input type="hidden" name="auto_locate" value="<?=core::config('general.auto_locate')?>">
    <?if(core::count($auto_locats) > 0):?>
        <div class="modal fade" id="auto-locations" tabindex="-1" role="dialog" aria-labelledby="autoLocations" aria-hidden="true">
            <div class="modal-dialog	modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="autoLocations" class="modal-title text-center"><?=__('Please choose your closest location')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <?foreach($auto_locats as $loc):?>
                                <a href="<?=Route::url('list', array('location'=>$loc->seoname))?>" class="list-group-item" data-id="<?=$loc->id_location?>"><span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span> <?=$loc->name?> (<?=i18n::format_measurement($loc->distance)?>)</a>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
<?endif?>

<?if(core::config('advertisement.homepage_map') == 2):?>
    <?=View::factory('pages/map/home')?>
<?endif?>
