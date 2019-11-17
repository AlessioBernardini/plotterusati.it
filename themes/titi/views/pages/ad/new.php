
<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h1><?=_e('Publish new advertisement')?></h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="<?=core::count(Widgets::render('publish_new')) > 0 ? 'col-lg-9 col-md-9 col-sm-12 col-xs-12' : ''?> <?=(core::count(Widgets::render('publish_new')) > 0 AND Theme::get('sidebar_position')=='left') ? 'col-lg-push-3 col-md-push-3' : NULL?>">
                        <?if (Theme::get('premium')==1 AND core::count($providers = Social::get_providers())>0 AND !Auth::instance()->get_user()):?>
                            <?foreach ($providers as $key => $value):?>
                                <?if($value['enabled']):?>
                                    <?if(strtolower($key) == 'live')$key='windows'?>
                                    <a  class=" zocial <?=strtolower($key)?> social-btn" href="<?=Route::url('default',array('controller'=>'social','action'=>'login','id'=>strtolower($key)))?>"><?=$key?></a>
                                <?endif?>
                            <?endforeach?>
                        <?endif?>
                        <div class="col-md-12">
                            <?= FORM::open(Route::url('post_new',array('controller'=>'new','action'=>'index')), array('class'=>'form-horizontal post_new', 'id'=>'publish-new', 'enctype'=>'multipart/form-data'))?>

                                    <? if (Core::config('general.multilingual')) : ?>
                                        <div class="form-group">
                                            <?= Form::label('locale', _e('Language'), array('class'=> 'col-md-4 control-label', 'for' => 'locale')) ?>
                                            <div class="col-md-6">
                                                <?= Form::select('locale', i18n::get_selectable_languages(), Core::request('locale', i18n::$locale), array('class' => 'form-control', 'id' => 'locale', 'required')) ?>
                                            </div>
                                        </div>
                                    <? endif ?>

                                    <div class="form-group">
                                        <?=FORM::label('title', __('Title'), array('class'=>'col-md-4 control-label', 'for'=>'title'))?>
                                        <div class="col-md-6">
                                            <?=FORM::input('title', Request::current()->post('title'), array('placeholder' => __('Title'), 'class' => 'form-control', 'id' => 'title', 'required'))?>
                                        </div>
                                    </div>

                                    <!-- location select -->
                                    <?if($form_show['location'] != FALSE):?>
                                        <div class="form-group">
                                            <?=FORM::label('locations', __('Location'), array('class'=>'col-md-4 control-label', 'for'=>'location'))?>
                                            <div class="col-md-6">
                                                <div id="location-chained" class="row <?=($id_location === NULL) ? NULL : 'hidden'?>" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'locations'))?>">
                                                    <div id="select-location-template" class="col-md-12 hidden">
                                                        <select class="disable-select2 select-location" placeholder="<?=__('Pick a location...')?>"></select>
                                                    </div>
                                                </div>
                                                <?if($id_location !== NULL):?>
                                                    <div id="location-edit" class="row">
                                                        <div class="col-md-12">
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

                                    <!-- category select -->
                                    <div class="form-group">
                                        <?=FORM::label('category', __('Category'), array('class'=>'col-md-4 control-label', 'for'=>'category'))?>
                                        <div class="col-md-6">
                                            <div id="category-chained" class="row <?=($id_category === NULL) ? NULL : 'hidden'?>"
                                                data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>"
                                                data-price0="<?=i18n::money_format(0)?>"
                                                <?=(core::config('advertisement.parent_category')) ? 'data-isparent' : NULL?>
                                            >
                                                <div id="select-category-template" class="col-md-12 hidden">
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

                                    <!-- Fields coming from custom fields feature -->
                                    <div id="custom-fields" data-customfield-values='<?=json_encode(Request::current()->post())?>'>
                                        <div id="custom-field-template" class="form-group hidden">
                                            <div data-label></div>
                                            <div class="col-md-6">
                                                <div data-input></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /endcustom fields -->

                                    <?if($form_show['description'] != FALSE):?>
                                        <div class="form-group">
                                            <?=FORM::label('description', __('Description'), array('class'=>'col-md-4 control-label', 'for'=>'description', 'spellcheck'=>TRUE))?>
                                            <div class="col-md-6">
                                                <?=FORM::textarea('description', Request::current()->post('description'), array('class'=>'form-control'.((Core::config("advertisement.description_bbcode"))? NULL:' disable-bbcode'),
                                                    'name'=>'description',
                                                    'id'=>'description',
                                                    'rows'=>10,
                                                    'required',
                                                    'data-bannedwords' => (core::config('advertisement.banned_words') != '') ? json_encode(explode(',', core::config('advertisement.banned_words'))) : '',
                                                    'data-error' => __('This field must not contain banned words ({0})')))?>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if(core::config("advertisement.num_images") > 0 ):?>
                                        <div class="form-group images"
                                            data-max-files="<?=core::config("advertisement.num_images")?>"
                                            data-max-image-size="<?=core::config('image.max_image_size')?>"
                                            data-image-width="<?=core::config('image.width')?>"
                                            data-image-height="<?=core::config('image.height') ? core::config('image.height') : ''?>">
                                            <label class="col-md-4 control-label"><?=_e('Images')?></label>
                                            <div class="col-md-6">
                                                <div class="dropzone" id="images-dropzone"></div>
                                                <p class="help-block"><?=__('Up to')?> <?=core::config('advertisement.num_images')?> <?=__('images allowed.')?></p>
                                                <p class="help-block"><?=join(' '.__('or').' ', array_filter(array_merge(array(join(', ', array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), 0, -2))), array_slice(array_map('strtoupper', explode(',', core::config('image.allowed_formats'))), -2))))?> <?=__('formats only')?>.</p>
                                                <p class="help-block"><?=__('Maximum file size of')?> <?=core::config('image.max_image_size')?>MB.</p>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if($form_show['phone'] != FALSE):?>
                                        <div class="form-group">
                                            <?=FORM::label('phone', __('Phone'), array('class'=>'col-md-4 control-label', 'for'=>'phone'))?>
                                            <div class="col-md-6">
                                                <?=FORM::input('phone', Request::current()->post('phone'), array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone')))?>
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
                                            <?=FORM::label('address', __('Address'), array('class'=>'col-md-4 control-label', 'for'=>'address'))?>
                                            <div class="col-md-6">
                                                <?if(core::config('advertisement.map_pub_new') AND Core::is_HTTPS()):?>
                                                    <div class="input-group">
                                                        <?= FORM::input('address', $address_default_value, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default locateme" type="button"><?=_e('Locate me')?></button>
                                                        </span>
                                                    </div>
                                                <?else:?>
                                                    <?= FORM::input('address', $address_default_value, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
                                                <?endif?>
                                            </div>
                                        </div>
                                        <?if (core::config('advertisement.map_pub_new')):?>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
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

                                    <?if($form_show['price'] != FALSE):?>
                                        <div class="form-group">
                                            <?=FORM::label('price', __('Price'), array('class'=>'col-md-4 control-label', 'for'=>'price'))?>
                                            <div class="col-md-6">
                                                <div class="input-prepend">
                                                    <?=FORM::input('price',
                                                        Request::current()->post('price'),
                                                        array('placeholder' => html_entity_decode(html_entity_decode(i18n::money_format(1))),
                                                            'class' => 'form-control',
                                                            'id' => 'price',
                                                            'type'=>'text',
                                                            'data-error' => __('Please enter only numbers.')))?>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if(core::config('payment.stock')):?>
                                        <div class="form-group">
                                            <?=FORM::label('stock', __('In Stock'), array('class'=>'col-md-4 control-label', 'for'=>'stock'))?>
                                            <div class="col-md-6">
                                                <div class="input-prepend">
                                                <?=FORM::input('stock', Request::current()->post('stock'), array('placeholder' => '10', 'class' => 'form-control', 'id' => 'stock', 'type'=>'text'))?>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if($form_show['website'] != FALSE):?>
                                        <div class="form-group">
                                            <?=FORM::label('website', __('Website'), array('class'=>'col-md-4 control-label', 'for'=>'website'))?>
                                            <div class="col-md-6">
                                                <?= FORM::input('website', Request::current()->post('website'), array('placeholder' => core::config("general.base_url"), 'class' => 'form-control', 'id' => 'website'))?>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if (!Auth::instance()->get_user()):?>
                                        <div class="form-group">
                                            <?=FORM::label('name', __('Name'), array('class'=>'col-md-4 control-label', 'for'=>'name'))?>
                                            <div class="col-md-6">
                                                <?= FORM::input('name', Request::current()->post('name'), array('class'=>'form-control', 'id'=>'name', 'required', 'placeholder'=>__('Name')))?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?=FORM::label('email', (core::config('payment.paypal_seller')==1)?__('Paypal Email'):__('Email'), array('class'=>'col-md-4 control-label', 'for'=>'email'))?>
                                            <div class="col-md-6">
                                                <?=FORM::input('email', Request::current()->post('email'), array('class'=>'form-control',
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
                                                    <?=FORM::label('cf_'.$name, $field['label'], array('class'=>'col-md-4 control-label', 'for'=>'cf_'.$name))?>
                                                    <div class="col-md-6">
                                                        <?$cf_name = 'cf_'.$name?>
                                                        <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                                                            $select = array(''=>'');
                                                            foreach ($field['values'] as $select_name) {
                                                                $select[$select_name] = $select_name;
                                                            }
                                                        } else $select = $field['values']?>
                                                        <?=Form::cf_form_field('cf_'.$name, array(
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

                                    <?if(core::config('advertisement.tos') != ''):?>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" required name="tos" id="tos"/>
                                                        <a target="_blank" href="<?=Route::url('page', array('seotitle'=>core::config('advertisement.tos')))?>"> <?=__('Terms of service')?></a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if ($form_show['captcha'] != FALSE):?>
                                        <div class="form-group">
                                            <?if (Core::config('general.recaptcha_active')):?>
                                                <div class="col-md-6 col-md-offset-4">
                                                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                                    <?if (Core::config('general.recaptcha_type') == 'checkbox'):?>
                                                        <input type="hidden" class="hidden-recaptcha required" name="hidden-recaptcha" id="hidden-recaptcha">
                                                    <?endif?>
                                                </div>
                                            <?else:?>
                                                <?=FORM::label('captcha', __('Captcha'), array('class'=>'control-label col-md-4', 'for'=>'captcha'))?>
                                                <div class="col-md-6">
                                                    <span id="helpBlock" class="help-block"><?=captcha::image_tag('publish_new')?></span>
                                                    <?=FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required', 'data-error' => __('Captcha is not correct')))?>
                                                </div>
                                            <?endif?>
                                        </div>
                                    <?endif?>
                                    <div class="page-header"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <?=FORM::button('submit_btn', __('Publish new'), array('type'=>'submit', 'id' => 'publish-new-btn', 'data-swaltitle' => __('Are you sure?'), 'data-swaltext' => __('It looks like you have been about to publish a new advertisement, if you leave before submitting your changes will be lost.'), 'class'=>'btn btn-primary btn-lg', 'action'=>Route::url('post_new',array('controller'=>'new','action'=>'index'))))?>
                                                <?if (!Auth::instance()->get_user()):?>
                                                    <p class="help-block"><?=__('User account will be created')?></p>
                                                <?endif?>
                                                <?if ( ! Core::config('advertisement.leave_alert')):?>
                                                    <input type="hidden" name="leave_alert" value="0" disabled>
                                                <?endif?>
                                            </div>
                                        </div>
                            <?= FORM::close()?>
                        </div>
                        <!--/well-->
                        <div class="modal modal-statc fade" id="processing-modal" data-backdrop="static" data-keyboard="false">
                            <div class="modal-body">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?=__('Processing...')?></h4>
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
                    </div>
                    <?if(core::count(Widgets::render('publish_new')) > 0) :?>
                        <div class="col-md-3 col-sm-12 col-xs-12 <?=(Theme::get('sidebar_position')=='left') ? 'col-lg-pull-9 col-md-pull-9' : NULL?>">
                            <?foreach ( Widgets::render('publish_new') as $widget):?>
                                <div class="panel panel-sidebar <?=get_class($widget->widget)?>">
                                    <?=$widget?>
                                </div>
                            <?endforeach?>
                        </div>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
</div>

<?=View::factory('pages/ad/new_scripts')?>
