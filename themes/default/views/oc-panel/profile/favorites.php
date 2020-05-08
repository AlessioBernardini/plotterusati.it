<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?=_e('My Favorites')?></h1>
    <?if (Auth::instance()->get_user()->is_admin()) :?>
        <small><a target='_blank' href='https://docs.yclas.com/add-chosen-ads-favourites/'><?=_e('Read more')?></a></small>
    <?endif?>
</div>

<div class="panel panel-default">
    <? $ceck = 0; ?>
    <? foreach ($favorites as $favorite) {$ceck++;} ?>
    <? if($ceck >0){?>
    <div id="mobile-desc"><small>Scorri verso destra per visualizzare tutti i dati</small></div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?=_e('Immagine')?></th>
                    <th><?=_e('Name')?></th>
                    <th><?=_e('Date')?></th>
                    <th><?=_e('Price')?></th>
                    <th><?=_e('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?foreach($favorites as $favorite):?>
                    <? $ceck++ ?>
                    <tr id="tr<?=$favorite->id_favorite?>">
                        <td><?=HTML::picture($favorite->ad->get_first_image('image'), ['w' => 70, 'h' => 70], ['1200px' => ['w' => '70', 'h' => '70'], '992px' => ['w' => '70', 'h' => '70'], '768px' => ['w' => '70', 'h' => '70'], '480px' => ['w' => '50', 'h' => '50'], '320px' => ['w' => '50', 'h' => '50']], ['class' => 'img-responsive', 'alt' => HTML::chars($favorite->ad->title)])?></td>
                        <td><a target="_blank" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$favorite->ad->category->seoname,'seotitle'=>$favorite->ad->seotitle))?>"><?= wordwrap($favorite->ad->title, 150, "<br />\n"); ?></a></td>
                        <td><?= Date::format($favorite->created, core::config('general.date_format'))?></td>
                        <td>
                            <?if ($favorite->ad->price!=0){?>
                                <div class="price pull-left">
                                    <?=i18n::money_format($favorite->ad->price, $favorite->ad->currency())?>
                                </div>
                            <?}?>
                            <?if ($favorite->ad->price==0 AND core::config('advertisement.free')==1){?>
                                <div class="price pull-left">
                                    <?=_e('Free');?>
                                </div>
                            <?}?>
                        </td>
                        <td>
                            <a 
                                href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$favorite->id_ad))?>" 
                                class="btn btn-danger index-delete index-delete-inline" 
                                data-title="<?=__('Are you sure you want to delete?')?>" 
                                data-id="tr<?=$favorite->id_favorite?>" 
                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                data-btnCancelLabel="<?=__('No way!')?>">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?endforeach?>
            </tbody>
        </table>
    </div>
    <? } ?>
    <?
    if($ceck == 0){
        $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
        echo '<h3 class="no-border light text-center">Non hai ancora nessun annuncio preferito. Fai un giro sul <a href="'.$domain.'">sito</a> e scopri quali sono!</a></h3>';
    }
    ?>
</div>
