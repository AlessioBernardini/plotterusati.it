<?if (Core::config('general.sms_auth') == TRUE ):?>
    <div class="page-header text-center">
        <h1><?=_e('Phone Register')?></h1>
    </div>
    <section id="main">
        <div class="container no-gutter">
            <div class="row">
                <?=View::factory('pages/auth/phoneregister-form')?>
            </div>
        </div>
    </section>
<?endif?>
