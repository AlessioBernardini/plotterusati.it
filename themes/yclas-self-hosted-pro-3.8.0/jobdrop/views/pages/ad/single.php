<?php defined('SYSPATH') or die('No direct script access.');?>
<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>
<div class="page-header text-center">
	<h1><?= _e('This advertisement doesn´t exist, or is not yet published!')?></h1>
</div>
<?else:?>
<?=Form::errors()?>
<div class="page-header text-center">
	<h1><?= $ad->title;?></h1>
    <div class="title-info">
    	<a href="<?=Route::url('list', array('category'=>$ad->category->seoname))?>" class="btn btn-inverse"><?=$ad->category->translate_name() ?></a>
        <?if(isset($ad->cf_jobtype) AND $ad->cf_jobtype):?>
          <a href="<?=Route::url('search')?>?<?=http_build_query(['cf_jobtype' => $ad->cf_jobtype])?>" class="btn btn-inverse"><?=$ad->cf_jobtype?></a>
        <?endif?>
        <?if ( ! in_array($ad->id_location, array(0, 1))) :?>
            <a href="<?=Route::url('list', array('category'=>$ad->category->seoname, 'location'=>$ad->location->seoname))?>"><span><i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?></span></a>
        <?endif?>
        <span><?=_e('Posted on ')?><?= Date::format($ad->published, core::config('general.date_format'))?></span>
        <?if ($ad->favorited > 0) :?>
	        <span class="add-favorite">
	        	<i class="glyphicon glyphicon-heart"></i>
	        	<i><?=$ad->favorited?></i><?=_e("times favorited")?>
			</span>
		<?endif?>
		<?if (Core::config('advertisement.reviews')==1):?>
            <span>
	            <a class="btn btn-inverse" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>" >
	                <?if ($ad->rate!==NULL):?>
	                    <?for ($i=0; $i < round($ad->rate,1); $i++):?>
	                        <span class="glyphicon glyphicon-star"></span>
	                    <?endfor?>
	                <?else:?>
	                    <?=_e('Leave a review')?>
	                <?endif?>
	            </a>
            </span>
        <?endif?>
    </div>
</div>
<?if (Theme::get('header_ad_possible')!=''):?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 header-ad-room">
                <?=(Theme::get('header_ad_possible')!='')?Theme::get('header_ad_possible'):''?>
            </div>
        </div>
    </div>
