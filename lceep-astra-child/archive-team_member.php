<?php
/**
 * Archive Team Member Template
 *
 * Template for displaying all team members
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<main id="main" class="site-main archive-team-member" role="main">

    <!-- Page Header -->
    <div class="lceep-page-header" style="background: linear-gradient(135deg, var(--lceep-primary) 0%, var(--lceep-secondary) 100%); padding: 3rem 0; margin-bottom: 3rem; color: var(--lceep-white);">
        <div class="container-lceep text-center">
            <h1 style="color: var(--lceep-white); font-size: 3rem; margin-bottom: 1rem;" data-aos="fade-up">
                Nuestro Equipo
            </h1>
            <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto;" data-aos="fade-up" data-aos-delay="100">
                Conoce a los investigadores, académicos y profesionales que conforman el LCEEP
            </p>
        </div>
    </div>

    <div class="container-lceep">

        <?php
        // Get all team categories for filters
        $categories = get_terms( array(
            'taxonomy' => 'team_category',
            'hide_empty' => true,
        ) );
        ?>

        <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
            <!-- Team Filters -->
            <div class="lceep-team-filters" data-aos="fade-up">
                <button class="lceep-team-filter-btn active" data-filter="all">
                    Todos
                </button>
                <?php foreach ( $categories as $category ) : ?>
                    <button class="lceep-team-filter-btn" data-filter="<?php echo esc_attr( $category->slug ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>

            <!-- Team Grid -->
            <div class="lceep-team-grid">
                <?php
                $delay = 0;
                while ( have_posts() ) : the_post();

                    // Get categories for filtering
                    $terms = get_the_terms( get_the_ID(), 'team_category' );
                    $categories_slugs = array();
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            $categories_slugs[] = $term->slug;
                        }
                    }
                    $categories_data = implode( ' ', $categories_slugs );

                    // Get position
                    $position = get_post_meta( get_the_ID(), '_lceep_position', true );
                    ?>

                    <div class="lceep-team-member"
                         data-aos="fade-up"
                         data-aos-delay="<?php echo $delay; ?>"
                         data-categories="<?php echo esc_attr( $categories_data ); ?>">

                        <a href="<?php the_permalink(); ?>" style="text-decoration: none;">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>"
                                     alt="<?php the_title(); ?>"
                                     class="lceep-team-photo">
                            <?php else : ?>
                                <img src="<?php echo LCEEP_CHILD_THEME_URI; ?>/assets/images/default-avatar.png"
                                     alt="<?php the_title(); ?>"
                                     class="lceep-team-photo">
                            <?php endif; ?>

                            <div class="lceep-team-info">
                                <h3 class="lceep-team-name"><?php the_title(); ?></h3>

                                <?php if ( $position ) : ?>
                                    <p class="lceep-team-role"><?php echo esc_html( $position ); ?></p>
                                <?php endif; ?>

                                <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center;">
                                        <?php foreach ( $terms as $term ) : ?>
                                            <span class="lceep-team-category"><?php echo esc_html( $term->name ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( has_excerpt() ) : ?>
                                    <p style="margin-top: 1rem; color: var(--lceep-gray); font-size: 0.9rem;">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <?php
                    $delay += 50;
                    if ( $delay > 300 ) $delay = 0; // Reset delay after 6 items
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <?php
            $pagination = paginate_links( array(
                'type' => 'array',
                'prev_text' => '← Anterior',
                'next_text' => 'Siguiente →',
            ) );

            if ( $pagination ) :
                ?>
                <nav class="lceep-pagination" style="margin-top: 3rem; text-align: center;" data-aos="fade-up">
                    <ul style="list-style: none; padding: 0; display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
                        <?php foreach ( $pagination as $page ) : ?>
                            <li><?php echo $page; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php
            endif;
            ?>

        <?php else : ?>

            <!-- No Team Members Found -->
            <div class="lceep-no-results" style="text-align: center; padding: 3rem 0;" data-aos="fade-up">
                <h2 style="color: var(--lceep-primary); margin-bottom: 1rem;">
                    No se encontraron miembros del equipo
                </h2>
                <p style="color: var(--lceep-gray); margin-bottom: 2rem;">
                    Actualmente no hay miembros del equipo para mostrar.
                </p>
                <a href="<?php echo home_url(); ?>"
                   class="lceep-btn lceep-btn-primary"
                   style="display: inline-block; padding: 12px 30px; background-color: var(--lceep-primary); color: var(--lceep-white); border-radius: 5px; text-decoration: none; transition: var(--lceep-transition);">
                    Volver al inicio
                </a>
            </div>

        <?php endif; ?>

    </div>

    <!-- Join Team CTA -->
    <section class="lceep-join-cta" style="background-color: var(--lceep-light-gray); padding: 3rem 0; margin-top: 3rem;">
        <div class="container-lceep text-center" data-aos="fade-up">
            <h2 style="color: var(--lceep-primary); font-size: 2rem; margin-bottom: 1rem;">
                ¿Quieres unirte a nuestro equipo?
            </h2>
            <p style="color: var(--lceep-gray); font-size: 1.1rem; margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">
                Estamos siempre en búsqueda de talento. Si estás interesado en investigación en energías renovables, contáctanos.
            </p>
            <a href="<?php echo home_url('/contacto'); ?>"
               class="lceep-btn lceep-btn-primary"
               style="display: inline-block; padding: 12px 30px; background-color: var(--lceep-primary); color: var(--lceep-white); border-radius: 5px; text-decoration: none; transition: var(--lceep-transition);">
                Contáctanos
            </a>
        </div>
    </section>

</main>

<style>
/* Additional pagination styles */
.lceep-pagination ul li a,
.lceep-pagination ul li span {
    display: block;
    padding: 0.5rem 1rem;
    background-color: var(--lceep-white);
    color: var(--lceep-primary);
    border: 2px solid var(--lceep-primary);
    border-radius: 5px;
    text-decoration: none;
    transition: var(--lceep-transition);
}

.lceep-pagination ul li a:hover,
.lceep-pagination ul li span.current {
    background-color: var(--lceep-primary);
    color: var(--lceep-white);
}

.lceep-pagination ul li span.current {
    cursor: default;
}
</style>

<?php get_footer(); ?>
