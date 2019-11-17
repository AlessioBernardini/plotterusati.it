<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?= __('Sales')?></h1>
</div>

<div class="header_devider"></div>

<?=Alert::show()?>

<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">

    <thead>
        <tr>
            <th>#</th>
            <th><?=__('Amount') ?></th>
            <th><?=__('Buyer') ?></th>
            <th><?=__('Date') ?></th>
            <th><?=__('Ad') ?></th>
        </tr>
    </thead>
    <tbody>
        <?foreach($orders as $order):?>
            <tr id="tr<?=$order->pk()?>">
                    
                 <td><?=$order->pk()?></td>
        
                <td><?=i18n::format_currency($order->amount, $order->currency)?></td>
                
                <td><a href="<?=Route::url('profile', array('seoname'=> $order->user->seoname)) ?>" ><?=$order->user->name?></a></td>

                <td><?=$order->pay_date?></td>

                <td>
                    <a href="<?=Route::url('ad', array('category'=> $order->ad->category->seoname,'seotitle'=>$order->ad->seotitle)) ?>" title="<?=HTML::chars($order->ad->title)?>">
                        <?=Text::limit_chars($order->ad->title, 30, NULL, TRUE)?>
                    </a>
                    <?if (isset($order->ad->cf_file_download)):?>
                        <a class="btn btn-sm btn-success" href="<?=$order->ad->cf_file_download?>">
                            <?=_e('Download')?>
                        </a>
                    <?endif?>

                    <?if ($order->paymethod == 'escrow'):?>
                        <? $transaction = json_decode($order->txn_id) ?>

                        <?if (isset($transaction->status) AND ! $transaction->status->shipped):?>
                            <a href="<?= Route::url('oc-panel', ['controller'=>'escrow', 'action'=>'ship', 'id' => $order->id_order]) ?>">
                                <i class="glyphicon glyphicon-check"></i> <?=_e('Mark as shipped')?>
                            </a>
                        <?endif?>
                    <?endif?>
                </td>

            </tr>
        <?endforeach?>
    </tbody>
</table>

<?=$pagination?>

