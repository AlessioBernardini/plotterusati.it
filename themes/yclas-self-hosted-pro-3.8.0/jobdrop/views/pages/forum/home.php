<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1 class="h1"><?=_e("Forums")?></h1> 
</div>
<section id="main">
	<div class="container">
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
		    <div class="col-xs-12">
		        <?if (!Auth::instance()->logged_in()):?>
			        <a class="btn btn-success pull-right" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
			    <?else:?>
			        <a class="btn btn-success pull-right" href="<?=Route::url('forum-new')?>">
			    <?endif?>
			        <?=_e('New Topic')?></a>		    
			    <?=View::factory('pages/forum/search-form')?>
		    </div>	
		</div>
		<div class="row">
			<div class="col-sm-12">			
				<table class="table table-hover" id="task-table">
				    <thead>
				        <tr>
				            <th><?=_e('Forum topic')?></th>
				            <th><?=_e('Last Message')?></th>
				            <th><?=_e('Topics')?></th>
				        </tr>
				    </thead>
				    <tbody>
				        <?foreach($forums as $f):?>
				        <?if($f['id_forum_parent'] == 0):?>
				            <tr class="success">
				                <td><a title="<?=HTML::chars($f['name'])?>" href="<?=Route::url('forum-list', array('forum'=>$f['seoname']))?>"><?=mb_strtoupper($f['name']);?></a></td>
				                <td width="15%"><span class="label label-warning pull-right"><?=(isset($f['last_message'])?Date::format($f['last_message'], core::config('general.date_format')):'')?></span></td>
				                <td width="5%"><span class="label label-success pull-right"><?=number_format($f['count'])?></span></td>
				            </tr>
				                <?foreach($forums as $fhi):?>
				                    <?if($fhi['id_forum_parent'] == $f['id_forum']):?>
				                    <tr>
				                        <th><a title="<?=HTML::chars($fhi['name'])?>" href="<?=Route::url('forum-list', array('forum'=>$fhi['seoname']))?>"><?=$fhi['name'];?></a></th>
				                        <th width="15%"><span class="label label-warning pull-right"><?=(isset($fhi['last_message'])?Date::format($fhi['last_message'], core::config('general.date_format')):'')?></span></th>
				                        <th width="5%"><span class="label label-success pull-right"><?=number_format($fhi['count'])?></span></th>
				                    </tr>
				                    <?endif?>
				                <?endforeach?>
				            <?endif?>
				        <?endforeach?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</section>


