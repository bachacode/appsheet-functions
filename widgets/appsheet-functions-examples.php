<?php

class Elementor_Appsheet_Functions_Examples extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'appsheet_functions_examples';
    }

    public function get_title()
    {
        return esc_html__('Appsheet Functions Examples', 'tailorsheet-manager');
    }

    public function get_icon()
    {
        return 'eicon-bullet-list';
    }

    public function get_categories()
    {
        return [ 'appsheet-functions' ];
    }

    public function get_keywords()
    {
        return [ 'appsheet', 'functions', 'examples' ];
    }

    protected function render()
    {
        if ( !function_exists( 'af_show_template' ) ) {
            return;
        }
        
        $queried_object = get_queried_object();
        if ( $queried_object ) {
            $post_id = $queried_object->ID;
            $terms = get_the_terms($post_id, 'ejemplo-de-expresion');
            if ($terms && !is_wp_error($terms)) {
                af_show_template( 'af-examples-list', [ 'terms' => $terms ] );
             } else { 
                af_show_template( 'af-examples-error');
             }
        }
    }

}

