<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Alert::show()?>

<?if( Core::config('payment.stripe_connect')==1):?>
    <div class="page-header">
        <h3 class="panel-title"><?=__('Stripe Connect')?></h3>
        <p><?=sprintf(__('Sell your items with credit card using stripe. Our platform charges %s percentage, per transaction.'),Core::config('payment.stripe_appfee'))?></p>
    </div>
    <div class="header_devider"></div>

    <?if ($user->stripe_user_id!=''):?>
        Stripe connected <?=$user->stripe_user_id?>
        <br>
        Reconnect:
        <br>
    <?endif?>
    <a class="btn btn-primary" href="<?=Route::url('default', array('controller'=>'stripe','action'=>'connect','id'=>'now'))?>">
        <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Connect with Stripe
    </a>
<?endif?>

<?if( Core::config('payment.escrow_pay')==1):?>
    <div class="panel panel-default">
        <div class="panel-heading" id="page-edit-profile">
            <h3 class="panel-title"><?=_e('Escrow Pay')?></h3>
            <p><?=__('Buy and sell items with Escrow')?></p>
        </div>
        <div class="panel-body">
            <?if ($user->escrow_api_key!=''):?>
                <div class="alert alert-success"><strong><?= __('Escrow connected.') ?></strong></div>
            <?endif?>

            <div class="row">
                <div class="col-md-8">
                    <?= FORM::open(Route::url('oc-panel',array('controller'=>'escrow','action'=>'update_api_key')), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>

                    <div class="form-group">
                        <?= FORM::label('escrow_email', _e('Escrow email'), array('class'=>'col-xs-4 control-label', 'for'=>'escrow_email'))?>
                        <div class="col-sm-8">
                            <?= FORM::input('escrow_email', $user->escrow_email, array('class'=>'form-control', 'id'=>'escrow_email', 'type'=>'escrow_email' ,'required','placeholder'=>__('Email')))?>
                            <p class="help-block small"><a href="https://www.escrow.com/signup-page" target="_blank"><?= __('Create an Escrow account.') ?></a></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= FORM::label('escrow_api_key', _e('API Key'), array('class'=>'col-xs-4 control-label', 'for'=>'escrow_api_key'))?>
                        <div class="col-sm-8">
                            <?= FORM::input('escrow_api_key', $user->escrow_api_key, array('class'=>'form-control', 'id'=>'escrow_api_key', 'required', 'placeholder'=>__('API Key')))?>
                            <p class="help-block small"><a href="https://www.escrow.com/integrations/portal/api" target="_blank"><?= __('Create an API key.') ?></a></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-primary">
                                <?if ($user->escrow_api_key == ''):?>
                                    <?=_e('Connect')?>
                                <?else:?>
                                    <?=_e('Reconnect')?>
                                <?endif?>
                            </button>
                        </div>
                    </div>
                    <?= FORM::close()?>
                </div>
            </div>
        </div>
    </div>
<?endif?>

<div class="page-header">
    <h1><?= __('Edit Profile')?></h1>
</div>

<div class="header_devider"></div>

<?=FORM::open(Route::url('oc-panel',array('controller'=>'profile','action'=>'edit')), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
    <div class="form-group">
        <?= FORM::label('name', __('Name'), array('class'=>'control-label', 'for'=>'name'))?>
        <?= FORM::input('name', $user->name, array('class'=>'input-xlarge', 'id'=>'name', 'required', 'placeholder'=>__('Name')))?>
        <?= FORM::label('email', __('Email'), array('class'=>'control-label', 'for'=>'email'))?>
        <?= FORM::input('email', $user->email, array('class'=>'input-xlarge', 'id'=>'email', 'type'=>'email' ,'required','placeholder'=>__('Email')))?>
        <?$locations = Model_Location::get_as_array(); $order_locations = Model_Location::get_multidimensional(); ?>
        <?if(core::count($locations) > 1):?>
            <?if(core::config('advertisement.location')):?>
            <div class="control-group">
                <?= FORM::label('location', __('Location'), array('class'=>'control-label', 'for'=>'location' , 'multiple'))?>
                <div class="controls">
                    <select name="location" id="location" class="input-xlarge">
                    <? if ($selected_location->loaded()) : ?>
                        <option value="<?= $selected_location->id_location ?>" selected><?= $selected_location->translate_name() ?></option>
                    <? else : ?>
                        <option></option>
                    <?endif?>
                    <?function lolo($item, $key,$locs){?>
                    <option value="<?=$key?>"><?=$locs[$key]['name']?></option>
                        <?if (core::count($item)>0):?>
                        <optgroup label="<?=$locs[$key]['name']?>">
                            <? if (is_array($item)) array_walk($item, 'lolo', $locs);?>
                        <?endif?>
                    <?}array_walk($order_locations, 'lolo',$locations);?>
                    </select>
                </div>
            </div>
            <?endif?>
        <?endif?>
        <?= FORM::label('description', __('Description'), array('class'=>'control-label', 'for'=>'description'))?>
        <?= FORM::textarea('description', $user->description, array('class'=>'form-control', 'id'=>'description','placeholder'=>__('Description')))?>

        <?foreach($custom_fields as $name=>$field):?>
            <?if($name!='whatsapp' AND ($name!='verifiedbadge' OR Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator())):?>
                <?$cf_name = 'cf_'.$name?>
                <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                    $select = array(''=>'');
                    foreach ($field['values'] as $select_name) {
                        $select[$select_name] = $select_name;
                    }
                    } else $select = $field['values']?>
                <?= FORM::label('cf_'.$name, $field['label'], array('class'=>'control-label', 'for'=>'cf_'.$name))?>
                <?=Form::cf_form_field('cf_'.$name, array(
                    'display'   => $field['type'],
                    'label'     => $field['label'],
                    'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                    'default'   => $user->$cf_name,
                    'options'   => (!is_array($field['values']))? $field['values'] : $select,
                    'required'  => $field['required'],
                ))?>
            <?elseif($name=='whatsapp'):?>
                <label class="control-label" for="cf_whatsapp"><?=_e('Whatsapp Number')?></label>
                <div class="">
                    <input id="cf_whatsapp" name="cf_whatsapp" title="" class="form-control cf_string_fields data-custom  " placeholder="whatsapp" data-placeholder="whatsapp" data-original-title="whatsapp" type="text"
                    data-country-code="<?= (core::config('general.country') !== NULL and isset(I18n::country_codes()[core::config('general.country')])) ? I18n::country_codes()[core::config('general.country')] : '' ?>"
                    value="<?=$user->cf_whatsapp?>"
                    >
                </div>
            <?endif?>
        <?endforeach?>

        <label>
            <input type="checkbox" name="subscriber" value="1" <?=($user->subscriber)?'checked':NULL?> > <?=__('Subscribed to emails')?>
        </label>

        <button type="submit" class="btn btn-primary"><?=__('Update')?></button>
<?= FORM::close()?>

<div class="page-header">
    <h1><?= __('Change password')?></h1>
</div>

<div class="header_devider"></div>

<form class="form-horizontal"  method="post" action="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'changepass'))?>">
    <?=Form::errors()?>
    <label class="control-label"><?=__('New password')?></label>
    <input class="form-control" type="password" name="password1" placeholder="<?=__('Password')?>">
    <label class="control-label"><?=__('Repeat password')?></label>
    <input class="form-control" type="password" name="password2" placeholder="<?=__('Password')?>">
    <p class="help-block"><?=__('Type your password twice to change')?></p>
    <button type="submit" class="btn btn-primary"><?=__('Update')?></button>
</form>

<div class="page-header">
    <h1><?= __('Profile picture')?></h1>
</div>

<div class="header_devider"></div>

<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'image'))?>">
    <?=Form::errors()?>

