import { Router, ActivatedRoute, AuthService, boot } from './eos-runtime.js';
class OtpComponent {
    constructor(router, route, auth) {
        this.router = router;
        this.route = route;
        this.auth = auth;
        this.email = '';
        this.cooldown = false;
    }
    mask(e) {
        const [u, d] = e.split('@');
        return u && d ? u.slice(0, 2) + '***@' + d : e;
    }
    ngAfterViewInit() {
        this.email = this.route.snapshot.queryParamMap.get('email') || '';
        const emailEl = document.getElementById('otp-phone-display');
        if (emailEl)
            emailEl.textContent = this.mask(this.email);
        const form = document.getElementById('otp-form');
        const btn = document.getElementById('otp-submit');
        const input = document.getElementById('otp-code');
        const errEl = document.getElementById('otp-error');
        const showErr = (m) => { errEl.textContent = m; errEl.classList.toggle('field__error--show', !!m); };
        input?.addEventListener('input', () => { input.value = input.value.replace(/\D/g, '').slice(0, 6); });
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const code = input.value;
            if (!/^[0-9]{6}$/.test(code)) {
                showErr('Enter the 6-digit code');
                return;
            }
            showErr('');
            btn.classList.add('auth-form__submit--loading');
            btn.disabled = true;
            try {
                await this.auth.verifyOtp(code);
                this.router.navigate(['/select-plan']);
            }
            catch (err) {
                showErr(err?.error?.error || 'Incorrect or expired code');
            }
            finally {
                btn.classList.remove('auth-form__submit--loading');
                btn.disabled = false;
            }
        });
        const resend = document.getElementById('otp-resend');
        resend?.addEventListener('click', async (e) => {
            e.preventDefault();
            if (this.cooldown)
                return;
            this.cooldown = true;
            showErr('');
            try {
                await this.auth.sendOtp();
                resend.textContent = 'Code sent';
            }
            catch (err) {
                showErr(err?.error?.error || 'Could not send the code');
            }
            setTimeout(() => { this.cooldown = false; resend.textContent = 'Resend code'; }, 60000);
        });
    }
}

boot(OtpComponent, [Router, ActivatedRoute, AuthService]);
