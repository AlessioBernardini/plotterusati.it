<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<div class="page-header">
    <h1><?=__('Advanced Search')?></h1>
</div>

<?if (core::count($ads)>0):?>
    <h3 class="c-bl"><?=__('Search results')?></h3>
    <?=View::factory('pages/ad/listing',array('pagination'=>$pagination,'ads'=>$ads,'category'=>NULL, 'location'=>NULL, 'user'=>$user, 'featured'=>NULL))?>
<?endif?>

<div class="well recomentadion clearfix">
    <?= FORM::open(Route::url('search'), array('class'=>'navbar-search', 'method'=>'GET', 'action'=>'', 'target'=>'_self'))?>
    <fieldset>
        <div class="control-group">
            <?= FORM::label('advertisement', __('Advertisement Title'), array('class'=>'control-label', 'for'=>'advertisement'))?>
            <div class="controls">  
                <input type="text" id="title" name="title" class="input-xlarge" value="" placeholder="<?=__('Search')?>">
            </div>
        </div>

        <?if(core::count($categories) > 1):?>
            <div class="control-group">
                <?= FORM::label('category', __('Category'), array('class'=>'control-label', 'for'=>'category' ))?>
                <div class="controls">          
                    <select name="category" id="category" class="input-xlarge" >
                    <option></option>
                    <?function lili($item, $key,$cats){?>
                    <option value="<?=$cats[$key]['seoname']?>" data-id="<?=$cats[$key]['id']?>" <?=(core::request('category') == $cats[$key]['seoname'])?"selected":''?> ><?=$cats[$key]['translate_name']?></option>
                        <?if (core::count($item)>0):?>
                        <optgroup label="<?=$cats[$key]['translate_name']?>">
                            <? if (is_array($item)) array_walk($item, 'lili', $cats);?>
                        <?endif?>
                    <?}array_walk($order_categories, 'lili',$categories);?>
                    </select>
                </div>
            </div>
        <?endif?>
        
        <?if(core::config('advertisement.location') != FALSE AND core::count($locations) > 1):?>
            <div class="control-group">
                <?= FORM::label('location', __('Location'), array('class'=>'', 'for'=>'location' , 'multiple'))?>        
                <div class="controls">
                    <select name="location" id="location" class="input-xlarge" data-placeholder="<?=__('Location')?>">
                    <option></option>
                    <?function lolo($item, $key,$locs){?>
                    <option value="<?=$locs[$key]['seoname']?>" <?=(core::request('location') == $locs[$key]['seoname'])?"selected":''?> ><?=$locs[$key]['translate_name']?></option>
                        <?if (core::count($item)>0):?>
                        <optgroup label="<?=$locs[$key]['translate_name']?>">
                            <? if (is_array($item)) array_walk($item, 'lolo', $locs);?>
                            </optgroup>
                        <?endif?>
                    <?}array_walk($order_locations, 'lolo',$locations);?>
                    </select>
                </div>
            </div>
        <?endif?>
        <?if(core::config('advertisement.price')):?>
            <div class="control-group">
                <label class="" for="price-min"><?=__('Price from')?> </label> 
                <div class="controls"> 
                    <input type="text" id="price-min" name="price-min" class="input-xlarge" value="<?=HTML::chars(core::get('price-min'))?>" placeholder="<?=__('Price from')?>">
                </div>
            </div>

            <div class="control-group">
                <label class="" for="price-max"><?=__('Price to')?></label>
                <div class="controls">
                    <input type="text" id="price-max" name="price-max" class="input-xlarge" value="<?=HTML::chars(core::get('price-max'))?>" placeholder="<?=__('to')?>">
                </div>
            </div>
        <?endif?>
        <!-- Fields coming from custom fields feature -->
        <div id="search-custom-fields" style="display:inline-block;" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>" data-customfield-values='<?=json_encode(Request::current()->query())?>'>
            <div id="search-custom-field-template" class="form-group hidden">
                <div data-label></div>
                <div>
                    <div data-input></div>
                </div>
            </div>
        </div>
        <!-- Fields coming from user custom fields feature -->
        <?foreach(Model_UserField::get_all() as $name=>$field):?>
            <?if(isset($field['searchable']) AND $field['searchable']):?>
                <div class="control-grp control-group">
                    <?$cf_name = 'cfuser_'.$name?>
                    <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                        $select = array('' => $field['label']);
                        foreach ($field['values'] as $select_name) {
                            $select[$select_name] = $select_name;
                        }
                    } else $select = $field['values']?>
                    <?if($field['type'] == 'checkbox' OR $field['type'] == 'radio'):?><div class="mt-10"></div><?endif?>
                    <?= FORM::label('cfuser_'.$name, $field['label'], array('for'=>'cfuser_'.$name))?>
                    <?=Form::cf_form_field('cfuser_'.$name, array(
                        'display'     => $field['type'],
                        'label'       => $field['label'],
                        'placeholder' => (!empty($field['label'])) ? $field['label']:$name,
                        'tooltip'     => (isset($field['tooltip']))? $field['tooltip'] : "",
                        'default'     => $field['values'],
                        'options'     => (!is_array($field['values']))? $field['values'] : $select,
                        ),core::get('cfuser_'.$name), FALSE, TRUE)?> 
                </div>
            <?endif?>
        <?endforeach?>
        <!-- /endcustom fields -->
        <div class="form-actions">
            <?= FORM::button('submit', _e('Search'), array('type'=>'submit', 'class'=>'btn-large btn-primary', 'action'=>Route::url('search')))?> 
        </div>

    </fieldset>
    <?= FORM::close()?>
</div>
