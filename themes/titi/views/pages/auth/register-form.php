<form class="form-horizontal register"  method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>">
          <?=Form::errors()?>

          <div class="form-group">
            <label class="col-sm-4 control-label"><?=__('Name')?></label>
            <div class="col-md-5 col-sm-6">
              <input class="form-control" type="text" name="name" value="<?=Request::current()->post('name')?>" placeholder="<?=__('Name')?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label"><?=__('Email')?></label>
            <div class="col-md-5 col-sm-6">
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
            <label class="col-sm-4 control-label"><?=__('New password')?></label>
            <div class="col-md-5 col-sm-6">
            <input class="form-control" type="password" name="password1" placeholder="<?=__('Password')?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label"><?=__('Repeat password')?></label>
            <div class="col-md-5 col-sm-6">
            <input class="form-control" type="password" name="password2" placeholder="<?=__('Password')?>">
              <p class="help-block">
              		<?=__('Type your password twice')?>
              </p>
            </div>
          </div>

          <?foreach(Model_UserField::get_all() as $name=>$field):?>
              <?if($field['show_register'] AND $name!='verifiedbadge'):?>
                  <div class="form-group">
                      <?$cf_name = 'cf_'.$name?>
                      <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                          $select = array(''=>'');
                          foreach ($field['values'] as $select_name) {
                              $select[$select_name] = $select_name;
                          }
                      } else $select = $field['values']?>
                      <?= FORM::label('cf_'.$name, $field['label'], array('class'=>'col-sm-4 control-label', 'for'=>'cf_'.$name))?>
                      <div class="col-md-5 col-sm-6">
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
              <?endif?>
          <?endforeach?>

          <div class="form-group">
              <?if (Core::config('advertisement.captcha')):?>
                  <?if (Core::config('general.recaptcha_active')):?>
                      <div class="col-sm-4"></div>
                      <div class="col-md-5 col-sm-6">
                          <?=View::factory('recaptcha', ['id' => isset($recaptcha_placeholder) ? $recaptcha_placeholder : 'recaptcha3'])?>
                      </div>
                  <?else:?>
                      <label class="col-sm-4 control-label"><?=_e('Captcha')?>*:</label>
                      <div class="col-md-5 col-sm-6">
                          <span id="helpBlock" class="help-block"><?=captcha::image_tag('register')?></span>
                          <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required', 'data-error' => __('Captcha is not correct')))?>
                      </div>
                  <?endif?>
              <?endif?>
          </div>

            <? if (core::config('advertisement.tos') != '') : ?>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required name="tos" id="tos"/>
                                <a target="_blank" href="<?= Route::url('page', array('seotitle' => core::config('advertisement.tos'))) ?>"> <?= _e('Terms of service') ?></a>
                            </label>
                        </div>
                    </div>
                </div>
            <? endif ?>

            <div class="page-header"></div>
            <div class="col-sm-offset-4">
              	<a class="btn btn-default"  data-dismiss="modal" data-toggle="modal"  href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
    				<i class="glyphicon glyphicon-user"></i>
    				<?=__('Login')?>
    			</a>
            <button type="submit" class="btn btn-primary"><?=__('Register')?></button>
            </div>
          <?=Form::redirect()?>
          <?=Form::CSRF('register')?>
          <?=View::factory('pages/auth/social')?>
</form>

<?if (Core::config('general.sms_auth') == TRUE ):?>
    <div class="page-header">
        <h1><?=_e('Phone Register')?></h1>
    </div>
    <?=View::factory('pages/auth/phoneregister-form')?>
<?endif?>
