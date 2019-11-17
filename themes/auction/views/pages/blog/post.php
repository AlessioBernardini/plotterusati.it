<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
	<h1><?= $post->title;?></h1>
</div>

<i class="text-muted">
    <?=Date::format($post->created, core::config('general.date_format'))?>  <?=_e('by')?> <?=$post->user->name?>
</i>

<br/>

<div class="text-description blog-description">
    <?=$post->description?>
</div>

<div class="pull-right hidden-xs">
    <?if($previous->loaded()):?>
        <a class="btn btn-success" href="<?=Route::url('blog',  array('seotitle'=>$previous->seotitle))?>" title="<?=HTML::chars($previous->title)?>">
        <i class="glyphicon glyphicon-backward glyphicon"></i> <?=$previous->title?></i></a>
    <?endif?>
    <?if($next->loaded()):?>
        <a class="btn btn-success" href="<?=Route::url('blog',  array('seotitle'=>$next->seotitle))?>" title="<?=HTML::chars($next->title)?>">
        <?=$next->title?> <i class="glyphicon glyphicon-forward glyphicon"></i></a>
    <?endif?>
</div>

<div class="visible-xs-block">
    <?if($previous->loaded()):?>
        <a class="btn btn-block btn-success truncate" href="<?=Route::url('blog',  array('seotitle'=>$previous->seotitle))?>" title="<?=HTML::chars($previous->title)?>">
        <i class="glyphicon glyphicon-backward glyphicon"></i> <?=$previous->title?></i></a>
    <?endif?>
    <?if($next->loaded()):?>
        <br>
        <a class="btn btn-block btn-success truncate" href="<?=Route::url('blog',  array('seotitle'=>$next->seotitle))?>" title="<?=HTML::chars($next->title)?>">
        <?=$next->title?> <i class="glyphicon glyphicon-forward glyphicon"></i></a>
    <?endif?>
</div>

<?=$post->disqus()?>
