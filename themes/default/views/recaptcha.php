<?if (Core::config('general.recaptcha_type') == 'invisible'):?>
    <?php Session::instance()->set('form_render_time', time()); ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div
            id="<?= $id ?>"
            class="g-recaptcha"
            data-sitekey="<?= Core::config('general.recaptcha_sitekey') ?>"
            data-size="invisible"
            data-callback="recaptcha_submit"
    ></div>
    <input type="hidden" name="g-recaptcha-response" value="">
    <div style="display:none;"><input type="text" name="website_url_hp" value="" tabindex="-1" autocomplete="off"></div>
<?else:?>
    <?=Captcha::recaptcha_display()?>
    <div id="<?= $id ?>"></div>
<?endif?>
