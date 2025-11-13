<?php
/**
 * Template part for displaying team member content
 *
 * Used in loops and can be included in other templates
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get custom fields
$position = get_post_meta( get_the_ID(), '_lceep_position', true );
$email = get_post_meta( get_the_ID(), '_lceep_email', true );
$phone = get_post_meta( get_the_ID(), '_lceep_phone', true );

// Get categories
$categories = get_the_terms( get_the_ID(), 'team_category' );
$categories_slugs = array();
if ( $categories && ! is_wp_error( $categories ) ) {
    foreach ( $categories as $category ) {
        $categories_slugs[] = $category->slug;
    }
}
$categories_data = implode( ' ', $categories_slugs );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'lceep-team-member' ); ?> data-categories="<?php echo esc_attr( $categories_data ); ?>">

    <a href="<?php the_permalink(); ?>" class="lceep-team-member-link" style="text-decoration: none; display: block;">

        <!-- Team Member Photo -->
        <div class="lceep-team-photo-wrapper">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array(
                    'class' => 'lceep-team-photo',
                    'alt' => get_the_title()
                ) ); ?>
            <?php else : ?>
                <img src="<?php echo LCEEP_CHILD_THEME_URI; ?>/assets/images/default-avatar.png"
                     alt="<?php the_title(); ?>"
                     class="lceep-team-photo">
            <?php endif; ?>
        </div>

        <!-- Team Member Info -->
        <div class="lceep-team-info">

            <!-- Name -->
            <h3 class="lceep-team-name"><?php the_title(); ?></h3>

            <!-- Position -->
            <?php if ( $position ) : ?>
                <p class="lceep-team-role"><?php echo esc_html( $position ); ?></p>
            <?php endif; ?>

            <!-- Categories -->
            <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                <div class="lceep-team-categories" style="display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; margin-top: 0.75rem;">
                    <?php foreach ( $categories as $category ) : ?>
                        <span class="lceep-team-category"><?php echo esc_html( $category->name ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Excerpt -->
            <?php if ( has_excerpt() ) : ?>
                <div class="lceep-team-excerpt" style="margin-top: 1rem; color: var(--lceep-gray); font-size: 0.9rem; line-height: 1.5;">
                    <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                </div>
            <?php endif; ?>

            <!-- Contact Info (optional - can be hidden in grid view) -->
            <?php if ( $email || $phone ) : ?>
                <div class="lceep-team-contact-preview" style="margin-top: 1rem; display: none;">
                    <?php if ( $email ) : ?>
                        <div class="lceep-contact-item" style="font-size: 0.85rem; color: var(--lceep-gray);">
                            📧 <?php echo esc_html( $email ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <div class="lceep-contact-item" style="font-size: 0.85rem; color: var(--lceep-gray);">
                            📞 <?php echo esc_html( $phone ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- View More Button -->
            <div class="lceep-team-view-more" style="margin-top: 1rem;">
                <span class="lceep-btn-link" style="color: var(--lceep-secondary); font-size: 0.9rem; font-weight: 600;">
                    Ver perfil →
                </span>
            </div>

        </div>

    </a>

</article>
