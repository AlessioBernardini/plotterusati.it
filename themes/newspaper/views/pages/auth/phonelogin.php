<?if (Core::config('general.sms_auth') == TRUE ):?>
<h1 class="listings-title"><span><?=_e('Phone Login')?></span></h1>
<form class="form-horizontal auth" method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'phonelogin'))?>">         
    <?=Form::errors()?>
     
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=_e('Phone')?></label>
        <div class="col-xs-10 col-md-6">
            <?= FORM::input('phone', '', array('class'=>'form-control', 'id'=>'phone', 'type'=>'phone' ,'required','placeholder'=>__('Phone'), 'data-country' => core::config('general.country')))?>
        </div>
    </div>
    
    <hr>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-6">
            <ul class="list-inline">
                <li>
                    <button type="submit" class="btn btn-primary">
                        <?=_e('Login')?>
                    </button>
                </li>
                <li>
                    <?=_e('Don’t Have an Account?')?>
                    <a data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>#register-modal">
                        <?=_e('Register')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?=Form::redirect()?>
    <?=Form::CSRF('phonelogin')?>
</form>
<?endif?>