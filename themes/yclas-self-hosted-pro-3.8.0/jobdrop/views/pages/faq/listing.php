<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1><?=_e('Frequently asked questions')?></h1>
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
		</div>	
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
			    <h3><?=_e('We do not have any FAQ-s')?></h3>
			<?endif?>
			
			<?=$disqus?>
			</div>
		</div>
	</div>
</section>