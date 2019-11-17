<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<!-- Logo & Navigation starts -->
<div class="header <?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'navbar-fixed-top':''?>">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <!-- Logo -->
                <div class="logo">
                    <?if (Theme::get('logo_url')!=''):?>
                        <a href="<?=Route::url('default')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>"><img class="img-responsive" href="<?=Route::url('default')?>" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" ></a>
                    <?else:?>
                        <h1>
                            <img src="<?=Route::url('default').'themes/olson/img/FFFFFF-0.png'?>">
                            <a href="<?=Route::url('default')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>"><?=core::config('general.site_name')?></a>
                        </h1>
                    <?endif?>
                    <?if (Theme::get('short_description')!=''):?>
                        <small><?=Theme::get('short_description')?></small>
                    <?endif?>
                </div>
            </div>
            <?
            $cats = Model_Category::get_category_count();
            $loc_seoname = NULL;
            if (Model_Location::current()->loaded())
            {
                if (Model_Location::current()->loaded())
                    $loc_seoname = Model_Location::current()->seoname;
            }?>
            <div class="col-md-6 col-sm-5">
                <!-- Navigation menu -->
                <div class="navi">
                    <div id="ddtopmenubar" class="mattblackmenu">
                        <ul>
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
                                <?=Theme::nav_link(_e('Listing'),'ad', '' ,'listing', 'list')?>
                                <?=Theme::nav_link(_e('Search'),'ad', '', 'advanced_search', 'search')?>
                                <?if (core::config('advertisement.map')==1):?>
                                    <?=Theme::nav_link(_e('Map'),'map', '', 'index', 'map')?>
                                <?endif?>
                                <?=Theme::nav_link(_e('Contact'),'contact', '', 'index', 'contact')?>
                                <li>
                                    <a href="#" rel="ddsubmenu1"><?=_e('Categories')?>
                                        <img src="<?=Route::url('default').'themes/olson/img/arrow-down.gif'?>" class="downarrowpointer" style="width: 11px; height: 7px;">
                                    </a>
                                    <ul id="ddsubmenu1">
                                        <?foreach($cats as $c ):?>
                                            <?if($c['id_category_parent'] == 1 && $c['id_category'] != 1):?>
                                                <li>
                                                    <a title="<?=HTML::chars($c['seoname'])?>" href="<?=(!$c['has_siblings'])?Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname)):'#'?>" class="<?=!$c['has_siblings']?'parent_cat_header':''?>">
                                                        <?=$c['translate_name']?>
                                                        <?if($c['has_siblings']):?>
                                                        	<img src="<?=Route::url('default').'themes/olson/img/arrow-right.gif'?>" class="downarrowpointer" style="width: 11px; height: 7px;">
                                                    	<?endif?>
                                                    </a>
                                                    <?if($c['has_siblings']):?>
	                                                    <ul id="ddsubmenu2">
	                                                        <?foreach($cats as $chi):?>
	                                                            <?if($chi['id_category_parent'] == $c['id_category']):?>
	                                                                <li>
	                                                                    <a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'],'location'=>$loc_seoname))?>">
	                                                                        <?=$chi['translate_name']?>
	                                                                    </a>
	                                                                </li>
	                                                            <?endif?>
	                                                        <?endforeach?>
	                                                    </ul>
                                                    <?endif?>
                                                </li>
                                            <?endif?>
                                        <?endforeach?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" rel="ddsubmenu2"><?=_e('More')?>
                                        <img src="<?=Route::url('default').'themes/olson/img/arrow-down.gif'?>" class="downarrowpointer" style="width: 11px; height: 7px;">
                                    </a>
                                    <ul id="ddsubmenu2">
                                        <?if (core::config('general.blog')==1):?>
                                            <?=Theme::nav_link(_e('Blog'),'blog','','index','blog')?>
                                        <?endif?>
                                        <?if (core::config('general.faq')==1):?>
                                            <?=Theme::nav_link(_e('FAQ'),'faq','','index','faq')?>
                                        <?endif?>
                                        <?if (core::config('general.forums')==1):?>
                                            <?=Theme::nav_link(_e('Forums'),'forum','','index','forum-home')?>
                                        <?endif?>
                                        <?=Theme::nav_link(_e('RSS'),'rss', '', 'index', 'rss')?>
                                    </ul>
                                </li>
                            <?endif?>
                        </ul>
                    </div>
                </div>
                <div class="navis"></div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="kart-links">
                    <?=View::factory('widget_login')?>
                    <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                        <a href="<?=Route::url('post_new')?>">
                            <i class="glyphicon glyphicon-pencil"></i> <?=_e('Publish new')?>
                        </a>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Logo & Navigation ends -->
<div class="clearfix"></div>
<?endif?>

<?if (!Auth::instance()->logged_in()):?>
    <!-- Login modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?=_e('Login')?></h4>
                </div>
                <div class="modal-body">
                    <?=View::factory('pages/auth/login-form')?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?=_e('Remember Password')?></h4>
                </div>
                <div class="modal-body">
                    <?=View::factory('pages/auth/forgot-form')?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?=_e('Register')?></h4>
                </div>
                <div class="modal-body">
                    <?=View::factory('pages/auth/register-form', ['recaptcha_placeholder' => 'recaptcha4', 'modal_form' => TRUE])?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?elseif(Core::config('general.pusher_notifications')):?>
    <div id="pusher-subscribe" class="hidden" data-user="<?=Auth::instance()->get_user()->email?>" data-key="<?=Core::config('general.pusher_notifications_key')?>" data-cluster="<?=Core::config('general.pusher_notifications_cluster')?>"></div>
<?endif?>