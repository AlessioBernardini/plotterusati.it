<?if (Core::config('general.sms_auth') == TRUE ):?>
    <form class="well form-horizontal auth" method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'phoneregister'))?>">
        <?=Form::errors()?>

        <div class="form-group">
            <label class="col-sm-2 control-label"><?=_e('Phone')?></label>
            <div class="col-md-5 col-sm-6">
                <?= FORM::input('phone', '', array('class'=>'form-control', 'id'=>'phone', 'type'=>'phone' ,'required','placeholder'=>__('Phone'), 'data-country' => core::config('general.country')))?>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="col-sm-offset-2 col-md-5 col-sm-6">
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
        <?=Form::CSRF('phoneregister')?>
    </form>
<?endif?>
