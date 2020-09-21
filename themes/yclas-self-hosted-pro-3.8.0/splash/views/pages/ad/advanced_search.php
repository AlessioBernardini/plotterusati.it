<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h1"><?=_e('Search')?></h1>
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
            <div class="col-xs-12 col-sm-8 <?=(Theme::get('sidebar_position')=='hidden')?'col-md-12':'col-md-9'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':NULL?>">

                <div class="well recomentadion def-size-form clearfix">
                    <h1><?=_e('Search')?></h1>
                    <?= FORM::open(Route::url('search'), array('class'=>'form-inline', 'method'=>'GET', 'action'=>''))?>
                        <fieldset>

                                <div class="form-group">
                                    <?= FORM::label('advertisement', _e('Advertisement Title'), array('class'=>'', 'for'=>'advertisement'))?>
                                    <div class="control mr-30">
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
                                        <div class="control mr-30">
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
                                        <div class="control mr-30">
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
                                        <div class="control mr-30">
                                            <?= Form::select('locale', i18n::get_selectable_languages(), Core::request('locale', i18n::$locale), array('class' => 'form-control', 'id' => 'locale')) ?>
                                        </div>
                                    </div>
                                <? endif ?>

                                <?if(core::config('advertisement.price')):?>
                                <div class="form-group">
                                    <label class="" for="price-min"><?=_e('Price from')?> </label>
                                    <div class="control mr-30">
                                        <input type="text" id="price-min" name="price-min" class="form-control" value="<?=HTML::chars(core::get('price-min'))?>" placeholder="<?=__('Price from')?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="" for="price-max"><?=_e('Price to')?></label>
                                    <div class="control mr-30">
                                        <input type="text" id="price-max" name="price-max" class="form-control" value="<?=HTML::chars(core::get('price-max'))?>" placeholder="<?=__('to')?>">
                                    </div>
                                </div>
                                <?endif?>
                                <!-- Fields coming from custom fields feature -->
                                <div id="search-custom-fields" style="display:inline-block;" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>" data-customfield-values='<?=json_encode(Request::current()->query())?>'>
                                    <div id="search-custom-field-template" class="form-group hidden">
                                        <div data-label></div>
                                        <div class="text-center">
                                            <div data-input></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fields coming from user custom fields feature -->
                                <?foreach(Model_UserField::get_all() as $name=>$field):?>
                                    <?if(isset($field['searchable']) AND $field['searchable']):?>
                                        <div class="form-group text-center">
                                            <?$cf_name = 'cfuser_'.$name?>
                                            <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                                                $select = array('' => $field['label']);
                                                foreach ($field['values'] as $select_name) {
                                                    $select[$select_name] = $select_name;
                                                }
                                            } else $select = $field['values']?>
                                            <?= FORM::label('cfuser_'.$name, $field['label'], array('for'=>'cfuser_'.$name, 'class'=>'pull-left'))?>
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
                                    <div class="control mr-30">
                                        <?= FORM::button('submit', _e('Search'), array('type'=>'submit', 'class'=>'btn btn-primary pull-right', 'action'=>Route::url('search')))?>
                                    </div>
                                </div>
                    </fieldset>
                    <?= FORM::close()?>
                </div>

                <h3>
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

                        <div class="listing-overview">
                            <ul class="list-view">
                                <?$i=1; foreach($ads as $ad ):?>
                                    <li class="col-xs-12 <?=($ad->featured >= Date::unix2mysql(time()))?'featured':''?>">
                                        <div class="adimage col-xs-4 col-sm-3">
                                            <figure>
                                                <?if($ad->get_first_image() !== NULL):?>
                                                    <img src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                                    <img src="<?=$icon_src?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?else:?>
                                                    <img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?endif?>
                                            </figure>
                                            <?if ($ad->price!=0):?>
                                                <div class="price">
                                                    <p><?=i18n::money_format( $ad->price, $ad->currency())?></p>
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
                                            <span><?=_e('Posted by')?> <?=$ad->user->name?> <?=_e('on')?> <?=(core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()) ? sprintf(__('from %s'), $ad->location->translate_name()) : NULL?> <?= Date::format($ad->published, core::config('general.date_format'))?></span>
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
                                                    <p><b><?=$name?></b>: <?=$value?></p>
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
                        <!-- Case when we dont have ads -->
                        <div class="page-header">
                            <h3><?=_e('Your search did not match any advertisement.')?></h3>
                        </div>
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
                    <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
                </div>
            </div>
        </div>
    </div>
</section>
