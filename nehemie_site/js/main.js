/**
 * NÉHÉMIE International - Script JavaScript
 * Maquette créée le 18 mai 2025
 */

// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Préchargeur
    setTimeout(function() {
        const preloader = document.getElementById('preloader');
        preloader.style.opacity = '0';
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 500);
    }, 1000);

    // Navigation sticky
    const header = document.getElementById('header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Menu mobile
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            menuToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });
    }

    // Dropdowns mobiles
    const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
    
    mobileDropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('.mobile-nav-link');
        const submenu = dropdown.querySelector('.mobile-dropdown-menu');
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            submenu.classList.toggle('active');
        });
    });

    // Slider héro
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    const prevHeroBtn = document.querySelector('.hero-control.prev');
    const nextHeroBtn = document.querySelector('.hero-control.next');
    let currentHeroSlide = 0;
    
    function showHeroSlide(index) {
        // Masquer tous les slides
        heroSlides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Désactiver tous les points
        heroDots.forEach(dot => {
            dot.classList.remove('active');
        });
        
        // Afficher le slide actif
        heroSlides[index].classList.add('active');
        heroDots[index].classList.add('active');
    }
    
    function nextHeroSlide() {
        currentHeroSlide++;
        if (currentHeroSlide >= heroSlides.length) {
            currentHeroSlide = 0;
        }
        showHeroSlide(currentHeroSlide);
    }
    
    function prevHeroSlide() {
        currentHeroSlide--;
        if (currentHeroSlide < 0) {
            currentHeroSlide = heroSlides.length - 1;
        }
        showHeroSlide(currentHeroSlide);
    }
    
    // Événements pour les boutons du slider héro
    if (prevHeroBtn && nextHeroBtn) {
        prevHeroBtn.addEventListener('click', prevHeroSlide);
        nextHeroBtn.addEventListener('click', nextHeroSlide);
    }
    
    // Événements pour les points du slider héro
    heroDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentHeroSlide = index;
            showHeroSlide(currentHeroSlide);
        });
    });
    
    // Rotation automatique du slider héro
    setInterval(nextHeroSlide, 5000);

    // Onglets des programmes
    const programTabs = document.querySelectorAll('.program-tab');
    const programContents = document.querySelectorAll('.program-content');
    
    programTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const program = this.getAttribute('data-program');
            
            // Désactiver tous les onglets et contenus
            programTabs.forEach(t => t.classList.remove('active'));
            programContents.forEach(c => c.classList.remove('active'));
            
            // Activer l'onglet et le contenu correspondant
            this.classList.add('active');
            document.getElementById('program-' + program).classList.add('active');
        });
    });

    // Slider témoignages
    const testimonials = document.querySelectorAll('.testimonial');
    const testimonialDots = document.querySelectorAll('.testimonial-dot');
    const prevTestimonialBtn = document.querySelector('.testimonial-control.prev');
    const nextTestimonialBtn = document.querySelector('.testimonial-control.next');
    let currentTestimonial = 0;
    
    function showTestimonial(index) {
        // Masquer tous les témoignages
        testimonials.forEach(testimonial => {
            testimonial.classList.remove('active');
        });
        
        // Désactiver tous les points
        testimonialDots.forEach(dot => {
            dot.classList.remove('active');
        });
        
        // Afficher le témoignage actif
        testimonials[index].classList.add('active');
        testimonialDots[index].classList.add('active');
    }
    
    function nextTestimonial() {
        currentTestimonial++;
        if (currentTestimonial >= testimonials.length) {
            currentTestimonial = 0;
        }
        showTestimonial(currentTestimonial);
    }
    
    function prevTestimonial() {
        currentTestimonial--;
        if (currentTestimonial < 0) {
            currentTestimonial = testimonials.length - 1;
        }
        showTestimonial(currentTestimonial);
    }
    
    // Événements pour les boutons du slider témoignages
    if (prevTestimonialBtn && nextTestimonialBtn) {
        prevTestimonialBtn.addEventListener('click', prevTestimonial);
        nextTestimonialBtn.addEventListener('click', nextTestimonial);
    }
    
    // Événements pour les points du slider témoignages
    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentTestimonial = index;
            showTestimonial(currentTestimonial);
        });
    });
    
    // Rotation automatique du slider témoignages
    setInterval(nextTestimonial, 7000);

    // Compteurs d'impact
    const counters = document.querySelectorAll('.counter-value');
    let counted = false;
    
    function startCounting() {
        if (counted) return;
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 secondes
            const step = target / (duration / 16); // 16ms par frame (environ 60fps)
            let current = 0;
            
            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            updateCounter();
        });
        
        counted = true;
    }
    
    // Observer pour démarrer les compteurs quand ils sont visibles
    const impactSection = document.querySelector('.impact-section');
    
    if (impactSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounting();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(impactSection);
    }

    // Bouton retour en haut
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTopBtn.classList.add('active');
        } else {
            backToTopBtn.classList.remove('active');
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Animation au défilement
    const animatedElements = document.querySelectorAll('[data-aos]');
    
    function checkScroll() {
        const triggerBottom = window.innerHeight * 0.8;
        
        animatedElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            
            if (elementTop < triggerBottom) {
                element.classList.add('aos-animate');
            }
        });
    }
    
    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Vérifier au chargement initial

    // Validation du formulaire de contact
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simuler l'envoi du formulaire
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Envoi en cours...';
            
            setTimeout(() => {
                alert('Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
                contactForm.reset();
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }, 1500);
        });
    }

    // Validation du formulaire de newsletter
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simuler l'inscription à la newsletter
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Inscription...';
            
            setTimeout(() => {
                alert('Merci pour votre inscription à notre newsletter !');
                newsletterForm.reset();
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }, 1500);
        });
    }

    // Navigation fluide pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId === '#') return;
            
            e.preventDefault();
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Fermer le menu mobile si ouvert
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    menuToggle.classList.remove('active');
                }
                
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Ajuster pour la hauteur du header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Mise à jour des liens actifs dans la navigation
    function updateActiveLinks() {
        const sections = document.querySelectorAll('section[id]');
        const scrollPosition = window.scrollY + 100;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }
    
    window.addEventListener('scroll', updateActiveLinks);
    updateActiveLinks(); // Vérifier au chargement initial
});
