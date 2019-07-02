<?php // Template Name: Page (Full Width) ?>
<?php get_header() ?>

<div id="content" class="section site-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div id="primary" class="site-main">
					<?php 
					if ( have_posts() ) : 
						while ( have_posts() ) : the_post(); ?>

							<div id="page-<?php the_ID(); ?>" <?php post_class(array('clearfix', 'page-entry-content')); ?>>
									
                                    <?php 
										the_content(); 

										// This section is for pagination purpose for a long large page that is seperated using nextpage tags
							            $args = array(
							                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'codexin' ) . '</span>',
							                'after'       => '</div>',
							                'link_before' => '<span>',
							                'link_after'  => '</span>',
							                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'codexin' ) . ' </span>%',
							                'separator'   => '<span class="screen-reader-text">, </span>',
							            );                 
							            wp_link_pages( $args );

									 ?>
							</div><!-- #page-## -->

							<?php

						endwhile;
					else : 
						// No posts to display
					endif;
					?>
					
				</div> <!-- end of #primary -->

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div><?php // .col-xs-12 ?>

		</div><?php // #content .container .row ?>
	</div><?php // #content .container-fluid ?>
</div><?php // #content ?>
<?php get_footer() ?>