<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?= __('My Advertisements')?></h1>
</div>

<div class="header_devider"></div>

<table data-role="table" data-mode="columntoggle" class="table table-hover ui-responsive" id="myTable">
    <thead>
        <tr>
            <th data-priority="1"><?=__('Name')?></th>
            <th data-priority="2"><?=__('Category')?></th>
            <th data-priority="3"><?=__('Location')?></th>
            <th data-priority="4"><?=__('Status')?></th>
            <th data-priority="5"><?=__('Date')?></th>
            <?if( core::config('payment.to_featured')):?>
                <th data-priority="6"><?=__('Featured')?></th>
            <?endif?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? $i = 0; foreach($ads as $ad):?>
            <tr>
                <? foreach($category as $cat){ if ($cat->id_category == $ad->id_category) $cat_name = $cat->seoname; }?>
                <td>
                    <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>"><?= $ad->title; ?></a>
                </td>
                    
                <?foreach($category as $cat):?>
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
                        <?=__('Not published')?>
                    <? elseif($ad->status == Model_Ad::STATUS_PUBLISHED):?>
                        <?=__('Published')?>
                    <? elseif($ad->status == Model_Ad::STATUS_SPAM):?>
                        <?=__('Spam')?>
                    <? elseif($ad->status == Model_Ad::STATUS_UNAVAILABLE):?>
                        <?=__('Unavailable')?>
                    <?endif?>
                    
                    <?if( ($order = $ad->get_order())!==FALSE ):?>
                        <?if ($order->status==Model_Order::STATUS_CREATED AND $ad->status != Model_Ad::STATUS_PUBLISHED):?>
                            <a class="btn btn-warning" href="<?=Route::url('default', array('controller'=> 'ad','action'=>'checkout' , 'id' => $order->id_order))?>">
                                <i class="glyphicon glyphicon-shopping-cart"></i> <?=__('Pay')?>  <?=i18n::format_currency($order->amount,$order->currency)?> 
                            </a>
                        <?elseif ($order->status==Model_Order::STATUS_PAID):?>
                            (<?=__('Paid')?>)
                        <?endif?>
                    <?endif?>
                </td>
                    
                <td><?= Date::format($ad->published, core::config('general.date_format'))?></td>
                    
                <?if( core::config('payment.to_featured')):?>
                    <td>
                        <?if ($ad->featured == NULL):?>
                            <a class="btn btn-default" 
                                href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_featured','id'=>$ad->id_ad))?>" 
                                onclick="return confirm('<?=__('Make featured?')?>');"
                                rel="tooltip" title="<?=__('Featured')?>" data-id="tr1" data-text="<?=__('Are you sure you want to make it featured?')?>"
                            >
                                <i class="glyphicon glyphicon-bookmark "></i> <?=__('Featured')?>
                            </a>
                        <?else:?>
                            <?= Date::format($ad->featured, core::config('general.date_format'))?>
                        <?endif?>
                        <?if ($ad->featured != NULL AND $user->is_admin()):?>
                            <a class="btn btn-info" 
                                href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'featured','id'=>$ad->id_ad))?>" 
                                onclick="return confirm('<?=__('Deactivate featured?')?>');"
                                rel="tooltip" title="<?=__('Deactivate featured')?>" data-id="tr1" data-text="<?=__('Are you sure you want to deactivate featured advertisement?')?>"
                            >
                                <i class="glyphicon glyphicon-bookmark"></i>
                            </a>
                        <?endif?>
                    </td>
                <?endif?>
                    
                <td>
                    <div data-role="controlgroup" data-type="horizontal">
                        <?if(core::config('advertisement.count_visits')):?>
                            <a class="btn btn-primary" data-role="button" data-mini="true" 
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'stats','id'=>$ad->id_ad))?>" 
                                rel="tooltip" title="<?=__('Stats')?>">
                                <?=__('Stats')?>
                            </a>
                        <?endif?>
                        <a class="btn btn-primary" data-role="button" data-mini="true" 
                            href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>" 
                            rel="tooltip" title="<?=__('Update')?>"
                        >
                            <?=__('Update')?>
                        </a>
                        <? if( $ad->status == Model_Ad::STATUS_UNAVAILABLE AND !in_array(core::config('general.moderation'), Model_Ad::$moderation_status)):?>
                            <a
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'activate','id'=>$ad->id_ad))?>" 
                                class="btn btn-success" 
                                title="<?=__('Activate?')?>" 
                                data-role="button"
                                data-mini="true" 
                                data-toggle="confirmation" 
                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                data-btnCancelLabel="<?=__('No way!')?>">
                                <?=__('Activate?')?>
                            </a>
                        <?elseif($ad->status != Model_Ad::STATUS_UNAVAILABLE):?>
                            <a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>" 
                                class="btn btn-primary" 
                                title="<?=__('Deactivate?')?>" 
                                data-role="button"
                                data-mini="true" 
                                data-toggle="confirmation" 
                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                data-btnCancelLabel="<?=__('No way!')?>"
                            >
                                <?=__('Deactivate?')?>
                            </a>
                        <?endif?>
                        <?if( core::config('payment.to_top') ):?>
                            <a href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_top','id'=>$ad->id_ad))?>" 
                                class="btn btn-info" 
                                title="<?=__('Refresh listing, go to top?')?>"
                                data-role="button"
                                data-mini="true" 
                                data-toggle="confirmation" 
                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                data-btnCancelLabel="<?=__('No way!')?>"
                            >
                                <?=__('Refresh listing, go to top?')?>
                            </a>
                        <?endif?>
                        <?if(core::config('advertisement.delete_ad')==TRUE):?>
                            <a
                                href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'delete','id'=>$ad->id_ad))?>"
                                class="btn btn-danger"
                                title="<?=__('Delete?')?>"
                                data-role="button"
                                data-mini="true" 
                                data-toggle="confirmation" 
                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                data-btnCancelLabel="<?=__('No way!')?>"
                            >
                                <?=__('Delete?')?>
                            </a>
                        <?endif?>
                    </div>
                </td>
            </tr>
        <?endforeach?>
    </tbody>
</table>

<?=$pagination?>
