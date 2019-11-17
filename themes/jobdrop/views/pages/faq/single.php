<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1><?=$faq->title?></h1>
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
				<div>
					<?=Text::bb2html($faq->description,TRUE,FALSE)?>
				</div><!-- /well -->
				
				<?=$disqus?>
			</div>
		</div>
	</div>
</section>