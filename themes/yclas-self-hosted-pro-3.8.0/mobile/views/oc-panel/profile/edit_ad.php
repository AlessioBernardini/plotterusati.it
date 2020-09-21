<?php defined('SYSPATH') or die('No direct script access.');?>

<?=Alert::show()?>

<?=Form::errors()?>

<div class="page-header text-center">
    <h1><?=$ad->title?></h1>
    <small><?=__('Edit Advertisement')?></small>
</div>

<div class="header_devider"></div>

<div class="text-center">
    <p><a class="btn btn-primary color-white" target="_blank" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
        <?=__('View Advertisement')?>
    </a></p>
    
    <?$str=NULL;switch ($ad->status) {
        case Model_Ad::STATUS_NOPUBLISHED:
            $str = __('NOPUBLISHED');
            break;
        case Model_Ad::STATUS_PUBLISHED:
            $str = __('PUBLISHED');
            break;
        case Model_Ad::STATUS_UNCONFIRMED:
            $str = __('UNCONFIRMED');
            break;
        case Model_Ad::STATUS_SPAM:
            $str = __('SPAM');
            break;
        case Model_Ad::STATUS_UNAVAILABLE:
            $str = __('UNAVAILABLE');
            break;
        default:
            break;
    }?>
    <p><span class="label label-warning label-as-badge"><?=$str?></span></p>
    <?if ($ad->status == Model_Ad::STATUS_UNAVAILABLE 
        AND !in_array(core::config('general.moderation'), Model_Ad::$moderation_status) ):?>
        <a
            href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'activate','id'=>$ad->id_ad))?>" 
            class="btn btn-success" 
            title="<?=__('Activate?')?>" 
            data-text="<?=__('Activate?')?>" 
            data-toggle="confirmation" 
            data-btnOkLabel="<?=__('Yes, definitely!')?>" 
            data-btnCancelLabel="<?=__('No way!')?>">
            <?=__('Activate')?>
        </a>
    <?endif?>
</div>

