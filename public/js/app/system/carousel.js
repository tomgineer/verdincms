// Initialize carousel controls and auto-advance behavior per wrapper.
export default function initCarousel() {
    const wrappers = document.querySelectorAll('.carousel-wrapper');
    if (wrappers.length === 0) return;

    const observers = [];
    const mqLarge = window.matchMedia('(min-width: 1536px)');

    wrappers.forEach((wrapper) => {
        const carousel = wrapper.querySelector('.carousel');
        if (!carousel) return;

        const btnLeft = wrapper.querySelector('.carousel-left');
        const btnRight = wrapper.querySelector('.carousel-right');
        const items = carousel.querySelectorAll('.carousel-item');

        if (!btnLeft || !btnRight || items.length === 0) return;

        btnLeft.addEventListener('click', () => {
            stopAuto(carousel);
            moveLeft(carousel);
        });
        btnRight.addEventListener('click', () => {
            stopAuto(carousel);
            moveRight(carousel);
        });

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    carousel._inView = entry.isIntersecting;
                    if (entry.isIntersecting) {
                        startAuto(carousel, mqLarge);
                    } else {
                        stopAuto(carousel);
                    }
                });
            },
            { threshold: 0.5 }
        );

        observer.observe(wrapper);
        observers.push(observer);

        mqLarge.addEventListener('change', () => {
            if (mqLarge.matches && carousel._inView) {
                startAuto(carousel, mqLarge);
            } else {
                stopAuto(carousel);
            }
        });
    });
}

// Compute one scroll step based on item width plus gap.
function getStep(carousel) {
    const firstItem = carousel.querySelector('.carousel-item');
    if (!firstItem) return 0;

    const style = window.getComputedStyle(carousel);
    const gap = parseFloat(style.columnGap || style.gap || '0');
    return Math.ceil(firstItem.getBoundingClientRect().width + gap);
}

// Scroll one item to the left.
function moveLeft(carousel) {
    const step = getStep(carousel);
    if (step === 0) return;
    carousel.scrollBy({ left: -step, behavior: 'smooth' });
}

// Scroll one item to the right.
function moveRight(carousel) {
    const step = getStep(carousel);
    if (step === 0) return;
    carousel.scrollBy({ left: step, behavior: 'smooth' });
}

// Auto-scroll right and wrap to start when at the end.
function moveRightAuto(carousel) {
    const step = getStep(carousel);
    if (step === 0) return;
    const maxScroll = carousel.scrollWidth - carousel.clientWidth;
    const atEnd = carousel.scrollLeft >= maxScroll - 1;

    if (atEnd) {
        carousel.scrollTo({ left: 0, behavior: 'smooth' });
        return;
    }

    carousel.scrollBy({ left: step, behavior: 'smooth' });
}

// Start the auto-advance timer if not already running.
function startAuto(carousel, mqLarge) {
    if (!mqLarge.matches) return;
    if (carousel._autoTimer) return;
    carousel._autoTimer = window.setInterval(() => {
        moveRightAuto(carousel);
    }, 3000);
}

// Stop the auto-advance timer if running.
function stopAuto(carousel) {
    if (!carousel._autoTimer) return;
    window.clearInterval(carousel._autoTimer);
    carousel._autoTimer = null;
}
