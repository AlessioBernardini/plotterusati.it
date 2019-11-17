<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?=__('Inbox')?></h1>
</div>

<div class="header_devider"></div>

<div data-role="controlgroup" data-type="horizontal">
    <a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'index'))?>" data-role="button">
        <?=__('All')?>
    </a>
    <a href="?status=<?=Model_Message::STATUS_NOTREAD?>" data-role="button">
        <?=__('Unread')?>
    </a>
    <a href="?status=<?=Model_Message::STATUS_ARCHIVED?>" data-role="button">
        <?=__('Archieved')?>
    </a>
    <a href="?status=<?=Model_Message::STATUS_SPAM?>" data-role="button">
        <?=__('Spam')?>
    </a>
</div>

<?if (core::count($messages) > 0):?>
    <table data-role="table" data-mode="columntoggle" class="table table-hover ui-responsive" id="myTable">
        <thead>
            <tr>
                <th><?=__('Title')?> / <?=__('From')?></th>
                <th><?=__('Date')?></th>
                <th><?=__('Last Answer')?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?foreach ($messages as $message):?>
                <tr class="message" 
                    data-url="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>($message->id_message_parent != NULL) ? $message->id_message_parent : $message->id_message))?>"
                    style="<?=($message->status_to == Model_Message::STATUS_NOTREAD AND $message->from->id_user != Auth::instance()->get_user()->id_user) ? 'font-weight: bold;' : NULL?>"
                >
                    <td>
                        <p>
                            <?if(isset($message->ad->title)):?>
                                <?=$message->ad->title?>
                            <?else:?>
                                <?=__('Direct Message')?>
                            <?endif?>
                            <br>
                            <a href="<?=Route::url('profile', array('seoname' => $message->from->seoname))?>"><?=$message->from->name?></a>
                        </p>
                    </td>
                    <td><?=$message->parent->created?></td>
                    <td><?=(empty($message->parent->read_date))?__('None'):$message->created?></td>
                    <td class="text-right">
                        <a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'message','id'=>($message->id_message_parent != NULL) ? $message->id_message_parent : $message->id_message))?>" 
                            class="btn btn-xs"
                        >
                            <?if ($message->status_to == Model_Message::STATUS_NOTREAD AND $message->from->id_user != Auth::instance()->get_user()->id_user) :?>
                                <span class="label label-warning"><?=__('Unread')?></span>
                            <?endif?>
                        </a>
                    </td>
                </tr>
            <?endforeach?>
        </tbody>
    </table>
    <?=$pagination?>
<?else:?>
    <?=__('You don’t have any messages yet.')?>
<?endif?>
