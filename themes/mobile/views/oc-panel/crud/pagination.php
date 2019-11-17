<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="pagination">
		<?if($current_page !== 1):?>
		<a data-role="button" class="pag_left ui_btn_pag" data-inline="true"  data-icon="arrow-l" data-iconpos="notext" title="<?=__('Previous')?> <?=$page->title()?>" href="<?=HTML::chars($page->url($previous_page))?>" rel="prev"><i class="icon-backward"></i></a>
		<?endif?>
			<span><?=__("Page ")?><?=$current_page?><?=__(' of ')?></span>
			<span><?=$total_pages?></span>	
		<?if($current_page !== $total_pages):?>
		<a data-role="button" class="pag_right ui_btn_pag" data-inline="true"  data-icon="arrow-r" data-iconpos="notext" title="<?=__('Next')?> <?=$page->title()?>" href="<?=HTML::chars($page->url($next_page)) ?>" rel="next"><i class="icon-forward"></i></a>
		<?endif?>
</div><!-- .pagination -->
<input class="current_page_listing" type="hidden" value='<?=$current_page?>'/>
<input class="total_page_listing" type="hidden" value="<?=$total_pages?>"/>	