<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="page-header">
	<div class="container no-gutter">	
        <div class="row">					
            <div class="col-sm-8">
    			<h1 class="h1"><?=_e('Frequently Asked Questions')?></h1>
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
	<div class="container">
		<div class="row">
			<div class="col-sm-12">			
			<?if(core::count($faqs)):?>
			<ol class="faq-list">
			    <?foreach($faqs as $faq ):?>
			    <li>
			        <h4>
			            <a title="<?=HTML::chars($faq->title)?>" href="<?=Route::url('faq', array('seotitle'=>$faq->seotitle))?>"> <?=$faq->title?></a>
			        </h4>            
			        <p><?=Text::limit_chars(Text::removebbcode($faq->description),400, NULL, TRUE);?>
			            <a title="<?=HTML::chars($faq->title)?>" href="<?=Route::url('faq', array('seotitle'=>$faq->seotitle))?>"><?=_e('Read more')?>.</a>
			        </p>
			    </li>
			    <?endforeach?>
			</ol>
			<?else:?>
			<!-- Case when we dont have ads for specific category / location -->
			    <div class="page-header">
			       <h3><?=_e('We do not have any FAQ-s')?></h3>
			    </div>
			<?endif?>
			
			<?=$disqus?>
			</div>
		</div>
	</div>
</section>