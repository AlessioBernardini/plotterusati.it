<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Theme::landing_single_ad() == FALSE):?>
<div class="navbar navbar-default">
    <div class="container">
        <? include_once "user_online.php"?>
        <div class="row">
            <div class="col-xs-3 col-sm-2 col-md-3">
                <a class="nav-btn" id="nav-open-btn" href="#nav"></a>
            </div>
            <div class="col-xs-12 col-md-5 text-center hidden-xs hidden-sm">
                <div class="row">
                    <div class="col-lg-12">
                        <a class="brand" href="<?=Route::url('default')?>">
                            <?if (Theme::get('logo_url')!=''):?>
                                <img src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                            <?else:?>
                                <h1><?=core::config('general.site_name')?></h1>
                            <?endif?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-9 col-sm-10 col-md-4">
                <div class="navbar-btn pull-right">
                    <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                        <a class="btn btn-primary pull-right hidden-xs" href="<?=Route::url('post_new')?>">
                            <i class="fa fa-pencil "></i> <?=_e('Publish new')?>
                        </a>
                        <a class="btn btn-primary pull-right hidden-lg hidden-md hidden-sm" href="<?=Route::url('post_new')?>">
                            <?=_e('Publish new')?>
                        </a>
                    <?endif?>
                    <span class="vertical-rule"></span>
                    <?=View::factory('widget_login')?>
                </div>
            </div>
            <div class="col-xs-12 hidden-lg hidden-md text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <a class="brand" href="<?=Route::url('default')?>">
                            <?if (Theme::get('logo_url')!=''):?>
                                <img src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                            <?else:?>
                                <h1><?=core::config('general.site_name')?></h1>
                            <?endif?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!--Container end -->
</div>
<nav id="nav" role="navigation">
    <ul class="navbar-nav">
        <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
            <?foreach ($menus as $menu => $data):?>
                <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>" >
                    <a href="<?=$data['url']?>" target="<?=$data['target']?>">
                        <?if($data['icon']!=''):?><i class="<?=$data['icon']?>"></i> <?endif?>
                        <?=$data['title']?>
                    </a>
                </li>
            <?endforeach?>
        <?else:?>
            <li class="<?=(Request::current()->controller()=='home')?'active':''?>" >
                <a href="<?=Route::url('default')?>"><i class="glyphicon glyphicon-home "></i> <?=_e('Home')?></a> </li>
            <?=Theme::nav_link(_e('Listing'),'ad', 'glyphicon glyphicon-list ' ,'listing', 'list')?>
            <?if (core::config('general.blog')==1):?>
                <?=Theme::nav_link(_e('Blog'),'blog','glyphicon glyphicon-file','index','blog')?>
            <?endif?>
            <?if (core::config('general.faq')==1):?>
                <?=Theme::nav_link(_e('FAQ'),'faq','glyphicon glyphicon-question-sign','index','faq')?>
            <?endif?>
            <?if (core::config('general.forums')==1):?>
                <?=Theme::nav_link(_e('Forums'),'forum','glyphicon glyphicon-tag','index','forum-home')?>
            <?endif?>
            <?=Theme::nav_link(_e('Search'),'ad', 'glyphicon glyphicon-search ', 'advanced_search', 'search')?>
            <?if (core::config('advertisement.map')==1):?>
                <?=Theme::nav_link(_e('Map'),'map', 'glyphicon glyphicon-globe ', 'index', 'map')?>
            <?endif?>
            <?=Theme::nav_link(_e('Contact'),'contact', 'glyphicon glyphicon-envelope ', 'index', 'contact')?>
            <?=Theme::nav_link(_e('RSS'),'rss', 'glyphicon glyphicon-signal ', 'index', 'rss')?>
        <?endif?>
    </ul>
    <a class="close-btn" id="nav-close-btn" href="#top"></a>
</nav>
<section class="search-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row no-gutter">
                    <?if(Core::config('general.algolia_search') == 1):?>
                        <div class="frm search-frm">
                            <?=View::factory('pages/algolia/autocomplete')?>
                        </div>
                    <?else:?>
                        <?=FORM::open(Route::url('search'), array('class'=>'frm search-frm', 'method'=>'GET', 'action'=>''))?>
                            <div class="form-group text-input col-sm-12 col-md-5">
                               <input name="title" type="text" class="search-query form-control" value="<?=HTML::chars(core::get('title'))?>" placeholder="<?=__('Keywords ...')?>">
                            </div>
                            <?$order_categories = Model_Category::get_multidimensional();?>
                            <div class="form-group select-input col-sm-12
                                <?=(core::config('advertisement.location') != FALSE) ? 'col-md-3' : 'col-md-6'?>
                            ">
                                <div class="control">
                                    <select <?=core::config('general.search_multi_catloc')? 'multiple':NULL?> name="category<?=core::config('general.search_multi_catloc')? '[]':NULL?>" id="category" class="form-control w175" data-placeholder="<?=__('Select category')?>" >
                                        <?if ( ! core::config('general.search_multi_catloc')) :?>
                                            <option value=""><?=_e('Select category')?></option>
                                        <?endif?>
                                        <?function lili2($item, $key,$cats){?>
                                            <?if (isset($cats[$key])):?>
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
                                            <?endif?>
                                        <?}array_walk($order_categories, 'lili2', Model_Category::get_as_array());?>
                                    </select>
                                </div>
                            </div>
                            <?$order_locations = Model_Location::get_multidimensional(); $locations = Model_Location::get_as_array();?>
                            <?if(core::config('advertisement.location') != FALSE AND core::count($locations) > 1):?>
                            <div class="form-group select-input col-sm-12 col-md-3">
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
                            <div class="col-sm-12 col-md-1 submit-btn">
                                <button type="submit" class="btn btn-primary hvr-icon-grow"></button>
                            </div>
                        <?=FORM::close()?>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
</section>
<?endif?>

<?if (!Auth::instance()->logged_in()):?>
    <div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Login')?></h3>
                </div>

                <div class="modal-body">
                    <?=View::factory('pages/auth/login-form')?>
                </div>
            </div>
        </div>
    </div>

    <div id="forgot-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Forgot password')?></h3>
                </div>

                <div class="modal-body">
                    <?=View::factory('pages/auth/forgot-form')?>
                </div>
            </div>
        </div>
    </div>

     <div id="register-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Register')?></h3>
                </div>

                <div class="modal-body">
                    <?=View::factory('pages/auth/register-form', ['recaptcha_placeholder' => 'recaptcha4', 'modal_form' => TRUE])?>
                </div>
            </div>
        </div>
    </div>
<?elseif(Core::config('general.pusher_notifications')):?> 
    <div id="pusher-subscribe" class="hidden" data-user="<?=Auth::instance()->get_user()->email?>" data-key="<?=Core::config('general.pusher_notifications_key')?>" data-cluster="<?=Core::config('general.pusher_notifications_cluster')?>"></div>
<?endif?>