<div class="form-group images"
    data-max-image-size="<?=core::config('image.max_image_size')?>"
    data-image-width="<?=core::config('image.width')?>"
    data-image-height="<?=core::config('image.height') ? core::config('image.height') : 0?>"
    data-image-quality="<?=core::config('image.quality')?>"
    data-swaltext="<?=sprintf(__('Is not of valid size. Size is limited to %s MB per image'),core::config('image.max_image_size'))?>">
    <?$images = $user->get_profile_images()?>
    <?if($images):?>
        <div class="row">
            <?foreach ($images as $key => $image):?>
                <div id="img<?=$key?>" class="col-md-4 edit-image">
                    <a><img src="<?=$image?>" class="img-rounded thumbnail img-responsive col-xs-8 col-xs-offset-2"></a>
                    <?if ($key > 0) :?>
                        <button class="ui_base_btn_shape ui_base_btn ui_btn_small"
                                data-title="<?=__('Are you sure you want to delete?')?>"
                                data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                data-btnCancelLabel="<?=__('No way!')?>"
                                type="submit"
                                name="img_delete"
                                value="<?=$key?>"
                                href="<?=Route::url('oc-panel', array('controller'=>'profile','action'=>'image'))?>">
                                <?=_e('Delete')?>
                        </button>
                    <?endif?>
                    <?if ($key > 1) :?>
                        <button class="btn btn-info img-primary"
                            type="submit"
                            name="primary_image"
                            value="<?=$key?>"
                            href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'image'))?>"
                            action="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'image'))?>"
                        >
                                <?=_e('Primary image')?>
                        </button>
                    <?endif?>
                </div>
            <?endforeach?>
        </div>
    <?endif?>
