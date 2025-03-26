<?php

namespace TailorSheet_Manager\Widgets;

/**
 * Builder class for registering Elementor controls with a fluent interface
 * 
 * This class provides a builder pattern implementation for registering various
 * Elementor controls (background, border, dimension, and text) in a more
 * readable and maintainable way.
 */
class TSM_Control_Builder {
    /**
     * The Elementor widget instance that will receive the controls
     * 
     * @var \Elementor\Widget_Base
     */
    private $widget;

    /**
     * Unique identifier for the control group
     * 
     * @var string
     */
    private $control_id;

    /**
     * CSS selector for the parent element that will trigger hover states
     * 
     * @var string
     */
    private $parent_selector;

    /**
     * CSS selector for the child element that will receive the styles
     * 
     * @var string
     */
    private $child_selector;

    /**
     * Flag to determine if background controls should be registered
     * 
     * @var boolean
     */
    private $include_background = false;

    /**
     * Flag to determine if border controls should be registered
     * 
     * @var boolean
     */
    private $include_border = false;

    /**
     * Flag to determine if dimension controls should be registered
     * 
     * @var boolean
     */
    private $include_dimension = false;

    /**
     * Flag to determine if text controls should be registered
     * 
     * @var boolean
     */
    private $include_text = false;

    /**
     * Flag to determine if text align controls should be registered
     * 
     * @var boolean
     */
    private $include_text_align = false;

    /**
     * Constructor for the control builder
     * 
     * @param \Elementor\Widget_Base $widget The Elementor widget instance
     * @param string $control_id Unique identifier for the control group
     * @param string $parent_selector CSS selector for the parent element
     * @param string $child_selector CSS selector for the child element
     */
    public function __construct($widget, $control_id, $parent_selector, $child_selector) {
        if (!$widget instanceof \Elementor\Widget_Base) {
            throw new \InvalidArgumentException('Widget must be an instance of Elementor\Widget_Base');
        }

        if (!is_string($control_id) || empty($control_id)) {
            throw new \InvalidArgumentException('Control ID must be a non-empty string');
        }

        if (!is_string($parent_selector) || empty($parent_selector)) {
            throw new \InvalidArgumentException('Parent selector must be a non-empty string');
        }

        if (!is_string($child_selector) || empty($child_selector)) {
            throw new \InvalidArgumentException('Child selector must be a non-empty string');
        }
        
        $this->widget = $widget;
        $this->control_id = sanitize_key($control_id);
        $this->parent_selector = $this->sanitize_css_selector($parent_selector);
        $this->child_selector = $this->sanitize_css_selector($child_selector);
    }

    /**
     * Sanitizes a CSS selector to prevent XSS
     * 
     * @param string $selector The CSS selector to sanitize
     * @return string The sanitized CSS selector
     */
    private function sanitize_css_selector($selector) {
        if (!is_string($selector)) {
            return '.tsm-default-selector';
        }

        // Remove any potentially dangerous characters
        $selector = preg_replace('/[^a-zA-Z0-9\s\-_.,#\[\]()=:>+~*]/', '', $selector);
        
        // Ensure the selector is not empty and starts with a valid character
        if (empty($selector) || !preg_match('/^[a-zA-Z0-9\-_.#\[\]()=:>+~*]/', $selector)) {
            return '.tsm-default-selector';
        }

        return $selector;
    }

    /**
     * Enables the registration of background controls
     * 
     * This method sets the flag to include background color controls
     * including hover states.
     * 
     * @return TSM_Control_Builder
     */
    public function withBackground() {
        $this->include_background = true;
        return $this;
    }

    /**
     * Enables the registration of border controls
     * 
     * This method sets the flag to include border controls
     * including hover states.
     * 
     * @return TSM_Control_Builder
     */
    public function withBorder() {
        $this->include_border = true;
        return $this;
    }

    /**
     * Enables the registration of dimension controls
     * 
     * This method sets the flag to include padding and margin controls.
     * 
     * @return TSM_Control_Builder
     */
    public function withDimension() {
        $this->include_dimension = true;
        return $this;
    }

    /**
     * Enables the registration of text controls
     * 
     * This method sets the flag to include typography and text color controls
     * including hover states.
     * 
     * @return TSM_Control_Builder
     */
    public function withText() {
        $this->include_text = true;
        return $this;
    }

    public function withTextAlign() {
        $this->include_text_align = true;
        return $this;
    }

    /**
     * Builds and registers all selected controls
     * 
     * This method checks which controls have been enabled and registers
     * them with the Elementor widget. It should be called after all
     * desired control types have been enabled.
     * 
     * @return void
     */
    public function build() {
        if (!$this->include_background && !$this->include_border && 
            !$this->include_dimension && !$this->include_text && !$this->include_text_align) {
            throw new \RuntimeException('At least one control type must be selected');
        }
        if ($this->include_background) {
            $this->register_background_controls();
        }
        if ($this->include_border) {
            $this->register_border_controls();
        }
        if ($this->include_dimension) {
            $this->register_dimension_controls();
        }
        if ($this->include_text) {
            $this->register_text_controls();
        }
        if ($this->include_text_align) {
            $this->register_text_align_controls();
        }
    }

