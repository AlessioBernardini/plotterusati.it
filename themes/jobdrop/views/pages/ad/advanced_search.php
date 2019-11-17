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
                    <?=$widget?>
                </div>
            <?endforeach?>
        </div>
        <div class="row">
            <div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active-container col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-xs-12 col-lg-12'?>">
                <div class="well recomentadion def-size-form clearfix">
                    <h1><?=_e('Search')?></h1>
                    <?= FORM::open(Route::url('search'), array('class'=>'form-inline advanced-search-frm', 'method'=>'GET', 'action'=>''))?>
                        <fieldset>
                        <div class="form-group">
                           <?= FORM::label('advertisement', _e('Advertisement Title'), array('class'=>'', 'for'=>'advertisement'))?>
                            <div class="control">
                                <?if(Core::config('general.algolia_search') == 1):?>
                                    <?=View::factory('pages/algolia/autocomplete_ad')?>
                                <?else:?>
                                    <input type="text" id="title" name="title" class="form-control" value="<?=HTML::chars(core::get('title'))?>" placeholder="<?=__('Title')?>">
                                <?endif?>
                            </div>
                        </div>

                        <?if(core::count($categories) > 1):?>
                            <div class="form-group">
                                <?= FORM::label('category', _e('Category'), array('class'=>'', 'for'=>'category' ))?>
                                <div class="control">
                                    <select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> name="category<?=core::config('general.search_multi_catloc')? '[]':NULL?>" id="category_search" class="form-control" data-placeholder="<?=__('Category')?>">
                                    <?if ( ! core::config('general.search_multi_catloc')) :?>
                                        <option value=""><?=__('Category')?></option>
                                    <?endif?>
                                    <?function lili($item, $key,$cats){?>
                                        <?if (core::config('general.search_multi_catloc')):?>
                                            <option value="<?=$cats[$key]['seoname']?>" data-id="<?=$cats[$key]['id']?>" <?=(is_array(core::request('category')) AND in_array($cats[$key]['seoname'], core::request('category')))?"selected":''?> ><?=$cats[$key]['translate_name']?></option>
                                        <?else:?>
                                            <option value="<?=$cats[$key]['seoname']?>" data-id="<?=$cats[$key]['id']?>" <?=(core::request('category') == $cats[$key]['seoname'])?"selected":''?> ><?=$cats[$key]['translate_name']?></option>
                                        <?endif?>
                                        <?if (core::count($item)>0):?>
                                        <optgroup label="<?=$cats[$key]['translate_name']?>">
                                            <? if (is_array($item)) array_walk($item, 'lili', $cats);?>
                                            </optgroup>
                                        <?endif?>
                                    <?}array_walk($order_categories, 'lili',$categories);?>
                                    </select>
                                </div>
                            </div>
                        <?endif?>

                        <?if(core::config('advertisement.location') != FALSE AND core::count($locations) > 1):?>
                            <div class="form-group">
                                <?= FORM::label('location', _e('Location'), array('class'=>'', 'for'=>'location' , 'multiple'))?>
                                <div class="control">
                                    <select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> name="location<?=core::config('general.search_multi_catloc')? '[]':NULL?>" id="location" class="form-control" data-placeholder="<?=__('Location')?>">
                                    <?if ( ! core::config('general.search_multi_catloc')) :?>
                                        <option value=""><?=__('Location')?></option>
                                    <?endif?>
                                    <?function lolo($item, $key,$locs){?>
                                        <?if (core::config('general.search_multi_catloc')):?>
                                            <option value="<?=$locs[$key]['seoname']?>" <?=(is_array(core::request('location')) AND in_array($locs[$key]['seoname'], core::request('location')))?"selected":''?> ><?=$locs[$key]['translate_name']?></option>
                                        <?else:?>
                                            <option value="<?=$locs[$key]['seoname']?>" <?=(core::request('location') == $locs[$key]['seoname'])?"selected":''?> ><?=$locs[$key]['translate_name']?></option>
                                        <?endif?>
                                        <?if (core::count($item)>0):?>
                                        <optgroup label="<?=$locs[$key]['translate_name']?>">
                                            <? if (is_array($item)) array_walk($item, 'lolo', $locs);?>
                                            </optgroup>
                                        <?endif?>
                                    <?}array_walk($order_locations, 'lolo',$locations);?>
                                    </select>
                                </div>
                            </div>
                        <?endif?>

                        <? if (Core::config('general.multilingual') == 1) : ?>
                            <div class="form-group">
                                <?= FORM::label('locale', _e('Language'), array('class' => '', 'for' => 'locale')) ?>
                                <div class="control">
                                    <?= Form::select('locale', i18n::get_selectable_languages(), Core::request('locale', i18n::$locale), array('class' => 'form-control', 'id' => 'locale')) ?>
                                </div>
                            </div>
                        <? endif ?>

                        <?if(core::config('advertisement.price')):?>
                        <div class="form-group">
                            <label class="" for="price-min"><?=_e('Price from')?> </label>
                            <div class="control">
                                <input type="text" id="price-min" name="price-min" class="form-control" value="<?=HTML::chars(core::get('price-min'))?>" placeholder="<?=__('Price from')?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="" for="price-max"><?=_e('Price to')?></label>
                            <div class="control">
                                <input type="text" id="price-max" name="price-max" class="form-control" value="<?=HTML::chars(core::get('price-max'))?>" placeholder="<?=__('to')?>">
                            </div>
                        </div>
                        <?endif?>
                        <!-- Fields coming from custom fields feature -->
                        <div id="search-custom-fields" style="display:inline-block;" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>" data-customfield-values='<?=json_encode(Request::current()->query())?>'>
                            <div id="search-custom-field-template" class="form-group hidden">
                                <div data-label></div>
                                <div>
                                    <div data-input></div>
                                </div>
                            </div>
                        </div>
                        <!-- Fields coming from user custom fields feature -->
                        <?foreach(Model_UserField::get_all() as $name=>$field):?>
                            <?if(isset($field['searchable']) AND $field['searchable']):?>
                                <div class="form-group">
                                    <?$cf_name = 'cfuser_'.$name?>
                                    <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                                        $select = array('' => $field['label']);
                                        foreach ($field['values'] as $select_name) {
                                            $select[$select_name] = $select_name;
                                        }
                                    } else $select = $field['values']?>
                                    <?= FORM::label('cfuser_'.$name, $field['label'], array('for'=>'cfuser_'.$name))?>
                                    <div>
                                        <?=Form::cf_form_field('cfuser_'.$name, array(
                                        'display'   => $field['type'],
                                        'label'     => $field['label'],
                                        'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                                        'default'   => $field['values'],
                                        'options'   => (!is_array($field['values']))? $field['values'] : $select,
                                        ),core::get('cfuser_'.$name), FALSE, TRUE)?>
                                    </div>
                                </div>
                            <?endif?>
                        <?endforeach?>
                        <div class="form-group">
                            <label></label>
                            <div class="control">
                                <?= FORM::button('submit', _e('Search'), array('type'=>'submit', 'class'=>'btn btn-primary pull-right', 'action'=>Route::url('search')))?>
                            </div>
                        </div>
                    </fieldset>
                    <?= FORM::close()?>
                </div>
                <h3 class="text-center">
                    <?if (core::get('title')) :?>
                        <?=($total_ads == 1) ? sprintf(__('%d advertisement for %s'), $total_ads, core::get('title')) : sprintf(__('%d advertisements for %s'), $total_ads, core::get('title'))?>
                    <?else:?>
                        <?=_e('Search results')?>
                    <?endif?>
                </h3>

                <?if (Request::current()->query()):?>
                    <?if(core::count($ads)):
                        //random ad
                        $position = NULL;
                        $i = 0;
                        if (strlen(Theme::get('listing_ad'))>0)
                            $position = rand(0,core::count($ads));
                    ?>
                    <div class="filter">
                        <div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active col-md-5 col-sm-12 col-xs-12':'col-xs-12 col-sm-12 col-md-5'?> pull-right">
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
                                    <a href="<?=Route::url('map')?>?category=<?=Model_Category::current()->loaded()?Model_Category::current()->seoname:NULL?>&location=<?=Model_Location::current()->loaded()?Model_Location::current()->seoname:NULL?>" class="btn-filter">
                                        <i class="fa fa-globe"></i><?=_e('Map')?>
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
                                        <?=sprintf(__('%s from you'), i18n::format_measurement(Core::config('advertisement.auto_locate_distance', 1)))?>
                                    </button>
                                <?endif?>
                            </div>
                        </div>
                    </div>
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
                                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 25, NULL, TRUE)?> <?if(Theme::get('companyname_listing')==1):?><a class="company" href="<?= $ad->website;?>"> @ <?=Text::limit_chars(Text::removebbcode($ad->user->name), 15, NULL, TRUE)?></a><?endif?>
                                        </h2>
                                        <h2 class="small-txt <?=core::cookie('list/grid', Theme::get('listgrid')) == 1 ? 'hide' : NULL ?>">
                                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a>
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

                                        <?if ( ! in_array($ad->id_location, array(0, 1))) :?>
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
                        <!-- Case when we dont have ads -->
                        <h3><?=_e('Your search did not match any advertisement.')?></h3>
                    <?endif?>
                    <?if(core::config('general.auto_locate')):?>
                        <div class="modal fade" id="myLocation" tabindex="-1" role="dialog" aria-labelledby="myLocationLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="input-group">
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
                <?endif?>
                    </div>
                    <?if(Theme::get('sidebar_position')!='none'):?>
                        <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
</section>
