import { AuthService, Router, boot } from './eos-runtime.js';
import { initAuthSlideshow, initThemeToggle, initPasswordToggles } from './auth-common.js';
class LoginComponent {
    constructor(auth, router) {
        this.auth = auth;
        this.router = router;
    }
    ngAfterViewInit() {
        window.AUTH_SLIDES = [
            { img: 'https://images.unsplash.com/photo-1541600383005-565c949cf777?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Strength', title: 'Train like the work actually matters', text: 'Free weights, machines, and a floor built for serious lifting — open early, open late.' },
            { img: 'https://images.unsplash.com/photo-1754257319747-df51c384c0fa?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Pilates', title: 'Balance and control, session after session', text: 'Reformer and mat classes led by instructors who actually watch your form.' },
            { img: 'https://images.unsplash.com/photo-1517130038641-a774d04afb3c?auto=format&fit=crop&w=1400&q=80', eyebrow: 'Community', title: 'A gym that knows your name', text: 'Group classes, a members-only app, and a front desk that remembers your goals.' },
        ];
        initThemeToggle();
        initAuthSlideshow();
        initPasswordToggles();
        const form = document.getElementById('login-form');
        const submitBtn = document.getElementById('login-submit');
        const errorEl = document.getElementById('login-error');
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email')?.value;
            const password = document.getElementById('login-password')?.value;
            if (!email || !password)
                return;
            submitBtn?.classList.add('auth-form__submit--loading');
            submitBtn.disabled = true;
            if (errorEl)
                errorEl.style.display = 'none';
            try {
                const { user } = await this.auth.login(email, password);
                // Resume unfinished signup
                if (user.status === 'pending_category') {
                    this.router.navigate(user.phone_verified ? ['/select-plan'] : ['/otp'], user.phone_verified ? {} : { queryParams: { email: user.email } });
                }
                else if (user.status === 'pending_approval') {
                    this.router.navigate(['/pending']);
                }
                else {
                    this.router.navigate(['/app']);
                }
            }
            catch (err) {
                const msg = err?.error?.error || 'Une erreur est survenue';
                if (errorEl) {
                    errorEl.textContent = msg;
                    errorEl.style.display = 'block';
                }
            }
            finally {
                submitBtn?.classList.remove('auth-form__submit--loading');
                submitBtn.disabled = false;
            }
        });
    }
}

boot(LoginComponent, [AuthService, Router]);
