<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
	<h1><?= $post->title;?></h1>
</div>

<div class="well">
    <a class="label label-default" href="<?=Route::url('profile',  array('seoname'=>$post->user->seoname))?>"><?=$post->user->name?> <?=$post->user->is_verified_user();?></a>
    <div class="pull-right">
        <span class="label label-info"><?=Date::format($post->created, core::config('general.date_format'))?></span>
    </div>    
</div>

<br/>

<div class="blog-description">
    <?=$post->description?>
</div>  

<?if($previous->loaded()):?>
    <a data-role="button" data-inline="true"  target="_blank" data-transition="slide" data-icon="arrow-l" class="pag_right ui_base_btn ui_btn_small" href="<?=Route::url('blog',  array('seotitle'=>$previous->seotitle))?>"><?=$previous->title?></a>
<?endif?>
<?if($next->loaded()):?>
    <a data-role="button" data-inline="true"  target="_blank" data-transition="slide" data-icon="arrow-r" class="pag_right ui_base_btn ui_btn_small" href="<?=Route::url('blog',  array('seotitle'=>$next->seotitle))?>"><?=$next->title?></a>
<?endif?>

<?=$post->disqus()?>