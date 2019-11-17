<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pages/auth/social')?>
<form class="form-horizontal register"  method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>">
    <?=Form::errors()?>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=_e('Name')?></label>
        <div class="col-xs-10 col-md-6">
            <input class="form-control" type="text" name="name" value="<?=Request::current()->post('name')?>" placeholder="<?=__('Name')?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=_e('Email')?></label>
        <div class="col-xs-10 col-md-6">
            <input
                class="form-control"
                type="text"
                name="email"
                value="<?=Request::current()->post('email')?>"
                placeholder="<?=__('Email')?>"
                data-domain='<?=(core::config('general.email_domains') != '') ? json_encode(explode(',', core::config('general.email_domains'))) : ''?>'
                data-error="<?=__('Email must contain a valid email domain')?>"
            >
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=_e('New password')?></label>
        <div class="col-xs-10 col-md-6">
            <input id="<?=isset($modal_form) ? 'register_password_modal' : 'register_password'?>" class="form-control" type="password" name="password1" placeholder="<?=__('Password')?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=_e('Repeat password')?></label>
        <div class="col-xs-10 col-md-6">
            <input class="form-control" type="password" name="password2" placeholder="<?=__('Password')?>">
            <p class="help-block">
                <?=_e('Type your password twice')?>
            </p>
        </div>
    </div>
    <?if(core::config('advertisement.tos') != ''):?>
        <div class="form-group">
            <div class="col-xs-10 col-md-6 col-xs-offset-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" required name="tos" id="tos"/>
                        <a target="_blank" href="<?=Route::url('page', array('seotitle'=>core::config('advertisement.tos')))?>"> <?=_e('Terms of service')?></a>
                    </label>
                </div>
            </div>
        </div>
    <?endif?>
    <?foreach(Model_UserField::get_all() as $name=>$field):?>
        <?if($field['show_register'] AND $name!='verifiedbadge' AND $name!='whatsapp'):?>
            <div class="form-group">
                <?$cf_name = 'cf_'.$name?>
                <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                    $select = array(''=>'');
                    foreach ($field['values'] as $select_name) {
                        $select[$select_name] = $select_name;
                    }
                } else $select = $field['values']?>
                <?= FORM::label('cf_'.$name, $field['label'], array('class'=>'col-sm-2 control-label', 'for'=>'cf_'.$name))?>
                <div class="col-xs-10 col-md-6">
                    <?=Form::cf_form_field('cf_'.$name, array(
                    'display'   => $field['type'],
                    'label'     => $field['label'],
                    'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                    'default'   => $field['values'],
                    'options'   => (!is_array($field['values']))? $field['values'] : $select,
                    'required'  => $field['required'],
                    ))?>
                </div>
            </div>
        <?elseif($name=='whatsapp'):?>
            <div class="form-group" id="cf_new">
                <label class="col-xs-2 control-label" for="cf_whatsapp"><?=_e('Whatsapp Number')?></label>
                <div class="col-xs-10 col-md-6">
                    <input id="cf_whatsapp" name="cf_whatsapp" title="" class="form-control cf_string_fields data-custom  " placeholder="whatsapp" data-placeholder="whatsapp" data-original-title="whatsapp" type="text" 
                    data-country-code="<?=(!empty(core::config('general.country')))?I18n::country_codes()[core::config('general.country')]:''?>"
                    >
                </div>
            </div>
        <?endif?>
    <?endforeach?>

    <div class="form-group">
        <?if (Core::config('advertisement.captcha')):?>
            <?if (Core::config('general.recaptcha_active')):?>
                <div class="col-sm-2"></div>
                <div class="col-md-5 col-sm-6">
                    <?=View::factory('recaptcha', ['id' => isset($recaptcha_placeholder) ? $recaptcha_placeholder : 'recaptcha3'])?>
                </div>
            <?else:?>
                <label class="col-sm-2 control-label"><?=_e('Captcha')?>*:</label>
                <div class="col-md-5 col-sm-6">
                  <span id="helpBlock" class="help-block"><?=captcha::image_tag('register')?></span>
                  <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required', 'data-error' => __('Captcha is not correct')))?>
                </div>
            <?endif?>
        <?endif?>
    </div>

    <hr>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-8">
            <ul class="list-inline">
                <li>
                    <button type="submit" class="btn btn-primary"><?=_e('Register')?></button>
                </li>
                <li>
                    <?=_e('Already Have an Account?')?>
                    <a data-dismiss="modal" data-toggle="modal"  href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                        <?=_e('Login')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?=Form::redirect()?>
    <?=Form::CSRF('register')?>
</form>
<?if (Core::config('general.sms_auth') == TRUE ):?>
    <div class="page-header">
        <h1 class="listings-title"><span><?=_e('Phone Register')?></span></h1>
    </div>
    <?=View::factory('pages/auth/phoneregister-form')?>
<?endif?>
