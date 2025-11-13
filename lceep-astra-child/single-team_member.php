<?php
/**
 * Single Team Member Template
 *
 * Template for displaying individual team member information
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<main id="main" class="site-main single-team-member" role="main">

    <?php
    while ( have_posts() ) : the_post();

        // Get custom fields
        $position = get_post_meta( get_the_ID(), '_lceep_position', true );
        $email = get_post_meta( get_the_ID(), '_lceep_email', true );
        $phone = get_post_meta( get_the_ID(), '_lceep_phone', true );
        $orcid = get_post_meta( get_the_ID(), '_lceep_orcid', true );
        $researchgate = get_post_meta( get_the_ID(), '_lceep_researchgate', true );
        $linkedin = get_post_meta( get_the_ID(), '_lceep_linkedin', true );

        // Get categories
        $categories = get_the_terms( get_the_ID(), 'team_category' );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Breadcrumbs -->
            <div class="lceep-breadcrumbs">
                <div class="container-lceep">
                    <a href="<?php echo home_url(); ?>">Inicio</a>
                    <span>/</span>
                    <a href="<?php echo get_post_type_archive_link( 'team_member' ); ?>">Equipo</a>
                    <span>/</span>
                    <span><?php the_title(); ?></span>
                </div>
            </div>

            <div class="container-lceep">

                <!-- Team Member Header -->
                <div class="lceep-team-single-header" data-aos="fade-up">

                    <!-- Photo -->
                    <div class="lceep-team-single-photo">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large' ); ?>
                        <?php else : ?>
                            <img src="<?php echo LCEEP_CHILD_THEME_URI; ?>/assets/images/default-avatar.png"
                                 alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="lceep-team-single-info">
                        <h1 class="lceep-team-single-name"><?php the_title(); ?></h1>

                        <?php if ( $position ) : ?>
                            <p class="lceep-team-single-position"><?php echo esc_html( $position ); ?></p>
                        <?php endif; ?>

                        <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                            <div class="lceep-team-categories" style="margin-bottom: 1.5rem;">
                                <?php foreach ( $categories as $category ) : ?>
                                    <span class="lceep-team-category"><?php echo esc_html( $category->name ); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Contact Information -->
                        <?php if ( $email || $phone ) : ?>
                            <div class="lceep-team-contact">
                                <h3 style="font-size: 1.2rem; margin-bottom: 1rem; color: var(--lceep-primary);">
                                    Información de Contacto
                                </h3>

                                <?php if ( $email ) : ?>
                                    <div class="lceep-team-contact-item">
                                        <span>📧</span>
                                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $phone ) : ?>
                                    <div class="lceep-team-contact-item">
                                        <span>📞</span>
                                        <a href="tel:<?php echo esc_attr( $phone ); ?>">
                                            <?php echo esc_html( $phone ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Social Links -->
                        <?php if ( $orcid || $researchgate || $linkedin ) : ?>
                            <div class="lceep-team-social-links">
                                <?php if ( $orcid ) : ?>
                                    <a href="<?php echo esc_url( $orcid ); ?>"
                                       class="lceep-social-link"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="ORCID">
                                        <span style="font-weight: bold; font-size: 1.1rem;">OR</span>
                                    </a>
                                <?php endif; ?>

                                <?php if ( $researchgate ) : ?>
                                    <a href="<?php echo esc_url( $researchgate ); ?>"
                                       class="lceep-social-link"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="ResearchGate">
                                        <span style="font-weight: bold; font-size: 1.1rem;">RG</span>
                                    </a>
                                <?php endif; ?>

                                <?php if ( $linkedin ) : ?>
                                    <a href="<?php echo esc_url( $linkedin ); ?>"
                                       class="lceep-social-link"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="LinkedIn">
                                        <span style="font-weight: bold; font-size: 1.1rem;">in</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Biography / Content -->
                <?php if ( get_the_content() ) : ?>
                    <div class="entry-content" data-aos="fade-up" data-aos-delay="100">
                        <h2 style="color: var(--lceep-primary); margin-bottom: 1rem;">Biografía</h2>
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

                <!-- Research Interests / Additional Info -->
                <?php if ( get_field( 'research_interests' ) ) : ?>
                    <div class="lceep-research-interests" data-aos="fade-up" data-aos-delay="200">
                        <h2 style="color: var(--lceep-primary); margin-bottom: 1rem;">Áreas de Investigación</h2>
                        <?php the_field( 'research_interests' ); ?>
                    </div>
                <?php endif; ?>

                <!-- Navigation to other team members -->
                <div class="lceep-post-navigation" style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid var(--lceep-light-gray);">
                    <div style="display: flex; justify-content: space-between; gap: 2rem;">
                        <?php
                        $prev_post = get_previous_post( true, '', 'team_category' );
                        $next_post = get_next_post( true, '', 'team_category' );
                        ?>

                        <div style="flex: 1;">
                            <?php if ( $prev_post ) : ?>
                                <a href="<?php echo get_permalink( $prev_post->ID ); ?>"
                                   style="display: block; padding: 1rem; background-color: var(--lceep-light-gray); border-radius: 5px; transition: var(--lceep-transition);">
                                    <span style="display: block; color: var(--lceep-gray); font-size: 0.9rem;">← Anterior</span>
                                    <strong style="color: var(--lceep-primary);"><?php echo get_the_title( $prev_post->ID ); ?></strong>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div style="flex: 1; text-align: right;">
                            <?php if ( $next_post ) : ?>
                                <a href="<?php echo get_permalink( $next_post->ID ); ?>"
                                   style="display: block; padding: 1rem; background-color: var(--lceep-light-gray); border-radius: 5px; transition: var(--lceep-transition);">
                                    <span style="display: block; color: var(--lceep-gray); font-size: 0.9rem;">Siguiente →</span>
                                    <strong style="color: var(--lceep-primary);"><?php echo get_the_title( $next_post->ID ); ?></strong>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Back to Team Link -->
                <div class="text-center mt-3">
                    <a href="<?php echo get_post_type_archive_link( 'team_member' ); ?>"
                       class="lceep-btn lceep-btn-primary"
                       style="display: inline-block; padding: 12px 30px; background-color: var(--lceep-primary); color: var(--lceep-white); border-radius: 5px; text-decoration: none; transition: var(--lceep-transition);">
                        ← Volver al Equipo
                    </a>
                </div>

            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
