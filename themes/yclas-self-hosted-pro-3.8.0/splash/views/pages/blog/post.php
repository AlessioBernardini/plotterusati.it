<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h1"><?= $post->title;?></h1>
                <div class="page-header-label">
                    <a class="label label-default" href="<?=Route::url('profile',  array('seoname'=>$post->user->seoname))?>"><?=$post->user->name?> <?=$post->user->is_verified_user();?></a>
                    <span class="label label-info"><?=Date::format($post->created, core::config('general.date_format'))?></span>
                </div>
            </div>
            <?if (Theme::get('breadcrumb')==1):?>
                <div class="col-sm-4 breadcrumbs">
                    <?=Breadcrumbs::render('breadcrumbs')?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<?=Alert::show()?>

<section id="main">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
    </div>
</section>
