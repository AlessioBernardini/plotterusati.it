<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Request::current()->controller() == 'Home' AND (Theme::get('home_slider_title_1') OR Theme::get('home_slider_title_2') OR Theme::get('home_slider_title_3'))):?>
    <div id="carousel-home-header" class="carousel slide">
        <ol class="carousel-indicators">
            <?if (Theme::get('home_slider_title_2') OR Theme::get('home_slider_title_3')) : ?>
                <li data-target="#carousel-home-header" data-slide-to="0" class="active"></li>
            <? endif ?>
            <?if (Theme::get('home_slider_title_2')) : ?>
                <li data-target="#carousel-home-header" data-slide-to="1"></li>
            <?endif?>
            <?if (Theme::get('home_slider_title_3')) : ?>
                <li data-target="#carousel-home-header" data-slide-to="2"></li>
            <?endif?>
        </ol>
        <div class="carousel-inner">
            <div class="item active animated fadeInRight">
                <?if (Theme::get('home_slider_img_1')) : ?>
                    <img src="<?=Theme::get('home_slider_img_1')?>" alt="" class="img-responsive center-block" />
                <?endif?>
                <div class="carousel-caption">
                    <?if (Theme::get('home_slider_title_1')) : ?>
                        <h2 class="animated fadeInLeftBig"><?=Theme::get('home_slider_title_1')?></h2>
                    <?endif?>
                    <?if (Theme::get('home_slider_subtitle_1')) : ?>
                        <p class="animated fadeInRightBig"><?=Theme::get('home_slider_subtitle_1')?></p>
                    <?endif?>
                    <?if (Theme::get('home_slider_cta_title_1')) : ?>
                        <a href="<?=Theme::get('home_slider_cta_url_1')?>" class="animated fadeInLeftBig btn btn-info btn-lg"><?=Theme::get('home_slider_cta_title_1')?></a>
                    <?endif?>
                </div>
            </div>

            <?if (Theme::get('home_slider_title_2')) : ?>
                <div class="item animated fadeInRight">
                    <?if (Theme::get('home_slider_img_2')) : ?>
                        <img src="<?=Theme::get('home_slider_img_2')?>" alt="" class="img-responsive" />
                    <?endif?>
                    <div class="carousel-caption">
                        <?if (Theme::get('home_slider_title_2')) : ?>
                            <h2 class="animated fadeInLeftBig"><?=Theme::get('home_slider_title_2')?></h2>
                        <?endif?>
                        <?if (Theme::get('home_slider_subtitle_2')) : ?>
                            <p class="animated fadeInRightBig"><?=Theme::get('home_slider_subtitle_2')?></p>
                        <?endif?>
                        <?if (Theme::get('home_slider_cta_title_2')) : ?>
                            <a href="<?=Theme::get('home_slider_cta_url_2')?>" class="animated fadeInLeftBig btn btn-info btn-lg"><?=Theme::get('home_slider_cta_title_2')?></a>
                        <?endif?>
                    </div>
                </div>
            <?endif?>

            <?if (Theme::get('home_slider_title_3')) : ?>
                <div class="item animated fadeInRight">
                    <?if (Theme::get('home_slider_img_3')) : ?>
                        <img src="<?=Theme::get('home_slider_img_3')?>" alt="" class="img-responsive" />
                    <?endif?>
                    <div class="carousel-caption">
                        <?if (Theme::get('home_slider_title_3')) : ?>
                            <h2 class="animated fadeInLeftBig"><?=Theme::get('home_slider_title_3')?></h2>
                        <?endif?>
                        <?if (Theme::get('home_slider_subtitle_3')) : ?>
                            <p class="animated fadeInRightBig"><?=Theme::get('home_slider_subtitle_3')?></p>
                        <?endif?>
                        <?if (Theme::get('home_slider_cta_title_3')) : ?>
                            <a href="<?=Theme::get('home_slider_cta_url_3')?>" class="animated fadeInLeftBig btn btn-info btn-lg"><?=Theme::get('home_slider_cta_title_3')?></a>
                        <?endif?>
                    </div>
                </div>
            <?endif?>
        </div>
        <?if (Theme::get('home_slider_title_2') OR Theme::get('home_slider_title_3')) : ?>
            <a class="left carousel-control" href="#carousel-home-header" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#carousel-home-header" data-slide="next">
                <span class="icon-next"></span>
            </a>
        <?endif?>
    </div>
<?endif?>
