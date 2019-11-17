<?php defined('SYSPATH') or die('No direct script access.');?>
<?if(core::count($breadcrumbs) > 0) : ?>
    <div class="row">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <?foreach ($breadcrumbs as $crumb) : ?>
                    <?if ($crumb->get_url() !== NULL) : ?>
                        <li>
                            <a title="<?=HTML::chars($crumb->get_title())?>" href="<?=$crumb->get_url()?>"><?=$crumb->get_title()?></a>
                        </li>
                    <?else : ?>
                        <li class="active"><?=$crumb->get_title()?></li>
                    <?endif;?>
                <?endforeach;?>
            </ol>
        </div>
    </div>
<? endif; ?>