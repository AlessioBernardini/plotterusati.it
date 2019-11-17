<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Core::config('general.sms_auth') == TRUE ):?>
    <section id="page-header">
        <div class="container no-gutter">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1><?=_e('Phone Register')?></h1>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </section>

    <section id="main">
        <div class="container no-gutter">
            <?=View::factory('pages/auth/phoneregister-form')?>
        </div>
    </section>
<?endif?>
