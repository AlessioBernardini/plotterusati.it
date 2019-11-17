<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
    <h1><?=_e('Users')?></h1>
</div>

<?=Form::errors()?>
<div id="users-search-form" class="def-size-form clearfix">
    <?= FORM::open(Route::url('profiles'), array('class'=>'form-inline', 'method'=>'GET', 'action'=>''))?>
        <fieldset>
            <div class="form-group">
                <?= FORM::label('user', _e('Name'), array('class'=>'', 'for'=>'user'))?>
                <div class="control">
                    <input type="text" id="search" name="search" class="form-control" value="<?=HTML::chars(core::request('search'))?>" placeholder="<?=__('Search')?>">
                </div>
            </div>
            <?if (Theme::get('premium')==1):?>
                <!-- Fields coming from user custom fields feature -->
                <?foreach(Model_UserField::get_all() as $name=>$field):?>
                    <?if(isset($field['searchable']) AND $field['searchable']):?>
                        <div class="form-group">
                            <?$cf_name = 'cf_'.$name?>
                            <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                                $select = array('' => $field['label']);
                                foreach ($field['values'] as $select_name) {
                                    $select[$select_name] = $select_name;
                                }
                            } else $select = $field['values']?>
                            <?= FORM::label('cfuser_'.$name, $field['label'], array('for'=>'cfuser_'.$name))?>
                            <div <?=($field['type']=='checkbox')?'class="control text-center"':''?>>
                                <?=Form::cf_form_field('cf_'.$name, array(
                                'display'   => $field['type'],
                                'label'     => $field['label'],
                                'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                                'default'   => $field['values'],
                                'options'   => (!is_array($field['values']))? $field['values'] : $select,
                                ),core::request('cf_'.$name), FALSE, TRUE)?> 
                            </div>
                        </div>
                    <?endif?>
                <?endforeach?>
            <?endif?>
            <div class="form-group submit-btn">
                <div class="control">
                    <?= FORM::button('submit', __('Search'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('profiles')))?> 
                </div>
            </div>
    </fieldset>
    <?= FORM::close()?>
</div>


<?if(core::count($users)):?>
<div class="btn-group pull-right">

    <button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort'))?>" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-list-alt"></span> <?=_e('Sort')?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" id="sort-list">
         <?if (Core::config('advertisement.reviews')==1):?>
            <li><a href="?<?=http_build_query(['sort' => 'rating'] + Request::current()->query())?>"><?=_e('Rating')?></a></li>
        <?endif?>
        <li><a href="?<?=http_build_query(['sort' => 'name-asc'] + Request::current()->query())?>"><?=_e('Name (A-Z)')?></a></li>
        <li><a href="?<?=http_build_query(['sort' => 'name-desc'] + Request::current()->query())?>"><?=_e('Name (Z-A)')?></a></li>
        <li><a href="?<?=http_build_query(['sort' => 'created-desc'] + Request::current()->query())?>"><?=_e('Newest')?></a></li>
        <li><a href="?<?=http_build_query(['sort' => 'created-asc'] + Request::current()->query())?>"><?=_e('Oldest')?></a></li>
        <li><a href="?<?=http_build_query(['sort' => 'ads-desc'] + Request::current()->query())?>"><?=_e('More Ads')?></a></li>
        <li><a href="?<?=http_build_query(['sort' => 'ads-asc'] + Request::current()->query())?>"><?=_e('Less Ads')?></a></li>
    </ul>
</div>
<div class="clearfix"></div><br>

<div class="row" id="users">
    <?$i = 1; foreach($users as $user ):?>
        <div class="col-sm-2 col-xs-6">
            <div class="thumbnail">
                <a title="<?=HTML::chars($user->name)?>" href="<?=Route::url('profile',  array('seoname'=>$user->seoname))?>">
                    <img class="img-responsive" src="<?=Core::imagefly($user->get_profile_image(),200,200)?>" alt="<?=__('Profile Picture')?>">
                </a>
                <div class="caption text-center">
                    <h4 class="">
                        <a title="<?=HTML::chars($user->name)?>" href="<?=Route::url('profile',  array('seoname'=>$user->seoname))?>">
                            <?=$user->name?> <?=$user->is_verified_user();?>
                        </a>
                    </h4>
                    <?if (Core::config('advertisement.reviews')==1 AND $user->rate!=NULL):?>
                        <p class="text-center">
                            <?for ($j=0; $j < round($user->rate,1); $j++):?>
                                <span class="glyphicon glyphicon-star"></span>
                            <?endfor?>
                            <?for ($jj=$j; $jj < 5; $jj++):?>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            <?endfor?>
                        </p>
                    <?endif?>
                    <span class="badge"><?=$user->ads_count?> <?=_e('Ads')?></span>
                    <p><?=Text::limit_chars(Text::removebbcode($user->description), 100, NULL, TRUE);?></p>
                </div>
            </div>
        </div>
    <?if ($i%6 == 0) :?>
            <div class="clearfix"></div>
        <?endif?>
    <?$i++; endforeach?>
</div>

<div class="row text-center">
    <?=$pagination?>
</div>

<?elseif (core::count($users) == 0):?>
<!-- Case when we dont have ads for specific category / location -->
<div class="page-header">
  <h3><?=_e('We do not have any users matching your search')?></h3>
</div>
<?endif?>