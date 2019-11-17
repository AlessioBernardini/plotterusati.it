<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::count($ads)):?>
    <br>
    <div class="row">
        <?foreach($ads as $ad):?>
            <div class="col-md-3">
                <div class="box-card box-item-card">
                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        <div class="box-card-header">
                            <img src="<?=$ad->user->get_profile_image()?>" class="profile img-circle"> <?=$ad->user->name?>
                        </div>
                        <div class="box-card-images">
                            <?if($ad->get_first_image()!== NULL):?>
                                <img width="1067" height="1067" src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                            <?else:?>
                                <img width="1067" height="1067" data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                            <?endif?>
                        </div>
                        <div class="box-card-footer">
                            <div class="box-card-footer-title">
                                <div class="box-card-footer-title-wrapper">
                                    <div class="headline"><h4><?=$ad->title?></h4></div>
                                    <div class="excerpt">
                                        <p>
                                            <?if ($ad->price!=0):?>
                                                <span class="price"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                            <?endif?>
                                            <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                                <span class="label label-danger"><?=_e('Free');?></span>
                                            <?endif?>
                                            <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                        </p>
                                        <?if(core::config('advertisement.location') AND $ad->id_location != 1):?>
                                            <p><?=_e('Location')?>: <?=$ad->location->translate_name() ?></p>
                                        <?endif?>
                                        <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                            <?if($value=='checkbox_1'):?>
                                                <p><?=$name?>: <i class="fa fa-check"></i></p>
                                            <?elseif($value=='checkbox_0'):?>
                                                <p><?=$name?>: <i class="fa fa-times"></i></p>
                                            <?else:?>
                                                <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                    <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                        <p><?=$name?>: <?=$value?></p>
                                                    <?endif?>
                                                <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                    <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                        <p><?=$name?>: <?=$value?></p>
                                                    <?endif?>
                                                <?else:?>
                                                    <?if(is_string($name)):?>
                                                        <p><?=$name?>: <?=$value?></p>
                                                    <?else:?>
                                                        <p><?=$value?></p>
                                                    <?endif?>
                                                <?endif?>
                                            <?endif?>
                                        <?endforeach?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?endforeach?>
    </div>
<?endif?>
