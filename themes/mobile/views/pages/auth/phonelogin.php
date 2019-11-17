<?if (Core::config('general.sms_auth') == TRUE ):?>
<div class="page-header">
    <h1><?=_e('Phone Login')?></h1>
</div>
<form class="well form-horizontal auth" method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'phonelogin'))?>">         
    <?=Form::errors()?>
     
    <div class="control-group">
        <label class="control-label"><?=_e('Phone')?></label>
        <div class="controls docs-input-sizes">
            <?= FORM::input('phone', '', array('class'=>'input-medium', 'id'=>'phone', 'type'=>'phone' ,'required','placeholder'=>__('Phone'), 'data-country' => core::config('general.country')))?>
        </div>
    </div>
    
    <hr>

    <div class="control-group">
            <ul class="list-inline">
                <li>
                    <button type="submit" class="btn btn-primary">
                        <?=_e('Login')?>
                    </button>
                </li>
                <li>
                    <?=_e('Don’t Have an Account?')?>
                    <a class="btn ui-btn color-gray" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>#register-modal">
                        <?=_e('Register')?>
                    </a>
                </li>
            </ul>
    </div>
    <?=Form::redirect()?>
    <?=Form::CSRF('phonelogin')?>
</form>
<?endif?>