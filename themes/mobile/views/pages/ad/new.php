<?php defined('SYSPATH') or die('No direct script access.');?>


	<div class="page-header">
		<h1><?=__('Publish new advertisement')?></h1>
	</div>
	<?if (Theme::get('premium')==1 AND core::count($providers = Social::get_providers())>0 AND !Auth::instance()->get_user()):?>
		<?foreach ($providers as $key => $value):?>
	        <?if($value['enabled']):?>
	        	<?if(strtolower($key) == 'live')$key='windows'?>
	            <a  target="_blank" class=" zocial icon <?=strtolower($key)?> social-btn" href="<?=Route::url('default',array('controller'=>'social','action'=>'login','id'=>strtolower($key)))?>"><?=$key?></a>
	        <?endif?>
	    <?endforeach?>
    <?endif?>

		<?= FORM::open(Route::url('post_new',array('controller'=>'new','action'=>'index')), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data', 'data-ajax'=>'false'))?>
			<fieldset data-mini="true">

				<? if (Core::config('general.multilingual')) : ?>
					<div class="control-group">
						<?= FORM::label('locale', __('Language'), array('class' => 'control-label', 'for' => 'locale')) ?>
						<div class="controls">
							<?= Form::select('locale', i18n::get_selectable_languages(), Core::request('locale', i18n::$locale), array('class' => 'input-xlarge', 'id' => 'locale', 'required')) ?>
						</div>
					</div>
				<? endif ?>

				<div class="control-group">
					<?= FORM::label('title', __('Title'), array('class'=>'control-label', 'for'=>'title'))?>
					<div class="controls">
						<?= FORM::input('title', Request::current()->post('title'), array('placeholder' => __('Title'), 'class' => 'input-xlarge', 'id' => 'title', 'required'))?>
					</div>
				</div>

				<div class="control-group">
                    <?= FORM::label('category', __('Category'), array('class'=>'control-label', 'for'=>'category' , 'multiple'))?>
                    <div class="controls">
                        <select name="category" id="category" class="input-xlarge" required>
                        <option></option>
                        <?$categories = Model_Category::get_as_array(); $order_categories = Model_Category::get_multidimensional(); ?>
                        <?function lili($item, $key,$cats){?>
                        <?if(!core::config('advertisement.parent_category')):?>
		                    <?if($cats[$key]['id_category_parent'] != 1):?>
		                        <option value="<?=$cats[$key]['id']?>" data-id="<?=$cats[$key]['id']?>"><?=$cats[$key]['translate_name']?></option>
		                    <?endif?>
		                <?else:?>
		                    <option value="<?=$cats[$key]['id']?>" data-id="<?=$cats[$key]['id']?>"><?=$cats[$key]['translate_name']?></option>
		                <?endif?>
                            <?if (core::count($item)>0):?>
                            <optgroup label="<?=$cats[$key]['translate_name']?>">
                                <? if (is_array($item)) array_walk($item, 'lili', $cats);?>
                                </optgroup>
                            <?endif?>
                        <?}array_walk($order_categories, 'lili', $categories);?>
                        </select>
                    </div>
                </div>
                <?$locations = Model_Location::get_as_array(); $order_locations = Model_Location::get_multidimensional(); ?>
                <?if(core::count($locations) > 1):?>
                    <?if($form_show['location'] != FALSE):?>
                    <div class="control-group">
                        <?= FORM::label('location', __('Location'), array('class'=>'control-label', 'for'=>'location' , 'multiple'))?>
                        <div class="controls">
                            <select name="location" id="location" class="input-xlarge"   required>
                            <option></option>
                            <?function lolo($item, $key,$locs){?>
                            <option value="<?=$key?>"><?=$locs[$key]['translate_name']?></option>
                                <?if (core::count($item)>0):?>
                                <optgroup label="<?=$locs[$key]['translate_name']?>">
                                    <? if (is_array($item)) array_walk($item, 'lolo', $locs);?>
                                <?endif?>
                            <?}array_walk($order_locations, 'lolo',$locations);?>
                            </select>
                        </div>
                    </div>
					<?endif?>
				<?endif?>

				<?if($form_show['description'] != FALSE):?>
					<div class="control-group">
						<?= FORM::label('description', __('Description'), array('class'=>'control-label', 'for'=>'description', 'spellcheck'=>TRUE))?>
						<div class="controls">
							<?= FORM::textarea('description', Request::current()->post('description'), array('class'=>'span6', 'name'=>'description', 'id'=>'description' ,  'rows'=>10, 'required'))?>
						</div>
					</div>
				<?endif?>
				<?if(Theme::get('upload_images_mobile')):?>
					<?for ($i=0; $i < core::config("advertisement.num_images") ; $i++):?>
					<div class="control-group">
						<?= FORM::label('images', __('Images'), array('class'=>'control-label', 'for'=>'images'.$i))?>
						<div class="controls">
							<input type="file" name="<?='image'.$i?>" id="<?='fileInput'.$i?>" />
						</div>
					</div>
					<?endfor?>
					<p class="help-block"><?=__('Up to')?> <?=core::config('advertisement.num_images')?> <?=__('images allowed.')?></p>
					<p class="help-block"><?=join(' '.__('or').' ', array_filter(array_merge(array(join(', ', array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), 0, -2))), array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), -2))))?> <?=__('formats only')?>.</p>
					<p class="help-block"><?=__('Maximum file size of')?> <?=core::config('image.max_image_size')?>MB.</p>
				<?endif?>
				<?if($form_show['phone'] != FALSE):?>
				<div class="control-group">
					<?= FORM::label('phone', __('Phone'), array('class'=>'control-label', 'for'=>'phone'))?>
					<div class="controls">
						<?= FORM::input('phone', Request::current()->post('phone'), array('class'=>'input-xlarge', 'id'=>'phone', 'placeholder'=>__('Phone')))?>
					</div>
				</div>
				<?endif?>
				<?if($form_show['address'] != FALSE):?>
					<div class="control-group">
						<?= FORM::label('address', _e('Address'), array('for'=>'address'))?>
						<?if(core::config('advertisement.map_pub_new')):?>
							<?if (Core::is_HTTPS()):?>
								<div class="controls">
									<?= FORM::input('address', Request::current()->post('address'), array('class'=>'input-xlarge', 'id'=>'address', 'placeholder'=>__('Address')))?>
									<span class="input-group-btn">
										<button class="btn btn-default locateme" type="button"><?=_e('Locate me')?></button>
									</span>
								</div>
							<?else:?>
								<?=FORM::input('address', Request::current()->post('address'), array('class'=>'input-xlarge', 'id'=>'address', 'placeholder'=>__('Address')))?>
							<?endif?>
						<?else:?>
							<?= FORM::input('address', Request::current()->post('address'), array('class'=>'input-xlarge', 'id'=>'address', 'placeholder'=>__('Address')))?>
						<?endif?>
					</div>
					<?if(core::config('advertisement.map_pub_new')):?>
						<div class="popin-map-container">
							<div class="map-inner" id="map"
								data-lat="<?=core::config('advertisement.center_lat')?>"
								data-lon="<?=core::config('advertisement.center_lon')?>"
								data-zoom="<?=core::config('advertisement.map_zoom')?>"
								style="height:200px;max-width:400px;">
							</div>
						</div>
						<input type="hidden" name="latitude" id="publish-latitude" value="" disabled>
						<input type="hidden" name="longitude" id="publish-longitude" value="" disabled>
					<?endif?>
				<?endif?>
				<?if($form_show['price'] != FALSE):?>
				<div class="control-group">
					<?= FORM::label('price', __('Price'), array('class'=>'control-label', 'for'=>'price'))?>
					<div class="controls">
						<div class="input-prepend">
						<?= FORM::input('price', Request::current()->post('price'), array('placeholder' => html_entity_decode(html_entity_decode(i18n::money_format(1))), 'class' => 'input-large', 'id' => 'price', 'type'=>'number'))?>
						</div>
					</div>
				</div>
				<?endif?>
				<?if(core::config('payment.stock')):?>
				<div class="control-group">

					<div class="controls">
						<?= FORM::label('stock', __('In Stock'), array('class'=>'control-label', 'for'=>'stock'))?>
						<div class="input-prepend">
						<?= FORM::input('stock', Request::current()->post('stock'), array('placeholder' => '10', 'class' => 'input-large', 'id' => 'stock', 'type'=>'text'))?>
						</div>
					</div>
				</div>
				<?endif?>
				<?if($form_show['website'] != FALSE):?>
				<div class="control-group">
					<?= FORM::label('website', __('Website'), array('class'=>'control-label', 'for'=>'website'))?>
					<div class="controls">
						<?= FORM::input('website', Request::current()->post('website'), array('placeholder' => core::config("general.base_url"), 'class' => 'input-xlarge', 'id' => 'website'))?>
					</div>
				</div>
				<?endif?>
				<?if (!Auth::instance()->get_user()):?>
					<div class="control-group">
						<?= FORM::label('name', __('Name'), array('class'=>'control-label', 'for'=>'name'))?>
						<div class="controls">
							<?= FORM::input('name', Request::current()->post('name'), array('class'=>'input-xlarge', 'id'=>'name', 'required', 'placeholder'=>__('Name')))?>
						</div>
					</div>
					<div class="control-group">
						<?= FORM::label('email', (core::config('payment.paypal_seller')==1)?__('Paypal Email'):__('Email'), array('class'=>'control-label', 'for'=>'email'))?>
						<div class="controls">
							<?= FORM::input('email', Request::current()->post('email'), array('class'=>'input-xlarge', 'id'=>'email', 'type'=>'email' ,'required','placeholder'=>(core::config('payment.paypal_seller')==1)?__('Paypal Email'):__('Email')))?>
						</div>
					</div>
					<?foreach(Model_UserField::get_all() as $name=>$field):?>
			            <?if($field['show_register']):?>
			              	<div class="control-group">
				                <?$cf_name = 'ucf_'.$name?>
				                <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
				                  	$select = array(''=>'');
				                  	foreach ($field['values'] as $select_name) {
				                    	$select[$select_name] = $select_name;
			                  		}
				                } else $select = $field['values']?>
				                	<?= FORM::label('ucf_'.$name, $field['label'], array('class'=>'control-label', 'for'=>'ucf_'.$name))?>
				                <div class="col-xs-12">
				                  	<?=Form::cf_form_field('ucf_'.$name, array(
					                    'display'   => $field['type'],
					                    'label'     => $field['label'],
					                    'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
					                    'default'   => $field['values'],
					                    'options'   => (!is_array($field['values']))? $field['values'] : $select,
					                    'required'  => $field['required'],
				                  	))?>
				                </div>
			              	</div>
			            <?endif?>
			        <?endforeach?>
				<?endif?>
				<!-- Fields coming from custom fields feature -->
				<?if(isset($fields)):?>
				<?if (is_array($fields)):?>
					<?foreach($fields as $name=>$field):?>
					<div class="control-group" id="cf_new">

					<?if($field['type'] == 'select' OR $field['type'] == 'radio') {
						$select = array(''=>'');
						foreach ($field['values'] as $select_name) {
							$select[$select_name] = $select_name;
						}
					} else $select = $field['values']?>
    					<?=Form::cf_form_tag('cf_'.$name, array(
                            'display'   => $field['type'],
                            'label'     => $field['label'],
                            'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                            'options'	=> (!is_array($field['values']))? $field['values'] : $select,
                            'required'	=> $field['required'],
                            'categories'=> (isset($field['categories']))? $field['categories'] : "",),Request::current()->post('cf_'.$name))?>
                    </div>
					<?endforeach?>
				<?endif?>
				<?endif?>
				<!-- /endcustom fields -->
				<?if ($form_show['captcha'] != FALSE):?>
                    <div class="form-group">
                        <div class="col-md-5 col-sm-8 col-xs-8">
                            <?if (Core::config('general.recaptcha_active')):?>
                                <?=Captcha::recaptcha_display()?>
                                <div id="recaptcha3"></div>
                            <?else:?>
                                <?= FORM::label('captcha', _e('Captcha'), array('for'=>'captcha'))?>
                                <span id="helpBlock" class="help-block"><?=captcha::image_tag('publish_new')?></span>
                                <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required', 'data-error' => __('Captcha is not correct')))?>
                            <?endif?>
                        </div>
                    </div>
				<?endif?>
				<?if(core::config('advertisement.tos') != FALSE):?>
				<div class="control-group">
					<div class="controls">
                        <label class="checkbox">
                          <input type="checkbox" required name="tos" id="tos"/>
                          <a target="_blank" href="<?=Route::url('page', array('seotitle'=>'tos'))?>"> <?=__('Terms of service')?></a>
                        </label>
					</div>
				</div>
				<?endif?>
				<div class="control-group">
					<div class="controls">
						<?= FORM::button('submit', __('Publish new'), array('type'=>'submit', 'class'=>'btn btn-large btn-primary', 'action'=>Route::url('post_new',array('controller'=>'new','action'=>'index'))))?>
					</div>
				</div>
			</fieldset>
		<?= FORM::close()?>
