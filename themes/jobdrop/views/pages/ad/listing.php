<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Theme::get('header_ad_possible')!=''):?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 header-ad-room">
                <?=(Theme::get('header_ad_possible')!='')?Theme::get('header_ad_possible'):''?>
            </div>
        </div>
    </div>
<?endif?>
<section id="main">
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
		</div>
        <div class="row">
			<section class="post-section <?=(Theme::get('sidebar_position')!='none')?'sidebar-active-container col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-xs-12 col-lg-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>" id="post-details">
				<?if ($category !== NULL AND $category->translate_description() != '') :?>
                    <div class="well">
                        <p>
                            <?=$category->translate_description() ?>
                        </p>
                    </div>
                <?elseif ($location !== NULL AND $location->translate_description() != '') :?>
                    <div class="well">
                        <p>
                            <?=$location->translate_description()?>
                        </p>
                    </div>
                <?endif?>
				<div class="filter"
					data-search-url="<?=Route::url('search',array('controller'=>'ad','action'=>'advanced_search'))?>"
					data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>"
					data-multi-catloc="<?=core::config('general.search_multi_catloc')? 'true':'false'?>"
					data-category="<?=$category ? $category->seoname : NULL?>"
					data-location="<?=$location ? $location->seoname : NULL?>"
				>
					<div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active col-md-4 col-sm-12 col-xs-12':'col-xs-12 col-sm-12 col-md-4'?> pull-left filter-buttons">
						<a id="categorie-dropdown"><?=_e('Filter categories')?></a>
		                <?$locats = Model_Location::get_location_count();?>
						<?if(Core::config('advertisement.location') AND core::count($locats) > 1):?>
							<a id="location-dropdown"><?=_e('Filter locations')?></a>
						<?endif?>
					</div>
					<div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active col-md-3 col-sm-12 col-xs-12':'col-xs-12 col-sm-12 col-md-2'?>">
					    <?= FORM::open(Route::url('search'), array('class'=>'navbar-form '.(Theme::get('short_description')!='')?'no-margin':'',
					        'method'=>'GET', 'action'=>''))?>
					        <input type="text" name="search" class="form-control" placeholder="<?=__('Search')?>">
					    <?= FORM::close()?>
					</div>
					<div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active col-md-5 col-sm-12 col-xs-12':'col-xs-12 col-sm-12 col-md-6'?> pull-right">
				    	<div class="btn-group" id="listgrid" data-default="<?=Theme::get('listgrid')?>">
				    		<button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn-filter dropdown-toggle" data-toggle="dropdown">
					            <i class="fa fa-sort"></i><?=_e('Sort')?> <span class="caret"></span>
					        </button>
					        <ul class="dropdown-menu" role="menu" id="sort-list">
					            <?if (Core::config('advertisement.reviews')==1):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'rating'] + Request::current()->query())?>"><?=_e('Rating')?></a></li>
                                <?endif?>
                                <li><a href="?<?=http_build_query(['sort' => 'title-asc'] + Request::current()->query())?>"><?=_e('Name (A-Z)')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'title-desc'] + Request::current()->query())?>"><?=_e('Name (Z-A)')?></a></li>
                                <?if(core::config('advertisement.price')!=FALSE):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'price-asc'] + Request::current()->query())?>"><?=_e('Price (Low)')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'price-desc'] + Request::current()->query())?>"><?=_e('Price (High)')?></a></li>
                                <?endif?>
                                <li><a href="?<?=http_build_query(['sort' => 'featured'] + Request::current()->query())?>"><?=_e('Featured')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'favorited'] + Request::current()->query())?>"><?=_e('Favorited')?></a></li>
                                <?if(core::config('general.auto_locate')):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'distance'] + Request::current()->query())?>" id="sort-distance"><?=_e('Distance')?></a></li>
                                <?endif?>
                                <li><a href="?<?=http_build_query(['sort' => 'published-desc'] + Request::current()->query())?>"><?=_e('Newest')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'published-asc'] + Request::current()->query())?>"><?=_e('Oldest')?></a></li>
					        </ul>
					        <a href="#" id="grid" class="btn-filter <?=(core::cookie('list/grid')==0)?'active':''?>">
					            <i class="fa fa-th"></i><?=_e('Grid')?>
					        </a>
					        <a href="#" id="list" class="btn-filter <?=(core::cookie('list/grid')==1)?'active':''?>">
					            <i class="fa fa-list"></i><?=_e('List')?>
					        </a>
					        <?if (core::config('advertisement.map')==1):?>
                                <a href="#" data-toggle="modal" data-target="#listingMap" class="btn-filter">
                                    <i class="glyphicon glyphicon-globe"></i> <?=_e('Map')?>
                                </a>
                            <?endif?>
                            <?if(core::config('general.auto_locate')):?>
					            <button
					                class="btn btn-filter <?=core::request('userpos') == 1 ? 'active' : NULL?>"
					                id="myLocationBtn"
					                type="button"
					                data-toggle="modal"
					                data-target="#myLocation"
					                data-marker-title="<?=__('My Location')?>"
					                data-marker-error="<?=__('Cannot determine address at this location.')?>"
					                data-href="?<?=http_build_query(['userpos' => 1] + Request::current()->query())?>">
                                    <?=sprintf(__('%s from you'), i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))))?>
					            </button>
				        	<?endif?>
				        </div>
				    </div>
				</div>
		        <div class="btn-group pull-right">
		          	<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			            <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>
		          	</button>
		          	<ul class="dropdown-menu" role="menu" id="show-list">
			            <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=_e('per page')?></a></li>
			            <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
			            <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
			            <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
			            <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
		          	</ul>
		        </div>
				<div class="subfilter subfilter-categorie">
					<?
			            $cats = Model_Category::get_category_count();

			            $cat_id = NULL;
			            $cat_parent = NULL;

			            if (Model_Category::current()->loaded())
			            {
			                $cat_id = Model_Category::current()->id_category;
			                $cat_parent =  Model_Category::current()->id_category_parent;
		                }

			            $cat_seoname = NULL;

			            if (Model_Location::current()->loaded())
			                $cat_seoname = Model_Category::current()->seoname;
			        ?>
					<ul>
			            <?foreach($cats as $c ):?>
			                <?if($c['id_category_parent'] == 1 && $c['has_siblings'] == FALSE):?>
			                    <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
			                        <a
			                        	href="<?=Route::url('search',array('controller'=>'ad','action'=>'advanced_search'))?>?<?=http_build_query(['category[]' => $c['seoname']] + Request::current()->query())?>"
			                        	data-seoname="<?=$c['seoname']?>"
			                        	title="<?=HTML::chars($c['translate_name'])?>"
			                        	class="<?=($category AND ($category->seoname == $c['seoname'])) ? 'active' : NULL?>"
			                        >
			                            <?=$c['translate_name']?><i class="fa fa-times"></i>
			                        </a>
			                    </li>
			                <?elseif($c['id_category_parent'] == 1 && $c['id_category'] != 1):?>
			                    <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
			                        <a
			                        	href="<?=Route::url('search',array('controller'=>'ad','action'=>'advanced_search'))?>?<?=http_build_query(['category[]' => $c['seoname']] + Request::current()->query())?>"
			                        	data-seoname="<?=$c['seoname']?>"
			                        	title="<?=HTML::chars($c['translate_name'])?>"
			                        	class="<?=($category AND ($category->seoname == $c['seoname'])) ? 'active' : NULL?>"
			                        >
			                            <?=$c['translate_name']?><i class="fa fa-times"></i>
			                        </a>
			                    </li>
			                <?endif?>
			            <?endforeach?>
					</ul>
					<select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> id="category_filter" name="category_filter<?=core::config('general.search_multi_catloc')? '[]':NULL?>" class="disable-select2 hidden">
			            <option value=""></option>
			            <?foreach($cats as $c ):?>
			           		<option value="<?=$c['seoname']?>" <?=(core::request('category') == $c['seoname'])?"selected":''?> ><?=$c['translate_name']?></option>
			           	<?endforeach?>
			        </select>
				</div>
				<?if(Core::config('advertisement.location') AND core::count($locats) > 1):?>
					<div class="subfilter subfilter-location">
						<?  $loc_id = NULL;
				            $loc_parent = NULL;

				            if (Model_Location::current()->loaded())
			                {
				                $loc_id = Model_Location::current()->id_location;
				                $loc_parent =  Model_Location::current()->id_location_parent;
				            }

				            $loc_seoname = NULL;

				            if (Model_Location::current()->loaded())
				                $loc_seoname = Model_Location::current()->seoname;
				        ?>
						<ul>
				            <?foreach($locats as $l ):?>
				            	<?if ( ! in_array($l['id_location'], array(0, 1))) :?>
					                <li class="<?=($l['id_location'] == $loc_id)?'active':''?>">
					                    <a
					                    	href="<?=Route::url('search',array('controller'=>'ad','action'=>'advanced_search'))?>?<?=http_build_query(['location[]' => $l['seoname']] + Request::current()->query())?>"
					                    	data-seoname="<?=$l['seoname']?>"
					                    	title="<?=HTML::chars($l['translate_name'])?>"
					                    	class="<?=($location AND ($location->seoname == $l['seoname'])) ? 'active' : NULL?>"
					                    >
					                        <?=$l['translate_name']?><i class="fa fa-times"></i>
					                    </a>
					                </li>
					            <?endif?>
				            <?endforeach?>
						</ul>
						<select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> id="location_filter" name="location_filter<?=core::config('general.search_multi_catloc')? '[]':NULL?>" class="disable-select2 hidden">
				            <option value=""></option>
				            <?foreach($locats as $l):?>
				            	<?if ( ! in_array($l['id_location'], array(0, 1))) :?>
					           		<option value="<?=$l['seoname']?>" <?=(core::request('location') == $l['seoname'])?"selected":''?> ><?=$l['translate_name']?></option>
					           	<?endif?>
				           	<?endforeach?>
				        </select>
					</div>
				<?endif?>
				<div class="clearfix"></div>
			        <?if(core::count($ads)):
			            //random ad
			            $position = NULL;
			            $i = 0;
			            if (strlen(Theme::get('listing_ad_possible'))>0)
			                $position = rand(0,core::count($ads));
			        ?>
			        <ul id="products" class="list-group">
			          <?$i=1;
                        $current_date = '';
			            foreach($ads as $ad )
                        {
                            if ($current_date != Date::format($ad->published, core::config('general.date_format')))
                            {
                                $current_date = Date::format($ad->published, core::config('general.date_format'));

                                if ($current_date == date(core::config('general.date_format')))
                                    $day_week     =  _e('Today');
                                elseif($current_date == date(core::config('general.date_format'),strtotime('-1 day')))
                                    $day_week     =  _e('Yesterday');
                                else{
                                    $day_week     = Date::format($ad->published, 'l');
                                	switch ($day_week) {
                                		case 'Monday':
                                			$day_week = _e('Monday');
                                			break;
                                		case 'Tuesday':
                                			$day_week = _e('Tuesday');
                                			break;
                                		case 'Wednesday':
                                			$day_week = _e('Wednesday');
                                			break;
                                		case 'Thursday':
                                			$day_week = _e('Thursday');
                                			break;
                                		case 'Friday':
                                			$day_week = _e('Friday');
                                			break;
                                		case 'Saturday':
                                			$day_week = _e('Saturday');
                                			break;
                                		default:
                                			$day_week = _e('Sunday');
                                			break;
                                	}
                                }

                                ?>
                                <li class="listing-date"><h2 class="text-center"><?=$day_week?> <small><?=$current_date?></small></h2></li>
                                <li class="clearfix"><li>
                                <?
                            }
                            ?>
			                <li class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-lg-4 col-md-4 col-sm-4 col-xs-12">
			                    <div class="<?=($ad->featured >= Date::unix2mysql(time()))?'featured':''?>">
			                    	<div class="overlay"><a class="btn" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('Read more')?></a></div>
			                        <div class="hidden-xs hidden-sm col-md-1 text-center favorite <?=core::cookie('list/grid', Theme::get('listgrid')) == 0 ? 'hide' : NULL ?>" id="fav-<?=$ad->id_ad?>">
			                            <?if (Auth::instance()->logged_in()):?>
			                                <?$fav = Model_Favorite::is_favorite($user,$ad);?>
			                                <a data-id="fav-<?=$ad->id_ad?>" class="add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
			                                	<i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
			                                	<p id="countfav-<?=$ad->id_ad?>"><?=$ad->favorited?></p>
			        						</a>
			                            <?else:?>
			                                <a data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
			                                    <i class="glyphicon glyphicon-heart-empty"></i>
                                                <p><?=$ad->favorited?></p>
			                                </a>
			                            <?endif?>
			                        </div>
			                        <div class="<?=(Theme::get('sidebar_position')!='none')?'col-xs-12 col-sm-8 col-md-7':'col-xs-12 col-sm-8 col-md-5'?> text <?=core::cookie('list/grid', Theme::get('listgrid')) == 0 ? 'fullwidth' : NULL ?>">
				                        <h2 class="big-txt <?=core::cookie('list/grid', Theme::get('listgrid')) == 0 ? 'hide' : NULL ?>">
				                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
				                            	<?=Text::limit_chars(Text::removebbcode($ad->title), 25, NULL, TRUE)?>
				                            </a>
				                            <?if(Theme::get('companyname_listing')==1):?>
				                            	<a class="company" href="<?=Valid::url($ad->website) ? : Route::url('profile', array('seoname'=>$ad->user->seoname))?>"> @ <?=Text::limit_chars(Text::removebbcode((isset($ad->cf_company) AND $ad->cf_company)?$ad->cf_company:$ad->user->name), 15, NULL, TRUE)?></a>
				                           	<?endif?>
				                           	<?if (Core::config('advertisement.reviews')==1):?>
				                           		<br>
				                           		<small>
							                        <?for ($j=0; $j < round($ad->rate,1); $j++):?>
							                            <span class="glyphicon glyphicon-star"></span>
							                        <?endfor?>
							                    </small>
						                    <?endif?>
				                     	</h2>
				                        <h2 class="small-txt <?=core::cookie('list/grid', Theme::get('listgrid')) == 1 ? 'hide' : NULL ?>">
				                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
				                            	<?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
				                            	<?if (Core::config('advertisement.reviews')==1):?>
							                        <small>
							                            <?for ($j=0; $j < round($ad->rate,1); $j++):?>
							                                <span class="glyphicon glyphicon-star"></span>
							                            <?endfor?>
							                        </small>
						                        <?endif?>
				                            </a>
				                        </h2>
				                        <?if(core::config('advertisement.description')!=FALSE):?>
				                        	<p><?=Text::limit_chars(Text::removebbcode($ad->description), 55, NULL, TRUE)?></p>
				                        <?endif?>
									</div>
									<div class="<?=(Theme::get('sidebar_position')!='none')?'hidden-xs col-sm-4 col-md-4':'hidden-xs col-sm-4 col-md-3'?> listing-categorie <?=core::cookie('list/grid', Theme::get('listgrid')) == 0 ? 'fullwidth' : NULL ?>">
										<span class="btn btn-inverse no-cursor"><?=$ad->category->translate_name() ?></span>
                                        <?if(isset($ad->cf_jobtype)):?>
										  <span class="btn btn-inverse no-cursor"><?=$ad->cf_jobtype?></span>
                                        <?endif?>
									</div>
									<?if(Theme::get('location_listing')==1):?>
									<div class="<?=(Theme::get('sidebar_position')!='none')?'hidden-xs hidden-sm hidden-md hidden-lg':'hidden-xs hidden-sm col-md-2'?> text-center location">
										<?if ( core::config('advertisement.location') AND ! in_array($ad->id_location, array(0, 1)) AND $ad->location->loaded() ) :?>
				                        	<span><i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?></span>
				                        <?endif?>
			                        </div>
			                        <?endif?>
			                        <?if(Theme::get('date_listing')==1):?><div class="<?=(Theme::get('sidebar_position')!='none')?'hidden-xs hidden-sm hidden-md hidden-lg':'hidden-xs hidden-sm col-md-1'?> text-center date">
			                            <?if ($ad->published!=0){?>
			                                <span><?= Date::format($ad->published, core::config('general.date_format'))?></span>
			                            <? }?>
			                        </div>
			                        <?endif?>
			                        <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
			                            <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
			                                <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
			                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i> <?=_e("Edit");?></a> |
			                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'deactivate','id'=>$ad->id_ad))?>"
			                                        onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
			                                    </a> |
			                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'spam','id'=>$ad->id_ad))?>"
			                                        onclick="return confirm('<?=__('Spam?')?>');"><i class="glyphicon glyphicon-fire"></i><?=_e("Spam");?>
			                                    </a> |
			                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'delete','id'=>$ad->id_ad))?>"
			                                        onclick="return confirm('<?=__('Delete?')?>');"><i class="glyphicon glyphicon-remove"></i><?=_e("Delete");?>
			                                    </a>
			                                </div>
			                            </div>
			                        <?elseif($user !== NULL && $user->id_user == $ad->id_user):?>
			                        <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
			                            <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
			                                <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i><?=_e("Edit");?></a> |
			                                <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
			                                    onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
			                                </a>
			                            </div>
			                        </div>
			                        <?endif?>
			                    </div>
			                </li>
			                <?if($i===$position):?>
			                	<div class="col-xs-12 listing-ad-room">
			                   		<?=Theme::get('listing_ad_possible')?>
			                   	</div>
			                <?endif?>
			            <?$i++?>
			            <?}?>
			        </ul>
			        <div class="clearfix"></div>
					<div class="text-center">
				        <?=$pagination?>
			     	</div>
			    <?elseif (core::count($ads) == 0):?>
				    <!-- Case when we dont have ads for specific category / location -->
				    <h3><?=_e('We do not have any advertisements in this category')?></h3>
			    <?endif?>
			    <?if(core::config('general.auto_locate')):?>
				    <div class="modal fade" id="myLocation" tabindex="-1" role="dialog" aria-labelledby="myLocationLabel">
				        <div class="modal-dialog" role="document">
				            <div class="modal-content">
				                <div class="modal-body">
				                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-distance btn-default dropdown-toggle" data-toggle="dropdown">
                                                <span class="label-icon"><?=i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2)))?></span>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu pull-left" role="menu">
                                                <li>
                                                    <a href="#" data-value="2"><?=i18n::format_measurement(2)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="5"><?=i18n::format_measurement(5)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="10"><?=i18n::format_measurement(10)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="20"><?=i18n::format_measurement(20)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="50"><?=i18n::format_measurement(50)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="250"><?=i18n::format_measurement(250)?></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-value="500"><?=i18n::format_measurement(500)?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="distance" id="myDistance" value="<?=Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))?>" disabled>
				                        <input type="hidden" name="latitude" id="myLatitude" value="" disabled>
				                        <input type="hidden" name="longitude" id="myLongitude" value="" disabled>
				                        <?=FORM::input('myAddress', Request::current()->post('address'), array('class'=>'form-control', 'id'=>'myAddress', 'placeholder'=>__('Where do you want to search?')))?>
				                        <span class="input-group-btn">
				                            <button id="setMyLocation" class="btn btn-default" type="button"><?=_e('Ok')?></button>
				                        </span>
				                    </div>
				                    <br>
				                    <div id="mapCanvas"></div>
				                </div>
				                <div class="modal-footer">
				                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=_e('Close')?></button>
				                    <?if (core::request('userpos') == 1) :?>
				                        <a class="btn btn-danger" href="?<?=http_build_query(['userpos' => NULL] + Request::current()->query())?>"><?=_e('Remove')?></a>
				                    <?endif?>
				                </div>
				            </div>
				        </div>
				    </div>
				<?endif?>
				<?if (core::config('advertisement.map')==1):?>
			        <?=View::factory('pages/ad/listing_map', compact('ads'))?>
			    <?endif?>
			</section>
			<?if(Theme::get('sidebar_position')!='none'):?>
		        <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
		    <?endif?>
		</div>
	</div>
</section>