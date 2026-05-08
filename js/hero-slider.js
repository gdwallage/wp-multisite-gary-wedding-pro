/**
 * File: js/hero-slider.js
 * Description: Absolute-positioning carousel logic (Infinite Loop)
 * Version: 3000.250.0
 */
document.addEventListener('DOMContentLoaded', function () {
    console.log('Gary Wallage Absolute Slider Engine Loaded');
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

    const stage = document.getElementById('heroCaptionStage');
    const stageTitle = stage ? stage.querySelector('.hero-peek-title') : null;
    const stageSubtitle = stage ? stage.querySelector('.hero-peek-subtitle') : null;
    const stageCTA = stage ? stage.querySelector('.hero-peek-cta') : null;

    function update(idx) {
        current = (idx + total) % total;
        
        // 1. Update Slide Classes for Rotation
        slides.forEach(function (slide, i) {
            let rel = i - current;
            if (rel > total / 2) rel -= total;
            if (rel < -total / 2) rel += total;
            slide.className = 'hero-peek-slide ' + getClass(rel);
        });

        // 2. Update Stable Caption Content (Direct DOM Sync)
        const stageEl = document.getElementById('heroCaptionStage');
        if (stageEl && slides[current]) {
            const activeSlide = slides[current];
            const title = activeSlide.getAttribute('data-title') || '';
            const subtitle = activeSlide.getAttribute('data-subtitle') || '';
            const cta = activeSlide.getAttribute('data-cta') || '';
            const url = activeSlide.getAttribute('data-url') || '#';

            const titleEl = stageEl.querySelector('.hero-peek-title');
            const subtitleEl = stageEl.querySelector('.hero-peek-subtitle');
            const ctaEl = stageEl.querySelector('.hero-peek-cta');

            if (titleEl) titleEl.textContent = title;
            if (subtitleEl) {
                subtitleEl.textContent = subtitle;
                subtitleEl.style.display = subtitle ? 'block' : 'none';
            }
            if (ctaEl) {
                ctaEl.href = url;
                ctaEl.style.display = cta ? 'inline-block' : 'none';
            }
            stageEl.style.opacity = '1';
        }

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

    if (prevBtn) prevBtn.addEventListener('click', function (e) { e.preventDefault(); prev(); startAutoplay(); });
    if (nextBtn) nextBtn.addEventListener('click', function (e) { e.preventDefault(); next(); startAutoplay(); });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function (e) { e.preventDefault(); update(i); startAutoplay(); });
    });

    slides.forEach(function (slide, i) {
        slide.addEventListener('click', function (e) {
            if (slide.classList.contains('prev') || slide.classList.contains('next')) {
                e.preventDefault();
                update(i);
                startAutoplay();
            } else if (slide.classList.contains('active')) {
                const url = slide.dataset.url;
                if (url && e.target.closest('.hero-peek-cta')) window.location.href = url;
            }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { prev(); startAutoplay(); }
        if (e.key === 'ArrowRight') { next(); startAutoplay(); }
    });

    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);

    update(0);
    if (total > 1) startAutoplay();
});
