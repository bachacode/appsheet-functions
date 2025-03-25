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

    protected function render()
    {
        wp_enqueue_script('tailorsheet-manager-alpinejs');
        wp_enqueue_script('tailwindcss');
        // Fetch posts
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
        ];
        $query = new \WP_Query($args);
        $posts = [];

        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'excerpt'   => get_the_excerpt(),
                'link'      => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'category_slug' => get_the_category()[0]->slug ?? '',
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
    
        Helpers::render_twig_template('example.html.twig', [
            'posts'      => $posts,
            'categories' => $category_data,
        ]);
    }

}

?>