<div class="aa-input-container" id="aa-input-container">
    <?=FORM::open(Route::url('search'), array('class'=>'search-frm', 'method'=>'GET', 'action'=>''))?>
        <input type="search" id="aa-search-input" class="form-control aa-input-search" placeholder="<?=__('Search')?>" name="title" autocomplete="off" value="<?=HTML::chars(core::get('title'))?>" />
        <button type="submit" class="primary-btn color-primary btn"><span><?=_e('Search')?></span> <i class="fa fa-search"></i></button>
    <?=FORM::close()?>
</div>

<script type="text/javascript">
    <?
        $config = array(
            'application_id'       => Core::config('general.algolia_search_application_id'),
            'search_api_key'       => Core::config('general.algolia_search_only_key'),
            'powered_by_enabled'   => Core::config('general.algolia_powered_by_enabled'),
            'query'                => core::request('title'),
            'autocomplete'         => array(
                'indices' => [
                    'ads' => [
                        'name' => 'yclas_ads'
                    ],
                    'categories' => [
                        'name' => 'yclas_categories'
                    ],
                    'locations' => [
                        'name' => 'yclas_locations'
                    ],
                    'users' => [
                        'name' => 'yclas_users'
                    ]
                ],
            ),
        );
    ?>
    var algolia = <?=json_encode($config)?>
</script>
