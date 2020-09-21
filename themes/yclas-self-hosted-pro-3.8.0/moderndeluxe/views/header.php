<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<header class="navbar header navbar-inverse <?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'navbar-fixed-top':''?>">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu-panel">
                <span class="sr-only"><?=_e('Toggle navigation')?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-btn pull-right hidden-md hidden-lg">
            	<?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
		            <a class="btn btn-default btn-custom1 hidden-xs" href="<?=Route::url('post_new')?>">
		                <i class="glyphicon glyphicon-pencil glyphicon"></i> <?=_e('Publish new ')?>
		            </a>
		            <a class="btn btn-default btn-custom1 hidden-sm" href="<?=Route::url('post_new')?>" title="<?=_e('Publish new ')?>">
		                <i class="glyphicon glyphicon-pencil glyphicon"></i>
		            </a>
		        <?endif?>
            	<?=View::factory('widget_login')?>
            </div>
            <a class="navbar-brand logo <?=(Theme::get('logo_url')!=''?'logo_img':'')?>" href="<?=Route::url('default')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>">
                <?if (Theme::get('logo_url')!=''):?>
                    <img href="<?=Route::url('default')?>" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                <?else:?>
                    <h1><?=core::config('general.site_name')?></h1>
                <?endif?>
            </a>
        </div>
        <?
            $cats = Model_Category::get_category_count();
            $loc_seoname = NULL;

            if (Model_Location::current()->loaded())
                $loc_seoname = Model_Location::current()->seoname;
        ?>
        <div class="collapse navbar-collapse" id="mobile-menu-panel">
        	<div class="row">
		        <ul class="nav navbar-nav group-right-box top-navigation">
		            <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
		                <?foreach ($menus as $menu => $data):?>
		                    <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>" >
		                    <a href="<?=$data['url']?>" target="<?=$data['target']?>">
		                        <?if($data['icon']!=''):?><i class="<?=$data['icon']?>"></i> <?endif?>
		                        <?=$data['title']?></a>
		                    </li>
		                <?endforeach?>
		            <?else:?>
		        	<li class="<?=(Request::current()->controller()=='home')?'active':''?>" >
		            	<a href="<?=Route::url('default')?>"><i class="glyphicon glyphicon-home "></i> <?=_e('Home')?></a>
		            </li>
		            <?=Theme::nav_link(_e('Listing'),'ad', 'glyphicon glyphicon-list' ,'listing', 'list')?>
		            <?if (core::config('general.blog')==1):?>
		            <?=Theme::nav_link(_e('Blog'),'blog','glyphicon glyphicon-book','index','blog')?>
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
		            <li class="log hidden-xs hidden-sm"><?=View::factory('widget_login')?></li>
		        </ul>
		        <div class="navbar-btn navbar-right categories-navigation">
		            <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
		                <a class="btn btn-default btn-custom1 hidden-xs hidden-sm" href="<?=Route::url('post_new')?>">
		                    <i class="glyphicon glyphicon-pencil glyphicon"></i> <?=_e('Publish new ')?>
		                </a>
		            <?endif?>
					<a href="#" class="btn btn-default btn-custom2" id="view-categories" title="Click to view categories"><?=_e('Categories')?>&nbsp;&nbsp;<i class="glyphicon glyphicon-chevron-down"></i></a>
		        </div>
	        </div>
    	</div>
	    <div class="categories-box">
	        <?
	            $cats = Model_Category::get_category_count();
	            $cols=0;
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
	       	<div class="row">
		        <?foreach($cats as $c ):?>
		            <?if($c['id_category_parent'] == 1 && $c['id_category'] != 1):?>
		        <?php $cols++; if( $cols<=++$cols ){ ?>
		             <ul class="col-sm-3">
		             		<li class="drop <?=($c['id_category'] == $cat_parent OR $c['id_category'] == $cat_id)?'active':''?>">
		                    <a href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>"  title="<?=HTML::chars($c['seoname'])?>" >
		                        <?=$c['translate_name']?></a>
		                    <ul>
		                    <?foreach($cats as $chi):?>
		                    <?if($chi['id_category_parent'] == $c['id_category']):?>
		                        <li class="<?=($chi['id_category'] == $cat_id)?'active':''?>" >
		                            <a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'],'location'=>$loc_seoname))?>">
		                            <?=$chi['translate_name']?>
		                                <?if (Theme::get('category_badge')!=1) : ?>
		                                    <span class="badge"><?=number_format($chi['count'])?></span>
		                                <?endif?>
		                            </a>
		                        </li>
		                    <?endif?>
		                    <?endforeach?>
		                    </ul>
		                </li>
		             </ul>
		             <?php } else { echo('<div class="clear"></div>');$cols=0;}?>
		            <?endif?>
		        <?endforeach?>
		    </div><!-- end row -->
 		</div><!-- end categories-box-->
	</div>
</header>
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