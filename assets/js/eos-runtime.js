// Replaces Angular's DI/HttpClient/Router for the page scripts. All calls go to the PHP proxy (/api/*).
const BASE = window.EOS_BASE || '';
async function http(method, path, body) {
  const init = { method, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } };
  if (body instanceof FormData) init.body = body;
  else if (body !== undefined && method !== 'GET' && method !== 'DELETE') { init.headers['Content-Type'] = 'application/json'; init.body = JSON.stringify(body); }
  const r = await fetch(BASE + '/api/' + path.replace(/^\//, ''), init);
  let data = null; try { data = await r.json(); } catch (e) {}
  if (!r.ok) throw { status: r.status, error: data || {} };
  return data;
}
export class AuthService {
  currentUser = null;
  async register(name, email, phone, password) { const r = await http('POST', 'auth/register', { name, email, phone, password }); this.currentUser = r.user; return r; }
  async login(email, password) { const r = await http('POST', 'auth/login', { email, password }); this.currentUser = r.user; return r; }
  async me() { return (this.currentUser = await http('GET', 'auth/me')); }
  sendOtp() { return http('POST', 'auth/send-otp', {}); }
  verifyOtp(code) { return http('POST', 'auth/verify-otp', { code }); }
  getPlans() { return http('GET', 'auth/plans'); }
  setSubscription(category, planId) { return http('POST', 'auth/subscription', { category, planId }); }
  forgotPassword(email) { return http('POST', 'auth/forgot-password', { email }); }
  resetPassword(token, password) { return http('POST', 'auth/reset-password', { token, password, newPassword: password }); }
  async refresh() { try { await http('POST', 'auth/refresh', {}); return true; } catch (e) { return false; } }
  async logout() { try { await http('POST', 'auth/logout', {}); } finally { this.currentUser = null; } }
  // NOTE: missing from the repo's AuthService copy - endpoint assumed (PUT /auth/me, multipart). Adjust if your API differs.
  async updateProfile(name, email, avatar) {
    const fd = new FormData(); fd.append('name', name); fd.append('email', email); if (avatar) fd.append('avatar', avatar);
    const r = await http('POST', 'auth/me', fd); return r.user || r;
  }
}
export class ClassesService {
  listClasses(from, to) { return http('GET', `classes?from=${from.toISOString()}&to=${to.toISOString()}`); }
  myBookings() { return http('GET', 'classes/bookings'); }
  book(id) { return http('POST', `classes/${id}/book`, {}); }
  cancelBooking(id) { return http('DELETE', `classes/${id}/book`); }
  getDashboardHome() { return http('GET', 'dashboard/home'); }
  listPosters() { return http('GET', 'content/posters'); }
  listTrainers() { return http('GET', 'trainers'); }
  myNotifications() { return http('GET', 'content/my-notifications'); }
  markNotificationsRead() { return http('POST', 'content/my-notifications/read', {}); }
  listNotifications() { return http('GET', 'content/notifications'); }
}
export class StoreService {
  listProducts(category) { return http('GET', category && category !== 'all' ? `store/products?category=${encodeURIComponent(category)}` : 'store/products'); }
  checkout(items) { return http('POST', 'store/orders', { items }); }
  myOrders() { return http('GET', 'store/orders/mine'); }
}
export class Router {
  navigate(commands, extras = {}) {
    let p = '/' + commands.join('/').replace(/^\/+/, ''); if (p === '/dashboard') p = '/app';
    const q = new URLSearchParams(extras.queryParams || {}).toString();
    window.location.href = BASE + p + (q ? '?' + q : '');
    return Promise.resolve(true);
  }
}
const R = window.EOS_ROUTE || {};
const q = new URLSearchParams(window.location.search);
export class ActivatedRoute {
  snapshot = { queryParamMap: { get: (k) => q.get(k) }, paramMap: { get: (k) => (R.params || {})[k] ?? null } };
}
const singletons = {};
const make = (C) => (singletons[C.name] ||= new C());
export function boot(Cls, deps) {
  const start = () => {
    const page = new Cls(...deps.map((D) => make(D)));
    window.__page = page;
    page.ngOnInit && page.ngOnInit();
    page.ngAfterViewInit && page.ngAfterViewInit();
    window.addEventListener('pagehide', () => page.ngOnDestroy && page.ngOnDestroy());
  };
  document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', start) : start();
}
