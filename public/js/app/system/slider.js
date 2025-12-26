export default function magneticSliderInit() {
    const slider = document.querySelector('[data-js="magnetic-slider"]');
    if (!slider) return;

    const list = slider.querySelector('ul');
    const prevBtn = slider.querySelector('[data-slider="prev"]');
    const nextBtn = slider.querySelector('[data-slider="next"]');
    if (!list || !prevBtn || !nextBtn) return;

    const getScrollAmount = () => {
        const firstItem = list.querySelector('li');
        if (!firstItem) return 0;
        const itemWidth = firstItem.getBoundingClientRect().width;
        const styles = getComputedStyle(list);
        const gap = parseFloat(styles.columnGap || styles.gap || 0) || 0;
        return itemWidth + gap;
    };

    const scrollByAmount = (direction) => {
        const amount = getScrollAmount();
        if (!amount) return;
        list.scrollBy({ left: direction * amount, behavior: 'smooth' });
    };

    prevBtn.addEventListener('click', () => scrollByAmount(-1));
    nextBtn.addEventListener('click', () => scrollByAmount(1));

    let autoScrollTimer = null;
    let autoScrollPaused = false;
    let userInteracted = false;
    const autoScrollDelayMs = 3000;

    let shouldReset = false;

    const tickAutoScroll = () => {
        const amount = getScrollAmount();
        if (!amount) return;
        const maxLeft = list.scrollWidth - list.clientWidth;
        if (shouldReset) {
            list.scrollTo({ left: 0, behavior: 'smooth' });
            shouldReset = false;
            return;
        }
        const nextLeft = list.scrollLeft + amount;
        if (nextLeft >= maxLeft - 1) {
            list.scrollTo({ left: maxLeft, behavior: 'smooth' });
            shouldReset = true;
            return;
        }
        list.scrollTo({ left: nextLeft, behavior: 'smooth' });
    };

    const startAutoScroll = () => {
        if (autoScrollTimer || autoScrollPaused || userInteracted) return;
        autoScrollTimer = setInterval(tickAutoScroll, autoScrollDelayMs);
    };

    const stopAutoScroll = () => {
        if (!autoScrollTimer) return;
        clearInterval(autoScrollTimer);
        autoScrollTimer = null;
    };

    const pauseAutoScroll = () => {
        userInteracted = true;
        autoScrollPaused = true;
        stopAutoScroll();
    };

    slider.addEventListener('pointerdown', pauseAutoScroll);
    slider.addEventListener('touchstart', pauseAutoScroll, { passive: true });
    list.addEventListener('pointerdown', pauseAutoScroll);
    list.addEventListener('touchstart', pauseAutoScroll, { passive: true });
    // Only pause on direct user interaction; auto-scroll triggers scroll events too.

    const observeVisibility = () => {
        if (!('IntersectionObserver' in window)) {
            startAutoScroll();
            return;
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !userInteracted) {
                    startAutoScroll();
                } else {
                    stopAutoScroll();
                }
            });
        }, { threshold: 0.25 });
        observer.observe(slider);
    };

    observeVisibility();
}
