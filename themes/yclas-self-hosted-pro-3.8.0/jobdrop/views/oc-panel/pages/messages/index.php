<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Alert::show()?>
<div class="page-header text-center">
    <h1><?=_e('Inbox')?></h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel">
                <?if (core::count($messages) > 0):?>
                    <br>
                    <table class="table table-striped">
                        <thead>
                             <tr>
                                <th><?=_e('Title')?> / <?=_e('From')?></th>
                                <th><?=_e('Date')?></th>
                                <th><?=_e('Last Answer')?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($messages as $message):?>
                                <tr class="message" 
                                    data-url="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>($message->id_message_parent != NULL) ? $message->id_message_parent : $message->id_message))?>"
                                    style="<?=($message->status_to == Model_Message::STATUS_NOTREAD AND $message->id_user_from != $user->id_user) ? 'font-weight: bold;' : NULL?>"
                                >
                                    <td>
                                        <p>
                                            <?if(isset($message->ad->title)):?>
                                                <?=$message->ad->title?>
                                            <?else:?>
                                                <?=_e('Direct Message')?>
                                            <?endif?>
                                            <?if ($message->status_to == Model_Message::STATUS_NOTREAD AND $message->id_user_from != $user->id_user) :?>
                                                <span class="label label-warning"><?=_e('Unread')?></span>
                                            <?endif?>
                                            <br>
                                            <a href="<?=Route::url('profile', array('seoname' => $message->from->seoname))?>"><?=$message->from->name?></a>
                                        </p>
                                    </td>
                                    <td><?=$message->parent->created?></td>
                                    <td><?=(empty($message->parent->read_date))?_e('None'):$message->created?></td>
                                    <td class="text-right">
                                        <a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>($message->id_message_parent != NULL) ? $message->id_message_parent : $message->id_message))?>" 
                                            class="btn btn-xs <?=($message->status_to == Model_Message::STATUS_NOTREAD AND $message->id_user_from != $user->id_user) ? 'btn-warning' : 'btn-default'?>"
                                        >
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?endforeach?>
                        </tbody>
                    </table>
                <?else:?>
                    <h3><?=_e('You don’t have any messages yet.')?></h3>
                <?endif?>
            </div><!--//panel-->
        </div>
    </div>
</div>

<?if(isset($pagination)):?>
    <div class="text-center">
        <?=$pagination?>
    </div>
<?endif?>