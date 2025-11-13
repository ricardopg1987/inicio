/**
 * LCEEP Astra Child Theme - Main JavaScript
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {

        // Initialize all components
        initAOS();
        initHeroSlider();
        initTeamCarousel();
        initSmoothScroll();
        initTeamFilters();

    });

    /**
     * Initialize AOS (Animate On Scroll)
     */
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100,
                delay: 100
            });
        }
    }

    /**
     * Initialize Hero Slider
     */
    function initHeroSlider() {
        const $slider = $('.lceep-hero-slider');

        if ($slider.length === 0) return;

        const $slides = $slider.find('.lceep-slide');
        const $dots = $slider.find('.lceep-slider-dot');
        let currentSlide = 0;
        const slideCount = $slides.length;
        let slideInterval;

        // Function to show specific slide
        function showSlide(index) {
            // Remove active class from all slides and dots
            $slides.removeClass('active');
            $dots.removeClass('active');

            // Add active class to current slide and dot
            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');

            currentSlide = index;
        }

        // Function to go to next slide
        function nextSlide() {
            let next = (currentSlide + 1) % slideCount;
            showSlide(next);
        }

        // Function to go to previous slide
        function prevSlide() {
            let prev = (currentSlide - 1 + slideCount) % slideCount;
            showSlide(prev);
        }

        // Auto-advance slides every 5 seconds
        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Stop auto-advance
        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Click event for dots
        $dots.on('click', function() {
            stopAutoSlide();
            const slideIndex = $(this).data('slide');
            showSlide(slideIndex);
            startAutoSlide();
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($slider.is(':visible')) {
                if (e.keyCode === 37) { // Left arrow
                    stopAutoSlide();
                    prevSlide();
                    startAutoSlide();
                } else if (e.keyCode === 39) { // Right arrow
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide();
                }
            }
        });

        // Pause on hover
        $slider.on('mouseenter', stopAutoSlide);
        $slider.on('mouseleave', startAutoSlide);

        // Start the slider
        startAutoSlide();
    }

    /**
     * Initialize Team Carousel with Swiper
     */
    function initTeamCarousel() {
        const $carousels = $('.lceep-team-carousel.swiper');

        if ($carousels.length === 0) return;

        $carousels.each(function() {
            const $carousel = $(this);

            // Initialize Swiper
            if (typeof Swiper !== 'undefined') {
                new Swiper(this, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: $carousel.find('.lceep-carousel-btn.next')[0],
                        prevEl: $carousel.find('.lceep-carousel-btn.prev')[0]
                    },
                    breakpoints: {
                        480: {
                            slidesPerView: 1,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 30
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 30
                        }
                    }
                });
            }
        });
    }

    /**
     * Initialize Smooth Scroll
     */
    function initSmoothScroll() {
        // Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);

            if (target.length) {
                e.preventDefault();

                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'swing');
            }
        });
    }

    /**
     * Initialize Team Filters
     */
    function initTeamFilters() {
        const $filterBtns = $('.lceep-team-filter-btn');
        const $teamMembers = $('.lceep-team-member');

        if ($filterBtns.length === 0) return;

        $filterBtns.on('click', function() {
            const $btn = $(this);
            const filter = $btn.data('filter');

            // Update active button
            $filterBtns.removeClass('active');
            $btn.addClass('active');

            // Filter team members
            if (filter === 'all') {
                $teamMembers.fadeIn(400);
            } else {
                $teamMembers.each(function() {
                    const $member = $(this);
                    const categories = $member.data('categories');

                    if (categories && categories.includes(filter)) {
                        $member.fadeIn(400);
                    } else {
                        $member.fadeOut(400);
                    }
                });
            }

            // Refresh AOS
            if (typeof AOS !== 'undefined') {
                setTimeout(function() {
                    AOS.refresh();
                }, 500);
            }
        });
    }

    /**
     * Accessibility: Add keyboard navigation to custom elements
     */
    function initAccessibility() {
        // Add role and tabindex to slider dots
        $('.lceep-slider-dot').attr({
            'role': 'button',
            'tabindex': '0',
            'aria-label': function(index) {
                return 'Go to slide ' + (index + 1);
            }
        });

        // Add keyboard support for dots
        $('.lceep-slider-dot').on('keypress', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                $(this).click();
            }
        });

        // Add role and tabindex to carousel buttons
        $('.lceep-carousel-btn').attr({
            'role': 'button',
            'tabindex': '0'
        });

        // Add keyboard support for carousel buttons
        $('.lceep-carousel-btn').on('keypress', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                $(this).click();
            }
        });
    }

    // Initialize accessibility features
    initAccessibility();

    /**
     * Handle window resize
     */
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Refresh AOS on resize
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }, 250);
    });

    /**
     * Lazy load images
     */
    function initLazyLoad() {
        const images = document.querySelectorAll('img[data-src]');

        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            images.forEach(function(img) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
        }
    }

    // Initialize lazy load
    initLazyLoad();

    /**
     * Add loading animation for team member links
     */
    $('.lceep-team-member').on('click', 'a', function() {
        const $member = $(this).closest('.lceep-team-member');
        $member.addClass('loading');
    });

    /**
     * Handle back to top button
     */
    function initBackToTop() {
        const $backToTop = $('<button>', {
            class: 'lceep-back-to-top',
            html: '&uarr;',
            'aria-label': 'Volver arriba'
        }).appendTo('body');

        $backToTop.hide();

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
    }

    // Initialize back to top button
    initBackToTop();

})(jQuery);
