<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<?if(core::config('general.contact_page') != ''):?>
    <?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
    <div class="page-title">
        <h1><i class="fa fa-envelope color"></i> <?=$content->title?></h1>
        <hr>
    </div>
    <?=$content->description?>
    <br>
<?else:?>
    <div class="page-title">
        <h1><i class="icon-mail color"></i> <?=_e('Contact Us')?></h1>
    </div>
<?endif?>

<?= FORM::open(Route::url('contact'), array('class'=>'form-horizontal cwell', 'enctype'=>'multipart/form-data'))?>
    <fieldset>
        <?if (!Auth::instance()->get_user()):?>
            <div class="form-group">
                <?= FORM::label('name', _e('Name'), array('class'=>'col-md-2 control-label', 'for'=>'name'))?>
                <div class="col-md-5 ">
                    <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
                </div>
            </div>
            <div class="form-group">
                <?= FORM::label('email', _e('Email'), array('class'=>'col-md-2 control-label', 'for'=>'email'))?>
                <div class="col-md-5 ">
                    <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                </div>
            </div>
        <?endif?>
        <div class="form-group">
            <?= FORM::label('subject', _e('Subject'), array('class'=>'col-md-2 control-label', 'for'=>'subject'))?>
            <div class="col-md-5 ">
                <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
            </div>
        </div>
        <div class="form-group">
            <?= FORM::label('message', _e('Message'), array('class'=>'col-md-2 control-label', 'for'=>'message'))?>
            <div class="col-md-5">
                <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
            </div>
        </div>
    
        <?if (core::config('advertisement.captcha') != FALSE):?>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-5">
                    <?if (Core::config('general.recaptcha_active')):?>
                        <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                    <?else:?>
                        <?=_e('Captcha')?>*:<br />
                        <?=captcha::image_tag('contact')?><br />
                        <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
                    <?endif?>
                </div>
            </div>
        <?endif?>
        <hr>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('contact')))?>
            </div>
            <br class="clear">
        </div>
    </fieldset>
<?= FORM::close()?>