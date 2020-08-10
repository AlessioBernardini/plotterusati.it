<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header" id="titolonuoviannunci">
	<h1><?=_e('Publish new advertisement')?></h1>
</div>
<?if (Theme::get('premium')==1 AND core::count($providers = Social::get_providers())>0 AND !Auth::instance()->get_user()):?>
	<?foreach ($providers as $key => $value):?>
        <?if($value['enabled']):?>
        	<?if(strtolower($key) == 'live')$key='windows'?>
            <a  class=" zocial <?=strtolower($key)?> social-btn" href="<?=Route::url('default',array('controller'=>'social','action'=>'login','id'=>strtolower($key)))?>"><?=$key?></a>
        <?endif?>
    <?endforeach?>
<?endif?>

<div class="row">
	<div class="col-xs-12">
	    <div class="wizard">
	        <div class="wizard-inner">
	            <div class="connecting-line"></div>
	            <ul class="nav nav-tabs" role="tablist">
	                <li role="presentation" class="active">
	                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="<?=__('Ad Information')?>">
	                        <span class="round-tab">
	                            <i class="fa fa-folder-open"></i>
	                        </span>
	                    </a>
	                </li>
	                <?if(core::config("advertisement.num_images") > 0 ):?>
		                <li role="presentation" class="disabled">
		                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="<?=__('Ad Images')?>">
		                        <span class="round-tab">
		                            <i class="fa fa-image"></i>
		                        </span>
		                    </a>
		                </li>
		            <?endif?>
                    <?if($form_show['price'] != FALSE OR core::config('payment.stock') OR core::count(Model_Field::get_all()) > 0) :?>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="<?=__('Ad Details')?>">
                                <span class="round-tab">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </a>
                        </li>
                    <?endif?>
	                <li role="presentation" class="disabled">
	                    <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="<?=__('Contact Information & Publish')?>">
	                        <span class="round-tab">
	                            <i class="fa fa-user"></i>
	                        </span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	        <?= FORM::open(Route::url('post_new',array('controller'=>'new','action'=>'index')), array('class'=>'form-horizontal post_new', 'id'=>'publish-new', 'enctype'=>'multipart/form-data'))?>
	            <fieldset class="tab-content">
	                <div class="tab-pane active" role="tabpanel" id="step1">
						<h3><?=_e('Ad Information')?></h3>
						<? if (Core::config('general.multilingual')) : ?>
							<div class="form-group">
								<?= Form::label('locale', _e('Language'), array('class'=>'col-xs-12 col-sm-2 control-label', 'for' => 'locale')) ?>
								<div class="col-sm-10">
									<?= Form::select('locale', i18n::get_selectable_languages(), Core::request('locale', i18n::$locale), array('class' => 'form-control', 'id' => 'locale', 'required')) ?>
								</div>
							</div>
						<? endif ?>
	                    <div class="form-group">
							<?= FORM::label('title', _e('Title'), array('class'=>'col-xs-12 col-sm-2 control-label', 'for'=>'title'))?>
							<div class="col-sm-10">
								<?= FORM::input('title', Request::current()->post('title'), array('placeholder' => __('Title'), 'class' => 'form-control col-xs-12 col-sm-10', 'id' => 'title', 'required'))?>
							</div>
						</div>
						<!-- category select -->
						<div class="form-group">
							<?= FORM::label('category', _e('Category'), array('class'=>'col-xs-12 col-sm-2 control-label', 'for'=>'category'))?>
							<div class="col-sm-10" id="descrizione-categoria">
								<div id="category-chained" class="row <?=($id_category === NULL) ? NULL : 'hidden'?>"
									data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>"
									data-price0="<?=i18n::money_format(0)?>"
									<?=(core::config('advertisement.parent_category')) ? 'data-isparent' : NULL?>
								>
									<div id="select-category-template" class="col-md-4 hidden">
										<select class="disable-select2 select-category" placeholder="<?=__('Pick a category...')?>"></select>
									</div>
									<div id="paid-category" class="col-md-12 hidden">
										<span class="help-block" data-title="<?=__('Category %s is a paid category: %d')?>"><span class="text-warning"></span></span>
									</div>
								</div>
								<?if($id_category !== NULL):?>
									<div id="category-edit" class="row">
										<div class="col-md-8">
											<div class="input-group">
												<input class="form-control" type="text" placeholder="<?=$selected_category->translate_name() ?>" disabled>
												<span class="input-group-btn">
													<button class="btn btn-default" type="button"><?=_e('Select another')?></button>
												</span>
											</div>
										</div>
									</div>
								<?endif?>
								<input id="category-selected" name="category" value="<?=$id_category?>" class="form-control invisible" style="height: 0; padding:0; width:1px; border:0;" required></input>
							</div>
						</div>

						<!-- location select -->
						<?if($form_show['location'] != FALSE):?>
							<div class="form-group">
								<?= FORM::label('locations', _e('Location'), array('class'=>'col-xs-12 col-sm-2 control-label label-left','for'=>'location'))?>
								<div class="col-sm-10">
									<div id="location-chained" class="row <?=($id_location === NULL) ? NULL : 'hidden'?>" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'locations'))?>">
										<div id="select-location-template" class="col-md-4 hidden">
											<select class="disable-select2 select-location" placeholder="<?=__('Pick a location...')?>"></select>
										</div>
									</div>
									<?if($id_location !== NULL):?>
										<div id="location-edit" class="row">
											<div class="col-md-8">
												<div class="input-group">
													<input class="form-control" type="text" placeholder="<?=$selected_location->translate_name() ?>" disabled>
													<span class="input-group-btn">
														<button class="btn btn-default" type="button"><?=_e('Select another')?></button>
													</span>
												</div>
											</div>
										</div>
									<?endif?>
									<input id="location-selected" name="location" value="<?=$id_location?>" class="form-control invisible" style="height: 0; padding:0; width:1px; border:0;" required></input>
								</div>
							</div>
						<?endif?>

						<div class="form-group">
							<?= FORM::label('description', _e('Description'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'description', 'spellcheck'=>TRUE))?>
							<div class="col-xs-12 col-sm-10">
                                <?=FORM::textarea('description', Core::post('description', ''), array('class'=>'form-control'.((Core::config("advertisement.description_bbcode"))? NULL:' disable-bbcode'),
                                    'name'=>'description',
                                    'id'=>'description',
                                    'rows'=>10,
                                    'required',
                                    'data-bannedwords' => (core::config('advertisement.validate_banned_words') AND core::config('advertisement.banned_words') != '') ? json_encode(explode(',', core::config('advertisement.banned_words'))) : '',
                                    'data-error' => __('This field must not contain banned words ({0})')))?>
							</div>
						</div>
	                    <ul class="list-inline pull-right">
	                        <li><button type="button" class="btn btn-primary next-step hvr-icon-forward"><?=_e('Save &amp; continue')?></button></li>
	                    </ul>
	                </div>
	                <?if(core::config("advertisement.num_images") > 0 ):?>
		                <div class="tab-pane" role="tabpanel" id="step2">
		                    <h3><?=_e('Ad Images')?></h3>
		                    <div class="form-group images"
								data-max-files="<?=core::config("advertisement.num_images")?>"
								data-max-image-size="<?=core::config('image.max_image_size')?>"
								data-image-width="<?=core::config('image.width')?>"
								data-image-height="<?=core::config('image.height') ? core::config('image.height') : ''?>">
								<div class="col-md-12">
									<label><?=_e('Images')?></label>
									<div class="dropzone" id="images-dropzone"></div>
									<p class="help-block"><?=__('Up to')?> <?=core::config('advertisement.num_images')?> <?=__('images allowed.')?></p>
									<p class="help-block"><?=join(' '.__('or').' ', array_filter(array_merge(array(join(', ', array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), 0, -2))), array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), -2))))?> <?=__('formats only')?>.</p>
									<p class="help-block"><?=__('Maximum file size of')?> <?=core::config('image.max_image_size')?>MB.</p>
								</div>
							</div>
		                    <ul class="list-inline pull-right">
		                        <li><button type="button" class="btn btn-default prev-step"><?=_e('Previous step')?></button></li>
		                        <li><button type="button" class="btn btn-primary next-step hvr-icon-forward"><?=_e('Save &amp; continue')?></button></li>
		                    </ul>
		                </div>
		            <?endif?>
                    <?if($form_show['price'] != FALSE OR core::config('payment.stock') OR core::count(Model_Field::get_all()) > 0) :?>
                        <div class="tab-pane" role="tabpanel" id="step3">
                            <h3><?=_e('Ad Details')?></h3>
                            <?if($form_show['price'] != FALSE):?>
                            <div class="form-group required">
                                <div class="col-xs-12 col-sm-2 control-label">
                                <?= FORM::label('price', _e('Price'), array('for'=>'price'))?>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <div class="input-prepend">
                                        <?= FORM::input('price', Request::current()->post('price'), array('placeholder' => html_entity_decode(html_entity_decode(i18n::money_format(1))), 'class' => 'form-control', 'id' => 'price', 'required'=>'required', 'type'=>'text', 'data-error' => __('Please enter only numbers.'), 'data-decimal_point' => i18n::get_decimal_point()))?>
                                    </div>
                                </div>
                            </div>
                            <?endif?>
                            <?if(core::config('payment.stock')):?>
                            <div class="form-group">
                                <?= FORM::label('stock', _e('In Stock'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'stock'))?>
                                <div class="col-xs-12 col-sm-10">
                                    <div class="input-prepend">
                                        <?= FORM::input('stock', Core::post('stock', 1), array('placeholder' => '10', 'class' => 'form-control', 'id' => 'stock', 'type'=>'text'))?>
                                    </div>
                                </div>
                            </div>
                            <?endif?>
                            <!-- Fields coming from custom fields feature -->
                            <div id="custom-fields" data-customfield-values='<?=json_encode(Request::current()->post())?>'>
                                <div id="custom-field-template" class="hidden form-group">
                                    <div class="col-xs-12 col-sm-2 control-label">
                                        <div data-label></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-10 pull-right">
                                        <div data-input></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /endcustom fields -->
                            <ul class="list-inline pull-right">
                                <li><button type="button" class="btn btn-default prev-step"><?=_e('Previous step')?></button></li>
                                <li><button type="button" class="btn btn-primary btn-info-full next-step hvr-icon-forward"><?=_e('Save &amp; continue')?></button></li>
                            </ul>
                        </div>
                    <?endif?>
	                <div class="tab-pane" role="tabpanel" id="complete">
	                    <h3><?=_e('Contact Information & Publish')?></h3>
						<?if (!Auth::instance()->get_user()):?>
							<div class="form-group">
								<?= FORM::label('name', _e('Name'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'name'))?>
								<div class="col-xs-12 col-sm-10">
									<?= FORM::input('name', Request::current()->post('name'), array('class'=>'form-control', 'id'=>'name', 'required', 'placeholder'=>__('Name')))?>
								</div>
							</div>
							<div class="form-group">
								<?= FORM::label('email', (core::config('payment.paypal_seller')==1)?_e('Paypal Email'):_e('Email'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'email'))?>
								<div class="col-xs-12 col-sm-10">
									<?= FORM::input('email', Request::current()->post('email'), array('class'=>'form-control',
										'id'=>'email',
										'type'=>'email',
										'required',
										'placeholder' => (core::config('payment.paypal_seller')==1) ? __('Paypal Email') : __('Email'),
										'data-domain' => (core::config('general.email_domains') != '') ? json_encode(explode(',', core::config('general.email_domains'))) : '',
										'data-error' => __('Email must contain a valid email domain')
										))?>
								</div>
							</div>
							<?foreach(Model_UserField::get_all() as $name=>$field):?>
                                <?if($field['show_register']):?>
                                    <div class="form-group">
                                        <?$cf_name = 'ucf_'.$name?>
                                        <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                                            $select = array(''=>'');
                                            foreach ($field['values'] as $select_name) {
                                                $select[$select_name] = $select_name;
                                            }
                                        } else $select = $field['values']?>
                                        <?= FORM::label('ucf_'.$name, $field['label'], array('class' => 'control-label col-xs-12 col-sm-2', 'for'=>'ucf_'.$name))?>
                                        <div class="col-xs-12 col-sm-10">
                                            <?=Form::cf_form_field('ucf_'.$name, array(
                                                'display'   => $field['type'],
                                                'label'     => $field['label'],
                                                'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                                                'default'   => $field['values'],
                                                'options'   => (!is_array($field['values']))? $field['values'] : $select,
                                                'required'  => $field['required'],
                                                'class'     => 'form-control'
                                            ))?>
                                        </div>
                                    </div>
                                <?endif?>
                            <?endforeach?>
						<?endif?>
	                    <?if($form_show['website'] != FALSE):?>
						<div class="form-group">
							<?= FORM::label('website', _e('Website'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'website'))?>
							<div class="col-xs-12 col-sm-10">
								<?= FORM::input('website', Request::current()->post('website'), array('placeholder' => core::config("general.base_url"), 'class' => 'form-control', 'id' => 'website'))?>
							</div>
						</div>
						<?endif?>
						<?if($form_show['phone'] != FALSE):?>
						<div class="form-group">
							<?= FORM::label('phone', _e('Phone'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'phone'))?>
							<div class="col-xs-12 col-sm-10">
								<?if (Auth::instance()->get_user()):?>
                                    <?=FORM::input('phone', Auth::instance()->get_user()->phone, array('class'=>'form-control input', 'id'=>'phone', 'data-country' => core::config('general.country')))?>
                                <?else:?>
                                    <?=FORM::input('phone', Request::current()->post('phone'), array('class'=>'form-control input', 'id'=>'phone', 'data-country' => core::config('general.country')))?>
                                <?endif?>
							</div>
						</div>
						<?endif?>
						<?if($form_show['address'] != FALSE):?>
                            <?
                                $address_default_value = Core::post('address');
                                $latitude_default_value = Core::post('latitude');
                                $longitude_default_value = Core::post('longitude');

                                if($current_user = Auth::instance()->get_user())
                                {
                                    $address_default_value = Core::post('address', $current_user->address);
                                    $latitude_default_value = Core::post('latitude', $current_user->latitude);
                                    $longitude_default_value = Core::post('longitude', $current_user->longitude);
                                }
                            ?>
							<div class="form-group">
								<?= FORM::label('address', _e('Address'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'address'))?>
								<?if(core::config('advertisement.map_pub_new') AND Core::is_HTTPS()):?>
									<div class="col-xs-12 col-sm-10">
										<div class="input-group">
											<?= FORM::input('address', $address_default_value, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
											<span class="input-group-btn">
												<button class="btn btn-default locateme" type="button"><?=_e('Locate me')?></button>
											</span>
										</div>
									</div>
								<?else:?>
								<div class="col-xs-12 col-sm-10">
									<?= FORM::input('address', $address_default_value, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
								</div>
								<?endif?>
							</div>
							<?if(core::config('advertisement.map_pub_new')):?>
								<div class="form-group">
									<div class="col-xs-12 col-sm-10 col-sm-offset-2">
										<div class="popin-map-container">
											<div class="map-inner" id="map"
                                                data-lat="<?= $latitude_default_value ? $latitude_default_value : core::config('advertisement.center_lat') ?>"
                                                data-lon="<?= $longitude_default_value ? $longitude_default_value : core::config('advertisement.center_lon') ?>"
												data-zoom="<?=core::config('advertisement.map_zoom')?>"
												style="height:200px;max-width:400px">
											</div>
										</div>
                                        <input type="hidden" name="latitude" id="publish-latitude" value="<?= $latitude_default_value ?>" <?=is_null($latitude_default_value) ? 'disabled': NULL?>>
                                        <input type="hidden" name="longitude" id="publish-longitude" value="<?= $longitude_default_value ?>" <?=is_null($longitude_default_value) ? 'disabled': NULL?>>
									</div>
								</div>
							<?endif?>
						<?endif?>
						<?if(core::config('advertisement.tos') != ''):?>
							<div class="form-group">
								<div class="col-xs-12 col-sm-10 col-sm-offset-2">
									<div class="checkbox">
						                <label>
						                  	<input type="checkbox" required name="tos" id="tos"/>
											<a target="_blank" href="<?=Route::url('page', array('seotitle'=>core::config('advertisement.tos')))?>"> <?=_e('Terms of service')?></a>
										</label>
									</div>
								</div>
							</div>
						<?endif?>
						<?if ($form_show['captcha'] != FALSE):?>
						<div class="form-group">
							<?if (Core::config('general.recaptcha_active')):?>
								<div class="col-xs-12">
                                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                    <?if (Core::config('general.recaptcha_type') == 'checkbox'):?>
                                        <input type="hidden" class="hidden-recaptcha required" name="hidden-recaptcha" id="hidden-recaptcha">
                                    <?endif?>
								</div>
							<?else:?>
								<?= FORM::label('captcha', _e('Captcha'), array('class'=>'control-label col-xs-12 col-sm-2', 'for'=>'captcha'))?>
								<span id="helpBlock" class="help-block"><?=captcha::image_tag('publish_new')?></span>
								<div class="col-xs-12 col-sm-10 col-sm-offset-2">
									<?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required', 'data-error' => __('Captcha is not correct')))?>
								</div>
							<?endif?>
						</div>
						<?endif?>
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
							<?= FORM::button('submit_btn', _e('Publish new'), array('type'=>'submit', 'id' => 'publish-new-btn', 'data-swaltitle' => __('Are you sure?'), 'data-swaltext' => __('It looks like you have been about to publish a new advertisement, if you leave before submitting your changes will be lost.'), 'class'=>'btn btn-primary pull-right', 'action'=>Route::url('post_new',array('controller'=>'new','action'=>'index'))))?>
							<?if (!Auth::instance()->get_user()):?>
							<p class="help-block"><?=_e('User account will be created')?></p>
							<?endif?>
							<ul class="list-inline pull-right">
    							<li><button type="button" class="btn btn-default prev-step"><?=_e('Previous step')?></button></li>
		                    </ul>
							</div>
							<?if ( ! Core::config('advertisement.leave_alert')):?>
				                <input type="hidden" name="leave_alert" value="0" disabled>
				            <?endif?>
						</div>
	                </div>
	                <div class="clearfix"></div>
	            </fieldset>
	        <?= FORM::close()?>
	    </div>
	</div>
</div>
<!--/well-->
<div class="modal modal-statc fade" id="processing-modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-body">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?=_e('Processing...')?></h4>
				</div>
				<div class="modal-body">
					<div class="progress progress-striped active">
						<div class="progress-bar" style="width: 100%"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?if (core::config("advertisement.num_images") > 0 AND core::config('image.upload_from_url')):?>
    <?for ($i=0; $i < core::config("advertisement.num_images") ; $i++):?>
        <div class="modal fade" id="<?='urlInputimage'.$i?>" tabindex="-1" role="dialog" aria-labelledby="<?='urlInputimage'.$i?>Label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="imageURL">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="<?='urlInput'.$i?>Label"><?=_e('Insert Image')?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?=_e('Image URL')?></label>
                                <input name="<?='image'.$i?>" class="note-image-url form-control" type="text">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><?=_e('Insert Image')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?endfor?>
<?endif?>

<?=View::factory('pages/ad/new_scripts')?>
