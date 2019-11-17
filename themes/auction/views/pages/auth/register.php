<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">			
            <div class="col-sm-12 text-center">
                <h1 class="h1"><?=_e('Register')?></h1>
            </div>
            <div class="col-sm-4 breadcrumbs">
                <?=Breadcrumbs::render('breadcrumbs')?>
            </div>
        </div>
    </div>
    <div class="overlay"></div>		       
</section>

<?=Alert::show()?>

<section id="main">
    <div class="container no-gutter">
        <div class="row">
            <?=View::factory('pages/auth/register-form')?>
        </div>
    </div>
</section>