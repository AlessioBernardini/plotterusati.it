<?if (Core::config('general.sms_auth') == TRUE ):?>
    <h1 class="listings-title"><span><?=_e('Phone Register')?></span></h1>
    <?=View::factory('pages/auth/phoneregister-form')?>
<?endif?>