<div class="text-center">
    <?if((core::config('payment.pay_to_go_on_top') > 0  
        AND core::config('payment.to_top') != FALSE )
        OR (core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql() )):?>
        <?if(core::config('payment.pay_to_go_on_top') > 0 AND core::config('payment.to_top') != FALSE):?>
            <p><?=__('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></p>
            <p><a href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=__('Go Top!')?></a></p>
        <?endif?>
        <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
            <p class="text-info"><?=__('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></p>
            <p><a href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>" class="btn btn-info color-white"><?=__('Go Featured!')?></a></p>
        <?endif?>
    <?endif?>
    <!-- end paypal button -->
</div>

<?if (core::count($orders) > 0) :?>
    <div class="text-center">
        <?foreach ($orders as $order):?>
            <p>
                <a class="btn btn-warning" href="<?=Route::url('default', array('controller'=> 'ad','action'=>'checkout' , 'id' => $order->id_order))?>">
                    <i class="glyphicon glyphicon-shopping-cart"></i> <?=__('Pay')?> <?=$order->description?>  
                </a>
            </p>
        <?endforeach?>
    </div>
<?endif?>

<?if(Auth::instance()->get_user()->is_admin()):?>
    <?$owner = new Model_User($ad->id_user)?>
    <table data-role="table" data-mode="columntoggle" class="table table-hover ui-responsive" id="myTable">
        <tr>
            <th><?=__('Id_User')?></th>
            <th><?=__('Profile')?></th>
            <th><?=__('Name')?></th>
            <th><?=__('Email')?></th>
            <th><?=__('Status')?></th>
        </tr>
        <tbody>
            <tr>
                <td><?= $ad->id_user?></td>
                <td>    
                    <a href="<?=Route::url('profile', array('seoname'=>$owner->seoname))?>" alt="<?=HTML::chars($owner->seoname)?>"><?= $owner->seoname?></a>
                </td>
                <td><?= $owner->name?></td>
                <td>    
                    <a href="<?=Route::url('contact')?>"><?= $owner->email?></a>
                </td>
                <td>
                    <?$str=NULL;switch ($ad->status) {
                        case Model_Ad::STATUS_NOPUBLISHED:
                            $str = __('NOPUBLISHED');
                            break;
                        case Model_Ad::STATUS_PUBLISHED:
                            $str = __('PUBLISHED');
                            break;
                        case Model_Ad::STATUS_UNCONFIRMED:
                            $str = __('UNCONFIRMED');
                            break;
                        case Model_Ad::STATUS_SPAM:
                            $str = __('SPAM');
                            break;
                        case Model_Ad::STATUS_UNAVAILABLE:
                            $str = __('UNAVAILABLE');
                            break;
                        default:
                            break;
                        }?> 
                    <b><?=$str?></b>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
<?endif?>

<?= FORM::open(Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad)), array('class'=>'form-horizontal edit_ad_form', 'enctype'=>'multipart/form-data'))?>
    <?= FORM::label('title', __('Title'), array('class'=>'', 'for'=>'title'))?>
    <?= FORM::input('title', $ad->title, array('placeholder' => __('Title'), 'class' => 'form-control', 'id' => 'title', 'required'))?>

    <?= FORM::label('category', __('Category'), array('class'=>'control-label', 'for'=>'category' , 'multiple'))?>
    <select name="category" id="category" class="input-xlarge" required>
        <option></option>
        <?$categories = Model_Category::get_as_array(); $order_categories = Model_Category::get_multidimensional(); ?>
        <?function lili($item, $key, $data){?>
            <?if(!core::config('advertisement.parent_category')):?>
                <?if($data['cats'][$key]['id_category_parent'] != 1):?>
                    <option value="<?=$data['cats'][$key]['id']?>" data-id="<?=$data['cats'][$key]['id']?>" <?=($data['cats'][$key]['id'] == $data['ad']->category->id_category) ? 'selected': NULL?>><?=$data['cats'][$key]['name']?></option>
                <?endif?>
            <?else:?>
                <option value="<?=$data['cats'][$key]['id']?>" data-id="<?=$data['cats'][$key]['id']?>" <?=($data['cats'][$key]['id'] == $data['ad']->category->id_category) ? 'selected': NULL?>><?=$data['cats'][$key]['name']?></option>
            <?endif?>
            <?if (core::count($item)>0):?>
                <optgroup label="<?=$data['cats'][$key]['name']?>">    
                    <? if (is_array($item)) array_walk($item, 'lili', $data);?>
                </optgroup>
            <?endif?>
        <?}array_walk($order_categories, 'lili', array('cats' => $categories, 'ad' => $ad));?>
    </select>

    <?$locations = Model_Location::get_as_array(); $order_locations = Model_Location::get_multidimensional(); ?>
    <?if(core::config('advertisement.location') AND core::count($locations) > 1):?>
        <?= FORM::label('location', __('Location'), array('class'=>'control-label', 'for'=>'location' , 'multiple'))?>
        <select name="location" id="location" class="input-xlarge"   required>
            <option></option>
            <?function lolo($item, $key,$data){?>
                <option value="<?=$key?>" <?=($data['locs'][$key]['id'] == $data['ad']->location->id_location) ? 'selected': NULL?>><?=$data['locs'][$key]['name']?></option>
                <?if (core::count($item)>0):?>
                    <optgroup label="<?=$data['locs'][$key]['name']?>">    
                    <? if (is_array($item)) array_walk($item, 'lolo', $data);?>
                <?endif?>
            <?}array_walk($order_locations, 'lolo', array('locs' => $locations, 'ad' => $ad));?>
        </select>
    <?endif?>

    <?if(core::config('advertisement.description') != FALSE):?>
        <?= FORM::label('description', __('Description'), array('class'=>'', 'for'=>'description', 'spellcheck'=>TRUE))?>
        <?= FORM::textarea('description', $ad->description, array('class'=>'form-control col-md-9 col-sm-9 col-xs-12 disable-bbcode', 'name'=>'description', 'id'=>'description', 'rows'=>8, 'required'))?>
    <?endif?>
    <?if(core::config('advertisement.phone') != FALSE):?>
        <?= FORM::label('phone', __('Phone'), array('class'=>'', 'for'=>'phone'))?>
        <?= FORM::input('phone', $ad->phone, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone')))?>
    <?endif?>

    <?if(core::config('advertisement.address') != FALSE):?>
        <?= FORM::label('address', __('Address'), array('class'=>'', 'for'=>'address'))?>
        <?if(core::config('advertisement.map_pub_new')):?>
            <?= FORM::input('address', $ad->address, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
            <button class="btn btn-default locateme" type="button"><?=__('Locate me')?></button>
        <?else:?>
            <?= FORM::input('address', $ad->address, array('class'=>'form-control', 'id'=>'address', 'placeholder'=>__('Address')))?>
        <?endif?>
        <?if(core::config('advertisement.map_pub_new')):?>
            <div class="popin-map-container">
                <div class="map-inner center-block" id="map" 
                    data-lat="<?=($ad->latitude)? $ad->latitude:core::config('advertisement.center_lat')?>" 
                    data-lon="<?=($ad->longitude)? $ad->longitude:core::config('advertisement.center_lon')?>"
                    data-zoom="<?=core::config('advertisement.map_zoom')?>" 
                    style="height:200px;max-width:400px;margin-bottom:5px;">
                </div>
            </div>
            <input type="hidden" name="latitude" id="publish-latitude" value="<?=$ad->latitude?>" <?=is_null($ad->latitude) ? 'disabled': NULL?>>
            <input type="hidden" name="longitude" id="publish-longitude" value="<?=$ad->longitude?>" <?=is_null($ad->longitude) ? 'disabled': NULL?>>
        <?endif?>
     <?endif?>

    <?if(core::config('payment.stock')):?>
        <?= FORM::label('stock', __('In Stock'), array('class'=>'', 'for'=>'stock'))?>
        <?= FORM::input('stock', $ad->stock, array('placeholder' => '10', 'class' => 'form-control', 'id' => 'stock', 'type'=>'text'))?>
    <?endif?>

    <?if(core::config('advertisement.price') != FALSE):?>
        <?= FORM::label('price', __('Price'), array('class'=>'', 'for'=>'price'))?>
        <?= FORM::input('price', i18n::format_currency_without_symbol($ad->price), array('placeholder'=>html_entity_decode(i18n::money_format(1)),'class'=>'form-control', 'id' => 'price', 'data-error' => __('Please enter only numbers.')))?>
    <?endif?>

    <?if(core::config('advertisement.website') != FALSE):?>
        <?= FORM::label('website', __('Website'), array('class'=>'', 'for'=>'website'))?>
        <?= FORM::input('website', $ad->website, array('class'=>'form-control', 'id'=>'website', 'placeholder'=>__('Website')))?>
    <?endif?>

    <!-- Fields coming from custom fields feature -->
    <?$fields = Model_Field::get_all(); $cf_list = $ad->custom_columns(0, true); if (isset($fields)):?>
        <?if (is_array($fields)):?>
            <?foreach($fields as $name=>$field):?>
                <div class="control-group" id="cf_new">
                    <?$cf_name = 'cf_'.$name?>
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
                            'default'   => $ad->$cf_name,
                            'options'   => (!is_array($field['values']))? $field['values'] : $select,
                            'required'  => $field['required'],
                            'categories'=> (isset($field['categories']))? $field['categories'] : "",))?>
                </div>     
            <?endforeach?>
        <?endif?>
    <?endif?>
    <!-- /endcustom fields -->
    
	<div class="form-group images"
        data-max-image-size="<?=core::config('image.max_image_size')?>"
        data-image-width="<?=core::config('image.width')?>"
        data-image-height="<?=core::config('image.height') ? core::config('image.height') : 0?>"
        data-image-quality="<?=core::config('image.quality')?>"
        data-swaltext="<?=sprintf(__('Is not of valid size. Size is limited to %s MB per image'),core::config('image.max_image_size'))?>">
        <div class="col-md-12">
            <div class="row">
                <?$images = $ad->get_images()?>
                <?if($images):?>
                    <?$i = 0; foreach ($images as $key => $value):?>
                        <?if(isset($value['thumb'])): // only formated images (not originals)?>
                            <div id="img<?=$key?>" class="col-md-4 col-sm-4 col-md-4 edit-image">
                                <a><img src="<?=$value['thumb']?>" class="img-rounded thumbnail img-responsive"></a>
                                <button class="btn btn-danger index-delete img-delete"
                                        data-title="<?=__('Are you sure you want to delete?')?>"
                                        data-btnOkLabel="<?=__('Yes, definitely!')?>"
                                        data-btnCancelLabel="<?=__('No way!')?>"
                                        type="submit"
                                        name="img_delete"
                                        value="<?=$key?>"
                                        href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>">
                                        <?=_e('Delete')?>
                                </button>
                                <?if ($key > 1) :?>
                                    <button class="btn btn-info img-primary"
                                        type="submit"
                                        name="primary_image"
                                        value="<?=$key?>"
                                        href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"
                                        action="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"
                                    >
                                            <?=_e('Primary image')?>
                                    </button>
                                <?endif?>
                            </div>
                        <?endif?>
                        <?$i++?>
                    <?endforeach?>
                <?endif?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?if (core::config('advertisement.num_images') > core::count($images)):?> <!-- permition to add more images-->
            <div class="col-sm-8">
                <?= FORM::label('images', _e('Add image'), array('class'=>'', 'for'=>'images0'))?>
                <div class="row">
                    <div class="col-md-12">
                        <?for ($i = 0; $i < (core::config('advertisement.num_images') - core::count($images)); $i++):?>
                            <div class="fileinput fileinput-new <?=($i >= 1) ? 'hidden' : NULL?>" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new"><?=_e('Select')?></span>
                                        <span class="fileinput-exists"><?=_e('Edit')?></span>
                                        <input type="file" name="<?='image'.$i?>" id="<?='fileInput'.$i?>" accept="<?='image/'.str_replace(',', ', image/', rtrim(core::config('image.allowed_formats'),','))?>">
                                    </span>
                                    <?if (core::config('image.upload_from_url')):?>
                                        <button type="button" class="btn btn-default fileinput-url" data-toggle="modal" data-target="#<?='urlInputimage'.$i?>"><?=_e('Image URL')?></button>
                                    <?endif?>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?=_e('Delete')?></a>
                                </div>
                            </div>
                        <?endfor?>
                    </div>
                </div>
            </div>
        <?endif?>
    </div>

    <?= FORM::button('submit_btn', (in_array(core::config('general.moderation'), Model_Ad::$moderation_status))?__('Publish'):__('Update'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))))?>
<?= FORM::close()?>

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
