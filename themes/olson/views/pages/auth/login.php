<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-title">
	<h1><i class="fa fa-sign-in color"></i> <?=_e('Login')?></h1>
	<hr>
</div>

<?=View::factory('pages/auth/login-form')?>
