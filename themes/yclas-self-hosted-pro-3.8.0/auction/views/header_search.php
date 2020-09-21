<!-- Dont show search bar in profile and myads pages -->
<?if(strtolower(Request::current()->controller())!='profile'
    AND strtolower(Request::current()->controller())!='myads'
    AND strtolower(Request::current()->controller())!='faq'
    AND strtolower(Request::current()->action())!='advanced_search'):?>
    <section class="search-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row no-gutter">
                        <h2 class="text-center home_slogan">
                            <?if(Theme::get('home_slogan') != '' 
                                AND strtolower(Request::current()->controller())=='home' 
                                AND strtolower(Request::current()->action())=='index')
                            :?>
                                <?=Theme::get('home_slogan')?>
                            <?endif?>
                        </h2>
                        <h4 class="text-center home_description text-muted">
                            <?if(Theme::get('home_description') != '' 
                                AND strtolower(Request::current()->controller())=='home' 
                                AND strtolower(Request::current()->action())=='index')
                            :?>
                                <?=Theme::get('home_description')?>
                            <?endif?>
                        </h4>
                        <?if(Core::config('general.algolia_search') == 1):?>
                            <div class="frm search-frm">
                                <?=View::factory('pages/algolia/autocomplete')?>
                            </div>
                        <?else:?>
                            <?=FORM::open(Route::url('search'), array('class'=>'frm search-frm', 'method'=>'GET', 'action'=>''))?>
                                <div class="form-group text-input col-sm-12 col-md-6">
                                   <input name="title" type="text" class="search-query form-control" value="<?=HTML::chars(core::get('title'))?>" placeholder="<?=__('Keywords ...')?>">
                                </div>
                                <?$order_categories = Model_Category::get_multidimensional();?>
                                <div class="form-group select-input col-sm-12 <?=(core::config('advertisement.location') != FALSE AND core::count(Model_Location::get_as_array())>1) ? 'col-md-2' : 'col-md-4'?>
                                ">
                                    <div class="control">
                                        <select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> name="category<?=core::config('general.search_multi_catloc')? '[]':NULL?>" id="category" class="form-control w175" data-placeholder="<?=__('Select category')?>" >
                                            <?if ( ! core::config('general.search_multi_catloc')) :?>
                                                <option value=""><?=_e('Select category')?></option>
                                            <?endif?>
                                            <?function lili2($item, $key,$cats){?>
                                                <?if (core::config('general.search_multi_catloc')):?>
                                                    <option value="<?=$cats[$key]['seoname']?>" <?=(is_array(core::request('category')) AND in_array($cats[$key]['seoname'], core::request('category')))?"selected":''?> ><?=$cats[$key]['translate_name']?></option>
                                                <?else:?>
                                                    <option value="<?=$cats[$key]['seoname']?>" <?=(core::request('category') == $cats[$key]['seoname'])?"selected":''?> ><?=$cats[$key]['translate_name']?></option>
                                                <?endif?>
                                                <?if (core::count($item)>0):?>
                                                    <optgroup label="<?=$cats[$key]['translate_name']?>">
                                                        <? if (is_array($item)) array_walk($item, 'lili2', $cats);?>
                                                    </optgroup>
                                                <?endif?>
                                            <?}array_walk($order_categories, 'lili2', Model_Category::get_as_array());?>
                                        </select>
                                    </div>
                                </div>
                                <?$order_locations = Model_Location::get_multidimensional(); $locations = Model_Location::get_as_array();?>
                                <?if(core::config('advertisement.location') != FALSE AND core::count($locations) > 1):?>
                                <div class="form-group select-input col-sm-12 col-md-2 location-select">
                                    <select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> name="location<?=core::config('general.search_multi_catloc')? '[]':NULL?>" id="location" class="form-control w175" data-placeholder="<?=__('Select location')?>" >
                                        <?if ( ! core::config('general.search_multi_catloc')) :?>
                                            <option value=""><?=_e('Select location')?></option>
                                        <?endif?>
                                        <?function lolo2($item, $key,$locs){?>
                                            <?if (core::config('general.search_multi_catloc')):?>
                                                <option value="<?=$locs[$key]['seoname']?>" <?=(is_array(core::request('location')) AND in_array($locs[$key]['seoname'], core::request('location')))?"selected":''?> ><?=$locs[$key]['translate_name']?></option>
                                            <?else:?>
                                                <option value="<?=$locs[$key]['seoname']?>" <?=(core::request('location') == $locs[$key]['seoname'])?"selected":''?> ><?=$locs[$key]['translate_name']?></option>
                                            <?endif?>
                                            <?if (core::count($item)>0):?>
                                                <optgroup label="<?=$locs[$key]['translate_name']?>">
                                                    <? if (is_array($item)) array_walk($item, 'lolo2', $locs);?>
                                                </optgroup>
                                            <?endif?>
                                        <?}array_walk($order_locations, 'lolo2', $locations);?>
                                    </select>
                                </div>
                                <?endif?>
                                <div class="col-xs-12 col-sm-12 col-md-2 btn-container">
                                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> <?=_e('Search')?></button>
                                </div>
                            <?=FORM::close()?>
                        <?endif?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?endif?>