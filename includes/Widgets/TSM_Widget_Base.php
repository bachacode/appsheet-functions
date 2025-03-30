<?php

namespace TailorSheet_Manager\Widgets;

use TailorSheet_Manager\Widgets\TSM_Control_Builder;

class TSM_Widget_Base extends \Elementor\Widget_Base 
{
    private TSM_Control_Builder $control_builder;

    public function get_name()
    {
        return 'tsm_widget_base';
    }

    public function get_categories()
    {
        return [ 'tailorsheet-manager' ];
    }

    public function get_keywords()
    {
        return [ 'tailorsheet' ];
    }

    /**
     * Registers a basic tab
     * @param string $section_id
     * @param string $label
     * @param string $tab_type
     * @param \Closure $controls
     */
    protected function register_generic_section($section_id, $label, $tab_type, $controls) {
        // Sanitize inputs
        $section_id = sanitize_key($section_id);
        $label = sanitize_text_field($label);
        $tab_type = sanitize_key($tab_type);

        $this->start_controls_section(
            $section_id,
            [
                'label' => esc_html__($label, 'tailorsheet-manager'),
                'tab'   => $tab_type,
            ]
        );

        $controls();

        $this->end_controls_section();
    }

    protected function register_generic_controls($control_id, $child_selector, $parent_selector = '') {
        $this->control_builder = new TSM_Control_Builder($this, $control_id, $child_selector, $parent_selector);
        return $this->control_builder;
    }
}