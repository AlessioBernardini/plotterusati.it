<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?if (Theme::get('header_ad_possible')!=''):?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 header-ad-room">
				<?=(Theme::get('header_ad_possible')!='')?Theme::get('header_ad_possible'):''?>
			</div>
		</div>
	</div>
<?endif?>

<?if(core::config('advertisement.homepage_map') == 1):?>
	<?=View::factory('pages/map/home')?>
<?endif?>

<section id="main" class="categories">
    <div class="container no-gutter">
    	<?=Alert::show()?>
		<div class="row">
			<div class="col-xs-12">
			     <?=(Theme::get('breadcrumb')==1)?Breadcrumbs::render('breadcrumbs'):''?>
			</div>
		    <?foreach ( Widgets::render('header') as $widget):?>
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		            <div class="header-widget">
		            	<?=$widget?>
		            </div>
		        </div>
		    <?endforeach?>
		    <?if (Core::Config('appearance.map_active')):?>
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="text-center"><?=_e("Map")?></h2>
                        <?=Core::Config('appearance.map_jscode')?>
                    </div>
                </div>
                <br><br>
            <?endif?>
		</div>
        <div class="row">
            <?if (Theme::get('homepage_html')!=''):?>
                <div class="col-xs-12 text-center">
                    <?=Theme::get('homepage_html')?>
                </div>
            <?endif?>
            <div class="col-xs-12">
                <?if(Core::config('general.algolia_search') == 1):?>
    	            <?=View::factory('pages/algolia/autocomplete')?>
                <?else:?>
                    <?= FORM::open(Route::url('search'), array('class'=>'search-frm', 'method'=>'GET', 'action'=>''))?>
                        <input type="text" name="title" class="form-control search-input"  placeholder="<?=__('Enter keyword...')?>">
                        <button type="submit" class="primary-btn color-primary btn"><span><?=_e('Search')?></span> <i class="fa fa-search"></i></button>
                    <?= FORM::close()?>
                <?endif?>
        	</div>
        </div>
    </div>
</section>
<section id="related">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 text-center">
		        <?if(core::config('advertisement.ads_in_home') == 0):?>
		        <h2><?=_e('Latest Ads')?></h2>
		        <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
		        <h2><?=_e('Featured Ads')?></h2>
		        <?elseif(core::config('advertisement.ads_in_home') == 2):?>
		        <h2><?=_e('Popular Ads last month')?></h2>
		        <?endif?>
    		</div>
    		<div class="col-xs-12">
	            <ul>
	                <?$i=0;
	                foreach($ads as $ad):?>
	                <li class="item list-group-item col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                	<div class="overlay"><a class="btn" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('Read more')?></a></div>
	                  	<div class="text col-xs-12 col-sm-8 col-md-6">
	                        <h2 class="big-txt">
	                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 25, NULL, TRUE)?> <a class="company" href="<?=Valid::url($ad->website) ? : Route::url('profile', array('seoname'=>$ad->user->seoname))?>"> @ <?=Text::limit_chars(Text::removebbcode((isset($ad->cf_company) AND $ad->cf_company)?$ad->cf_company:$ad->user->name), 15, NULL, TRUE)?></a>
	                     	</h2>
	                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 55, NULL, TRUE)?></p>
						</div>
	                    <div class="listing-categorie hidden-xs col-sm-4 col-md-3">
							<span class="btn btn-inverse no-cursor"><a href="<?=Route::url('list', array('category'=>$ad->category->seoname, 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$ad->category->translate_name() ?></a></span>
							<?if(isset($ad->cf_jobtype) AND $ad->cf_jobtype):?>
								<span class="btn btn-inverse no-cursor"><a href="<?=Route::url('search')?>?<?=http_build_query(['cf_jobtype' => $ad->cf_jobtype])?>"><?=$ad->cf_jobtype?></a></span>
							<?endif?>
						</div>
						<div class="text-center location hidden-xs hidden-sm col-md-2">
							<?if ( core::config('advertisement.location') AND ! in_array($ad->id_location, array(0, 1)) AND $ad->location->loaded() ) :?>
	                        	<span><i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?></span>
	                        <?endif?>
                        </div>
                        <div class=" text-center date hidden-xs hidden-sm col-md-1">
                            <?if ($ad->published!=0){?>
                                <span><?= Date::format($ad->published, core::config('general.date_format'))?></span>
                            <? }?>
                        </div>

	                </li>
	                <?endforeach?>
	            </ul>
        	</div>
        </div>
    </div>
</section>

<?if(core::config('advertisement.homepage_map') == 2):?>
	<?=View::factory('pages/map/home')?>
<?endif?>
