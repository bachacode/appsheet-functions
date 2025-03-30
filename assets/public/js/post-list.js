(function($) {
    'use strict';
    // Post List Widget Class
    class PostList {
        constructor(element, options) {
            this.element = $(element);
            this.options = options;
            this.searchQuery = '';
            this.selectedCategories = new Set();
            
            this.init();
        }

        init() {
            // Initialize the widget
            this.bindEvents();
            this.updatePostCount();
        }

        bindEvents() {
            // Search input event
            this.element.find('.tsm-search-input').on('input', (e) => {
                this.searchQuery = e.target.value.toLowerCase();
                this.filterPosts();
            });

            // Category checkbox events
            this.element.find('.tsm-categories-list__checkbox').on('change', (e) => {
                const category = $(e.target).data('category');
                this.toggleCategory(category);
            });
        }

        updatePostCount() {
            const visiblePosts = this.element.find('.tsm-post-list-element:visible').length;
            this.element.find('.tsm-post-count strong').text(visiblePosts);
        }

        toggleCategory(category) {
            if (this.selectedCategories.has(category)) {
                this.selectedCategories.delete(category);
            } else {
                this.selectedCategories.add(category);
            }
            this.filterPosts();
        }

        filterPosts() {
            const posts = this.element.find('.tsm-post-list-element');
            
            posts.each((_, post) => {
                const $post = $(post);
                const title = $post.find('.tsm-content-title').text().toLowerCase();
                const terms = JSON.parse($post.attr('data-terms'));
                
                const matchesSearch = title.includes(this.searchQuery);
                const matchesCategory = this.selectedCategories.size === 0 || 
                    terms.some(term => this.selectedCategories.has(term));
                
                if (matchesSearch && matchesCategory) {
                    $post.show();
                } else {
                    $post.hide();
                }
            });

            this.updatePostCount();
        }
    }

    // jQuery plugin wrapper
    $.fn.postList = function(options) {
        return this.each(function() {
            if (!$.data(this, 'postList')) {
                $.data(this, 'postList', new PostList(this, options));
            }
        });
    };

    // Initialize on document ready
    $(document).ready(function() {
        $('.tsm-container').postList();
    });

})(jQuery);