<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?=__('Subscriptions')?></h1>
</div>

<div class="header_devider"></div>

<?=Alert::show()?>

<?=Form::errors()?>

<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">
    <tr>
        <th><?=__('Category')?></th>
        <th><?=__('Location')?></th>
        <th><?=__('Min Price')?></th>
        <th><?=__('Max Price')?></th>
        <th><?=__('Created')?></th>
        <th>
            <a
                href="<?=Route::url('default', array('controller'=>'subscribe','action'=>'unsubscribe', 'id'=>Auth::instance()->get_user()->id_user))?>" 
                class="pag_right ui_base_btn ui_btn_small " 
                title="<?=__('Unsubscribe to all?')?>" 
                data-toggle="confirmation" 
                data-placement="left" 
                data-href="<?=Route::url('default', array('controller'=>'subscribe','action'=>'unsubscribe', 'id'=>Auth::instance()->get_user()->id_user))?>" 
                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                data-btnCancelLabel="<?=__('No way!')?>" 
                data-role="button" 
                data-inline="true" 
                target="_blank" 
                data-transition="slide" 
                data-icon="delete" 
                data-mini="true" 
            >
                <?=__('Delete All')?>
            </a>
        </th>
    </tr>
    <tbody>
        <?foreach($list as $l):?>
            <tr>
                <td>
                    <!-- category -->
                    <p><?=$l['category']?></p>
                </td>
                        
                <td>
                    <!-- locations -->
                    <p><?=$l['location']?></p>
                </td>
                        
                <td>
                    <!-- Min price -->
                    <p><?=$l['min_price']?></p>
                </td>
                <td>
                    <!-- Max Price -->
                    <p><?=$l['max_price']?></p>
                </td>
                <td>
                    <!-- Created -->
                    <p><?=substr($l['created'], 0, 11)?></p>
                </td>
                <td>
                    <!-- unsubscribe one entry button -->
                    <a
                        href="<?=Route::url('oc-panel', array('controller'=>'profile','action'=>'unsubscribe','id'=>$l['id']))?>" 
                        class="pag_right ui_base_btn ui_btn_small" 
                        title="<?=__('Unsubscribe?')?>" 
                        data-toggle="confirmation" 
                        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                        data-btnCancelLabel="<?=__('No way!')?>"
                        data-role="button" 
                        data-inline="true" 
                        target="_blank" 
                        data-transition="slide" 
                        data-icon="delete" 
                        data-mini="true" 
                    >
                        <?=__('Delete')?>
                    </a>
                </td>
            </tr>
        <?endforeach?>
    </tbody>
</table>
