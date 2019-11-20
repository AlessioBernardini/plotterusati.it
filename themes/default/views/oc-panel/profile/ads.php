<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Alert::show()?>
<div id="page-my-dvertisements" class="page-header">
    <h1><?=_e('My Advertisements')?></h1>
</div>

<div class="panel panel-default">
    <div id="mobile-desc"><small>Scorri verso destra per visualizzare tutti i dati</small></div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th><?=_e('Immagine')?></th>
                <th><?=_e('Name')?></th>
                <th><?=_e('Category')?></th>
                <th><?=_e('Location')?></th>
                <th><?=_e('Status')?></th>
                <th><?=_e('Date')?></th>
                <th><?=_e('Price')?></th>
                <?if( core::config('payment.to_featured')):?>
                <th><?=_e('Featured')?></th>
                <?endif?>
                <th><?=_e('Actions')?></th>
            </tr>
            <? $i = 0; foreach($ads as $ad):?>
            <tbody>
                <tr>

                    <td><?=HTML::picture($ad->get_first_image('image'), ['w' => 70, 'h' => 70], ['1200px' => ['w' => '70', 'h' => '70'], '992px' => ['w' => '70', 'h' => '70'], '768px' => ['w' => '70', 'h' => '70'], '480px' => ['w' => '50', 'h' => '50'], '320px' => ['w' => '50', 'h' => '50']], ['class' => 'img-responsive', 'alt' => HTML::chars($ad->title)])?></td>

                    <? foreach($category as $cat){ if ($cat->id_category == $ad->id_category) $cat_name = $cat->seoname; }?>
                    <?/*<td><a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>"><?= $ad->title; ?></a></td>*/?>
                    <td>
                        <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>">
                            <?=Text::limit_chars(Text::removebbcode($ad->title), 20, NULL, TRUE)?>
                        </a>
                    </td>

                    <? foreach($category as $cat):?>
                        <? if ($cat->id_category == $ad->id_category): ?>
                            <td><?= $cat->name ?>
                        <?endif?>
                    <?endforeach?>

                    <?$locat_name = NULL;?>
                    <?foreach($location as $loc):?>
                        <? if ($loc->id_location == $ad->id_location):
                            $locat_name=$loc->name;?>
                            <td><?=$locat_name?></td>
                        <?endif?>
                    <?endforeach?>
                    <?if($locat_name == NULL):?>
                        <td>n/a</td>
                    <?endif?>


                    <td>
                    <?if($ad->status == Model_Ad::STATUS_NOPUBLISHED):?>
                        <?=_e('Not published')?>
                    <? elseif($ad->status == Model_Ad::STATUS_PUBLISHED):?>
                        <?=_e('Published')?>
                    <? elseif($ad->status == Model_Ad::STATUS_SPAM):?>
                        <?=_e('Spam')?>
                    <? elseif($ad->status == Model_Ad::STATUS_UNAVAILABLE):?>
                        <?=_e('Unavailable')?>
                    <? elseif($ad->status == Model_Ad::STATUS_UNCONFIRMED):?>
                        <?=_e('Unconfirmed')?>
                    <? elseif($ad->status == Model_Ad::STATUS_SOLD):?>
                        <?=_e('Sold')?>
                    <?endif?>

                    <?if( ($order = $ad->get_order())!==FALSE ):?>
                        <?if ($order->status==Model_Order::STATUS_CREATED AND $ad->status != Model_Ad::STATUS_PUBLISHED):?>
                            <a class="btn btn-warning" href="<?=Route::url('default', array('controller'=> 'ad','action'=>'checkout' , 'id' => $order->id_order))?>">
                                <i class="glyphicon glyphicon-shopping-cart"></i> <?=_e('Pay')?>  <?=i18n::format_currency($order->amount,$order->currency)?> 
                            </a>
                        <?elseif ($order->status==Model_Order::STATUS_PAID):?>
                            (<?=_e('Paid')?>)
                        <?endif?>
                    <?endif?>

                    </td>

                    <td><?= Date::format($ad->published, core::config('general.date_format'))?></td>

                    <td>
                        <?if ($ad->price!=0){?>
                            <div class="price pull-left">
                                <?=i18n::money_format( $ad->price, $ad->currency())?>
                            </div>
                        <?}?>
                        <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                            <div class="price pull-left">
                               <?=_e('Free');?>
                            </div>
                        <?}?>
                    </td>

                    <?if( core::config('payment.to_featured')):?>
                    <td>
                        <?if($ad->featured == NULL):?>
                            <a class="btn btn-default"
                                href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_featured','id'=>$ad->id_ad))?>"
                                onclick="return confirm('<?=__('Make featured?')?>');"
                                rel="tooltip" title="<?=__('Featured')?>" data-id="tr1" data-text="<?=__('Are you sure you want to make it featured?')?>">
                                <i class="glyphicon glyphicon-bookmark "></i> <?=_e('Featured')?>
                            </a>
                        <?else:?>
                            <?= Date::format($ad->featured, core::config('general.date_format'))?>
                        <?endif?>
                    </td>
                    <?endif?>

                    <td>
                        <?if(core::config('advertisement.count_visits')):?>
                            <a class="btn btn-primary"
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'stats','id'=>$ad->id_ad))?>"
                                rel="tooltip" title="<?=__('Stats')?>">
                                <i class="glyphicon glyphicon-align-left"></i>
                            </a>
                        <?endif?>
                        <a class="btn btn-primary"
                            href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"
                            rel="tooltip" title="<?=__('Update')?>">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                        <?if($ad->status != Model_Ad::STATUS_SOLD AND $ad->status != Model_Ad::STATUS_UNCONFIRMED):?>
                            <?/*
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#soldModal<?=$ad->id_ad?>">
                                <i class="glyphicon glyphicon-usd"></i>
                            </button>*/?>
                            <div class="modal fade" id="soldModal<?=$ad->id_ad?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <?=FORM::open(Route::url('oc-panel', array('controller'=>'myads','action'=>'sold','id'=>$ad->id_ad)), array('enctype'=>'multipart/form-data'))?>
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title"><?=__('Mark as Sold')?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="amount"><?=__('Amount')?></label>
                                                    <input name="amount" type="text" class="form-control" id="amount" placeholder="<?=i18n::format_currency(0,core::config('payment.paypal_currency'))?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><?=__('Submit')?></button>
                                            </div>
                                        <?=FORM::close()?>
                                    </div>
                                </div>
                            </div>
                        <?endif?>
                        <? if (in_array($ad->status, [Model_Ad::STATUS_UNAVAILABLE, Model_Ad::STATUS_SOLD])
                                    AND !in_array(core::config('general.moderation'), Model_Ad::$moderation_status)
                            ):?>
                            <?if ( ($order = $ad->get_order()) === FALSE OR ($order !== FALSE AND $order->status == Model_Order::STATUS_PAID) ):?>
                                <a
                                    href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'activate','id'=>$ad->id_ad))?>"
                                    class="btn btn-success"
                                    title="<?=__('Activate?')?>"
                                    data-text="<?=__('Activate?')?>"
                                    data-toggle="confirmation"
                                    data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                    data-btnCancelLabel="<?=__('No way!')?>">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </a>
                            <?endif?>
                        <?elseif($ad->status != Model_Ad::STATUS_UNAVAILABLE AND $ad->status != Model_Ad::STATUS_UNCONFIRMED):?>
                            <a
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                class="btn btn-warning"
                                title="<?=__('Deactivate?')?>"
                                data-text="<?=__('Deactivate?')?>"
                                data-toggle="confirmation"
                                data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                data-btnCancelLabel="<?=__('No way!')?>">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                        <?endif?>
                        <?if( core::config('payment.to_top') ):?>
                            <a
                                href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_top','id'=>$ad->id_ad))?>"
                                class="btn btn-info"
                                title="<?=__('Refresh listing, go to top?')?>"
                                data-text="<?=__('Refresh listing, go to top?')?>"
                                data-toggle="confirmation"
                                data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                data-btnCancelLabel="<?=__('No way!')?>">
                                <i class="glyphicon glyphicon-circle-arrow-up"></i>
                            </a>
                        <?endif?>
                        <?if(core::config('advertisement.delete_ad')==TRUE):?>
                            <a
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'delete','id'=>$ad->id_ad))?>"
                                class="btn btn-danger"
                                title="<?=__('Delete?')?>"
                                data-text="<?=__('Delete?')?>"
                                data-toggle="confirmation"
                                data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                data-btnCancelLabel="<?=__('No way!')?>">
                                <i class="glyphicon glyphicon-minus"></i>
                            </a>
                        <?endif?>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
</div>
<div class="text-center"><?=$pagination?></div>
