<?if(core::count($posts)):?>
    <div class="home-section mr-less-30">
        <div class="container">
            <div class="home-section-header">
                <h2 class="text-center"><?=_e('Blog')?></h2>
            </div>
            <div class="home-section-content">
                <div class="row" data-masonry='{ "itemSelector": ".grid-item" }'>
                    <?foreach($posts as $post):?>
                        <div class="col-xs-12 col-sm-4 col-md-3 grid-item">
                            <div class="box-card">
                                <a href="<?=Route::url('blog', array('seotitle'=>$post->seotitle))?>">
                                    <?if(preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->description, $post_images)):// First image used as post thumb?>
                                        <div class="box-card-images">
                                            <img width="1067" height="1067" alt="<?=HTML::chars($post->title)?>" src="<?=$post_images[1]?>">
                                        </div>
                                    <?endif?>
                                    <div class="box-card-footer">
                                        <div class="box-card-footer-title">
                                            <div class="box-card-footer-title-wrapper">
                                                <div class="headline"><h4><?=$post->title?></h4></div>
                                                <div class="excerpt"><p><?=Text::truncate_html(strip_tags($post->description), 255, NULL)?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?endforeach?>
                </div>
            </div>
            <div class="home-section-footer">
                <?=$pagination?>
            </div>
        </div>
    </div>
<?else:?>
    <div class="home-section">
        <div class="container">
            <div class="home-section-header">
                <h2 class="text-center"><?=_e('Blog')?></h2>
            </div>
            <div class="home-section-content">
                <h3><?=_e('We do not have any blog posts')?></h3>
            </div>
        </div>
    </div>
<?endif?>
