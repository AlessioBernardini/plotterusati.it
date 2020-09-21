<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1><?= $post->title;?></h1>
</div>
<section id="main">
    <div class="container no-gutter">
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
		</div>
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
