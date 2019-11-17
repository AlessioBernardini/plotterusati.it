<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
	<h1><?= $post->title;?></h1>
    <div class="page-header-label">
    	<a class="label label-default" href="<?=Route::url('profile',  array('seoname'=>$post->user->seoname))?>"><?=$post->user->name?> <?=$post->user->is_verified_user();?></a>
        <span class="label label-info"><?=Date::format($post->created, core::config('general.date_format'))?></span>
    </div>
</div>

<div class="text-description blog-description">
    <?=$post->description?>
</div>

<hr>

<? if($next->loaded()):?>
    <div class="pull-right hidden-xs">
        <a class="btn btn-default" href="<?=Route::url('blog', array('seotitle'=>$next->seotitle))?>" title="<?=HTML::chars($next->title)?>">
        <?=$next->title?> <i class="glyphicon glyphicon-chevron-right"></i></a>
    </div>
    <div class="visible-xs-block">
        <a class="btn btn-block btn-default truncate" href="<?=Route::url('blog', array('seotitle'=>$next->seotitle))?>" title="<?=HTML::chars($next->title)?>">
        <?=$next->title?> <i class="glyphicon glyphicon-chevron-right"></i></a>
    </div>
<? endif?>
<? if($previous->loaded()):?>
    <div class="pull-left hidden-xs">
        <a class="btn btn-default" href="<?=Route::url('blog', array('seotitle'=>$previous->seotitle))?>" title="<?=HTML::chars($previous->title)?>">
        <i class="glyphicon glyphicon-chevron-left"></i> <?=$previous->title?></a>
    </div>
    <div class="visible-xs-block">
        <br>
        <a class="btn btn-block btn-default truncate" href="<?=Route::url('blog', array('seotitle'=>$previous->seotitle))?>" title="<?=HTML::chars($previous->title)?>">
        <i class="glyphicon glyphicon-chevron-left"></i> <?=$previous->title?></a>
    </div>
<? endif?>

<?=$post->disqus()?>
