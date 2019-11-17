<?php defined('SYSPATH') or die('No direct access allowed.');

if (Auth::instance()->logged_in() AND Auth::instance()->get_user()->is_admin() )
{
    $custom_fields = Model_Field::get_all();

    if (Core::get('theme-config') == '1')
    {
        $new_field  = new Model_Field();

        $fields = $arrayName = array(
                array('name' => 'auction_days',
                    'type' => 'integer',
                    'options' => array(
                        'label' => 'Auction Days',
                        'tooltip' => 'Auction Days',
                        'required' => TRUE,
                        'searchable' => TRUE,
                        'admin_privilege' => FALSE,
                        'show_listing' => FALSE,
                        ),
                    'values' => FALSE,
                    ),
            );

        foreach ($fields as $field) {
            if ($new_field->create($field['name'],$field['type'],$field['values'],NULL,$field['options']))
            {
                Alert::set(Alert::SUCCESS,sprintf(__('Field %s created'),$field['name']));
            }
        }

        $configs = array(
                        array( 'config_key'     => 'messaging',
                               'group_name'     => 'general', 
                               'config_value'   => '1'),
                        array( 'config_key'     => 'paypal_seller',
                               'group_name'     => 'payment', 
                               'config_value'   => '0'),
                        array( 'config_key'     => 'contact_price',
                               'group_name'     => 'advertisement', 
                               'config_value'   => '1'),
                        array( 'config_key'     => 'price',
                               'group_name'     => 'advertisement', 
                               'config_value'   => '1'),
                        );
        
        foreach ($configs as $config) {
            Model_Config::set_value($config['group_name'], $config['config_key'], $config['config_value']);
        }

        $theme_data['theme_config'] = 1;
        Theme::save('auction', $theme_data);
        Core::delete_cache();
        
        header('Location: ' . Route::url('oc-panel',array('controller'=>'theme','action'=>'options')));
    }
    elseif (Core::get('theme-config') == '0')
    {
        $theme_data['theme_config'] = 1;
        Theme::save('auction', $theme_data);
        Core::delete_cache();
        header('Location: ' . Route::url('oc-panel',array('controller'=>'theme','action'=>'options')));
    }
    elseif ( ! array_key_exists('auction_days', $custom_fields)
        OR Core::config('general.messaging') == FALSE
        OR Core::config('advertisement.contact_price') == FALSE
        OR Core::config('advertisement.price') == FALSE
        OR Core::config('payment.paypal_seller') == TRUE)
    {
        Alert::set(Alert::WARNING, __('The configuration of the "Auction!" theme is not complete. Would you like to auto-configure it?').'<br><br> <a href="?theme-config=1" class="btn btn-success">'.__('Yes').'</a>'.' <a href="?theme-config=0" class="btn btn-danger">'.__('No').'</a>');
    }

}

// return 1 for list, 0 for grid **Can be placed in Theme class
function get_listgrid_state(){
    if((core::cookie('list/grid')!= NULL AND core::cookie('list/grid')==1) OR (core::cookie('list/grid')== NULL AND Theme::get('listgrid')==1))
        return 1; // list
    elseif((core::cookie('list/grid')!= NULL AND core::cookie('list/grid')==0) OR (core::cookie('list/grid')== NULL AND Theme::get('listgrid')==0))
        return 0; // grid
}

// return bid increment step
function get_bid_increment($price){

    // if increment step is NOT set in theme options

    // https://pages.ebay.co.uk/help/buy/bid-increments.html
    switch ($price) {
        case ($price > 0 AND $price < 1):
            $bid_increment = 0.05;
            break;
        case ($price >= 1 AND $price < 5):
            $bid_increment = 0.20;
            break;
        case ($price >= 5 AND $price < 15):
            $bid_increment = 0.50;
            break;
        case ($price >= 15 AND $price < 60):
            $bid_increment = 1.00;
            break;
        case ($price >= 60 AND $price < 150):
            $bid_increment = 2.00;
            break;
        case ($price >= 150 AND $price < 300):
            $bid_increment = 5.00;
            break;
        case ($price >= 300 AND $price < 600):
            $bid_increment = 10.00;
            break;
        case ($price >= 600 AND $price < 1500):
            $bid_increment = 20.00;
            break;
        case ($price >= 1500 AND $price < 3000):
            $bid_increment = 50.00;
            break;
        case ($price >= 3000):
            $bid_increment = 100.00;
            break;
        
        default:
            $bid_increment = 0;
            break;
    }

    return $bid_increment;
}

// hide bidder username
function hide_bidder_username($username){

    return substr($username, 0, 1).str_repeat('*', strlen($username) - 2).substr($username, strlen($username) - 1, 1);
}

// returns the time that the auction ends
function get_target_date($ad){

    if(isset($ad->cf_auction_days) AND $ad->cf_auction_days > 0){
        return $target_date = Date::mysql2unix($ad->published) + ($ad->cf_auction_days * 24 * 60 * 60);
    }
    else{
        return NULL;
    }
    
}

// returns remaining time or NULL
function get_remaining_time($ad){

    if(isset($ad->cf_auction_days) AND $ad->cf_auction_days > 0){
        $remaining_time = get_target_date($ad) - Date::mysql2unix('now');
        if(($remaining_time > 0) AND ($ad->price > 0)) // valid ads for auction need to have remaining time and price > 0
            return $remaining_time;
        else
            return 0;
    }
    else
        return 0;
}

// marks the ad as sold if remaining time equal or less than zero
function deactivate_auction($ad){

    if($ad->status == Model_Ad::STATUS_PUBLISHED AND get_remaining_time($ad) == 0){
        
        $ad->status = Model_Ad::STATUS_SOLD;
        try
        {
            $ad->save();
        }
        catch (Exception $e)
        {
            throw HTTP_Exception::factory(500,$e->getMessage());
        }

    }
}

// return array with sold ads (for homepage closed auctions section)
function get_sold_ads(){

    // Get sold ads
    $ads = new Model_Ad();
    $ads = $ads->where('status','=',Model_Ad::STATUS_SOLD)
                // ->limit(Theme::get(''))
                ->find_all();

    return (core::count($ads) > 0)?$ads:NULL;
}