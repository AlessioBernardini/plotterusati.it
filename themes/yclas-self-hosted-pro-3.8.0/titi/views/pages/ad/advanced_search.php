<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Form::errors() !== NULL) :?>
    <div class="container">
        <?=Form::errors()?>
    </div>
<?endif?>

<?if (Request::current()->query()):?>
    <?if (core::count($ads)>0):?>
        <div class="container text-center">
            <h3>
                <?if (core::get('title')) :?>
                    <?=($total_ads == 1) ? sprintf(__('%d advertisement for %s'), $total_ads, core::get('title')) : sprintf(__('%d advertisements for %s'), $total_ads, core::get('title'))?>
                <?else:?>
                    <?=_e('Search results')?>
                <?endif?>
            </h3>
        </div>
        <?=View::factory('pages/ad/listing',array('pagination'=>$pagination,'ads'=>$ads,'category'=>NULL, 'location'=>NULL, 'user'=>$user, 'featured'=>NULL))?>
    <?else:?>
        <div class="container text-center">
            <div class="page-header text-center">
                <h3><?=_e('Your search did not match any advertisement.')?></h3>
            </div>
        </div>
    <?endif?>
<?endif?>
