<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="pad_10tb">
	<div class="container">
		<div class="row">
			<div class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-xs-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>">
				<div class="page-header">
					<h3>
						<?if(core::count($users)):?>
							<div class="btn-group pull-right">
								<button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort'))?>" class="btn btn-base-dark btn-sm dropdown-toggle" data-toggle="dropdown">
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
						 <?endif?>			
						<?=_e('Users')?>
					</h3>
				</div>

					<?=Form::errors()?>
					<?= FORM::open(Route::url('profiles'), array('class'=>'', 'method'=>'GET', 'action'=>''))?>
						<fieldset>
                            <div class="form-group">
                                <?= FORM::label('user', _e('Name'), array('class'=>'', 'for'=>'user'))?>
                                <div class="control mr-30">
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
                                        <div>
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
                            <div class="form-group">
                                <label></label>
                                <div class="control mr-30">
                                    <?= FORM::button('submit', _e('Search'), array('type'=>'submit', 'class'=>'btn btn-primary pull-right', 'action'=>Route::url('profiles')))?> 
                                </div>
                            </div>
                		</fieldset>
					<?= FORM::close()?>

					<?if(core::count($users)):?>

					<div class="clearfix"><br></div>
					<div id="users">
						<?$i = 1; foreach($users as $user ):?>
							<div class="user-block">
								<div class="ub-inner">
									<div class="thumbnail">
										<div class="thumb-img">
											 <span class="badge badge-success"><?=$user->ads_count?> <?=_e('Ads')?></span>
											<a title="<?=HTML::chars($user->name)?>" href="<?=Route::url('profile',  array('seoname'=>$user->seoname))?>">
												<img src="<?=Core::imagefly($user->get_profile_image(),200,200)?>" class="img-rounded img-responsive" alt="<?=HTML::chars($user->name)?>" />
											</a>
											<p class="u-name">
												<?=$user->name?> <?=$user->is_verified_user();?>
											</p>
											
										</div>	
									</div>
								</div>
							</div>
							<?if ($i%4 == 0) :?>
								<div class="clearfix"></div>
							<?endif?>
						<?$i++; endforeach?>
					</div>

					<div class="text-center pad_10">
						<?=$pagination?>
					</div>

					<?elseif (core::count($users) == 0):?>
						<div class="no_results text-center">
							<span class="nr_badge"><i class="glyphicon glyphicon-info-sign glyphicon"></i></span>
							<p class="nr_info"><?=_e('We do not have any users matching your search')?></p>
						</div>
					<?endif?>

			</div>
		
			<?if(Theme::get('sidebar_position')!='none'):?>
	            <?=(Theme::get('sidebar_position')=='left')?View::fragment('sidebar_front','sidebar'):''?>
	            <?=(Theme::get('sidebar_position')=='right')?View::fragment('sidebar_front','sidebar'):''?>
	        <?endif?>
	    </div>
	</div>
</div>	