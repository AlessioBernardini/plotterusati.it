<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
    <h1><?=Core::config('general.site_name')?> <?=__('Blog')?></h1>
</div>

<?if(core::count($posts)):?>
    <?foreach($posts as $post ):?>
    <article class="list well clearfix">
    	<h2>
    		<a title="<?=HTML::chars($post->title)?>" href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>"> <?=$post->title; ?></a>
    	</h2>
    	
    	<?=Date::format($post->created, core::config('general.date_format'))?>
	   		
	    <div class="blog-description"><?=Text::truncate_html($post->description, 255, NULL)?></div>
	    
	    <a title="<?=HTML::chars($post->seotitle)?>" href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>"><i class="icon-share"></i><?=__('Read more')?></a>
    	<?if ($user !== NULL AND $user!=FALSE):?>
            <?if ($user->id_role == 10):?>
            <br />
            <a href="<?=Route::url('oc-panel', array('controller'=>'blog','action'=>'update','id'=>$post->id_post))?>"><?=__("Edit");?></a> |
            <a href="<?=Route::url('oc-panel', array('controller'=>'blog','action'=>'delete','id'=>$post->id_post))?>" 
                onclick="return confirm('<?=__('Delete?')?>');"><?=__("Delete");?></a>
            <?endif?>
        <?endif?>
    </article>
    <?endforeach?>
    <?=$pagination?>
<?else:?>
<!-- Case when we dont have ads for specific category / location -->
	<div class="page-header">
	   <h3><?=__('We do not have any blog posts')?></h3>
    </div>
<?endif?>
