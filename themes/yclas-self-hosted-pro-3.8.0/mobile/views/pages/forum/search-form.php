<?php defined('SYSPATH') or die('No direct script access.');?>
<form class="" action="<?=Route::URL('forum-home')?>" method="get">
<div>
    <input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="<?=__('Search')?>" type="search" value="<?=HTML::chars(core::get('search'))?>" name="search"/>
</div>
    <button class="btn btn-default pull-right" type="submit" value="<?=__('Search')?>"><?=_e('Search')?></button>
</form>