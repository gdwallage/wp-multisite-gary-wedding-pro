/**
 * File: js/hero-slider.js
 * Description: High-performance peek carousel logic for the Gary Wallage Wedding Pro theme.
 */
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('heroPeekCarousel');
    if (!carousel) return;

    const slides = Array.from(carousel.querySelectorAll('.hero-peek-slide'));
    const dots = Array.from(carousel.querySelectorAll('.hero-peek-dot'));
    const prevBtn = document.getElementById('heroPeekPrev');
    const nextBtn = document.getElementById('heroPeekNext');
    const total = slides.length;
    let current = 0;
    let timer = null;

    function getClass(relativeIndex) {
        if (relativeIndex === 0) return 'active';
        if (relativeIndex === 1) return 'next';
        if (relativeIndex === -1) return 'prev';
        if (relativeIndex === 2) return 'far-next';
        if (relativeIndex === -2) return 'far-prev';
        return 'hidden';
    }

    function update(idx) {
        current = (idx + total) % total;
        slides.forEach(function (slide, i) {
            let rel = i - current;
            if (rel > total / 2) rel -= total;
            if (rel < -total / 2) rel += total;
            slide.className = 'hero-peek-slide ' + getClass(rel);
        });
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === current);
        });
    }

    function next() { update(current + 1); }
    function prev() { update(current - 1); }

    function startAutoplay() {
        clearInterval(timer);
        timer = setInterval(next, 7000);
    }
    function stopAutoplay() {
        clearInterval(timer);
    }

    if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAutoplay(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAutoplay(); });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { update(i); startAutoplay(); });
    });

    slides.forEach(function (slide, i) {
        slide.addEventListener('click', function (e) {
            if (slide.classList.contains('prev') || slide.classList.contains('next') ||
                slide.classList.contains('far-prev') || slide.classList.contains('far-next')) {
                e.preventDefault();
                update(i);
                startAutoplay();
            } else if (slide.classList.contains('active')) {
                const url = slide.dataset.url;
                if (url) window.location.href = url;
            }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { prev(); startAutoplay(); }
        if (e.key === 'ArrowRight') { next(); startAutoplay(); }
    });

    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);

    let touchStartX = 0;
    carousel.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
    carousel.addEventListener('touchend', function (e) {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) next(); else prev();
            startAutoplay();
        }
    });

    update(0);
    if (total > 1) startAutoplay();
});
