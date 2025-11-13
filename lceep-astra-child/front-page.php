<?php
/**
 * Template Name: Front Page
 * Template Post Type: page
 *
 * Home page template for LCEEP site
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<main id="main" class="site-main" role="main">

    <?php
    // Hero Slider Section
    ?>
    <section class="lceep-hero-section">
        <?php echo do_shortcode('[lceep_hero_slider]'); ?>
    </section>

    <?php
    // About Section
    ?>
    <section class="lceep-front-section lceep-about-section">
        <div class="container-lceep">
            <div class="lceep-section-header" data-aos="fade-up">
                <h2 class="lceep-section-title">Acerca del LCEEP</h2>
                <p class="lceep-section-subtitle">
                    Laboratorio de Conversión de Energía y Electrónica de Potencia
                </p>
            </div>
            <div class="lceep-about-content" data-aos="fade-up" data-aos-delay="100">
                <p style="text-align: center; max-width: 800px; margin: 0 auto; font-size: 1.1rem; line-height: 1.8;">
                    El LCEEP es un laboratorio de investigación dedicado al desarrollo de tecnologías
                    innovadoras en el campo de la conversión de energía y electrónica de potencia,
                    con especial énfasis en energías renovables y sistemas de generación eólica.
                </p>
            </div>
        </div>
    </section>

    <?php
    // News Section
    ?>
    <section class="lceep-front-section lceep-news-section">
        <div class="container-lceep">
            <div class="lceep-section-header" data-aos="fade-up">
                <h2 class="lceep-section-title">Noticias Recientes</h2>
                <p class="lceep-section-subtitle">
                    Mantente informado sobre nuestras últimas investigaciones y actividades
                </p>
            </div>

            <div class="lceep-news-grid">
                <?php
                $news_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );

                $news_query = new WP_Query( $news_args );

                if ( $news_query->have_posts() ) :
                    $delay = 0;
                    while ( $news_query->have_posts() ) : $news_query->the_post();
                        ?>
                        <article class="lceep-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ); ?>"
                                     alt="<?php the_title(); ?>"
                                     class="lceep-card-image">
                            <?php endif; ?>

                            <div class="lceep-card-content">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) :
                                    ?>
                                    <span class="lceep-card-category">
                                        <?php echo esc_html( $categories[0]->name ); ?>
                                    </span>
                                <?php endif; ?>

                                <h3 class="lceep-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="lceep-card-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                                </div>

                                <div class="lceep-card-meta">
                                    <span class="lceep-card-date">
                                        <?php echo get_the_date(); ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                        <?php
                        $delay += 100;
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p style="grid-column: 1 / -1; text-align: center;">No hay noticias disponibles.</p>
                    <?php
                endif;
                ?>
            </div>

            <div class="text-center mt-2">
                <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"
                   class="lceep-btn lceep-btn-primary"
                   style="display: inline-block; padding: 12px 30px; background-color: var(--lceep-primary); color: var(--lceep-white); border-radius: 5px; text-decoration: none; transition: var(--lceep-transition);">
                    Ver todas las noticias
                </a>
            </div>
        </div>
    </section>

    <?php
    // Team Section
    ?>
    <section class="lceep-front-section lceep-team-section">
        <div class="container-lceep">
            <div class="lceep-section-header" data-aos="fade-up">
                <h2 class="lceep-section-title">Nuestro Equipo</h2>
                <p class="lceep-section-subtitle">
                    Conoce a los investigadores y profesionales que conforman el LCEEP
                </p>
            </div>

            <?php echo do_shortcode('[lceep_team_carousel]'); ?>

            <div class="text-center mt-2">
                <a href="<?php echo get_post_type_archive_link( 'team_member' ); ?>"
                   class="lceep-btn lceep-btn-primary"
                   style="display: inline-block; padding: 12px 30px; background-color: var(--lceep-primary); color: var(--lceep-white); border-radius: 5px; text-decoration: none; transition: var(--lceep-transition);">
                    Ver todo el equipo
                </a>
            </div>
        </div>
    </section>

    <?php
    // Programs Section
    ?>
    <section class="lceep-front-section lceep-programs-section">
        <div class="container-lceep">
            <div class="lceep-section-header" data-aos="fade-up">
                <h2 class="lceep-section-title">Programas de Investigación</h2>
                <p class="lceep-section-subtitle">
                    Áreas de investigación y desarrollo en las que trabajamos
                </p>
            </div>

            <div class="lceep-programs-grid">
                <?php
                $programs = array(
                    array(
                        'icon' => '🌊',
                        'title' => 'Energía Marina',
                        'description' => 'Investigación en sistemas de conversión de energía de olas y corrientes marinas.'
                    ),
                    array(
                        'icon' => '💨',
                        'title' => 'Energía Eólica',
                        'description' => 'Desarrollo de tecnologías para generación eólica de alta eficiencia.'
                    ),
                    array(
                        'icon' => '☀️',
                        'title' => 'Energía Solar',
                        'description' => 'Optimización de sistemas fotovoltaicos y de concentración solar.'
                    ),
                    array(
                        'icon' => '⚡',
                        'title' => 'Electrónica de Potencia',
                        'description' => 'Diseño de convertidores y sistemas de control avanzados.'
                    ),
                );

                $delay = 0;
                foreach ( $programs as $program ) :
                    ?>
                    <div class="lceep-program-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="lceep-program-icon"><?php echo $program['icon']; ?></div>
                        <h3 class="lceep-program-title"><?php echo esc_html( $program['title'] ); ?></h3>
                        <p class="lceep-program-description"><?php echo esc_html( $program['description'] ); ?></p>
                    </div>
                    <?php
                    $delay += 100;
                endforeach;
                ?>
            </div>
        </div>
    </section>

    <?php
    // Contact CTA Section
    ?>
    <section class="lceep-front-section lceep-cta-section" style="background: linear-gradient(135deg, var(--lceep-primary) 0%, var(--lceep-secondary) 100%); color: var(--lceep-white);">
        <div class="container-lceep">
            <div class="text-center" data-aos="fade-up">
                <h2 style="color: var(--lceep-white); font-size: 2.5rem; margin-bottom: 1rem;">
                    ¿Interesado en colaborar?
                </h2>
                <p style="font-size: 1.2rem; margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">
                    Contáctanos para conocer más sobre nuestros proyectos de investigación y oportunidades de colaboración.
                </p>
                <a href="<?php echo home_url('/contacto'); ?>"
                   class="lceep-btn lceep-btn-light"
                   style="display: inline-block; padding: 15px 40px; background-color: var(--lceep-white); color: var(--lceep-primary); border-radius: 5px; text-decoration: none; font-weight: 600; transition: var(--lceep-transition);">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
