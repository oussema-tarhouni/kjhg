import { AuthService, Router, boot } from './eos-runtime.js';
import { initAuthSlideshow, initThemeToggle, initPasswordToggles, initPasswordStrength } from './auth-common.js';
class SignupComponent {
    constructor(auth, router) {
        this.auth = auth;
        this.router = router;
    }
    ngAfterViewInit() {
        window.AUTH_SLIDES = [
            { img: 'https://images.unsplash.com/photo-1754257319747-df51c384c0fa?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Get started', title: 'Your first rep starts here', text: 'Create a free account and set up your membership in under a minute.' },
            { img: 'https://images.unsplash.com/photo-1517130038641-a774d04afb3c?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Group classes', text: 'From HIIT to reformer pilates, book your spot before it fills up.', title: 'Classes for every kind of training day' },
            { img: 'https://images.unsplash.com/photo-1541600383005-565c949cf777?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Stay accountable', title: 'Track workouts, streaks, and personal bests', text: 'Your membership card, class schedule, and progress — all in one place.' },
        ];
        initThemeToggle();
        initAuthSlideshow();
        initPasswordToggles();
        initPasswordStrength();
        const checkPasswordsMatch = () => {
            const pw = document.getElementById('su-password').value;
            const cf = document.getElementById('su-confirm');
            const err = document.getElementById('confirm-error');
            const mismatch = cf.value.length > 0 && cf.value !== pw;
            cf.classList.toggle('field--invalid', mismatch);
            err.classList.toggle('field__error--show', mismatch);
        };
        document.getElementById('su-confirm').addEventListener('input', checkPasswordsMatch);
        document.getElementById('su-password').addEventListener('input', checkPasswordsMatch);
        const phoneInput = document.getElementById('su-phone');
        const phoneError = document.getElementById('phone-error');
        phoneInput?.addEventListener('input', () => {
            phoneInput.value = phoneInput.value.replace(/\D/g, '').slice(0, 8);
        });
        const signupForm = document.getElementById('signup-form');
        const submitBtn = document.getElementById('signup-submit');
        signupForm?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('su-name')?.value;
            const email = document.getElementById('su-email')?.value;
            const phone = phoneInput?.value || '';
            const password = document.getElementById('su-password').value;
            const confirm = document.getElementById('su-confirm').value;
            const phoneValid = /^[0-9]{8}$/.test(phone);
            phoneError?.classList.toggle('field__error--show', !phoneValid);
            phoneInput?.classList.toggle('field--invalid', !phoneValid);
            if (!name || !email || !password || password !== confirm || !phoneValid)
                return;
            submitBtn?.classList.add('auth-form__submit--loading');
            submitBtn.disabled = true;
            try {
                await this.auth.register(name, email, phone, password);
                await this.auth.sendOtp();
                this.router.navigate(['/verify-otp'], { queryParams: { email } });
            }
            catch (err) {
                const msg = err?.error?.error || 'Une erreur est survenue';
                phoneError.textContent = msg;
                phoneError.classList.add('field__error--show');
            }
            finally {
                submitBtn?.classList.remove('auth-form__submit--loading');
                submitBtn.disabled = false;
            }
        });
    }
}

boot(SignupComponent, [AuthService, Router]);
