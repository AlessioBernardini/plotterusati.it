<?php defined('SYSPATH') or die('No direct script access.');?>
<form action="<?=Route::URL('forum-home')?>" method="get">
    <input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="<?=__('Cerca nel forum...')?>" type="search" value="<?=HTML::chars(core::get('search'))?>" name="search" />
    <button class="btn btn-default" type="submit" value="<?=__('Search')?>"><?=_e('Search')?></button>
</form>