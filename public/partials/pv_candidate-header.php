<?php

/**
 *
 *  The template for displaying the header
 *
 *  Displays all of the head element and everything up until the breadcrumbs or content
 *
 *  @package WordPress
 *  @subpackage Materialize
 *  @since Materialize 1.0
 */



?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

    <head>

        <meta charset="<?php bloginfo( 'charset' ); ?>" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />

        <?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>

       		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <?php } ?>

        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

        <?php
		/**
		 *
		 *  Chekc if can show or can hide the header for different templates
		 *  From theme options ( Appearance > Customize > Header Elements > General )
		 *  you can enable and disable the header for next templates:
		 *  Front Page ( static page ), Blog, Archives Templates ( Archives, Author,
		 *  Categories, Tags, 404 and Search ), Sigle Post and Single Page.
		 */
       	$show_header            = false;

			// Front Page ( show / hide )
            $on_front_page		= get_theme_mod( 'mythemes-header-front-page', true );

            // get the Front Page ( static page )
            $is_enb_front_page 	= get_option( 'show_on_front' ) == 'page';

            $is_front_page   	= $is_enb_front_page && is_front_page();

            // blog page ( show / hide )
            $on_blog_page     	= get_theme_mod( 'mythemes-header-blog-page', false );

            // get the blog page
            if ( $is_enb_front_page ) {

                $is_blog_page = is_home();

            } else {

                $is_blog_page = is_front_page();

            }

            /**
             *
             *  Check if is static Front Page and
             *  if can show header for static Front Page
             */

            if ( $is_front_page && $on_front_page ) {

                $show_header = true;

            }

            /**
             *
             *  Check if is static Front Page and
             *  if can hide header for static Front Page
             */

            else if ( $is_front_page && !$on_front_page ) {

                $show_header = false;

            }

            /**
             *
             *  Check if is Blog Page and
             *  if can show header for Blog Page
             */

            else if ( $is_blog_page && $on_blog_page ) {

                $show_header = true;

            }

            /**
             *
             *  Check if is Blog Page and
             *  if can hide header for Blog Page
             */

            else if ( $is_blog_page && !$on_blog_page ) {

                $show_header = false;

            }

            // check if is single post

            else if ( is_singular( 'post' ) ) {

	            // show or hide the header for single post
	            $show_header = get_theme_mod( 'mythemes-header-single-post', false );

            }

            // check if is single page ( exclude static front page )
            else if ( is_singular( 'page' ) && ! $is_front_page ) {

                // show or hide the header for single page
                $show_header = get_theme_mod( 'mythemes-header-single-page', false );

            }

            // show or hide the header for archives templates
            else {

                $show_header = get_theme_mod( 'mythemes-header-templates', false );

            }

            // header class
            $mythemes_header_class      = 'mythemes-miss-header-image';

            if ( $show_header ) {

                $mythemes_header_class  = '';

            } 
			
            /**
             *
             *  The header area contain
             *  - site identity elements: Site Logo, Site Title and Description
             *  - header menu and aside menu
             *  - header image and header elements: Headline, Description and Buttons
             */ ?>

   		<header class="<?php echo esc_attr( $mythemes_header_class ); ?>">

            <!-- header navigation -->
            <nav class="white mythemes-topper" role="navigation">

                <div class="nav-wrapper container">

                    <!-- header button -->
                    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="materialize-icon-menu"></i></a>

                        <!-- Site Logo, Title and Description -->
	                    <?php
                        $blog_title    		= esc_attr( get_bloginfo( 'name' ) );

                        $blog_description   = esc_attr( get_bloginfo( 'description' ) );

                        $mythemes_logo_src  = esc_url( get_theme_mod( 'mythemes-blog-logo' , get_template_directory_uri() . '/media/_frontend/img/logo.png' ) );

                        echo '<div class="mythemes-blog-identity">';

                       	if ( function_exists( 'the_custom_logo' ) && $has_custom_logo = has_custom_logo() ) {

                            echo '<div class="mythemes-blog-logo" style="margin-top: ' . absint( get_theme_mod( 'mythemes-blog-logo-m-top' ) ) . 'px; margin-bottom: ' . absint( get_theme_mod( 'mythemes-blog-logo-m-bottom' ) ) . 'px;">';

                            the_custom_logo();

                            echo '</div>';

                        }

                        // blog logo ( if not is empty )
                        else if( !empty( $mythemes_logo_src ) ) {

                            echo '<a class="mythemes-blog-logo" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( $blog_title . ' - ' . $blog_description ) . '" style="margin-top: ' . absint( get_theme_mod( 'mythemes-blog-logo-m-top' ) ) . 'px; margin-bottom: ' . absint( get_theme_mod( 'mythemes-blog-logo-m-bottom' ) ) . 'px;">';

                            echo '<img src="' . esc_url( $mythemes_logo_src ) . '" title="' . esc_attr( $blog_title . ' - ' . $blog_description ) . '"/>';

                            echo '</a>';

                        }

                        // blog title ( if not is empty )
                        if( !empty( $blog_title ) ) {

                            echo '<a class="mythemes-blog-title" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( $blog_title . ' - ' . $blog_description ) . '">';

                            bloginfo( 'name' );

                            echo '</a>';

                        }

                        // blog description ( if not is empty )
                        if( !empty( $blog_description ) ) {

                            echo '<a class="mythemes-blog-description" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( $blog_title . ' - ' . $blog_description ) . '">';

                            bloginfo( 'description' );

                            echo '</a>';

                        }

                        echo '</div>';

                        global $mythemes_curr_ancestor;

                        $location = get_nav_menu_locations();

                        {   // not collapsed header menu

                            $args = array(

                                'theme_location'    => 'header',

                                'container_class'   => 'not-collapsed-wrapper',

                                'menu_class'        => 'right hide-on-med-and-down'

                            );

                            if ( isset( $location[ 'header' ] ) && $location[ 'header' ] > 0 ) {

                                wp_nav_menu( $args );

                            }

                            /**
                             *
                             *  If not is set header menu then
                             *  the header menu is build from existing pages
                             */

                            else {

                                $pages = get_posts( array(

                                    'post_type' => 'page',

                                    'order' => 'ASC'

                                ));

                                if ( !empty( $pages ) ) {

                                    echo '<div class="not-collapsed-wrapper">';

                                    echo '<ul class="right hide-on-med-and-down">';

                                    foreach ( $pages as $p => $item ) {

                                        $classes                = '';

                                        $mythemes_curr_ancestor = false;

                                        if ( $item -> post_parent > 0 ) {

                                            continue;

                                        }

                                        if ( is_page( $item -> ID ) ||  ( $item -> ID === absint( get_option( 'page_for_posts' ) ) && is_home() ) ) {

                                            $classes = 'current-menu-item';

                                        }

	                                    $submenu = mythemes_tools::submenu( $item -> ID );

                                        if ( !empty( $submenu ) ) {

                                            $classes .= ' menu-item-has-children';

                                            if ( $mythemes_curr_ancestor  ) {

                                                $classes .= ' current-menu-ancestor';

                                            }

                                        }

                                        echo '<li class="menu-item ' . $classes . '">';

                                        echo '<a href="' . esc_url( get_permalink( $item -> ID ) ) . '" title="' . esc_attr( mythemes_post::title( $item -> ID, true ) ) . '">' . mythemes_post::title( $item -> ID ) . '</a>';

                                        echo $submenu;

                                        echo '</li>';

                                    }

                                    echo '</ul>';

                                    echo '</div>';

                                }

                            }

                        }

                        {   /**
                             *
                             *  Collapsed aside menu
                             *  this menu is available only for small devices
                             */

                            $args = array(

                                'theme_location'    => 'header',

                                'container_class'   => 'collapsed-wrapper',

                                'menu_class'        => 'side-nav',

                                'menu_id'           => 'nav-mobile'

                            );

                            if ( isset( $location[ 'header' ] ) && $location[ 'header' ] > 0 ) {

                                wp_nav_menu( $args );

                            }

                            /**
                             *
                             *  If not is set header menu then
                             *  the header menu is build from existing pages
                             */

                            else {

                                $pages = get_posts( array(

                                    'post_type' => 'page',

                                    'order' => 'ASC'

                                ) );

                                if ( !empty( $pages ) ) {

                                    echo '<div class="collapsed-wrapper">';

                                    echo '<ul id="nav-mobile" class="side-nav">';

                                    foreach ( $pages as $p => $item ) {

                                        $classes = '';

                                        if ( is_page( $item -> ID ) ) {

                                            $classes = 'current-menu-item';

                                        }

                                        echo '<li class="menu-item ' . $classes . '">';

                                        echo '<a href="' . esc_url( get_permalink( $item -> ID ) ) . '" title="' . esc_attr( mythemes_post::title( $item -> ID, true ) ) . '">' . mythemes_post::title( $item -> ID ) . '</a>';

                                        echo '</li>';

                                    }

                                    echo '</ul>';

                                    echo '</div>';

                                }

                            }

                        } ?>

                </div>

            </nav>

            <!-- the header image and the header elements -->

            <?php
            if ( $show_header ) {

             	get_template_part( 'templates/header' );

          	} ?>

        </header>