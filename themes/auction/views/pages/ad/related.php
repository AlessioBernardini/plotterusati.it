<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::count($ads) > 0):?>
    <h3><?=_e('Related ads')?></h3>
    <?$i=0;
    foreach($ads as $ad ):?>
        <?if(get_remaining_time($ad) > 0):?>
        <?

            // Get highest bid
            $message = new Model_Message();

            $message->where('id_ad','=',$ad->id_ad)
                        ->and_where('id_user_to','=',$ad->id_user)
                        ->order_by('price', 'DESC')
                        ->limit(1)
                        ->find();

            $best_bidder = '';

            if($message->price != '' AND $message->price != NULL){
                $ad->price = $message->price;
                $best_bidder = new Model_User($message->id_user_from);
            }

            $messages = new Model_Message();

            $bids = $messages->where('id_ad', '=', $ad->id_ad)
                            ->and_where('price','>',0)
                            ->and_where('price','!=','');

            $num_of_bids = $bids->count_all();

            // Calculate and $time_left
            $time_left = get_remaining_time($ad);

            $remaining_time = $time_left;

            $days = intval($time_left / 86400);
            $time_left = $time_left % 86400;

            $remaining_time_content = '';

            // We show hours and minutes only if the remaining time is less than a day

            if ($days > 0) {
                if ($days > 1){
                    $remaining_time_content .= '<span>'.$days.'</span> days ';
                } elseif ($days > 0){
                    $remaining_time_content .= '<span>'.$days.'</span> day ';
                }

                $hours = intval($time_left / 3600);
                $time_left = $time_left % 3600;

                $remaining_time_content .= '<span>'.$hours.'</span>h ';

            } else {
                $hours = intval($time_left / 3600);
                $time_left = $time_left % 3600;

                if ($hours > 1){
                    $remaining_time_content .= '<span>'.$hours.'</span>h ';
                }

                $minutes = $time_left / 60;

                if ($minutes > 1){
                    $remaining_time_content .= '<span>'.intval($minutes).'</span>min ';
                // elseif less than a minute left to bid
                } elseif ($remaining_time < 61 AND $remaining_time > 0){
                    $remaining_time_content .= '<span> < '.intval($minutes).'</span>min ';
                } elseif ($remaining_time < 1){
                    $remaining_time_content .= '<span>0</span>mins ';
                }
            }

        ?>
        <div class="media col-md-2 col-xs-6 text-center <?=$ad->featured >= Date::unix2mysql(time())?'featured':''?>">
        <?if($ad->featured >= Date::unix2mysql(time())):?>
            <div class="corner-ribbon top-left sticky red shadow"><?=_e('Featured')?></div>
        <?endif?>
            <div class="media-center">
                <a title="<?=HTML::chars($ad->title);?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                    <?if($ad->get_first_image() !== NULL):?>
                        <img class="media-object img-responsive center-block" src="<?=Core::imagefly($ad->get_first_image(),150,150)?>" alt="<?= HTML::chars($ad->title)?>">
                    <?else:?>
                        <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                            <img class="media-object img-responsive center-block" src="<?=Core::imagefly($icon_src,150,150)?>" alt="<?=HTML::chars($ad->title);?>">
                        <?else:?>
                            <img class="media-object img-responsive center-block" data-src="holder.js/150x150?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 8, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                        <?endif?>
                    <?endif?>
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a title="<?=HTML::chars($ad->title);?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"> <?=$ad->title?></a>
                </h4>
                <?if($ad->price > 0 AND isset($ad->cf_auction_days) AND $ad->cf_auction_days!=''):?>
                    <p><b><i class="fa fa-clock-o fa-lg"></i> <?=$remaining_time_content?> <?=_e('left')?></b></p>
                    <p class="text-muted"><?=$num_of_bids?> <?=_e('Bids')?></p>
                    <p><i><?=Text::limit_chars(($best_bidder!=''?$best_bidder->name:''), 15, NULL, TRUE)?></i> <!-- theme Option --></p>
                    <p><b><span class="price-curry text-danger"><?=i18n::money_format( $ad->price, $ad->currency())?></span></b></p>
                <?endif?>
            </div>
        </div>
        <?endif?>
    <?endforeach?>
<?endif?>
