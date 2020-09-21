<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="main">
    <div class="container no-gutter">
        <?=Alert::show()?>
        <div class="row">
            <div class="col-xs-12">
                 <?=(Theme::get('breadcrumb')==1)?Breadcrumbs::render('breadcrumbs'):''?>
            </div>
            <?foreach ( Widgets::render('header') as $widget):?>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?=$widget?>
                </div>
            <?endforeach?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?if(core::count($plans) > 0):?>
                    <?if($subscription!==FALSE):?>
                        <p>
                            <?if($subscription->amount_ads_left > -1 ):?>
                                <?=sprintf(__('You are subscribed to the plan %s until %s with %u ads left'),$subscription->plan->name,$subscription->expire_date,$subscription->amount_ads_left)?>
                            <?else:?>
                                <?=sprintf(__('You are subscribed to the plan %s until %s with unlimited ads'),$subscription->plan->name,$subscription->expire_date)?>
                            <?endif?>
                        </p>
                    <?endif?>
                    <div class="row pricing">
                        <?foreach ($plans as $plan):?>
                            <?
                                $current_plan = FALSE;
                                if ($subscription!==FALSE AND $subscription->plan->id_plan==$plan->id_plan)
                                    $current_plan = TRUE;
                            ?>
                            <div class="col-md-4">
                                <div class="well">
                                    <h3><b><?=$plan->name?></b></h3>
                                    <hr>
                                    <p><?=Text::bb2html($plan->description,TRUE)?></p>
                                    <hr>
                                    <p>
                                        <?if ($plan->days == 0 AND $plan->price>0):?>
                                            <?=_e('Pay once')?>
                                        <?elseif ($plan->days == 365):?>
                                            <?=_e('Yearly')?>
                                        <?elseif ($plan->days == 180):?>
                                            <?=_e('6 months')?>
                                        <?elseif ($plan->days == 90):?>
                                            <?=_e('Quarterly')?>
                                        <?elseif ($plan->days == 30):?>
                                            <?=_e('Monthly')?>
                                        <?else:?>
                                            <?=sprintf(__('%u days'), $plan->days)?>
                                        <?endif?>
                                    </p>
                                    <hr>
                                    <p>
                                        <?if ($plan->amount_ads > -1):?>
                                            <?=sprintf(__('%u Ads'), $plan->amount_ads)?>
                                        <?else:?>
                                            <?=_('Unlimited Ads')?>
                                        <?endif?>
                                    </p>
                                    <?if(Core::config('payment.stripe_connect')):?>
                                    <hr>
                                    <p><b><?=sprintf(__('%s%% market place fee'), round($plan->marketplace_fee,1))?></b></p>
                                    <?endif?>

                                    <hr>
                                    <?if($current_plan==TRUE):?>
                                        <button type="button" disabled=""
                                            class="btn btn-primary btn-block">
                                            <?=_e('Current Plan')?>
                                        </button>
                                    <?else:?>
                                        <a href="<?=Route::url('default', array('controller'=>'plan','action'=>'buy','id'=>$plan->seoname))?>"
                                            class="btn btn-success btn-block">
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?=_e('Sign Up')?>
                                            <b><?=i18n::format_currency($plan->price,core::config('payment.paypal_currency'))?></b>
                                        </a>
                                    <?endif?>
                                </div>
                            </div>
                        <?endforeach?>
                    </div>
                <?endif?>
            </div>
        </div>
    </div>
</section>
