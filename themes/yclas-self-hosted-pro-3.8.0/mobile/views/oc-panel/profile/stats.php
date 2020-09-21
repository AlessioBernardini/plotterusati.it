<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?=__('Statistics')?> <?=$advert->loaded() ? $advert->title : NULL?></h1>
</div>

<div class="header_devider"></div>

<?=Alert::show()?>

<section id="page-header">
    <div class="container no-gutter">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h1"></h1>
            </div>
            <?if (Theme::get('breadcrumb')==1):?>
                <div class="col-sm-4 breadcrumbs">
                    <?=Breadcrumbs::render('breadcrumbs')?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable">
    <thead>
        <tr>
            <th></th>
            <th><?=__('Today')?></th>
            <th><?=__('Yesterday')?></th>
            <th><?=__('Last 30 days')?></th>
            <th><?=__('Total')?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b><?=__('Contacts')?></b></td>
            <td><?=$contacts_today?></td>
            <td><?=$contacts_yesterday?></td>
            <td><?=$contacts_month?></td>
            <td><?=$contacts_total?></td>
        </tr>
        <tr>
            <td><b><?=__('Visits')?></b></td>
            <td><?=$visits_today?></td>
            <td><?=$visits_yesterday?></td>
            <td><?=$visits_month?></td>
            <td><?=$visits_total?></td>
        </tr>
    </tbody>
</table>

<div class="page-header">
    <h1><?=__('Charts')?></h1>
</div>

<form id="edit-profile" class="form-inline text-center" method="post" action="">
    <?=__('From')?>
    <input type="text" class="form-control" id="from_date" name="from_date" value="<?=$from_date?>" data-date="<?=$from_date?>" data-date-format="yyyy-mm-dd">
    <?=__('To')?>
    <input type="text" class="form-control" id="to_date" name="to_date" value="<?=$to_date?>" data-date="<?=$to_date?>" data-date-format="yyyy-mm-dd">

    <button type="submit" class="btn btn-primary"><?=__('Filter')?></button>
    <div>
        <br>
        <strong class="text-center"><?=__('Views and Contacts statistic')?></strong>
        <?=Chart::line($stats_daily, array('height'  => 400,
                                           'width'   => 400,
                                           'options' => array('responsive' => true, 'maintainAspectRatio' => false, 'scaleShowVerticalLines' => false, 'multiTooltipTemplate' => '<%= datasetLabel %> - <%= value %>')))?>
    </div>
</form>
