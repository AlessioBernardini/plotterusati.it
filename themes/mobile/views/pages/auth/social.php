<?if (Theme::get('premium')==1 AND core::count($providers = Social::get_providers())>0):?>
<fieldset>
    <legend><?=__('Social Login')?></legend>
    <?foreach ($providers as $key => $value):?>
        <?if($value['enabled']):?>
        	<?if(strtolower($key) == 'live')$key='windows'?>
            <a  target="_blank" class=" zocial icon <?=strtolower($key)?> social-btn" href="<?=Route::url('default',array('controller'=>'social','action'=>'login','id'=>strtolower($key)))?>"><?=$key?></a>
        <?endif?>
    <?endforeach?>
</fieldset>
<?endif?>