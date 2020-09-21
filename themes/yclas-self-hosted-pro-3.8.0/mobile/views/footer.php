<?php defined('SYSPATH') or die('No direct script access.');?>

<div data-role="footer" class="ui_base" data-position="fixed" data-theme="<?=Theme::get('theme_color_main');?>"> 
       
	<!-- ACTIONS (navigational list manu) -->
	<div class="ui-grid-solo footer_grid">
		<div class="ui-block-solo">
			<!-- Nav panel button -->
			<!-- <a href="#nav-panel" data-icon="bars" class="ui_base_btn ui_base_btn_shape" data-inline="true" >Menu</a> -->
		</div>
	    <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator())) AND strtolower(Request::current()->controller()) != 'new' AND strtolower(Request::current()->controller()) != 'myads'):?>
	    <div class="ui-block-solo"><a target="_self" data-role="button" data-transition="slide" href="<?=Route::url('post_new')?>" class="ui_base_btn_shape ui_base_btn ui_btn_small"  data-inline="true" ><?=__('Publish new ')?>
	    </a></div>
        <?endif?>
	</div>
</div>

</div><!-- end page 1 -->