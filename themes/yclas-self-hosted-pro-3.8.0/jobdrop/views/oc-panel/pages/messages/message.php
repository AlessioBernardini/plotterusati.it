<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Alert::show()?>

<div class="page-header text-center">
    <h1>
        <?if ($msg_thread->id_ad !== NULL):?>
            <?=$msg_thread->ad->title?>
        <?else:?>
            <?=sprintf(__('Direct message from %s to %s'), $msg_thread->from->name, $msg_thread->to->name);   ?>
        <?endif?>
    </h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <table class="table table-striped">
                    <tbody>
                        <?foreach ($messages as $message):?>
                            <tr>
                                <td class="text-center">
                                    <strong><a href="<?=Route::url('profile', array('seoname' => $message->from->seoname))?>"><?=$message->from->name?></a></strong>
                                </td>
                                <td>
                                    <em>
                                        <?=Date::fuzzy_span(Date::mysql2unix($message->created))?>
                                         - 
                                        <?=$message->created?>
                                    </em>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 12%;" class="text-center">
                                    <img src="<?=$message->from->get_profile_image()?>" class="img-rounded" width="50" height="50" title="<?=HTML::chars($message->from->name)?>">
                                </td>
                                <td>
                                    <p class="<?=HTML::chars($message->from->name)?>"><?=Text::bb2html($message->message,TRUE)?></p>
                                    <?if ($message->price > 0):?>
                                        <p>
                                            <strong><?=_e('Price')?></strong>: <?=i18n::money_format($message->price)?>
                                        </p>
                                    <?endif?>
                                </td>
                            </tr>
                        <?endforeach?>
                        <tr>
                            <td style="width: 12%;" class="text-center">
                                <img src="<?=$user->get_profile_image()?>" class="img-rounded" width="50" height="50" title="<?=HTML::chars($user->name)?>">
                            </td>
                            <td>
                                <form class="form-horizontal"  method="post" action="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>Request::current()->param('id')))?>"> 
                                    <?php if (isset($errors)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <p><?=_e('Some errors were encountered, please check the details you entered.')?></p>
                                            <ul>
                                                <?php foreach ($errors as $message): ?>
                                                    <li><?php echo $message ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    <?php endif ?>    
                                    <div class="form-group control-group">
                                        <div class="col-md-12">
                                            <textarea name="message" rows="10" class="form-control input-xxlarge disable-bbcode" data-editor="html" required><?=core::post('message')?></textarea>
                                        </div>
                                    </div>
                                    <?=Form::token('reply_message')?>
                                    <a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'index'))?>" class="btn btn-default"><?=_e('Cancel')?></a>
                                    <button type="submit" class="btn btn-primary"><?=_e('Reply')?></button>
                                </form> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!--//panel-->
        </div>
    </div>
</div>