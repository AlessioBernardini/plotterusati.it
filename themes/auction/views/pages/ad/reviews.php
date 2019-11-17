<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($ad->status != Model_Ad::STATUS_PUBLISHED AND $permission === FALSE AND ($ad->id_user != $user) OR (Theme::get('premium')!=1)):?>

<div class="page-header">
	<h1><?= __('This advertisement doesn´t exist, or is not yet published!')?></h1>
</div>

<?else:?>
    <?=Form::errors()?>

    <div class="well well-sm">
        <div class="row">
            <div class="col-xs-12 col-md-12 section-box span8">
                <h1>
                    <?=__("Reviews for").' '.$ad->title?>
                </h1>
                <hr />
                <div class="row rating-desc">
                    <div class="col-md-12 span9">
                        <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                            <span class="glyphicon glyphicon-star"></span>
                        <?endfor?>
                        <?for ($ii=$i; $ii < 5; $ii++):?>
                            <span class="glyphicon glyphicon-star-empty"></span>
                        <?endfor?>(<?=round($ad->rate,1)?>/<?=Model_Review::RATE_MAX?>)<span class="separator"> | </span>
                        <span class="glyphicon glyphicon-comment"></span> <?=core::count($reviews)?>
                        <?if(core::count($reviews) == 1):?>
                            <?=_e(' review')?>
                        <?else:?>
                            <?=_e(' reviews')?>
                        <?endif?>
                    </div>
                </div>

                <?if (Auth::instance()->logged_in()):?>
                <a class="btn btn-success pull-right" data-toggle="modal" data-target="#review-modal" href="#">
                <?else:?>
                <a class="btn btn-success pull-right" data-toggle="modal" data-dismiss="modal" 
                    href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                <?endif?>
                    <i class="glyphicon glyphicon-bullhorn"></i> <?=_e('Write a review')?>
                </a>

            </div>
        </div>
    </div>

    <?if (Auth::instance()->logged_in()):?>    
        <div id="review-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                            <h3 class="modal-title"><?=__('Add New Review')?></h3>
                        </div>
                        <div class="modal-body">
                            <?=Form::errors()?>
                            <div class="form-group">
                                <div id="review_raty" data-baseurl="<?=Route::url('default')?>"></div>
                            </div>

                            <div class="form-group">
                                <?=FORM::label('description', __('Review'), array('for'=>'description'))?>
                                <div class="controls">
                                    <?=FORM::textarea('description', HTML::chars(core::post('description','')), array('placeholder' => __('Review'), 'class' => 'form-control', 'name'=>'description', 'id'=>'description', 'required'))?>
                                </div>
                            </div>

                            <?if (core::config('advertisement.captcha') != FALSE):?>
                                <div class="form-group">
                                    <?if (Core::config('general.recaptcha_active')):?>
                                        <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                    <?else:?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?=FORM::label('captcha', __('Captcha'), array('for'=>'captcha'))?>
                                                <span id="helpBlock" class="help-block"><?=captcha::image_tag('review')?></span>
                                                <?=FORM::input('captcha', "", array('class'=>'form-control', 'id' => 'captcha', 'required'))?>
                                            </div>
                                        </div>
                                    <?endif?>
                                </div>
                                <div class="clearfix"></div>
                            <?endif?>
                        </div>
                        <div class="modal-footer">  
                            <input type="submit" class="btn btn-success" value="<?=__('Post Review')?>" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?endif?>
    
    <hgroup class="mb20"></hgroup>
    <?if(core::count($reviews)):?>
        <?foreach ($reviews as $review):?>
        
        <article class="reviews-search-result row">
            <ul class="col-xs-12 meta-search list-inline">
                <li><i class="glyphicon glyphicon-calendar"></i> <span><?=$review->created?></span></li>
                <li><i class="glyphicon glyphicon-time"></i> <span><?=Date::fuzzy_span(Date::mysql2unix($review->created))?></span></li>
                <li><i class="glyphicon glyphicon-user"></i> <span><?=$review->user->name?></span></li>
            </ul>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <a title="<?=HTML::chars($review->user->name)?>" class="thumbnail">
                    <img src="<?=Core::imagefly($review->user->get_profile_image(),150,150)?>" alt="<?=__('Profile image')?>">
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?if ($review->rate!==NULL):?>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="rating text-center">
                                <div class="rating-num"><?=round($review->rate,2)?>.0</div>
                                <?for ($j=0; $j < round($review->rate,1); $j++):?>
                                    <span class="glyphicon glyphicon-star"></span>
                                <?endfor?>
                                <?for ($jj=$j; $jj < 5; $jj++):?>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                <?endfor?>
                            </div>
                        </div>
                    <?endif?>
                    <div class="col-xs-12 col-sm-12 col-md-10">
                        <div class="text-description"><?=Text::bb2html($review->description,TRUE)?></div>                      
                            <!-- <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span> -->
                    </div>
                    <span class="clearfix borda"></span>
                </div>
            </div>
        </article>
        <hgroup class="mb20 mt20"></hgroup>
        <?endforeach?>

    <?elseif (core::count($reviews) == 0):?>
    <div class="page-header">
        <h3><?=__('We do not have any reviews for this product yet.')?></h3>
    </div>
    <?endif?>


<?endif?>

