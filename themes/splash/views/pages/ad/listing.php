<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <?if ($category!==NULL):?>
                    <h1 class="h1"><?=$category->translate_name() ?></h1>
                <?elseif ($location!==NULL):?>
                    <h1 class="h1"><?=$location->translate_name() ?></h1>
                <?else:?>
                    <h1 class="h1"><?=_e('Listings')?></h1>
                <?endif?>
            </div>
            <?if (Theme::get('breadcrumb')==1):?>
                <div class="col-sm-4 breadcrumbs">
                    <?=Breadcrumbs::render('breadcrumbs')?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<?=Alert::show()?>

<section id="main">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-xs-12 col-sm-12 <?=(Theme::get('sidebar_position')=='hidden')?'col-md-12':'col-md-9'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':NULL?>">
                <?if ($category !== NULL AND $category->translate_description() != '') :?>
                    <div class="alert alert-info" role="info">
                        <p>
                            <?=$category->translate_description() ?>
                        </p>
                    </div>
                <?elseif ($location !== NULL AND $location->translate_description() != '') :?>
                    <div class="alert alert-info" role="info">
                        <p>
                            <?=$location->translate_description() ?>
                        </p>
                    </div>
                <?endif?>
                <div class="filter" id="listgrid" data-default="<?=Theme::get('listgrid')?>">
                    <ul class="nav-tabs">
                        <li class="dropdown">
                            <a href="#" type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-sort-amount-asc"></i> <?=_e('Sort')?></a>
                            <ul class="dropdown-menu">
                                <?if (Core::config('advertisement.reviews')==1):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'rating'] + Request::current()->query())?>"><?=_e('Rating')?></a></li>
                                <?endif?>
                                <li><a href="?<?=http_build_query(['sort' => 'title-asc'] + Request::current()->query())?>"><?=_e('Name (A-Z)')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'title-desc'] + Request::current()->query())?>"><?=_e('Name (Z-A)')?></a></li>
                                <?if(core::config('advertisement.price')!=FALSE):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'price-asc'] + Request::current()->query())?>"><?=_e('Price (Low)')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'price-desc'] + Request::current()->query())?>"><?=_e('Price (High)')?></a></li>
                                <?endif?>
                                <?if(core::config('general.auto_locate')):?>
                                    <li><a href="?<?=http_build_query(['sort' => 'distance'] + Request::current()->query())?>" id="sort-distance"><?=_e('Distance')?></a></li>
                                <?endif?>
                                <li><a href="?<?=http_build_query(['sort' => 'featured'] + Request::current()->query())?>"><?=_e('Featured')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'favorited'] + Request::current()->query())?>"><?=_e('Favorited')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'published-desc'] + Request::current()->query())?>"><?=_e('Newest')?></a></li>
                                <li><a href="?<?=http_build_query(['sort' => 'published-asc'] + Request::current()->query())?>"><?=_e('Oldest')?></a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?>
                            </button>
                            <ul class="dropdown-menu" role="menu" id="show-list">
                                <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=_e('per page')?></a></li>
                                <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
                                <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
                                <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
                                <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
                            </ul>
                        </li>
                        <li><button class="grid"><i class="fa fa-align-justify grid"></i> <?=_e('Grid')?></button></li>
                        <li><button class="list active"><i class="fa fa-list"></i> <?=_e('List')?></button></li>

                        <?if (core::config('advertisement.map')==1):?>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#listingMap">
                                    <i class="glyphicon glyphicon-globe"></i> <?=_e('Map')?>
                                </a>
                            </li>
                        <?endif?>
                        <?if(core::config('general.auto_locate')):?>
                            <li>
                                <button
                                    class="btn btn-filter <?=core::request('userpos') == 1 ? 'active' : NULL?>"
                                    id="myLocationBtn"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#myLocation"
                                    data-marker-title="<?=__('My Location')?>"
                                    data-marker-error="<?=__('Cannot determine address at this location.')?>"
                                    data-href="?<?=http_build_query(['userpos' => 1] + Request::current()->query())?>">
                                    <i class="glyphicon glyphicon-map-marker"></i> <?=sprintf(__('%s from you'), i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))))?>
                                </button>
                            </li>
                        <?endif?>
                    </ul>
                </div>

                <div class="clearfix"></div><br>
                <?if(core::count($ads)):
                    //random ad
                    $position = NULL;
                    $i = 0;
                    if (strlen(Theme::get('listing_ad'))>0)
                        $position = rand(0,core::count($ads));
                ?>

                <div class="listing-overview">
                    <ul class="list-view">
                        <?$i=1;
                        foreach($ads as $ad ):?>
                            <li class="col-xs-12 <?=($ad->featured >= Date::unix2mysql(time()))?'featured':''?>">
                                <?if($ad->featured >= Date::unix2mysql(time())):?>
                                    <div class="triangle-top-left">
                                        <p class="featured-text"><?=_e('Featured')?></p>
                                    </div>
                                <?endif?>
                                <div class="adimage col-xs-4 col-sm-3">
                                    <figure>
                                        <?if($ad->get_first_image() !== NULL): ?>
			                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 255, 'h' => 255], ['1200px' => ['w' => '255', 'h' => '255'],'992px' => ['w' => '205', 'h' => '205'], '768px' => ['w' => '690', 'h' => '690'], '480px' => ['w' => '710', 'h' => '710'], '320px' => ['w' => '420', 'h' => '420']], array('class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)))?>
			                            <?else:?>
			                                <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
			                                    <?=HTML::picture($icon_src, ['w' => 255, 'h' => 255], ['1200px' => ['w' => '255', 'h' => '255'],'992px' => ['w' => '205', 'h' => '205'], '768px' => ['w' => '690', 'h' => '690'], '480px' => ['w' => '710', 'h' => '710'], '320px' => ['w' => '420', 'h' => '420']], array('class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)))?>
			                                <?else:?>
			                                    <img data-src="holder.js/205x205?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>">
			                                <?endif?>
	                            		<?endif?>
                                    </figure>
                                    <?if (core::config('advertisement.price')!=FALSE AND $ad->price!=0):?>
                                        <div class="price">
                                            <p><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></p>
                                        </div>
                                        <div class="overlay list-image-overlay"></div>
                                    <?endif?>
                                    <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                        <div class="price">
                                            <p><?=_e('Free');?></p>
                                        </div>
                                        <div class="overlay list-image-overlay"></div>
                                    <?endif?>
                                </div>
                                <div class="col-xs-8 col-sm-9 text">
                                    <div class="pull-right favorite" id="fav-<?=$ad->id_ad?>">
                                        <?if (Auth::instance()->logged_in()):?>
                                            <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                            <a data-id="fav-<?=$ad->id_ad?>" class="element-over-link-overlay add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                                <i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
                                            </a>
                                        <?else:?>
                                            <a class="element-over-link-overlay" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                <i class="glyphicon glyphicon-heart-empty"></i>
                                            </a>
                                        <?endif?>
                                    </div>
                                    <h2 class="h2"><?=Text::limit_chars(Text::removebbcode($ad->title), 40, NULL, TRUE)?> </h2>
                                    <span><?=_e('Posted by')?> <?=$ad->user->name?> <?=(core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()) ? sprintf(__('from %s'), $ad->location->translate_name()) : NULL?> <?=_e('on')?> <?= Date::format($ad->published, core::config('general.date_format'))?></span>
                                    <?if(core::config('advertisement.description')!=FALSE):?>
                                        <p <?=(core::cookie('list/grid')==1)?'hide':''?>><?=Text::limit_chars(Text::removebbcode($ad->description), 255, NULL, TRUE)?></p>
                                    <?endif?>
                                    <?if (Core::config('advertisement.reviews')==1):?>
                                        <p>
                                            <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                <i class="glyphicon glyphicon-star"></i>
                                            <?endfor?>
                                        </p>
                                    <?endif?>
                                    <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                                        <?elseif($value=='checkbox_0'):?>
                                            <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                                        <?else:?>
                                            <?if(is_string($name)):?>
                                                <p><b><?=$name?></b>: <?=$value?></p>
                                            <?else:?>
                                                <p><?=$value?></p>
                                            <?endif?>
                                        <?endif?>
                                    <?endforeach?>
                                    <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                                        <br />
                                        <div class="toolbar btn btn-primary btn-xs element-over-link-overlay"><i class="glyphicon glyphicon-cog"></i>
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
                                        <br/>
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
                                <a class="link-overlay" title="<?=HTML::chars($ad->title)?>" alt="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                            </li>
                            <?if($i===$position):?>
                                <li class="col-xs-12 listing_ad">
                                    <?=Theme::get('listing_ad')?>
                                </li>
                                <div class="clearfix"></div>
                            <?endif?>
                            <?if($i%3==0):?><div class="clearfix"></div><?endif?>
                            <?$i++?>
                        <?endforeach?>
                    </ul>
                </div>
                <div class="clearfix"></div>

                <?=$pagination?>
                        <?elseif (core::count($ads) == 0):?>
                        <!-- Case when we dont have ads for specific category / location -->
                        <div class="page-header">
                            <h3><?=_e('We do not have any advertisements in this category')?></h3>
                        </div>

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
                </div>
                <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
            </div>
        </div>
    </div>
</section>
