<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h1"><?=_e('Checkout')?></h1>
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
        <div class="container no-gutter">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
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
                                                <?=_e('Unlimited Ads')?>
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
    </div>
</section>