</div>
<?if (core::config('advertisement.num_images') > core::count($images)):?>
    <hr>
    <div class="">
        <h5><?=_e('Add image')?></h5>
        <div>
            <?for ($i = 0; $i < (core::config('advertisement.num_images') - core::count($images)); $i++):?>
                <div class="fileinput fileinput-new <?=($i >= 1) ? 'hidden' : NULL?>" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="">
                            <span class="fileinput-new"><?=_e('Select')?></span>
                            <span class="fileinput-exists"><?=_e('Edit')?></span>
                            <input type="file" name="<?='image'.$i?>" id="<?='fileInput'.$i?>" accept="<?='image/'.str_replace(',', ', image/', rtrim(core::config('image.allowed_formats'),','))?>">
                        </span>
                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><?=_e('Delete')?></a>
                    </div>
                </div>
            <?endfor?>
        </div>
    </div>
<?endif?>

    <button type="submit" class="btn btn-primary"><?=__('Update')?></button>
</form>

<?if( Core::config('general.subscriptions')==1):?>
    <div class="panel panel-default">
        <div class="panel-heading" id="page-edit-profile">
            <h3 class="panel-title"><?=_e('Subscription')?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <?if ($user->subscription()->loaded()):?>
                        <p class="color-gray">
                            <?if($user->subscription()->amount_ads_left > -1 ):?>
                                <?=sprintf(__('You are subscribed to the plan %s until %s with %u ads left'),$user->subscription()->plan->name,$user->subscription()->expire_date,$user->subscription()->amount_ads_left)?>
                            <?else:?>
                                <?=sprintf(__('You are subscribed to the plan %s until %s with unlimited ads'),$user->subscription()->plan->name,$user->subscription()->expire_date)?>
                            <?endif?>
                        </p>
                        <?if ($user->stripe_agreement!=NULL):?>
                            <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'cancelsubscription'))?>"
                                      class="btn btn-danger"
                                      onclick="return confirm('<?=__('Cancel Subscription?')?>');"
                                      title="<?=__('Cancel Subscription')?>">
                                      <?=_e('Cancel Subscription')?>
                            </a>
                        <?endif?>
                    <?else:?>
                        <a class="btn btn-primary" href="<?=Route::url('pricing')?>">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?=_e('Choose a Plan')?>
                        </a>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
<?endif?>
