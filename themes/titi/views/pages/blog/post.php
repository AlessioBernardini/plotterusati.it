<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1><?= $post->title;?></h1>
                </div>

                <p>
                    <span class="label label-default"><?=$post->user->name?></span>
                    <span class="pull-right">
                        <span class="label label-info"><?=Date::format($post->created, core::config('general.date_format'))?></span>
                    </span>
                </p> 

                <br/>

                <div class="text-description blog-description">
                    <?=$post->description?>
                </div>  

                <div class="pull-right">
                    <?if($previous->loaded()):?>
                        <a class="btn btn-success" href="<?=Route::url('blog',  array('seotitle'=>$previous->seotitle))?>" title="<?=HTML::chars($previous->title)?>">
                        <i class="glyphicon glyphicon-backward glyphicon"></i> <?=Text::limit_chars($previous->title, 30, NULL, TRUE)?></i></a>
                    <?endif?>
                    <?if($next->loaded()):?>
                        <a class="btn btn-success" href="<?=Route::url('blog',  array('seotitle'=>$next->seotitle))?>" title="<?=HTML::chars($next->title)?>">
                        <?=Text::limit_chars($next->title, 30, NULL, TRUE)?> <i class="glyphicon glyphicon-forward glyphicon"></i></a>
                    <?endif?>
                </div>  
                    
                <?=$post->disqus()?>
            </div>
        </div>
    </div>
</div>
