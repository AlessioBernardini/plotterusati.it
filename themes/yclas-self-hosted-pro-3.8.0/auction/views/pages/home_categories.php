
<section class="categories">
	<hr class="hidden-lg hidden-md hidden-sm">
    <h2>
        <?=_e("Categories")?>
        <?if ($user_location) :?>
            <small><?=$user_location->translate_name() ?></small>
        <?endif?>
    </h2>
    <div class="row">

        <!-- count categories -->
        <?
        $cats_counter = 0;
        foreach ($categs as $c){
            if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)){
                $cats_counter++;
            }
        }
        ?>

        <!-- categories slider desktop, laptop, tablet -->
        <div id="slider-fixed-categories" class="carousel slide hidden-xs">
            <div id="latest-ads" class="carousel-inner">
                <div class="active item">
                    <?$i=0; foreach($categs as $c):?>
                        <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                            <?if ($i%6==0 AND $i!=0):?></div><div class="item"><?endif?>
                            <div class="cat_item_home col-lg-2 col-md-2 col-sm-2">
                                <div class="thumbnail latest_ads">
                                    <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>" class="min-h">
                                        <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon();?>
                                        <? if(( $icon_src )!==FALSE ):?>
                                            <img src="<?=Core::imagefly($icon_src,185,185)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                        <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                            <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',185,185)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                        <?else:?>
                                            <img data-src="holder.js/185x185?<?=str_replace('+', ' ', http_build_query(array('text' => $c['translate_name'], 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($c['translate_name'])?>" class="img-responsive">
                                        <?endif?>
                                    </a>
                                    <div class="caption">
                                        <h5 class="h5 text-center">
                                            <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                                <?= $category->get_icon_font() ?> <strong><?=$c['translate_name']?> (<?=number_format($c['count'])?>)</strong>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                        <?endif?>
                    <?endforeach?>
                </div>
            </div>

            <?if($i > 6):?>
                <a class="left carousel-control" href="#slider-fixed-categories" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#slider-fixed-categories" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            <?endif?>
        </div>

        <!-- categories slider mobile -->
        <div id="slider-fixed-categories-mobile" class="carousel slide hidden-lg hidden-md hidden-sm">
            <div id="latest-ads" class="carousel-inner">
                <div class="active item">
                    <?$i=0; foreach($categs as $c):?>
                        <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                            <?if ($i%2==0 AND $i!=0):?></div><div class="item"><?endif?>
                            <div class="cat_item_home col-xs-6">
                                <div class="thumbnail latest_ads">
                                    <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>" class="min-h">
                                        <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon();?>
                                        <? if(( $icon_src )!==FALSE ):?>
                                            <img src="<?=Core::imagefly($icon_src,185,185)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                        <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                            <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',185,185)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                        <?else:?>
                                            <img data-src="holder.js/185x185?<?=str_replace('+', ' ', http_build_query(array('text' => $c['translate_name'], 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($c['translate_name'])?>" class="img-responsive">
                                        <?endif?>
                                    </a>
                                    <div class="caption">
                                        <h5 class="h5 text-center">
                                            <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                                <?= $category->get_icon_font() ?> <strong><?=$c['translate_name']?> (<?=number_format($c['count'])?>)</strong>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                        <?endif?>
                    <?endforeach?>
                </div>
            </div>

            <?if($cats_counter > 2):?>
                <a class="left carousel-control" href="#slider-fixed-categories-mobile" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#slider-fixed-categories-mobile" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            <?endif?>
        </div>

    </div>
</section>
