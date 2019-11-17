<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Theme::landing_single_ad() == FALSE):?>

<div class="navbar navbar-default <?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'navbar-fixed-top':''?>">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu-panel">
                <span class="sr-only"><?=_e('Toggle navigation')?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-btn pull-right hidden-md hidden-lg">
                <?=View::factory('widget_login')?>
                <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    <a class="btn btn-inverse" href="<?=Route::url('post_new')?>">
                        <i class="glyphicon glyphicon-pencil "></i> <?=_e('Publish new')?>
                    </a>
                <?endif?>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="mobile-menu-panel">
            <ul class="nav navbar-nav">
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
                        <?=Theme::nav_link('','map', 'glyphicon glyphicon-globe ', 'index', 'map')?>
                    <?endif?>
                    <?=Theme::nav_link(_e('Contact'),'contact', 'glyphicon glyphicon-envelope ', 'index', 'contact')?>
                    <?=Theme::nav_link('','rss', 'glyphicon glyphicon-signal ', 'index', 'rss')?>
                <?endif?>
            </ul>
            <div class="navbar-btn pull-right hidden-xs hidden-sm">
                <?=View::factory('widget_login')?>
                <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    <a class="btn btn-inverse" href="<?=Route::url('post_new')?>">
                        <i class="glyphicon glyphicon-pencil "></i> <?=_e('Publish new')?>
                    </a>
                <?endif?>
            </div>
        </div>

        <!--/.nav-collapse -->
    </div>
    <!-- end container-->
</div>

<div id="logo">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <a class="brand" href="<?=Route::url('default')?>">
                            <?if (Theme::get('logo_url')!=''):?>
                                <img class="img-responsive" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                            <?else:?>
                                <h1><?=core::config('general.site_name')?></h1>
                            <?endif?>
                        </a>
                    </div>
                    <?if (Theme::get('short_description')!=''):?>
                        <div class="col-lg-12 col-md-12">
                            <p class="lead"><?=Theme::get('short_description')?></p>
                        </div>
                    <?endif?>
                </div>
            </div>

            <div class="col-lg-3">
                <?if(Core::config('general.algolia_search') == 1):?>
                    <div class="navbar-form">
                        <?=View::factory('pages/algolia/autocomplete')?>
                    </div>
                <?else:?>
                    <?= FORM::open(Route::url('search'), array('class'=>'navbar-form '.(Theme::get('short_description')!='')?'no-margin':'',
                            'method'=>'GET', 'action'=>''))?>
                        <input type="text" name="search" class="form-control col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-30" placeholder="<?=__('Search')?>">
                    <?= FORM::close()?>
                <?endif?>
            </div>
        </div>
    </div>
</div>

<!-- end navbar top-->
<div class="subnav navbar <?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'':'fixed_header'?>">
    <div class="container">
        <ul class="nav nav-pills">
            <?
                $cats = Model_Category::get_category_count();

                $cat_id = NULL;
                $cat_parent = NULL;

                if (Model_Category::current()->loaded())
                {
                    $cat_id = Model_Category::current()->id_category;
                    $cat_parent =  Model_Category::current()->id_category_parent;
                }

                $loc_seoname = NULL;

                if (Model_Location::current()->loaded())
                    $loc_seoname = Model_Location::current()->seoname;

            ?>
            <?foreach($cats as $c ):?>
                <?if($c['id_category_parent'] == 1 && $c['has_siblings'] == FALSE):?>
                    <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
                        <a title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                            <?=$c['translate_name']?>
                        </a>
                    </li>
                <?elseif($c['id_category_parent'] == 1 && $c['id_category'] != 1):?>
                    <li class="dropdown dropdown-large <?=($c['id_category'] == $cat_parent OR $c['id_category'] == $cat_id)?'active':''?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="<?=HTML::chars($c['seoname'])?>" >
                            <?=$c['translate_name']?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-large row">
                            <li class="col-sm-3 dropdown-list-width" >
                                <ul>
                                    <?$i=1;foreach($cats as $chi):?>
                                        <?if($chi['id_category_parent'] == $c['id_category']):?>
                                            <?if($i%12 == 0):?></ul></li><li class="col-sm-3 dropdown-list-width<?=($chi['id_category'] == $cat_id)?'active':''?>" ><ul><?$i=1;endif?>
                                            <li>
                                                <a class="<?=($chi['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'],'location'=>$loc_seoname))?>">
                                                    <?=$chi['translate_name']?>
                                                    <?if (Theme::get('category_badge')!=1) : ?>
                                                        <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"><?=number_format($chi['count'])?></div>
                                                    <?endif?>
                                                </a>
                                            </li>
                                        <?$i++;endif?>
                                    <?endforeach?>
                                    <li class="divider"></li>
                                    <li>
                                        <a class="<?=($c['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                            <?=$c['translate_name']?>
                                            <?if (Theme::get('category_badge')!=1) : ?>
                                                <span class="badge badge-success <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"><?=number_format($c['count'])?></span>
                                            <?endif?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?endif?>
            <?endforeach?>
        </ul>
        <!-- end nav-pills-->
        <div class="clear"></div>
    </div> <!-- end container-->
</div><!-- end .subnav-->
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
