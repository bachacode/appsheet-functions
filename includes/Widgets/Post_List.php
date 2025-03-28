<?php

namespace TailorSheet_Manager\Widgets;

use TailorSheet_Manager\Helpers;

class Post_List extends TSM_Widget_Base
{
    public function get_name()
    {
        return 'tsm_post_list';
    }

    public function get_title()
    {
        return esc_html__('Post List', 'tailorsheet-manager');
    }

    public function get_icon()
    {
        return 'eicon-editor-code';
    }

    public function get_keywords()
    {
        return [ 'tailorsheet', 'appsheet', 'posts', 'list' ];
    }

    protected function _register_controls()
    {
        // Register the Basic section
        $this->register_basic_controls();

        // Register the Grid section (shown when "Elements" is selected)
        $this->register_grid_controls();

        // // Register the Current Post meta controls (shown when "Current Post" is selected)
        // $this->register_current_post_controls();

        // // Register the elements icon
        // $this->register_icons_controls();

        // Style controls
        $this->register_style_controls();

        // Card controls
        $this->register_card_controls();
    }

    /**
     * Register Basic controls.
     */
    protected function register_basic_controls()
    {
        $this->register_generic_section(
            'tsm_post_list_basic_section', 
            'Query', 
            \Elementor\Controls_Manager::TAB_CONTENT,
            function () {
                $this->add_control(
                    'tsm_post_list_source',
                    [
                        'label'   => esc_html__( 'Source', 'tailorsheet-manager' ),
                        'type'    => \Elementor\Controls_Manager::SELECT,
                        'default' => 'expresiones-appsheet',
                        'options' => array(
                            'expresiones-appsheet' => esc_html__( 'Appsheet Functions', 'tailorsheet-manager' ),
                            'ejemplos-appsheet' => esc_html__( 'AppSheet Examples', 'tailorsheet-manager' )
                        ),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_taxonomy',
                    [
                        'label'   => esc_html__( 'Main Taxonomy', 'tailorsheet-manager' ),
                        'type'    => \Elementor\Controls_Manager::SELECT,
                        'default' => 'categoria-de-expresion',
                        'options' => array(
                            'categoria-de-expresion' => esc_html__( 'Function Category', 'tailorsheet-manager' ),
                            'sector-de-ejemplo'   => esc_html__('Example Sector', 'tailorsheet-manager'),
                            'func-de-ejemplo'       => esc_html__('Example Functionality', 'tailorsheet-manager'),
                            'integracion-de-ejemplo' => esc_html__('Example Integration', 'tailorsheet-manager'),
                        ),
                    ]
                );

                $this->add_control(
                    'tsm_search_placeholder',
                    [
                        'label'     => esc_html__('Search Placeholder', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::TEXT,
                        'default'   => esc_html__('Search posts...', 'tailorsheet-manager'),
                        'separator' => 'before',
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_post_list_terms_section',
            'Terms',
            \Elementor\Controls_Manager::TAB_CONTENT,
            function() {
                $repeater = new \Elementor\Repeater();

                $repeater->add_control(
                    'term_title',
                    [
                        'label' => esc_html__( 'Terms Title', 'tailorsheet-manager' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' =>  esc_html__( 'Category', 'tailorsheet-manager' ),
                    ]
                );

                $repeater->add_control(
                    'term_slug',
                    [
                        'label' => esc_html__( 'Terms', 'tailorsheet-manager' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'categoria-de-expresion' => esc_html__( 'Function Category', 'tailorsheet-manager' ),
                            'sector-de-ejemplo'   => esc_html__('Example Sector', 'tailorsheet-manager'),
                            'func-de-ejemplo'       => esc_html__('Example Functionality', 'tailorsheet-manager'),
                            'integracion-de-ejemplo' => esc_html__('Example Integration', 'tailorsheet-manager'),
                        ],
                        'default' => 'categoria-de-expresion'
                    ]
                );
                

                $this->add_control(
                    'tsm_post_list_terms_filter',
                    [
                        'label'   => esc_html__( 'Taxonomies', 'tailorsheet-manager' ),
                        'type'    => \Elementor\Controls_Manager::REPEATER,
                        'fields' => $repeater->get_controls(),
                        'title_field' => '{{{ term_title }}}'
                    ]
                );
            }
        );
    }

    protected function register_grid_controls()
    {
        $this->register_generic_section(
            'tsm_list_section',
            'List',
            \Elementor\Controls_Manager::TAB_CONTENT,
            function() {
                $this->add_responsive_control(
                    'tsm_list_cols',
                    [
                        'label'     => esc_html__( 'Columns', 'tailorsheet-manager' ),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'default'   => 3,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list__wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                        ],
                    ]
                );
            }
        );
    }

    protected function register_card_controls()
    {
        $this->register_generic_section(
            'tsm_post_list_elements_section',
            'Elements',
            \Elementor\Controls_Manager::TAB_CONTENT,
            function() {
                $this->add_control(
                    'tsm_post_list_whole_post_linkable',
                    [
                        'label'     => esc_html__('Make Whole Post Linkable', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'no',
                        'label_on'  => esc_html__('Yes', 'tailorsheet-manager'),
                        'label_off' => esc_html__('No', 'tailorsheet-manager'),
                        'separator' => 'before',
                    ]
                );

                $this->add_control(
                    'tsm_post_list_show_image',
                    [
                        'label'     => esc_html__('Show Featured Image', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_show_category',
                    [
                        'label'     => esc_html__('Show Category', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_category_show_icon',
                    [
                        'label'     => esc_html__('Show Category Icon', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );
                $this->add_control(
                    'tsm_post_list_category_icon',
                    [
                        'label'     => esc_html__('Category Icon', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::ICONS,
                        'default'   => [
                            'value'   => 'fas fa-tag',
                            'library' => 'fa-solid',
                        ],
                        'condition' => [
                            'tsm_post_list_show_category' => 'yes',
                        ],
                    ]
                );

                $this->add_control(
                    'tsm_post_list_show_title',
                    [
                        'label'     => esc_html__('Show Title', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_show_excerpt',
                    [
                        'label'     => esc_html__('Show Excerpt', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_show_read_more',
                    [
                        'label'     => esc_html__('Show Read More', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SWITCHER,
                        'default'   => 'yes',
                        'label_on'  => esc_html__('Show', 'tailorsheet-manager'),
                        'label_off' => esc_html__('Hide', 'tailorsheet-manager'),
                    ]
                );

                $this->add_control(
                    'tsm_post_list_read_more_text',
                    [
                        'label'     => esc_html__('Read More Text', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::TEXT,
                        'default'   => esc_html__('Read More', 'tailorsheet-manager'),
                        'condition' => [
                            'tsm_post_list_show_read_more' => 'yes',
                        ],
                    ]
                );

                
            }
        );
    }

    protected function register_style_controls()
    {
        $this->register_generic_section(
            'tsm_search_style_section',
            'Search Bar',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_search', 
                    '.tsm-search-input'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withText()
                ->build();

                $this->add_control(
                    'tsm_search_icon_color',
                    [
                        'label'     => esc_html__('Icon Color', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-search-icon' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'tsm_search_max_width',
                    [
                        'label'     => esc_html__('Max Width', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range'     => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'   => [
                            'unit' => 'px',
                            'size' => 500,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .tsm-search-container' => 'max-width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'tsm_search_margin',
                    [
                        'label'     => esc_html__('Margin', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .tsm-search-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(    
            'tsm_sidebar_style_section',
            'Sidebar',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_sidebar',
                    '.tsm-sidebar'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();

                $this->add_control(
                    'tsm_sidebar_checkbox_spacing',
                    [
                        'label'     => esc_html__('Checkbox Spacing', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range'     => [
                            'px' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default'   => [
                            'unit' => 'px',
                            'size' => 10,
                        ], 
                        'selectors' => [
                            '{{WRAPPER}} .tsm-categories-list__checkbox' => 'margin-right: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_list_style_section',
            'List',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_list', 
                    '.tsm-post-list__wrapper'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();

                $this->add_control(
                    'tsm_post_list_gap',
                    [
                        'label'     => esc_html__('Gap', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'default'   => 20,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list__wrapper' => 'gap: {{VALUE}}px;',
                        ],
                    ]
                );

                $this->add_control(
                    'tsm_post_list_width',
                    [
                        'label'     => esc_html__('List Width (px)', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list__wrapper' => 'width: {{VALUE}}px;',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_element_style_section',
            'Element',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_element', 
                    '.tsm-post-list-element',
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withShadow()
                ->build();

                $this->add_control(
                    'tsm_post_list_element_width',
                    [
                        'label'     => esc_html__('Element Width (px)', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list-element' => 'max-width: {{VALUE}}px;',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_content_style_section',
            'Content',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_content', 
                    '.tsm-content',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_heading_wrapper_style_section',
            'Heading Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_heading_wrapper', 
                    '.tsm-content-title__wrapper',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withTextAlign()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_heading_style_section',
            'Heading',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_heading', 
                    '.tsm-content-title',
                    '.tsm-post-list-element',
                    
                )
                ->withText()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_excerpt_wrapper_style_section',
            'Excerpt Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_excerpt_wrapper', 
                    '.tsm-content-excerpt__wrapper',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withTextAlign()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_excerpt_style_section',
            'Excerpt',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_excerpt', 
                    '.tsm-content-excerpt',
                    '.tsm-post-list-element'    
                )
                ->withText()
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_read_more_wrapper_style_section',
            'Read More Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_read_more_wrapper', 
                    '.tsm-content-read-more__wrapper',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withTextAlign()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_read_more_style_section',
            'Read More',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_read_more', 
                    '.tsm-content-read-more'
                )
                ->withText()
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_image_style_section',
            'Image',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_image', 
                    '.tsm-post-list-card__image',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();

                $this->add_control(
                    'tsm_post_list_image_height',
                    [
                        'label'     => esc_html__('Image Height (px)', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'default'   => 100, 
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list-card__image' => 'height: {{VALUE}}px;',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_category_wrapper_style_section',
            'Category Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_category_wrapper',   
                    '.tsm-content-category__wrapper',
                    '.tsm-post-list-element'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->withTextAlign()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_category_style_section',
            'Category',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_category', 
                    '.tsm-content-category',
                    '.tsm-post-list-element'
                )
                ->withText()
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();
            }
        );
    }

    protected function render()
    {
        // Enqueue Alpine.js
        wp_enqueue_script(
            'tailorsheet-manager-alpinejs',
            'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js',
            [],
            '3.x.x',
            true
        );

        $settings = $this->get_settings_for_display();
        
        // Generate a unique ID for this widget instance
        $unique_id = 'tsm_' . $this->get_id();

        // Get selected taxonomies
        if($settings['tsm_post_list_terms_filter']) {
            $selected_taxonomies = $settings['tsm_post_list_terms_filter'];
        } else {
            $selected_taxonomies = [];
        }

        $main_taxonomy = $settings['tsm_post_list_taxonomy'];
        
        // Initialize categories array to store terms from all selected taxonomies
        $all_categories = [];
        
        // Query terms for each selected taxonomy
        foreach ($selected_taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy['term_slug'],
                'hide_empty' => false,
            ]);
            
            $all_categories[$taxonomy['term_slug']] = [
                'title' => $taxonomy['term_title'],
                'taxonomy_list' => []
            ];

            if (!is_wp_error($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    $all_categories[$taxonomy['term_slug']]['taxonomy_list'][] = [
                        'name' => $term->name,
                        'slug' => $term->slug,
                        'taxonomy' => $taxonomy,
                        'term_id' => $term->term_id
                    ];
                }
            }
        }

        // Fetch posts
        $args = [
            'post_type'      => $settings['tsm_post_list_source'],
            'posts_per_page' => -1,
        ];
        $query = new \WP_Query($args);
        $posts = [];

        while ($query->have_posts()) {
            $query->the_post();
            $post_terms = [];
            $post_taxonomies = [];
            
            // Get terms from all selected taxonomies for this post
            foreach ($selected_taxonomies as $taxonomy) {
                $terms = get_the_terms(get_the_ID(), $taxonomy['term_slug']);
                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $post_terms[] = $term->slug;
                        $post_taxonomies[$term->slug] = [
                            'slug' => $term->slug,
                            'name' => $term->name,
                            'taxonomy' => $taxonomy['term_slug'],
                            'term_id' => $term->term_id
                        ];
                    }
                }
            }

            $posts[] = [
                'id'         => get_the_ID(),
                'title'      => get_the_title(),
                'excerpt'    => get_the_excerpt(),
                'link'       => get_permalink(),
                'thumbnail'  => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'terms'      => $post_terms,
                'taxonomies' => $post_taxonomies,
                'main_taxonomy' => !empty($main_taxonomy) ? get_the_terms(get_the_ID(), $main_taxonomy)[0]->name : '',
                'taxonomy_slugs' => array_keys($post_taxonomies)
            ];
        }
        wp_reset_postdata();

        Helpers::render_twig_template('post-list.html.twig', [
            'posts'       => $posts,
            'settings'    => $settings,
            'unique_id'   => $unique_id,
            'categories'  => $all_categories
        ]);
    }

}

?>