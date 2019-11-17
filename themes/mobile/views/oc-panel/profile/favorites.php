<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="page-header">
    <h1><?=__('My Favorites')?></h1>
</div>

<div class="header_devider"></div>

<?=Alert::show()?>

<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">
    <thead>
        <tr>
            <th data-priority="1"><?=__('Advertisement')?></th>
            <th data-priority="2"><?=__('Favorited')?></th>
            <th data-priority="3"><?=__('Action')?></th>
        </tr>
    </thead>
    <tbody>
        <?foreach($favorites as $favorite):?>
            <tr id="tr<?=$favorite->id_favorite?>">
                <td><a target="_blank" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$favorite->ad->category->seoname,'seotitle'=>$favorite->ad->seotitle))?>"><?= wordwrap($favorite->ad->title, 150, "<br />\n"); ?></a></td>
                <td><?= Date::format($favorite->created, core::config('general.date_format'))?></td>
                <td>
                    <a
                        data-id="tr<?=$favorite->id_favorite?>" 
                        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                        data-title="<?=__('Are you sure you want to delete?')?>" 
                        data-btnCancelLabel="<?=__('No way!')?>"
                        data-role="button" 
                        data-inline="true" 
                        target="_blank" 
                        data-transition="slide" 
                        data-icon="delete" 
                        data-mini="true" 
                        class="pag_right ui_base_btn ui_btn_small index-delete index-delete-inline" 
                        href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$favorite->id_ad))?>">
                        <?=__('Delete')?>
                    </a>
                </td>
            </tr>
        <?endforeach?>
    </tbody>
</table>
