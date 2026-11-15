import { AuthService, Router, boot } from './eos-runtime.js';
class PendingComponent {
    constructor(auth, router) {
        this.auth = auth;
        this.router = router;
    }
    ngOnInit() {
        // Poll GET /api/me every 15s; once status === 'approved', move to the app.
        this.poll = setInterval(async () => {
            try {
                const me = await this.auth.me();
                if (me?.status === 'approved') {
                    clearInterval(this.poll);
                    this.router.navigate(['/dashboard']);
                }
            }
            catch { /* ignore transient errors while polling */ }
        }, 15000);
    }
    ngOnDestroy() {
        if (this.poll)
            clearInterval(this.poll);
    }
    logout() {
        this.auth.logout().finally(() => this.router.navigate(['/login']));
    }
}

boot(PendingComponent, [AuthService, Router]);
