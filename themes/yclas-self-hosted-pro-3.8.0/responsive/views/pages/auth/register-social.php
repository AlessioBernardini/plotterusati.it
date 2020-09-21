<?php defined('SYSPATH') or die('No direct script access.');?>
<form class="well form-horizontal"  method="post" action="<?=$form_action?>">         
          <?=Form::errors()?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?=_e('Name')?></label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="name" value="<?=HTML::chars(Core::post('name'))?>" placeholder="<?=__('Name')?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label"><?=_e('Email')?></label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="email" value="<?=HTML::chars(Core::post('email'))?>" placeholder="<?=__('Email')?>">
            </div>
          </div>
     
          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><?=_e('Register')?></button>
              </div>
          </div>
          <?=Form::CSRF('register_social')?>
</form>      	
