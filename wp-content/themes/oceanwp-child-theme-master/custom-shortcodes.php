<?php

    // shortcode display customer reviews on homepage
    // function getCustomerReviews() {
    //     $args = array(
    //         'post_type'      => 'customers',
    //         'posts_per_page' => -1,
    //     );

    //     $customers = new WP_Query($args);

    //     return $customers;
    // }

    function homepageCustomerReview() {
        $content = '';
        $args = array(
            'post_type'      => 'customers',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'orderby' => 'rand',
        );

        $customers = new WP_Query($args);
        
        if ( $customers->have_posts() ) {
            $content .= '<div class="container-fluid">';
            $content .= '<div class="row g-0 justify-content-center">';
            while( $customers->have_posts() ) {
                $customers->the_post();
                $content .= '<div class="col text-center cust-review-card">';
                $content .= '<div class="card shadow">';
                $content .= '<div class="rounded-circle shadow card-img-div border"><img src="' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '" class="card-img-top" alt="' . get_the_title() . '"></div>';
                $content .= '<div class="card-body">';
                $content .= '<h4 class="card-title">' . get_the_title() . '</h4>';
                $content .= '<p class="card-position">' . get_post_meta( get_the_ID(), 'position', true ) . '</p>';
                $content .= '<p class="card-text">"' . get_the_content() . '"</p>';
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</div>';
            }
            wp_reset_postdata();

            $content .= '</div>';
            $content .= '</div>';
        }

        print_r( $content );
    }

    add_shortcode('homepage-customer-review', 'homepageCustomerReview');

    // get schedules
    function getAllSchedules() {
        $content = '';
        $args = array(
            'category_name' => 'schedule',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'order' => 'desc',
        );

        $schedules = new WP_Query( $args );

        // var_dump( $schedules );
        
        if ( $schedules->have_posts() ) {
            $content .= '<ul id="schedule-list">';
            while( $schedules->have_posts() ) {
                $schedules->the_post();

                $content .= '<li class="schedule-list-item">';
                $content .= '<div class="schedule-title">' . get_the_title() . '</div>';
                $content .= '<div class="schedule-download"><a href="' . get_field( 'schedule' ) . '" target="_blank">Download</a></div>';
                $content .= '</li>';
            }
            wp_reset_postdata();

            $content .= '</ul>';
        }

        print_r( $content );
    }

    add_shortcode('schedules', 'getAllSchedules');

    // get news
    function getAllNews() {
        $content = '';
        $args = array(
            'post_type'      => 'news',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'meta_value',
            'meta_key'       => 'news_date',
            'order'          => 'DESC'
        );

        $news = new WP_Query( $args );

        // var_dump( $news );
        
        if ( $news->have_posts() ) {
            $content .= '<ul id="news-list">';
            while( $news->have_posts() ) {
                $news->the_post();

                $content .= '<li class="news-list-item">';
                $content .= '<div class="news-img"><a href="' . get_permalink() . '"><img src="' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '" alt="' . get_the_title() . '"></a></div>';
                $content .= '<div class="news-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
                $content .= '<div class="news-text">' . wp_trim_words( get_the_content(), 40, '...' ) . '</div>';
                $content .= '<div class="news-readmore-btn"><a href="' . get_permalink() . '">Read More</a></div>';
                $content .= '</li>';
            }
            wp_reset_postdata();

            $content .= '</ul>';
        }

        print_r( $content );
    }

    add_shortcode('news', 'getAllNews');

    // get news
    function getAllMilestones() {
        $content = '';
        $args = array(
            'post_type'      => 'milestones',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            // 'meta_key'       => 'order',
            // 'meta_type'      => 'NUMERIC',
            'orderby'        => [
                 'milestone_month' => 'ASC',
                 'milestone_year' => 'ASC',
            ],
        );

        $milestones = new WP_Query( $args );

        $months = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec' );

        // var_dump( $milestones );
        
        if ( $milestones->have_posts() ) {
            $content .= '<div id="milestones">';
            while( $milestones->have_posts() ) {
                $milestones->the_post();

                $content .= '<div class="milestones-item">';
                $content .= '<div class="milestones-org-bar"><img src="/wp-content/uploads/2023/03/shim.png" /><div class="milestone-org-circle"><img src="/wp-content/uploads/2023/03/org-circle.png" /></div></div>';
                $content .= '<div class="milestones-date"><span>' . $months[get_field( 'milestone_month', get_the_ID() )] . '</span> ' . get_field( 'milestone_year', get_the_ID() ) . '</div>';
                $content .= '<div class="milestones-title">' . get_the_title() . '</div>';
                $content .= '<div class="milestones-text">' . get_the_content() . '</div>';

                if( get_post_thumbnail_id( get_the_ID() ) ) {
                    $content .= '<div class="milestones-img"><img src="' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '?v=03032023" alt="' . get_the_title() . '" /></div>';
                }

                $content .= '</div>';
            }
            wp_reset_postdata();

            $content .= '</div>';
        }

        print_r( $content );
    }

    add_shortcode('milestones', 'getAllMilestones');

    // shortcode for custom menu// Function that will return our Wordpress menu
    function list_menu( $atts, $content = null ) {
        extract( shortcode_atts( array(  
            'menu'            => '', 
            'container'       => 'div', 
            'container_class' => '', 
            'container_id'    => '', 
            'menu_class'      => 'menu', 
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 0,
            'walker'          => '',
            'theme_location'  => '' ), 
            $atts )
        );
    
    
        return wp_nav_menu( array( 
            'menu'            => $menu, 
            'container'       => $container, 
            'container_class' => $container_class, 
            'container_id'    => $container_id, 
            'menu_class'      => $menu_class, 
            'menu_id'         => $menu_id,
            'echo'            => false,
            'fallback_cb'     => $fallback_cb,
            'before'          => $before,
            'after'           => $after,
            'link_before'     => $link_before,
            'link_after'      => $link_after,
            'depth'           => $depth,
            'walker'          => $walker,
            'theme_location'  => $theme_location)
        );
    }
    //Create the shortcode
    add_shortcode( "listmenu", "list_menu" );

?>