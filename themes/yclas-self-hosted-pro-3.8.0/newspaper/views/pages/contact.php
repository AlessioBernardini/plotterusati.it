<?php defined('SYSPATH') or die('No direct script access.');?>
<?if(core::config('general.contact_page') != ''):?>
    <?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
    <h1 class="listings-title">
        <span><?=$content->title?></span>
    </h1>
    <?=$content->description?>
    <br>
<?else:?>
    <h1 class="listings-title">
        <span><?=_e('Contact Us')?></span>
    </h1>
<?endif?>
<div>
    <?=Form::errors()?>
    <?=FORM::open(Route::url('contact'), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
        <fieldset>
            <?if (!Auth::instance()->get_user()):?>
                <div class="form-group">
                    <?=FORM::label('name', _e('Name'), array('class'=>'col-xs-2 control-label', 'for'=>'name'))?>
                    <div class="col-xs-10 col-md-6">
                        <?=FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
                    </div>
                </div>
                <div class="form-group">
                    <?=FORM::label('email', _e('Email'), array('class'=>'col-xs-2 control-label', 'for'=>'email'))?>
                    <div class="col-xs-10 col-md-6">
                        <?=FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                    </div>
                </div>
            <?endif?>
            <div class="form-group">
                <?=FORM::label('subject', _e('Subject'), array('class'=>'col-xs-2 control-label', 'for'=>'subject'))?>
                <div class="col-xs-10 col-md-6">
                    <?=FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
                </div>
            </div>
            <div class="form-group">
                <?=FORM::label('message', _e('Message'), array('class'=>'col-xs-2 control-label', 'for'=>'message'))?>
                <div class="col-xs-10 col-md-6">
                    <?=FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
                </div>
            </div>
            <?if (core::config('advertisement.captcha') != FALSE):?>
                <div class="form-group">
                    <div class="col-xs-10 col-md-6 col-xs-offset-2">
                        <?if (Core::config('general.recaptcha_active')):?>
                            <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                        <?else:?>
                            <?=_e('Captcha')?>*:<br>
                            <?=captcha::image_tag('contact')?><br>
                            <?=FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
                        <?endif?>
                    </div>
                </div>
            <?endif?>
            <div class="form-group">
                <div class="col-xs-10 col-md-6 col-xs-offset-2">
                    <?=FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('contact')))?>
                </div>
                <br class="clear">
            </div>
        </fieldset>
    <?=FORM::close()?>
</div>