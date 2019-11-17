<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="page-header">
	<div class="container no-gutter">	
        <div class="row">					
            <div class="col-sm-8">
    			<h1 class="h1"><?=$page->title?></h1>
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
				<div>
					<?=Text::bb2html($page->description,TRUE,FALSE)?>
				</div><!-- /well -->
			</div>
		</div>
	</div>
</section>
