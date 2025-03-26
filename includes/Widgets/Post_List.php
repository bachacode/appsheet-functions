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
                            'sector-de-categoria'   => esc_html__('Example Sector', 'tailorsheet-manager'),
                            'func-de-ejemplo'       => esc_html__('Example Functionality', 'tailorsheet-manager'),
                            'integracion-de-ejemplo' => esc_html__('Example Integration', 'tailorsheet-manager'),
                        ),
                    ]
                );

                // Get all registered taxonomies
                $taxonomies = get_taxonomies(['public' => false], 'objects');
                $taxonomy_options = [];
                foreach ($taxonomies as $taxonomy) {
                    $taxonomy_options[$taxonomy->name] = $taxonomy->label;
                }

                $this->add_control(
                    'tsm_post_list_terms',
                    [
                        'label'   => esc_html__( 'Terms', 'tailorsheet-manager' ),
                        'type'    => \Elementor\Controls_Manager::SELECT2,
                        'options' => $taxonomy_options,
                        'multiple' => true,
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
                $this->add_control(
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
            'tsm_list_style_section',
            'List',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_list', 
                    '.tsm-post-list__wrapper',
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
            }
        );

        $this->register_generic_section(
            'tsm_content_style_section',
            'Content',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_content', 
                    '.tsm-post-list-link',
                    '.tsm-post-list-link-content'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();

                $this->add_control(
                    'tsm_post_list_content_width',
                    [
                        'label'     => esc_html__('Content Width (px)', 'tailorsheet-manager'),
                        'type'      => \Elementor\Controls_Manager::NUMBER,
                        'default'   => 100,
                        'selectors' => [
                            '{{WRAPPER}} .tsm-post-list-link-content' => 'max-width: {{VALUE}}px;',
                        ],
                    ]
                );
            }
        );

        $this->register_generic_section(
            'tsm_heading_wrapper_style_section',
            'Heading Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_heading_wrapper', 
                    '.tsm-post-list-card-link',
                    '.tsm-content-title__wrapper'
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
                    '.tsm-post-list-card-link',
                    '.tsm-content-title'
                )
                ->withText()
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
                    '.tsm-post-list-card-link',
                    '.tsm-content-excerpt'
                )
                ->withText()
                ->withBackground()
                ->withBorder()
                ->withDimension()
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
                    '.tsm-post-list-card-link',
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
                    '.tsm-post-list-card-link',
                    '.tsm-post-list-card__image'
                )
                ->withBackground()
                ->withBorder()
                ->withDimension()
                ->build();
            }
        );

        $this->register_generic_section(
            'tsm_category_wrapper_style_section',
            'Category Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_category_wrapper',   
                    '.tsm-post-list-card-link',
                    '.tsm-content-category__wrapper'
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
                    '.tsm-post-list-card-link',
                    '.tsm-content-category'
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
        wp_enqueue_script('tailorsheet-manager-alpinejs');

        $settings = $this->get_settings_for_display();

        // Fetch posts
        $args = [
            'post_type'      => $settings['tsm_post_list_source'],
            'posts_per_page' => -1,
        ];
        $query = new \WP_Query($args);
        $posts = [];

        while ($query->have_posts()) {
            $query->the_post();
            $terms = get_the_terms(get_the_ID(), $settings['tsm_post_list_taxonomy']);
            $category_slug = '';
            $category_name = '';
            
            if ($terms && !is_wp_error($terms) && !empty($terms)) {
                $first_term = reset($terms);
                $category_slug = esc_attr($first_term->slug);
                $category_name = esc_html($first_term->name);
            }

            $posts[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'excerpt'   => get_the_excerpt(),
                'link'      => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'category_slug' => $category_slug,
                'category_name' => $category_name,
            ];
        }
        wp_reset_postdata();

        // Fetch categories
        $categories = get_categories(['hide_empty' => true]);
        $category_data = [];
        foreach ($categories as $category) {
            $category_data[] = [
                'name' => $category->name,
                'slug' => $category->slug,
            ];
        }
    
        Helpers::render_twig_template('post-list.html.twig', [
            'posts'      => $posts,
            'categories' => $category_data,
            'settings'   => $settings
        ]);
    }

}

?>