<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<div class="well advise clearfix">
    <h3><?=_e('Advanced Search')?></h3>
    <?= FORM::open(Route::url('search'), array('class'=>'form-horizontal', 'method'=>'GET', 'action'=>''))?>
        <fieldset>
        <div class="form-group">
            <?= FORM::label('advertisement', _e('Advertisement Title'), array('class'=>'col-sm-2 control-label', 'for'=>'advertisement'))?>
            <div class="col-sm-10">  
                <input type="text" id="title" name="title" class="form-control" value="" placeholder="<?=__('Search')?>">
            </div>
        </div>

        <!-- <div class="form-group">
            <label class="" for="price-min"><?=__('Price from')?> </label>  
            <input type="text" id="price-min" name="price-min" class="form-control" value="<?=core::get('price-min')?>" placeholder="0">
        </div>
        <div class="form-group">
            <label class="" for="price-max"><?=__('to')?></label>
            <input type="text" id="price-max" name="price-max" class="form-control" value="<?=core::get('price-max')?>" placeholder="100">
        </div> -->
         <div class="form-group">
            <?= FORM::label('category', _e('Category'), array('class'=>'col-sm-2 control-label', 'for'=>'category' ))?>
            <div class="col-sm-10">          
                <select name="category" id="category" class="form-control" >
                <option></option>
                <?function lili($item, $key,$cats){?>
                <?if(!core::config('advertisement.parent_category')):?>
                    <?if($cats[$key]['id_category_parent'] != 1):?>
                        <option value="<?=$cats[$key]['seoname']?>"><?=$cats[$key]['translate_name']?></option>
                    <?endif?>
                <?else:?>
                    <option value="<?=$cats[$key]['seoname']?>"><?=$cats[$key]['translate_name']?></option>
                <?endif?>
                    <?if (core::count($item)>0):?>
                    <optgroup label="<?=$cats[$key]['translate_name']?>">
                        <? if (is_array($item)) array_walk($item, 'lili', $cats);?>
                    <?endif?>
                <?}array_walk($order_categories, 'lili',$categories);?>
                </select>
            </div>
        </div>
        <?if(core::count($locations) > 1):?>
            <div class="form-group">
                <?= FORM::label('location', _e('Location'), array('class'=>'col-sm-2 control-label', 'for'=>'location' , 'multiple'))?>
                <div class="col-sm-10">          
                    <select name="location" id="location" class="form-control" >
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
        <!-- Fields coming from custom fields feature -->
        <?if(isset($fields)):?>
        <?if (is_array($fields)):?>
            <?foreach($fields as $name=>$field):?>
            <?if(isset($field['searchable']) AND $field['searchable']):?>
            <div class="form-group">
            
            <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                $select = array(''=>'');
                foreach ($field['values'] as $select_name) {
                    $select[$select_name] = $select_name;
                }
            }?>
                <?=Form::cf_form_tag('cf_'.$name, array(    
                    'display'   => $field['type'],
                            'label'     => $field['label'],
                            'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                            'default'   => $field['values'],
                            'options'	=> (!is_array($field['values']))? $field['values'] : $select,
                            'required'	=> $field['required'],))?> 
            </div>
            <?endif?>     
            <?endforeach?>
        <?endif?>
        <?endif?>
        <div class="col-sm-offset-2 col-sm-10">
            <?= FORM::button('submit', _e('Search'), array('type'=>'submit', 'class'=>'btn-large btn-primary', 'action'=>Route::url('search')))?> 
        </div>
    </fieldset>
    <?= FORM::close()?>
</div>

<?if (core::count($ads)>0):?>
    <h3><?=_e('Search results')?></h3>
    <?=View::factory('pages/ad/listing',array('pagination'=>$pagination,'ads'=>$ads,'category'=>NULL, 'location'=>NULL, 'user'=>$user, 'featured'=>NULL))?>
<?endif?>