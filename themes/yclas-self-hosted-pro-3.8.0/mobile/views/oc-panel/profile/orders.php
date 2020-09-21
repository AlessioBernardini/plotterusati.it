<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?= __('Orders')?></h1>
</div>

<div class="header_devider"></div>

<?=Alert::show()?>

<table data-role="table" data-mode="columntoggle" class="table table-hover ui-responsive" id="myTable">

    <thead>
        <tr>
            <th>#</th>
            <th><?=__('Status') ?></th>
            <th><?=__('Product') ?></th>
            <th><?=__('Amount') ?></th>
            <th><?=__('Ad') ?></th>
            <th><?=__('Date') ?></th>
            <th><?=__('Date Paid') ?></th>
        </tr>
    </thead>
    <tbody>
        <?foreach($orders as $order):?>
            <tr id="tr<?=$order->pk()?>">
                    
                <td><?=$order->pk()?></td>
                    
                <td>
                    <?if ($order->status == Model_Order::STATUS_CREATED AND $order->paymethod != 'escrow'):?>
                        <a href="<?=Route::url('default', array('controller'=> 'ad','action'=>'checkout' , 'id' => $order->id_order))?>">
                            <i class="glyphicon glyphicon-shopping-cart"></i> <?=__('Pay')?>   
                        </a>
                    <?elseif ($order->status == Model_Order::STATUS_CREATED AND $order->paymethod == 'escrow'):?>
                        <? $transaction = json_decode($order->txn_id) ?>
                        <a href="<?= $transaction->landing_page ?>">
                            <i class="glyphicon glyphicon-shopping-cart"></i> <?=_e('Pay')?>   
                        </a>
                        <a href="<?= Route::url('default', ['controller'=>'escrow', 'action'=>'paid', 'id' => $order->id_order]) ?>">
                            <i class="glyphicon glyphicon-check"></i> <?=_e('Mark as paid')?>   
                        </a>
                    <?else:?>
                        <a href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'order', 'id' => $order->id_order))?>">
                            <i class="glyphicon glyphicon-search"></i> <?=__('View')?>   
                        </a>
                    <?endif?>

                    <?if ($order->paymethod == 'escrow'):?>
                        <? $transaction = json_decode($order->txn_id) ?>

                        <?if (isset($transaction->status) AND $transaction->status->shipped AND ! $transaction->status->received):?>
                            <a href="<?= Route::url('oc-panel', ['controller'=>'escrow', 'action'=>'receive', 'id' => $order->id_order]) ?>">
                                <i class="glyphicon glyphicon-check"></i> <?=_e('Mark as received')?>
                            </a>
                        <?endif?>

                        <?if (isset($transaction->status) AND $transaction->status->received AND ! $transaction->status->accepted):?>
                            <a href="<?= Route::url('oc-panel', ['controller'=>'escrow', 'action'=>'accept', 'id' => $order->id_order]) ?>">
                                <i class="glyphicon glyphicon-check"></i> <?=_e('Mark as accepted')?>
                            </a>
                        <?endif?>
                    <?endif?>
                </td>
                    
                <td><?=Model_Order::product_desc($order->id_product)?></td>
                    
                <td><?=i18n::format_currency($order->amount, $order->currency)?></td>
                    
                <td><a href="<?=Route::url('ad', array('category'=> $order->ad->category->seoname,'seotitle'=>$order->ad->seotitle)) ?>" title="<?=HTML::chars($order->ad->title)?>">
                            <?=Text::limit_chars($order->ad->title, 30, NULL, TRUE)?></a></td>
                    
                <td><?=$order->created?></td>
                    
                <td><?=$order->pay_date?></td>
                    
            </tr>
        <?endforeach?>
    </tbody>
</table>

<?=$pagination?>

