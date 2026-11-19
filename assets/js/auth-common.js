// @ts-nocheck
// Ported from eos-auth.js — shared auth page behavior (slideshow, password toggles/strength, fake submit)
const DEFAULT_SLIDES = [
    {
        img: 'https://images.unsplash.com/photo-1541600383005-565c949cf777?auto=format&fit=crop&w=1400&q=80',
        eyebrow: 'Strength',
        title: 'Train like the work actually matters',
        text: 'Free weights, machines, and a floor built for serious lifting — open early, open late.',
    },
    {
        img: 'https://images.unsplash.com/photo-1754257319747-df51c384c0fa?auto=format&fit=crop&w=1400&q=80',
        eyebrow: 'Pilates',
        title: 'Balance and control, session after session',
        text: 'Reformer and mat classes led by instructors who actually watch your form.',
    },
    {
        img: 'https://images.unsplash.com/photo-1517130038641-a774d04afb3c?auto=format&fit=crop&w=1400&q=80',
        eyebrow: 'Community',
        title: 'A gym that knows your name',
        text: 'Group classes, a members-only app, and a front desk that remembers your goals.',
    },
];
export function initAuthSlideshow() {
    const root = document.getElementById('auth-visual');
    if (!root)
        return;
    const slides = window.AUTH_SLIDES && window.AUTH_SLIDES.length ? window.AUTH_SLIDES : DEFAULT_SLIDES;
    const slideLayer = document.getElementById('auth-slide-layer');
    const eyebrowEl = document.getElementById('auth-caption-eyebrow');
    const titleEl = document.getElementById('auth-caption-title');
    const textEl = document.getElementById('auth-caption-text');
    const dotsEl = document.getElementById('auth-dots');
    if (!slideLayer)
        return;
    slideLayer.innerHTML = slides
        .map((s, i) => `<div class="auth__slide${i === 0 ? ' auth__slide--active' : ''}" data-idx="${i}">
        <img src="${s.img}" alt="" />
      </div>`)
        .join('');
    if (dotsEl) {
        dotsEl.innerHTML = slides
            .map((_, i) => `<button type="button" class="auth__dot${i === 0 ? ' auth__dot--active' : ''}" data-idx="${i}" aria-label="Show slide ${i + 1}"></button>`)
            .join('');
    }
    let current = 0;
    let timer = null;
    function paintCaption(i) {
        const s = slides[i];
        if (eyebrowEl)
            eyebrowEl.textContent = s.eyebrow;
        if (titleEl)
            titleEl.textContent = s.title;
        if (textEl)
            textEl.textContent = s.text;
        [eyebrowEl, titleEl, textEl].forEach((el) => {
            if (!el)
                return;
            el.style.opacity = 0;
            el.style.transform = 'translateY(6px)';
            requestAnimationFrame(() => {
                el.style.opacity = 1;
                el.style.transform = 'translateY(0)';
            });
        });
    }
    function goTo(i) {
        current = (i + slides.length) % slides.length;
        slideLayer.querySelectorAll('.auth__slide').forEach((el, idx) => {
            el.classList.toggle('auth__slide--active', idx === current);
        });
        if (dotsEl) {
            dotsEl.querySelectorAll('.auth__dot').forEach((el, idx) => {
                el.classList.toggle('auth__dot--active', idx === current);
            });
        }
        paintCaption(current);
    }
    function restartTimer() {
        if (timer)
            clearInterval(timer);
        timer = setInterval(() => goTo(current + 1), 5500);
    }
    if (dotsEl) {
        dotsEl.addEventListener('click', (e) => {
            const btn = e.target.closest('.auth__dot');
            if (!btn)
                return;
            goTo(Number(btn.dataset.idx));
            restartTimer();
        });
    }
    paintCaption(0);
    restartTimer();
}
const EYE_OPEN = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>';
const EYE_OFF = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18"/><path d="M10.6 5.2A9.6 9.6 0 0 1 12 5c6.4 0 10 7 10 7a15.6 15.6 0 0 1-3.4 4.3M6.7 6.7C4 8.5 2 12 2 12s3.6 7 10 7a9.5 9.5 0 0 0 3.9-.8"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>';
export function initPasswordToggles() {
    document.querySelectorAll('.field__toggle').forEach((btn) => {
        btn.innerHTML = EYE_OPEN;
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.for);
            if (!input)
                return;
            const showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            btn.innerHTML = showing ? EYE_OPEN : EYE_OFF;
            btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        });
    });
}
function scorePassword(pw) {
    let score = 0;
    if (pw.length >= 8)
        score++;
    if (pw.length >= 12)
        score++;
    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw))
        score++;
    if (/\d/.test(pw))
        score++;
    if (/[^A-Za-z0-9]/.test(pw))
        score++;
    return Math.min(score, 4);
}
export function initPasswordStrength() {
    const input = document.getElementById('su-password');
    const bars = document.querySelectorAll('.strength__bar');
    const label = document.getElementById('strength-label');
    if (!input || !bars.length)
        return;
    const colors = ['#e0355a', '#c9a227', '#e6cc7a', '#8fc25f'];
    const labels = ['Weak', 'Okay', 'Good', 'Strong'];
    input.addEventListener('input', () => {
        const val = input.value;
        const score = val ? scorePassword(val) : 0;
        bars.forEach((bar, i) => {
            bar.style.background = i < score ? colors[Math.max(score - 1, 0)] : 'var(--line)';
        });
        if (label)
            label.textContent = val ? labels[Math.max(score - 1, 0)] : '';
    });
}
export function initFakeSubmit(formId, btnId, onDone) {
    const form = document.getElementById(formId);
    const btn = document.getElementById(btnId);
    if (!form || !btn)
        return;
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (btn.disabled)
            return;
        btn.classList.add('auth-form__submit--loading');
        btn.disabled = true;
        setTimeout(() => {
            btn.classList.remove('auth-form__submit--loading');
            btn.disabled = false;
            if (typeof onDone === 'function')
                onDone();
        }, 900);
    });
}
export function initThemeToggle() {
    document.documentElement.setAttribute('data-theme', 'dark'); // dark mode only
}
