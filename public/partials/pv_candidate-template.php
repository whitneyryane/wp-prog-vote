<?php

/**
 *
 *  The template for displaying all single posts and attachments
 *
 *  @package WordPress
 *  @subpackage Prog_vote
 *  @since prog_vote 1.0
 */

  get_header(); ?>

    <!--  the content -->
    <div class="content">

        <!--  the container ( align to center ) -->
        <div class="container">

            <div class="row">

            <?php
			global $post;
			
			if( have_posts() ) {

             	while( have_posts() ){

                	the_post(); ?>

                    <article <?php post_class(); ?>>

					<?php // the post thumbnail

                    $p_thumbnail = get_post( get_post_thumbnail_id( $post -> ID ) );

					if ( has_post_thumbnail( $post -> ID ) && isset( $p_thumbnail -> ID ) ) { ?>

                        <!-- the post thumbanil wrapper -->
                        <div class="post-thumbnail right overflow-wrapper" style="float:left;">

	                        <?php // the post thumbnail
                            echo get_the_post_thumbnail( $post -> ID, 'medium' );

							// the post thumbnail caption
							$c_thumbnail = isset( $p_thumbnail -> post_excerpt ) ? esc_html( $p_thumbnail -> post_excerpt ) : null;

							if ( !empty( $c_thumbnail ) ) {

                            	echo '<div class="valign-bottom-cell-wrapper">';

                            	echo '<footer class="valign-cell">' . $c_thumbnail . '</footer>';

                            	echo '</div>';

                         	} ?>

                   		</div><!-- .post-thumbnail -->

                    <?php
                    } // end if has thumbnail. ?>

					<!-- the post title -->
					<h1 class="post-title">
					
						<?php the_title(); ?>
                        
                  	</h1>

					<!-- the post content wrapper -->
					<div class="post-content">

						<!-- the post content -->
						<?php the_content(); ?>

                        <div class="clearfix"></div>

                    </div>

              	</article>

				<?php
				} // end of post

			} ?>
		
        </div>

	</div><!-- .container -->

</div><!-- .content -->

<?php get_footer(); ?>