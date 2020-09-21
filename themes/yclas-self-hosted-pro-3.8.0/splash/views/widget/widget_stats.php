<?php defined('SYSPATH') or die('No direct script access.');?>
<h3 class="h3"><?=$widget->text_title?></h3>
<?if (!is_null($widget->info)):?>
<p><?=$widget->info->views?> <strong><?=_e('views')?></strong></p>
<p><?=$widget->info->ads?> <strong><?=_e('ads')?></strong></p>
<p><?=$widget->info->users?> <strong><?=_e('users')?></strong></p>
<?endif?>