    /**
     * Registers background-related controls
     * 
     * Adds controls for background color and hover states.
     * 
     * @return void
     */
    private function register_background_controls() {
        $this->widget->add_control(
            "tsm_{$this->control_id}_background_header",
            [
                'label' => esc_html__( 'Background Options', 'tailorsheet-manager' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'default',
            ]
        );

        $this->widget->start_controls_tabs(
            "tsm_{$this->control_id}_background_tabs"
        );

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_background_tab_normal",    
            [
                'label' => esc_html__( 'Normal', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_background_color",
            [
                'label'     => esc_html__( 'Background Color', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->child_selector}" => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_background_tab_hover",
            [
                'label' => esc_html__( 'Hover', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_background_color_hover",
            [
                'label'     => esc_html__( 'Background Color (Hover)', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->parent_selector}:hover {$this->child_selector}" => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->end_controls_tabs();
    }

    /**
     * Registers border-related controls
     * 
     * Adds controls for border styles and hover states.
     * 
     * @return void
     */
    private function register_border_controls() {
        $this->widget->add_control(
            "tsm_{$this->control_id}_border_header",
            [
                'label' => esc_html__( 'Border Options', 'tailorsheet-manager' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => "tsm_{$this->control_id}_border",
                'label'    => esc_html__( 'Border', 'tailorsheet-manager' ),
                'selector' => "{{WRAPPER}} {$this->child_selector}",
                'exclude'  => [ 'color' ],
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_border_radius",
            [
                'label'     => esc_html__( 'Border Radius', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors'  => [
                    "{{WRAPPER}} {$this->child_selector}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->widget->start_controls_tabs(
            "tsm_{$this->control_id}_border_color_tabs"
        );

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_border_color_tab_normal",
            [
                'label' => esc_html__( 'Normal', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_border_color",
            [
                'label'     => esc_html__( 'Border Color', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->child_selector}" => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_border_color_tab_hover",
            [
                'label' => esc_html__( 'Hover', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_border_color_hover",
            [
                'label'     => esc_html__( 'Border Color (Hover)', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->parent_selector}:hover {$this->child_selector}" => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->end_controls_tabs();
    }

    /**
     * Registers dimension-related controls
     * 
     * Adds controls for padding and margin settings.
     * 
     * @return void
     */
    private function register_dimension_controls() {
        $this->widget->add_control(
            "tsm_{$this->control_id}_dimensions_header",
            [
                'label' => esc_html__( 'Dimensions Options', 'tailorsheet-manager' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_padding",
            [
                'label'      => esc_html__( 'Padding', 'tailorsheet-manager' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors'  => [
                    "{{WRAPPER}} {$this->child_selector}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_margin",
            [
                'label'      => esc_html__( 'Margin', 'tailorsheet-manager' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors'  => [
                    "{{WRAPPER}} {$this->child_selector}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Registers text-related controls
     * 
     * Adds controls for typography, text color, and hover states.
     * 
     * @return void
     */
    private function register_text_controls() {
        $this->widget->add_control(
            "tsm_{$this->control_id}_typography_header",
            [
                'label' => esc_html__( 'Typography Options', 'tailorsheet-manager' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => "tsm_{$this->control_id}_typography",
                'label'    => esc_html__( 'Typography', 'tailorsheet-manager' ),
                'selector' => "{{WRAPPER}} {$this->child_selector}",
            ]
        );

        $this->widget->start_controls_tabs(
            "tsm_{$this->control_id}_text_color_tabs"
        );

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_text_color_tab_normal",        
            [
                'label' => esc_html__( 'Normal', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_text_color",
            [
                'label'     => esc_html__( 'Text Color', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->child_selector}" => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->start_controls_tab(
            "tsm_{$this->control_id}_text_color_tab_hover",
            [
                'label' => esc_html__( 'Hover', 'tailorsheet-manager' ),
            ]
        );

        $this->widget->add_control(
            "tsm_{$this->control_id}_text_color_hover",
            [
                'label'     => esc_html__( 'Text Color (Hover)', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} {$this->parent_selector}:hover {$this->child_selector}" => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->widget->end_controls_tab();

        $this->widget->end_controls_tabs();
    }

    private function register_text_align_controls() {
        $this->widget->add_control(
            "tsm_{$this->control_id}_text_align",
            [
                'label'     => esc_html__( 'Text Align', 'tailorsheet-manager' ),
                'type'      => \Elementor\Controls_Manager::SELECT, 
                'default'   => 'left',
                'options'   => [
                    'left'   => esc_html__( 'Left', 'tailorsheet-manager' ),
                    'center' => esc_html__( 'Center', 'tailorsheet-manager' ),
                    'right'  => esc_html__( 'Right', 'tailorsheet-manager' ),
                ],
                'selectors' => [
                    "{{WRAPPER}} {$this->child_selector}" => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }
}