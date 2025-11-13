/**
 * LCEEP - JavaScript Principal
 * Funcionalidades del sitio estático
 */

// Esperar a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {

    // === MENÚ MÓVIL === //
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');

            // Cambiar el ícono del menú
            const icon = this.textContent;
            this.textContent = icon === '☰' ? '✕' : '☰';
        });
    }

    // Cerrar menú al hacer clic en un enlace (móvil)
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                mainNav.classList.remove('active');
                if (mobileMenuToggle) {
                    mobileMenuToggle.textContent = '☰';
                }
            }
        });
    });

    // === NAVEGACIÓN ACTIVA === //
    // Resaltar el enlace de navegación actual
    const currentPath = window.location.pathname;
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath ||
            currentPath.includes(link.getAttribute('href').replace('index.html', ''))) {
            link.classList.add('active');
        }
    });

    // === ANIMACIONES AL SCROLL === //
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observar tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        observer.observe(card);
    });

    // === SCROLL SUAVE === //
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // === BÚSQUEDA Y FILTRADO (para páginas de listado) === //
    const searchInput = document.querySelector('.search-input');
    const filterButtons = document.querySelectorAll('.filter-btn');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterPosts(searchTerm);
        });
    }

    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remover active de todos los botones
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Agregar active al botón clickeado
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                filterByCategory(filterValue);
            });
        });
    }

    function filterPosts(searchTerm) {
        const posts = document.querySelectorAll('.card, .post-item');

        posts.forEach(post => {
            const title = post.querySelector('.card-title, .post-title')?.textContent.toLowerCase() || '';
            const excerpt = post.querySelector('.card-excerpt, .post-excerpt')?.textContent.toLowerCase() || '';

            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                post.style.display = '';
            } else {
                post.style.display = 'none';
            }
        });
    }

    function filterByCategory(category) {
        const posts = document.querySelectorAll('.card, .post-item');

        posts.forEach(post => {
            if (category === 'all') {
                post.style.display = '';
            } else {
                const postCategory = post.getAttribute('data-category');
                if (postCategory === category) {
                    post.style.display = '';
                } else {
                    post.style.display = 'none';
                }
            }
        });
    }

    // === MANEJO DE IDIOMA === //
    // Detectar idioma actual y actualizar selector
    const languageLinks = document.querySelectorAll('.language-selector a');
    const isEnglish = currentPath.includes('/en/') || currentPath.includes('/news/') ||
                      currentPath.includes('/events/') || currentPath.includes('/lceep-seminar/') ||
                      currentPath.includes('/talk-on-wind-energy/') || currentPath.includes('/programs/');

    languageLinks.forEach(link => {
        const lang = link.getAttribute('data-lang');
        if ((lang === 'en' && isEnglish) || (lang === 'es' && !isEnglish)) {
            link.classList.add('active');
        }
    });

    // === BOTÓN VOLVER ARRIBA === //
    const backToTopButton = document.querySelector('.back-to-top');

    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // === LAZY LOADING DE IMÁGENES === //
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        imageObserver.observe(img);
    });

    // === FORMULARIO DE CONTACTO (si existe) === //
    const contactForm = document.querySelector('.contact-form');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Aquí podrías integrar un servicio como Formspree, EmailJS, etc.
            alert('Esta funcionalidad requiere configuración de un servicio de envío de emails.');
        });
    }

});

// === FUNCIONES GLOBALES === //

/**
 * Alternar idioma
 * @param {string} lang - Código de idioma ('es' o 'en')
 */
function switchLanguage(lang) {
    const currentPath = window.location.pathname;
    let newPath;

    if (lang === 'en') {
        // Convertir rutas españolas a inglesas
        newPath = currentPath
            .replace('/noticias/', '/news/')
            .replace('/eventos/', '/events/')
            .replace('/seminarios-lceep/', '/lceep-seminar/')
            .replace('/charlas-energia-eolica/', '/talk-on-wind-energy/')
            .replace('/programas/', '/programs/');

        // Si estamos en la home
        if (currentPath === '/' || currentPath === '/index.html') {
            newPath = '/en/index.html';
        }
    } else {
        // Convertir rutas inglesas a españolas
        newPath = currentPath
            .replace('/news/', '/noticias/')
            .replace('/events/', '/eventos/')
            .replace('/lceep-seminar/', '/seminarios-lceep/')
            .replace('/talk-on-wind-energy/', '/charlas-energia-eolica/')
            .replace('/programs/', '/programas/')
            .replace('/en/', '/');
    }

    if (newPath !== currentPath) {
        window.location.href = newPath;
    }
}

/**
 * Formatear fecha
 * @param {string} dateString - Fecha en formato ISO
 * @param {string} lang - Idioma ('es' o 'en')
 */
function formatDate(dateString, lang = 'es') {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };

    return date.toLocaleDateString(lang === 'es' ? 'es-CL' : 'en-US', options);
}

/**
 * Compartir en redes sociales
 * @param {string} platform - Plataforma ('twitter', 'facebook', 'linkedin')
 */
function share(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);

    let shareUrl;

    switch(platform) {
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
            break;
        default:
            return;
    }

    window.open(shareUrl, '_blank', 'width=600,height=400');
}

// === EXPORTAR PARA USO GLOBAL === //
window.LCEEP = {
    switchLanguage,
    formatDate,
    share
};
