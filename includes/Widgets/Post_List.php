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
                    '.tsm-post-list-link',
                    '.tsm-post-list-link'
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
                            '{{WRAPPER}} .tsm-post-list-link' => 'max-width: {{VALUE}}px;',
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
                    '.tsm-content'
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
                    '.tsm-post-list-link',
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
            'tsm_excerpt_wrapper_style_section',
            'Excerpt Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_excerpt_wrapper', 
                    '.tsm-post-list-card-link',
                    '.tsm-content-excerpt__wrapper'
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
            'tsm_read_more_wrapper_style_section',
            'Read More Wrapper',
            \Elementor\Controls_Manager::TAB_STYLE,
            function() {
                $this->register_generic_controls(
                    'post_list_read_more_wrapper', 
                    '.tsm-post-list-card-link',
                    '.tsm-content-read-more__wrapper'
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

        // Check if we're in Elementor editor
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            $this->render_preview($posts, $settings);
        } else {
            Helpers::render_twig_template('post-list.html.twig', [
                'posts'      => $posts,
                'settings'   => $settings,
                'unique_id'  => $unique_id
            ]);
        }
    }

    /**
     * Render preview for Elementor editor
     * 
     * @param array $posts Array of post data
     * @param array $settings Widget settings
     */
    protected function render_preview($posts, $settings)
    {
        ?>
        <div class="tsm-container">
            <div class="tsm-post-list__wrapper">
                <?php foreach ($posts as $post) : ?>
                    <a href="<?php echo esc_url($post['link']); ?>" class="tsm-post-list-link">
                        <div class="tsm-post-list-link-content">
                            <?php if ($settings['tsm_post_list_show_image'] === 'yes' && $post['thumbnail']) : ?>
                                <div class="tsm-post-list-card__image">
                                    <img src="<?php echo esc_url($post['thumbnail']); ?>" alt="<?php echo esc_attr($post['title']); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="tsm-content">
                                <?php if ($settings['tsm_post_list_show_title'] === 'yes') : ?>
                                    <div class="tsm-content-title__wrapper">
                                        <span class="tsm-content-title"><?php echo esc_html($post['title']); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['tsm_post_list_show_category'] === 'yes' && $post['category_slug']) : ?>
                                    <div class="tsm-content-category__wrapper">
                                        <span class="tsm-content-category">
                                            <?php if ($settings['tsm_post_list_category_show_icon'] === 'yes') : ?>
                                                <i class="<?php echo esc_attr($settings['tsm_post_list_category_icon']['value']); ?>"></i>
                                            <?php endif; ?>
                                            <span><?php echo esc_html($post['category_name']); ?></span>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['tsm_post_list_show_excerpt'] === 'yes') : ?>
                                    <div class="tsm-content-excerpt__wrapper">
                                        <span class="tsm-content-excerpt"><?php echo wp_kses_post($post['excerpt']); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['tsm_post_list_show_read_more'] === 'yes') : ?>
                                    <div class="tsm-content-read-more__wrapper">
                                        <span class="tsm-content-read-more"><?php echo esc_html($settings['tsm_post_list_read_more_text']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <style>
            .tsm-container {
                width: 100%;
            }

            .tsm-post-list__wrapper {
                display: grid;
                width: 100%;
            }

            .tsm-post-list-link {
                display: flex;
                flex-direction: column;
                height: 100%;
                text-decoration: none;
            }

            .tsm-post-list-link-content {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .tsm-post-list-card__image {
                width: 100%;
                overflow: hidden;
            }

            .tsm-post-list-card__image img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .tsm-content {
                display: flex;
                flex-direction: column;
                flex: 1;
                height: 100%;
            }

            .tsm-content-title__wrapper {
                margin-bottom: 0.5rem;
            }

            .tsm-content-category__wrapper {
                margin-bottom: 0.5rem;
            }

            .tsm-content-excerpt__wrapper {
                flex: 1;
                margin-bottom: 0.5rem;
            }

            .tsm-content-read-more {
                margin-top: auto;
            }

            /* Add transition for smooth animations */
            .tsm-container * {
                transition: all 0.3s ease;
            }

            .tsm-post-list-link:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
        </style>
        <?php
    }

}

?>