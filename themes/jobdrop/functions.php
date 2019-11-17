<?php defined('SYSPATH') or die('No direct access allowed.');

if (Auth::instance()->logged_in() 
    AND Auth::instance()->get_user()->is_admin()
    AND (!isset($theme_data['theme_config']) OR $theme_data['theme_config'] == 0))
{
    $custom_fields = Model_Field::get_all();

    if (Core::get('theme-config') == '1')
    {
        $new_field  = new Model_Field();

        $fields = $arrayName = array(
                array('name' => 'company',
                    'type' => 'string',
                    'options' => array(
                        'label' => 'Company Name',
                        'tooltip' => 'Company Name',
                        'required' => TRUE,
                        'searchable' => TRUE,
                        'admin_privilege' => FALSE,
                        'show_listing' => FALSE,
                        ),
                    'values' => '',
                    ),
                array('name' => 'companylogo',
                    'type' => 'string',
                    'options' => array(
                        'label' => 'Company Logo URL',
                        'tooltip' => 'Company Logo URL',
                        'required' => FALSE,
                        'searchable' => FALSE,
                        'admin_privilege' => FALSE,
                        'show_listing' => FALSE,
                        ),
                    'values' => '',
                    ),
                array('name' => 'companydescription',
                    'type' => 'textarea',
                    'options' => array(
                        'label' => 'Company Description',
                        'tooltip' => 'Company Description',
                        'required' => FALSE,
                        'searchable' => FALSE,
                        'admin_privilege' => FALSE,
                        'show_listing' => FALSE,
                        ),
                    'values' => '',
                    ),
                array('name' => 'jobtype',
                    'type' => 'string',
                    'options' => array(
                        'label' => 'Job type',
                        'tooltip' => 'Job type',
                        'required' => TRUE,
                        'searchable' => TRUE,
                        'admin_privilege' => FALSE,
                        'show_listing' => TRUE,
                        ),
                    'values' => 'Full-time,Part-time',
                    ),
            );

        foreach ($fields as $field) {
            if ($new_field->create($field['name'],$field['type'],$field['values'],NULL,$field['options']))
            {
                Alert::set(Alert::SUCCESS,sprintf(__('Field %s created'),$field['name']));
            }
        }

        $configs = array(
                        array( 'config_key'     => 'landing_page',
                               'group_name'     => 'general', 
                               'config_value'   => '{"controller":"ad","action":"listing"}'),
                        );
        
        Model_Config::config_array($configs);
        Core::delete_cache();
        header('Location: ' . Route::url('oc-panel',array('controller'=>'theme','action'=>'options')));
    }
    elseif (Core::get('theme-config') == '0')
    {
        $theme_data['theme_config'] = 1;
        Theme::save('jobdrop', $theme_data);
        Core::delete_cache();
        header('Location: ' . Route::url('oc-panel',array('controller'=>'theme','action'=>'options')));
    }
    elseif ( ! array_key_exists('company', $custom_fields)
        OR  ! array_key_exists('companylogo', $custom_fields)
        OR  ! array_key_exists('companydescription', $custom_fields)
        OR  ! array_key_exists('jobtype', $custom_fields))
    {
        Alert::set(Alert::WARNING, __('Some theme custom field(s) does not exist. Would you like to create them?').'<br><br> <a href="?theme-config=1" class="btn btn-success">'.__('Yes').'</a>'.' <a href="?theme-config=0" class="btn btn-danger">'.__('No').'</a>');
    }

}
