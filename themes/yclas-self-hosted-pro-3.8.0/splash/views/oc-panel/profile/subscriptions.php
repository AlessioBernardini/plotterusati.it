<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h1"><?=_e('Subscriptions')?></h1>
            </div>
            <?if (Theme::get('breadcrumb')==1):?>
                <div class="col-sm-4 breadcrumbs">
                    <?=Breadcrumbs::render('breadcrumbs')?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<?=Alert::show()?>

<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?=Alert::show()?>
                <?=Form::errors()?>
                <div>
                    <div class="panel panel-default">
                        <table class="table table-bordered">
                            <tr>
                                <th><?=_e('Category')?></th>
                                <th><?=_e('Location')?></th>
                                <th><?=_e('Min Price')?></th>
                                <th><?=_e('Max Price')?></th>
                                <th><?=_e('Created')?></th>
                                <th>
                                    <a
                                        href="<?=Route::url('default', array('controller'=>'subscribe','action'=>'unsubscribe', 'id'=>Auth::instance()->get_user()->id_user))?>" 
                                        class="btn btn-danger" 
                                        title="<?=__('Unsubscribe to all?')?>" 
                                        data-toggle="confirmation" 
                                        data-placement="left" 
                                        data-href="<?=Route::url('default', array('controller'=>'subscribe','action'=>'unsubscribe', 'id'=>Auth::instance()->get_user()->id_user))?>" 
                                        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                        data-btnCancelLabel="<?=__('No way!')?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </th>
                            </tr>
                            <?foreach($list as $l):?>
                                <tbody>
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
                                                class="btn btn-warning" 
                                                title="<?=__('Unsubscribe?')?>" 
                                                data-toggle="confirmation" 
                                                data-btnOkLabel="<?=__('Yes, definitely!')?>" 
                                                data-btnCancelLabel="<?=__('No way!')?>">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?endforeach?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
