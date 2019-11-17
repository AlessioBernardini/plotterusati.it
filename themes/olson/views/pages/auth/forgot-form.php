<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<form class="form-horizontal cwell auth"  method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'forgot'))?>">         
    <div class="form-group">
        <label class="col-lg-2 control-label"><?=_e('Email')?></label>
        <div class="col-lg-5">
            <input class="form-control" type="text" name="email" placeholder="<?=__('Email')?>">
        </div>
    </div>
          
    <hr>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <ul class="list-inline">
                <li>
                    <button type="submit" class="btn btn-primary"><?=_e('Send')?></button>
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
    <?=Form::CSRF('forgot')?>
</form>      	