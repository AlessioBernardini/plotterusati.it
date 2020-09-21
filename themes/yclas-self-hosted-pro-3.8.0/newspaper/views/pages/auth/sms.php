<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
    <h1><?=_e('2 Step SMS Authentication')?></h1>
</div>

<form class="form-horizontal auth"  method="post" action="<?=$form_action?>">
    <?=Form::errors()?>

    <div class="form-group">
        <label class="col-sm-12">
            <?=_e('We have sent an SMS code to your phone number')?>
            <?=substr($phone,0,3)?>*****<?=substr($phone,-4)?>
        </label>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label"><?=_e('Verification Code')?></label>
        <div class="col-xs-9 col-md-6">
            <input class="form-control" type="text" name="code" placeholder="<?=__('Code')?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-3 col-xs-10 col-md-6">
            <button type="submit" class="btn btn-primary"><?=_e('Send')?></button>
        </div>
    </div>
    <?=Form::redirect()?>
    <?=Form::CSRF('sms')?>
</form>
