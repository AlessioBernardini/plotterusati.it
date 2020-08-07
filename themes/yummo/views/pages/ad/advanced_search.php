<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<div class="recomentadion def-size-form clearfix">
    <h1><?=_e('Search')?></h1>
    <?= FORM::open(Route::url('search'), array('class'=>'form-inline well', 'method'=>'GET', 'action'=>''))?>
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

<?if (Request::current()->query()):?>
    <?if (core::count($ads)>0):?>
        <h3>
            <?if (core::get('title')) :?>
                <?=($total_ads == 1) ? sprintf(__('%d advertisement for %s'), $total_ads, core::get('title')) : sprintf(__('%d advertisements for %s'), $total_ads, core::get('title'))?>
            <?else:?>
                <?=_e('Search results')?>
            <?endif?>
        </h3>
        <?=View::factory('pages/ad/listing',array('pagination'=>$pagination,'ads'=>$ads,'category'=>NULL, 'location'=>NULL, 'user'=>$user, 'featured'=>NULL))?>
    <?else:?>
        <h3><?=_e('Your search did not match any advertisement.')?></h3>
    <?endif?>
<?endif?>