<?endif?>
<section id="main">
	<div class="container">
		<?=Alert::show()?>
		<div class="row">
			<div class="col-xs-12">
			    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
			</div>
		    <?if (Theme::landing_single_ad() == FALSE):?>
		    <?foreach ( Widgets::render('header') as $widget):?>
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		            <div class="header-widget">
		            	<?=$widget?>
            		</div>
		        </div>
		    <?endforeach?>
		    <?endif?>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-9">
	        	<!-- PAYPAL buttons to featured and to top -->
				<?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
					(Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
					<?if((core::config('payment.pay_to_go_on_top') > 0
						AND core::config('payment.to_top') != FALSE )
						OR (core::config('payment.pay_to_go_on_feature') > 0
						AND core::config('payment.to_featured') != FALSE)):?>

						<?if(core::config('payment.pay_to_go_on_top') > 0 && core::config('payment.to_top') != FALSE):?>
							<div id="recomentadion" class="well recomentadion clearfix text-center">
								<p class="text-info"><?=_e('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></p>
								<a class="btn btn-inverse" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Top!')?></a><br />
							</div>
						<?endif?>
						<?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
							<div id="recomentadion" class="well recomentadion clearfix text-center">
								<p class="text-info"><?=_e('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></p>
								<a class="btn btn-inverse" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Featured!')?></a>
							</div>
						<?endif?>
					<?endif?>
				<?endif?>
				<!-- end paypal button -->
	            <?if ( ! core::config('advertisement.description') OR core::config('advertisement.description')!=FALSE):?>
	            	<p><?= Text::bb2html($ad->description,TRUE)?></p>
	            <?endif?>
                <?=$ad->btc()?>
			    <div class="tabbed">
        			<ul>
                        <?if (core::count($cf_list)>0):?>
        				<li><button class="custom active"><i class="fa fa-list"></i><?=_e("Custom info")?></button></li>
                        <?endif?>

        				<?if(core::config('advertisement.sharing')==1):?>
                        <li><button class="share"><i class="fa fa-share-alt"></i><?=_e("Share")?></button></li>
                        <?endif?>

        				<?if (core::config('advertisement.map')==1 AND $ad->latitude AND $ad->longitude):?>
                        <li><button class="map"><i class="fa fa-map-marker"></i><?=_e("Map")?></button></li>
                        <?endif?>

                        <?if (core::config('advertisement.qr_code')==1):?>
                        <li><button class="qr"><i class="fa fa-qrcode"></i><?=_e("QR code")?></button></li>
                        <?endif?>
        			</ul>
        		</div>
        		<!-- Custom fields -->
        		<?if (core::count($cf_list)>0):?>
	        		<div id="custom-fields-container" class="well tabbed-content">
						<?foreach ($cf_list as $name => $value):?>
							<?if ( ! isset($ad->cf_companylogo) OR ($value != $ad->cf_companylogo)):?>
					            <?if($value=='checkbox_1'):?>
					                <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
					            <?elseif($value=='checkbox_0'):?>
					                <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
					            <?else:?>
					                <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
						                <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
						                	<p><b><?=$name?></b>: <?=$value?></p>
						                <?endif?>
						            <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
					                    <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
					                        <p><b><?=$name?></b>: <?=$value?></p>
					                    <?endif?>
					                <?else:?>
                                        <?if(is_string($name)):?>
                                            <p><b><?=$name?></b>: <?=$value?></p>
                                        <?else:?>
                                            <p><?=$value?></p>
                                        <?endif?>
					                <?endif?>
					            <?endif?>
					        <?endif?>
					    <?endforeach?>
				    </div>
			    <?endif?>
			    <!-- sharing -->
		        <?if(core::config('advertisement.sharing')==1):?>
		        	<div id="share-container" class="well hide tabbed-content">
		            	<?=View::factory('share')?>
		            </div>
		        <?endif?>
		        <!-- Google map -->
		        <?if ($ad->map() !== FALSE):?>
			        <div id="maps-container" class="gmap hide tabbed-content">
        				<?=$ad->map()?>
			        </div>
		        <?endif?>

		        <?if (core::config('advertisement.qr_code')==1):?>
		        	<div id="qr-container" class="qr hide tabbed-content well">
			        	<?=$ad->qr()?>
			        </div>
		        <?endif?>
		        <?endif?>
		        <div class="btn-group btn-group-justified" role="group">
		        	<?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1) AND $ad->price != NULL AND $ad->price > 0):?>
			            <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
			                <div class="btn-group" role="group">
                                <?if($ad->status != Model_Ad::STATUS_SOLD):?>
                                    <a class="btn btn-primary" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>">
                                        <i class="fa fa-money" aria-hidden="true"></i>
    			                            &nbsp;&nbsp;<?=_e('Buy Now')?>
                                    </a>
                                <?else:?>
                                    <a class="btn btn-primary disabled">
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                            &nbsp;&nbsp;<?=_e('Sold')?>
                                    </a>
                                <?endif?>
			                </div>
			            <?endif?>
                    <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary" type="button" href="<?=$ad->cf_file_download?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                &nbsp;&nbsp;<?=_e('Download')?>
                            </a>
                        </div>
			        <?endif?>
    		        <?if ($ad->can_contact()):?>
    					<div class="btn-group" role="group">
    			            <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
    			                <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
    			                    <i class="glyphicon glyphicon-envelope"></i>
    			                    <?=_e('Send Message')?>
    			                </a>
    			            <?else :?>
    			                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#contact-modal"><i class="glyphicon glyphicon-envelope"></i> <?=_e('Send Message')?></button>
    			            <?endif?>
                            <div id="contact-modal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                                            <h3><?=_e('Contact')?></h3>
                                        </div>
                                        <div class="modal-body">

                                            <?=Form::errors()?>

                                            <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'form-horizontal well', 'enctype'=>'multipart/form-data'))?>
                                            <fieldset>
                                                <?if (!Auth::instance()->get_user()):?>
                                                    <div class="form-group">
                                                        <?= FORM::label('name', _e('Name'), array('class'=>'col-sm-2 control-label', 'for'=>'name'))?>
                                                        <div class="col-sm-6 col-xs-11 ">
                                                            <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class'=>'form-control', 'id' => 'name', 'required'))?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <?= FORM::label('email', _e('Email'), array('class'=>'col-sm-2 control-label', 'for'=>'email'))?>
                                                        <div class="col-sm-6 col-xs-11 ">
                                                            <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class'=>'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                                        </div>
                                                    </div>
                                                <?endif?>
                                                <?if(core::config('general.messaging') != TRUE):?>
                                                    <div class="form-group">
                                                        <?= FORM::label('subject', _e('Subject'), array('class'=>'col-sm-2 control-label', 'for'=>'subject'))?>
                                                        <div class="col-sm-6 col-xs-11 ">
                                                            <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class'=>'form-control', 'id' => 'subject'))?>
                                                        </div>
                                                    </div>
                                                <?endif?>
                                                <div class="form-group">
                                                    <?= FORM::label('message', _e('Message'), array('class'=>'col-sm-2 control-label', 'for'=>'message'))?>
                                                    <div class="col-sm-6 col-xs-11">
                                                        <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                                    </div>
                                                </div>
                                                <?if(core::config('general.messaging') AND
                                                    core::config('advertisement.price') AND
                                                    core::config('advertisement.contact_price')):?>
                                                    <div class="form-group">
                                                        <?= FORM::label('price', _e('Price'), array('class'=>'col-sm-2 control-label', 'for'=>'price'))?>
                                                        <div class="col-sm-6 col-xs-11">
                                                            <?= FORM::input('price', Core::post('price'), array('placeholder' => html_entity_decode(i18n::money_format(1, $ad->currency())), 'class' => 'form-control', 'id' => 'price', 'type'=>'text'))?>
                                                        </div>
                                                    </div>
                                                <?endif?>
                                                <!-- file to be sent-->
                                                <?if(core::config('advertisement.upload_file') AND core::config('general.messaging') != TRUE):?>
                                                    <div class="form-group">
                                                        <?= FORM::label('file', _e('File'), array('class'=>'col-sm-2 control-label', 'for'=>'file'))?>
                                                        <div class="col-sm-6 col-xs-11">
                                                            <?= FORM::file('file', array('placeholder' => __('File'), 'class'=>'form-control', 'id' => 'file'))?>
                                                        </div>
                                                    </div>
                                                <?endif?>
                                                <?if (core::config('advertisement.captcha') != FALSE):?>
                                                    <div class="form-group">
                                                        <?= FORM::label('captcha', _e('Captcha'), array('class'=>'col-sm-2 control-label', 'for'=>'captcha'))?>
                                                        <div class="col-sm-6 col-xs-11">
                                                            <?if (Core::config('general.recaptcha_active')):?>
                                                                <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                                            <?else:?>
                                                                <?=captcha::image_tag('contact')?><br />
                                                                <?= FORM::input('captcha', "", array('class'=>'form-control', 'id' => 'captcha', 'required'))?>
                                                            <?endif?>
                                                        </div>
                                                    </div>
                                                <?endif?>
                                                <div class="modal-footer">
                                                    <?= FORM::button(NULL, _e('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                                                </div>
                                            </fieldset>
                                            <?= FORM::close()?>
                                        </div>
                                    </div>
                                </div>
                            </div>
    			        </div>
    				    <?if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
    				    	<div class="btn-group" role="group">
    				            <a class="btn btn-warning" href="tel:<?=$ad->phone?>"><?=_e('Phone').': '.$ad->phone?></a>
    				        </div>
    				    <?endif?>
    		        <?endif?>
                </div>
			</div>
			<sidebar class="col-xs-12 col-sm-12 col-md-3">
				<?if (isset($ad->cf_companylogo) AND $ad->cf_companylogo) :?>
					<p class="text-center"><?=HTML::picture($ad->cf_companylogo, ['h' => 200], ['1200px' => ['h' => '200'],'992px' => ['h' => '200'], '768px' => ['h' => '200'], '480px' => ['h' => '200'], '320px' => ['h' => '200']], array('class' => 'img-responsive center-block','alt' => HTML::chars(isset($ad->cf_company)) ? HTML::chars($ad->cf_company) : HTML::chars($ad->user->name)))?><br></p>
				<?elseif ($ad->user->has_image) :?>
					<p class="text-center"><?=HTML::picture($ad->user->get_profile_image(), ['h' => 200], ['1200px' => ['h' => '200'],'992px' => ['h' => '200'], '768px' => ['h' => '200'], '480px' => ['h' => '200'], '320px' => ['h' => '200']], array('class' => 'img-responsive center-block', 'alt' => HTML::chars(isset($ad->cf_company)) ? HTML::chars($ad->cf_company) : HTML::chars($ad->user->name)))?>
					<br></p>
				<?endif?>
				<h3 class="sidebar-title company-name"><?=(isset($ad->cf_company))?$ad->cf_company:$ad->user->name?> <?=$ad->user->is_verified_user();?></h3>
		        <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
		            <p><?=$ad->address?></p>
		        <?endif?>
	            <?if (Valid::url($ad->website)):?>
		           	<p><a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a></p>
		        <?endif?>
	            <h3 class="sidebar-title"><?=_e("About")?> <?=(isset($ad->cf_company))?$ad->cf_company:$ad->user->name?></h3>
	            <p class="company-description">
                <?=(isset($ad->cf_companydescription))?$ad->cf_companydescription:$ad->user->description?>
                </p>

				<?$images = $ad->get_images()?>
				<?if($images):?>
				<h3 class="sidebar-title"><?=_e("Work environment")?></h3>
					<div class="row">
						<div id="gallery">
							<?foreach ($images as $path => $value):?>
								<?if( isset($value['thumb']) AND isset($value['image']) ):?>
									<div class="col-xs-12 col-md-6">
										<a href="<?= $value['image']?>" class="thumbnail gallery-item" data-gallery>
											<img src="<?=Core::imagefly($value['image'],200,200)?>" class="img-rounded" alt="">
										</a>
									</div>
								<?endif?>
							<?endforeach?>
						</div>
					</div>
				<?endif?>
				<?if(Theme::get('sidebar_position')!='none'):?>
					<?foreach ( Widgets::render('sidebar') as $widget):?>
				        <div class="sidebar-widget">
				           	<?=$widget?>
				        </div>
				    <?endforeach?>
				<?endif?>
			</sidebar>
		</div>
        <?=$ad->related()?>
        <?=$ad->comments()?>
        <?if(core::config('advertisement.report')==1):?>
	        <?=$ad->flagad()?>
	    <?endif?>
        <?=$ad->structured_data()?>
	</div>
</section>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
