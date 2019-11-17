<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1><?=_e('2 Step SMS Authentication')?></h1>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<section id="main">
    <div class="container no-gutter">
        <form class="form-horizontal auth text-center"  method="post" action="<?=$form_action?>">
            <?=Form::errors()?>

            <div class="form-group">
                <label class="col-sm-8 col-sm-offset-2">
                    <?=_e('We have sent an SMS code to your phone number')?>
                    <?=substr($phone,0,3)?>*****<?=substr($phone,-4)?>
                </label>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label"><?=_e('Verification Code')?></label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" name="code" placeholder="<?=__('Code')?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="submit" class="btn btn-primary"><?=_e('Send')?></button>
                </div>
            </div>
            <?=Form::redirect()?>
            <?=Form::CSRF('sms')?>
        </form>
    </div>
</section>
