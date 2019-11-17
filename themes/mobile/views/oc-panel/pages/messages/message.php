<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Alert::show()?>

<div class="page-header">
    <h1>
        <?if ($msg_thread->id_ad !== NULL):?>
            <?=$msg_thread->ad->title?>
        <?else:?>
            <?=sprintf(__('Direct message from %s to %s'), $msg_thread->from->name, $msg_thread->to->name);   ?>
        <?endif?>
    </h1>
</div>

<div class="header_devider"></div>

<div data-role="controlgroup" data-type="horizontal">
    <a
        href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'status','id'=>$msg_thread->id_message))?>?status=<?=Model_Message::STATUS_ARCHIVED?>"
        class="btn btn-warning"
        data-toggle="confirmation"
        data-text="<?=__('Are you sure you want to archive this message?')?>" 
        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
        data-btnCancelLabel="<?=__('No way!')?>"
    >
        <?=_e('Archive')?>
    </a>
    <a 
        href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'status','id'=>$msg_thread->id_message))?>?status=<?=Model_Message::STATUS_SPAM?>"
        data-role="button"
        data-toggle="confirmation"
        data-text="<?=__('Are you sure you want to mark it as Spam?')?>" 
        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
        data-btnCancelLabel="<?=__('No way!')?>"
    >
        <?=__('Spam')?>
    </a>
    <a 
        href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'status','id'=>$msg_thread->id_message))?>?status=<?=Model_Message::STATUS_DELETED?>"
        data-role="button"
        data-toggle="confirmation"
        data-text="<?=__('Are you sure you want to delete?')?>" 
        data-btnOkLabel="<?=__('Yes, definitely!')?>" 
        data-btnCancelLabel="<?=__('No way!')?>"
    >
        <?=__('Delete')?>
    </a>
</div>

<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">
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
                            <strong><?=__('Price')?></strong>: <?=i18n::money_format($message->price)?>
                        </p>
                    <?endif?>
                </td>
            </tr>
        <?endforeach?>
        <tr>
            <td style="width: 12%;" class="text-center">
                <img src="<?=Auth::instance()->get_user()->get_profile_image()?>" class="img-rounded" width="50" height="50" title="<?=HTML::chars(Auth::instance()->get_user()->name)?>">
            </td>
            <td>
                <form class="form-horizontal"  method="post" action="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>Request::current()->param('id')))?>"> 
                    <?if (isset($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <p><?=__('Some errors were encountered, please check the details you entered.')?></p>
                            <ul>
                                <?php foreach ($errors as $message): ?>
                                    <li><?php echo $message ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?endif ?>    
                    <textarea name="message" rows="10" class="form-control input-xxlarge disable-bbcode" data-editor="html" required><?=core::post('message')?></textarea>
                    <?=Form::token('reply_message')?>
                    <button type="submit" class="btn btn-primary"><?=__('Reply')?></button>
                </form> 
            </td>
        </tr>
    </tbody>
</table>
