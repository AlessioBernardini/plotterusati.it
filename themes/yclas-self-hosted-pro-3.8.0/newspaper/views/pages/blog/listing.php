<?php defined('SYSPATH') or die('No direct script access.');?>
<h1 class="listings-title"><span><?=Core::config('general.site_name')?> <?=_e('Blog')?></span></h1>

<form class="pull-right" action="<?=Route::URL('blog')?>" method="get">
    <button class="btn btn-default pull-right" type="submit" value="<?=__('Search')?>"><?=_e('Search')?></button>
    <div class="pull-right">&nbsp;</div>
    <div class="pull-right">
        <input type="text" class="form-control" placeholder="<?=__('Search')?>" type="search" value="<?=HTML::chars(core::get('search'))?>" name="search" />
    </div>
</form>

<? if(core::count($posts)):?>
    <div class="row blog-listings">
        <div class="col-xs-12">
			<? foreach($posts as $post ):?>
				<div class="row listing-row">
					<div class="col-sm-12">
						<h2>
							<a title="<?=HTML::chars($post->title)?>" href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>"> <?=$post->title; ?></a>
						</h2>
						<p class="muted">
							<?= _e('Publish Date'); ?>: <?=Date::format($post->created, core::config('general.date_format'))?>
						</p>
						<div class="text-description blog-description">
                            <?=Text::truncate_html($post->description, 400, NULL)?>
                        	<a title="<?=HTML::chars($post->seotitle)?>" href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>"><?=_e('Read more')?> <i class="glyphicon glyphicon-share"></i></a>
						</div>
						<? if ($user !== NULL AND $user!=FALSE):?>
							<p class="text-right">
								<a href="<?=Route::url('oc-panel', array('controller'=>'blog','action'=>'update','id'=>$post->id_post))?>"><?=_e("Edit");?></a> | 
								<a href="<?=Route::url('oc-panel', array('controller'=>'blog','action'=>'delete','id'=>$post->id_post))?>" onclick="return confirm('<?=__('Delete?')?>');"><?=_e("Delete");?></a>
							</p>
						<? endif?>
					</div>
				</div>
			<? endforeach?>
			<?=$pagination?>
        </div>
	</div>
<? else:?>
<!-- Case when we dont have ads for specific category / location -->
	<div class="page-header">
	   <h3><?=_e('We do not have any blog post')?></h3>
    </div>
<?endif?>
