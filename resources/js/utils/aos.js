// Vue-совместимая версия AOS анимаций
export function initAOS() {
    // Добавляем расширенные стили анимаций
    const animationStyles = document.createElement('style');
    animationStyles.textContent = `
        /* Базовые стили для всех анимаций */
        [data-aos] {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            backface-visibility: hidden;
            transform: translateZ(0);
            will-change: transform, opacity;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        /* Улучшенные версии стандартных анимаций AOS */
        [data-aos="fade-up"] {
            transform: translate3d(0, 50px, 0);
            opacity: 0;
        }
        [data-aos="fade-up"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        
        [data-aos="fade-down"] {
            transform: translate3d(0, -50px, 0);
            opacity: 0;
        }
        [data-aos="fade-down"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        
        [data-aos="fade-right"] {
            transform: translate3d(-50px, 0, 0);
            opacity: 0;
        }
        [data-aos="fade-right"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        
        [data-aos="fade-left"] {
            transform: translate3d(50px, 0, 0);
            opacity: 0;
        }
        [data-aos="fade-left"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        
        [data-aos="zoom-in"] {
            transform: scale3d(0.8, 0.8, 0.8);
            opacity: 0;
        }
        [data-aos="zoom-in"].aos-animate {
            transform: scale3d(1, 1, 1);
            opacity: 1;
        }
        
        [data-aos="zoom-out"] {
            transform: scale3d(1.2, 1.2, 1.2);
            opacity: 0;
        }
        [data-aos="zoom-out"].aos-animate {
            transform: scale3d(1, 1, 1);
            opacity: 1;
        }
        
        /* Новые эффектные анимации */
        [data-aos="flip-up"] {
            transform: perspective(2500px) rotateX(-100deg);
            opacity: 0;
        }
        [data-aos="flip-up"].aos-animate {
            transform: perspective(2500px) rotateX(0);
            opacity: 1;
        }
        
        [data-aos="flip-down"] {
            transform: perspective(2500px) rotateX(100deg);
            opacity: 0;
        }
        [data-aos="flip-down"].aos-animate {
            transform: perspective(2500px) rotateX(0);
            opacity: 1;
        }
        
        [data-aos="slide-up"] {
            transform: translate3d(0, 100%, 0);
            opacity: 0;
        }
        [data-aos="slide-up"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
        
        [data-aos="rotate-in"] {
            transform: rotate(-15deg) scale(0.9);
            opacity: 0;
            transform-origin: center;
        }
        [data-aos="rotate-in"].aos-animate {
            transform: rotate(0) scale(1);
            opacity: 1;
        }
        
        [data-aos="bounce-in"] {
            transform: scale3d(0.3, 0.3, 0.3);
            opacity: 0;
        }
        [data-aos="bounce-in"].aos-animate {
            animation: bounceIn 0.8s;
            opacity: 1;
        }
        
        @keyframes bounceIn {
            from, 20%, 40%, 60%, 80%, to {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }
            0% {
                opacity: 0;
                transform: scale3d(0.3, 0.3, 0.3);
            }
            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                transform: scale3d(0.9, 0.9, 0.9);
            }
            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                transform: scale3d(0.97, 0.97, 0.97);
            }
            to {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }
    `;
    document.head.appendChild(animationStyles);
    
    // Улучшенная реализация анимаций при скролле
    function initEnhancedAnimations() {
        if (typeof window === 'undefined') {
            return;
        }

        if (!('IntersectionObserver' in window)) {
            console.warn('[AOS] IntersectionObserver не поддерживается — анимации отключены.');
            return;
        }

        // Получаем все элементы с атрибутом data-aos
        const animatedElements = () => document.querySelectorAll('[data-aos]');

        // Создаем наблюдатель пересечений
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        requestAnimationFrame(() => {
                            entry.target.classList.add('aos-animate');
                        });
                    } else {
                        requestAnimationFrame(() => {
                            entry.target.classList.remove('aos-animate');
                        });
                    }
                });
            },
            {
                root: null,
                rootMargin: '0px 0px -10% 0px',
                threshold: [0, 0.1, 0.2, 0.3],
            }
        );

        const observeElements = () => {
            animatedElements().forEach((element) => {
                element.classList.add('aos-init');
                observer.observe(element);
            });
        };

        window.AOS = {
            refresh() {
                animatedElements().forEach((element) => observer.unobserve(element));
                observeElements();
            },
            init() {
                observeElements();
            },
        };

        // Принудительно обновляем все элементы
        window.AOS.init();
        
        // Добавляем обработчик прокрутки
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    window.AOS.refresh();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }
    
    // Запускаем нашу улучшенную инициализацию
    initEnhancedAnimations();
}

// Vue composable для использования AOS
export function useAOS() {
    const refreshAOS = () => {
        if (window.AOS && typeof window.AOS.refresh === 'function') {
            window.AOS.refresh();
        }
    };
    
    return {
        refreshAOS
    };
}
