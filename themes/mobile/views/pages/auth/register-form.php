<?php defined('SYSPATH') or die('No direct script access.');?>
<form class="well form-horizontal"  method="post" target="_blank" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>">         
          <?=Form::errors()?>
          
          <div class="control-group">
            <label class="control-label"><?=__('Name')?></label>
            <div class="controls docs-input-sizes">
              <input class="input-medium" type="text" name="name" value="<?=Request::current()->post('name')?>" placeholder="<?=__('Name')?>">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label"><?=__('Email')?></label>
            <div class="controls docs-input-sizes">
              <input class="input-medium" type="text" name="email" value="<?=Request::current()->post('email')?>" placeholder="<?=__('Email')?>">
            </div>
          </div>
     
          <div class="control-group">
            <label class="control-label"><?=__('New password')?></label>
            <div class="controls docs-input-sizes">
            <input class="input-medium" type="password" name="password1" placeholder="<?=__('Password')?>">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label"><?=__('Repeat password')?></label>
            <div class="controls docs-input-sizes">
            <input class="input-medium" type="password" name="password2" placeholder="<?=__('Password')?>">
              <p class="help-block">
                  <?=__('Type your password twice')?>
              </p>
            </div>
          </div>

          <?if(core::config('advertisement.tos') != FALSE):?>
            <div class="control-group">
              <div class="controls">
                <label class="checkbox">
                  <input type="checkbox" required name="tos" id="tos"/> 
                  <a target="_blank" href="<?=Route::url('page', array('seotitle'=>'tos'))?>"> <?=__('Terms of service')?></a>
                </label>
              </div>
            </div>
          <?endif?>

          <?foreach(Model_UserField::get_all() as $name=>$field):?>
            <?if($field['show_register'] AND $name!='verifiedbadge' AND $name!='whatsapp'):?>
              <div class="control-group">
                <?$cf_name = 'cf_'.$name?>
                <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                  $select = array(''=>'');
                  foreach ($field['values'] as $select_name) {
                    $select[$select_name] = $select_name;
                  }
                } else $select = $field['values']?>
                <?= FORM::label('cf_'.$name, $field['label'], array('class'=>'control-label', 'for'=>'cf_'.$name))?>
                <div class="controls docs-input-sizes">
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
                <div class="control-group" id="cf_new">
                    <label class="control-label" for="cf_whatsapp"><?=_e('Whatsapp Number')?></label>
                    <div class="controls">
                        <input id="cf_whatsapp" name="cf_whatsapp" title="" class="form-control cf_string_fields data-custom  " placeholder="whatsapp" data-placeholder="whatsapp" data-original-title="whatsapp" type="text" 
                        data-country-code="<?=(!empty(core::config('general.country')))?I18n::country_codes()[core::config('general.country')]:''?>"
                        >
                    </div>
                </div>
            <?endif?>
          <?endforeach?>
                    
          <div class="control-group">
            <?if (core::config('advertisement.captcha') != FALSE OR core::config('general.captcha') != FALSE):?>
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
          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=__('Register')?></button>
          </div>
          <div class="help-block">
            <?=_e('Already Have an Account?')?>
            <a data-dismiss="modal" data-toggle="modal"  href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>">
				<i class="icon-user"></i> 
				<?=__('Login')?>
			</a>
          </div>
          <?=Form::CSRF('register')?>
</form>       
<?if (Core::config('general.sms_auth') == TRUE ):?>
    <div class="page-header">
        <h2 class="h2"><?=_e('Phone Register')?></h2>
    </div>
    <?=View::factory('pages/auth/phoneregister-form')?>
<?endif?>