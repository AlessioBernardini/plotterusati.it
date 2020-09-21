<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
    <h1 class="forum-title pull-left"><?=_e("Forums")?></h1>
    
    <?if (!Auth::instance()->logged_in()):?>
        <a class="btn btn-success pull-right" data-toggle="modal" data-dismiss="modal" 
            href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
    <?else:?>
        <a class="btn btn-success pull-right" href="<?=Route::url('forum-new')?>">
    <?endif?>
        <?=_e('New Topic')?></a>
    
    <?=View::factory('pages/forum/search-form')?>
<div class="clearfix"></div>
</div>

<?if(Core::count($forums) > 0):?>
	<div id="forum-headers" class="col-xs-12">
        <div class="col-sm-9 col-xs-10">
            <?=_e('Forum')?>
        </div>
        <div class="col-sm-2 hidden-xs">
        	<?=_e('Last Message')?>
    	</div>
        <div class="col-sm-1 col-xs-2">
        	<?=_e('Topics')?>
    	</div>
    </div>

	<?foreach($forums as $f):?>
		<?if($f['id_forum_parent'] == 0):?>
		    <div class="parent-forum col-xs-12">
		        <div class="parent-forum-name col-sm-9 col-xs-10">
		            <a title="<?=HTML::chars($f['name'])?>" href="<?=Route::url('forum-list', array('forum'=>$f['seoname']))?>"><?=mb_strtoupper($f['name']);?>
		            </a>
		        </div>
		        <div class="col-sm-2 hidden-xs">
		        	<span class="text-muted"><?=(isset($f['last_message'])?Date::format($f['last_message'], core::config('general.date_format')):'')?></span>
		    	</div>
		        <div class="col-sm-1 col-xs-2">
		        	<strong><?=number_format($f['count'])?></strong>
		    	</div>
		    </div>
	        <?foreach($forums as $fhi):?>
	            <?if($fhi['id_forum_parent'] == $f['id_forum']):?>
	            <div class="child-forum col-xs-12">
	                <div class="child-forum-name col-sm-9 col-xs-12"><a title="<?=HTML::chars($fhi['name'])?>" href="<?=Route::url('forum-list', array('forum'=>$fhi['seoname']))?>"><?=$fhi['name'];?></a></div>
	                <div class="col-sm-2 hidden-xs text-muted"><small><?=(isset($fhi['last_message'])?Date::format($fhi['last_message'], core::config('general.date_format')):'')?></small></div>
	                <div class="col-sm-1 hidden-xs"><?=number_format($fhi['count'])?></div>
	            </div>
	            <?endif?>
	        <?endforeach?>
	    <?endif?>
	<?endforeach?>
<?endif?>



