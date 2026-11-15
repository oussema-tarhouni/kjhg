import { AuthService, Router, ClassesService, StoreService, boot } from './eos-runtime.js';
class DashboardComponent {
    applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        try {
            localStorage.setItem('theme', theme);
        }
        catch { }
        document.getElementById('themeSwitch')?.setAttribute('aria-checked', String(theme === 'dark'));
    }
    initTheme() {
        let saved = 'light';
        try {
            saved = localStorage.getItem('theme') || 'light';
        }
        catch { }
        this.applyTheme(saved);
        if (window.__themeBound)
            return;
        window.__themeBound = true;
        document.addEventListener('click', (e) => {
            if (e.target.closest('#themeMenuItem')) {
                this.applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
            }
        });
    }
    constructor(auth, router, classesApi, storeApi) {
        this.auth = auth;
        this.router = router;
        this.classesApi = classesApi;
        this.storeApi = storeApi;
        this.realUserName = '';
        this.realUserLevel = '';
        this.myBookedClassIds = new Set();
        this.selectedScheduleDate = new Date();
        this.lastScheduleClasses = [];
        this.pendingBookBtn = null;
        this.pendingBookClass = null;
        this.products = [];
        this.cart = new Map(); // product_id -> qty
        this.storeCategory = 'all';
        this.storeSearch = '';
        this.storeSort = 'random';
        this.storePage = 1;
        this.storeKey = '';
        this.storeOrder = [];
        this.PAGE_SIZE = 12;
        this.favorites = new Set();
        this.selectedCategory = 'all';
        this.categoryFiltersRendered = false;
        this.initTheme();
    }
    // Handles data-action/data-arg clicks (replaces original inline onclick="" attributes,
    // which Angular's template compiler disallows for security reasons)
    __run(event) {
        const el = event.currentTarget;
        const action = el.dataset['action'];
        const arg = el.dataset['arg'];
        if (action === 'toggleParentOpen') {
            el.parentElement?.classList.toggle('open');
            return;
        }
        if (action === 'addToCart' && arg) {
            this.addToCart(arg);
            return;
        }
        if (action === 'changeCartQty' && arg) {
            const [id, delta] = arg.split(':');
            this.changeCartQty(Number(id), Number(delta));
            return;
        }
        if (action && typeof window[action] === 'function') {
            window[action](arg, el);
        }
    }
    initialsOf(name) {
        return (name || '').trim().split(/\s+/).slice(0, 2).map(p => p[0]?.toUpperCase() || '').join('') || '?';
    }
    applyUserToDom(user) {
        if (!user)
            return;
        const initials = this.initialsOf(user.name);
        this.realUserName = user.name || '';
        this.realUserLevel = user.level || '';
        const lvlKey = this.levelKey(user.level);
        const lvlBadge = lvlKey ? `<span class="level-badge level-${lvlKey}">${this.levelLabel(lvlKey)}</span>` : '';
        const nameHtml = `${this.escapeHtml(user.name)}${lvlBadge}`;
        const tbName = document.getElementById('tbName');
        if (tbName)
            tbName.innerHTML = nameHtml;
        const profileName = document.getElementById('profileNameText');
        if (profileName)
            profileName.innerHTML = nameHtml;
        const sbFootName = document.getElementById('sbFootName');
        if (sbFootName)
            sbFootName.innerHTML = nameHtml;
        const sbAvatar = document.getElementById('sbAvatar');
        if (sbAvatar) {
            if (user.avatar) {
                sbAvatar.style.cssText = `background:url(${user.avatar}) center/cover; color:transparent;`;
            }
            else {
                sbAvatar.textContent = initials;
            }
        }
        const profileAvatar = document.getElementById('profileAvatarLg');
        if (profileAvatar) {
            if (user.avatar) {
                profileAvatar.style.cssText = `background:url(${user.avatar}) center/cover; color:transparent;`;
            }
            else {
                profileAvatar.textContent = initials;
            }
        }
        const epName = document.getElementById('epName');
        if (epName)
            epName.value = user.name || '';
        const epEmail = document.getElementById('epEmail');
        if (epEmail)
            epEmail.value = user.email || '';
        const epPhone = document.getElementById('epPhone');
        if (epPhone)
            epPhone.value = user.phone || '';
        const epAvatarPreview = document.getElementById('epAvatarPreview');
        if (epAvatarPreview) {
            if (user.avatar) {
                epAvatarPreview.style.cssText = `background:url(${user.avatar}) center/cover; color:transparent;`;
            }
            else {
                epAvatarPreview.textContent = initials;
            }
        }
    }
    async loadRealUser() {
        try {
            const user = await this.auth.me();
            this.applyUserToDom(user);
            this.applyMemberSince(user.created_at);
            await this.loadMembershipAndTodaysClasses();
            await this.renderSchedulePills();
            await this.loadPosters();
            await this.loadNotifications();
            await this.loadTrainers();
            await this.loadStore();
        }
        catch (err) {
            console.error('Impossible de charger le profil:', err);
            this.router.navigate(['/login']);
        }
    }
    applyMemberSince(createdAt) {
        if (!createdAt)
            return;
        const d = new Date(createdAt);
        const label = d.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        const mcSub = document.getElementById('mcSub');
        if (mcSub)
            mcSub.textContent = `Member since ${label} · Auto-renew enabled`;
        const profileTier = document.getElementById('profileTierText');
        if (profileTier)
            profileTier.textContent = `Member since ${label}`;
    }
    async loadMembershipAndTodaysClasses() {
        try {
            const home = await this.classesApi.getDashboardHome();
            const m = home?.membership;
            if (m) {
                const tier = document.getElementById('mcTier');
                if (tier)
                    tier.textContent = `${(m.plan_name || 'MEMBERSHIP').toUpperCase()} MEMBERSHIP`;
                const status = document.getElementById('mcStatus');
                if (status)
                    status.textContent = m.status === 'active' ? 'Active' : m.status;
                const used = m.classes_used_this_month ?? 0;
                const total = m.classes_per_month;
                const quota = document.getElementById('mcQuota');
                if (quota)
                    quota.textContent = total === null || total === undefined ? `${used} / Unlimited` : `${used} / ${total}`;
                const fill = document.getElementById('mcProgressFill');
                if (fill)
                    fill.style.width = total ? `${Math.min(100, (used / total) * 100)}%` : '100%';
                const renew = document.getElementById('mcRenewDate');
                if (renew && m.renews_at) {
                    renew.textContent = new Date(m.renews_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                }
            }
        }
        catch (err) {
            console.error('Erreur chargement abonnement:', err);
        }
        await this.loadTodaysClasses();
    }
    async loadTodaysClasses() {
        const grid = document.getElementById('hclassGrid');
        if (!grid)
            return;
        try {
            const start = new Date();
            start.setHours(0, 0, 0, 0);
            const end = new Date();
            end.setHours(23, 59, 59, 999);
            const [classes, bookings] = await Promise.all([
                this.classesApi.listClasses(start, end),
                this.classesApi.myBookings(),
            ]);
            this.myBookedClassIds = new Set(bookings.filter((b) => b.status === 'booked').map((b) => b.class_id));
            if (!classes.length) {
                grid.innerHTML = `<div class="hclass-card"><div class="hclass-meta">No classes scheduled today.</div></div>`;
                return;
            }
            grid.innerHTML = classes.slice(0, 3).map((c) => {
                const start = new Date(c.starts_at);
                const end = new Date(c.ends_at);
                const tagClass = c.spots_left <= 0 ? 'tag-gold' : c.spots_left <= 3 ? 'tag-gold' : 'tag-green';
                const tagText = c.spots_left <= 0 ? 'Full' : c.spots_left <= 3 ? 'Filling fast' : `${c.spots_left} spots`;
                const levelKey = this.levelKey(c.level);
                const levelBadge = levelKey ? `<span class="level-badge level-${levelKey}">${this.levelLabel(levelKey)}</span>` : '';
                return `
          <div class="hclass-card">
            <div class="hclass-time-col">
              <span class="hclass-time">${this.fmtTime(start)}</span>
              <span class="hclass-time-sep">–</span>
              <span class="hclass-time">${this.fmtTime(end)}</span>
            </div>
            <div class="hclass-body">
              <div class="hclass-name">${c.name}${levelBadge}</div>
              <div class="hclass-meta">with ${c.trainer_name} · ${c.location || ''}</div>
            </div>
            <span class="hclass-tag ${tagClass}">${tagText}</span>
          </div>`;
            }).join('');
        }
        catch (err) {
            console.error('Erreur chargement cours du jour:', err);
            grid.innerHTML = `<div class="hclass-card"><div class="hclass-meta">Erreur de chargement.</div></div>`;
        }
    }
    escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s ?? '';
        return d.innerHTML;
    }
    initials(name) {
        return (name || '').split(' ').filter(Boolean).map(w => w[0]).join('').slice(0, 2).toUpperCase();
    }
    async loadStore(filter = this.storeCategory) {
        const grid = document.getElementById('storeGrid');
        if (!grid)
            return;
        this.storeCategory = filter;
        try {
            if (filter === 'all' || !this.products.length) {
                this.products = await this.storeApi.listProducts();
            }
            let items = filter === 'all' ? this.products : this.products.filter(p => p.category === filter);
            if (this.storeSearch) {
                const q = this.storeSearch.toLowerCase();
                items = items.filter(p => p.name.toLowerCase().includes(q));
            }
            const key = `${filter}|${this.storeSearch}|${this.storeSort}`;
            if (key !== this.storeKey) {
                this.storeKey = key;
                this.storePage = 1;
            }
            if (this.storeSort === 'asc')
                items = [...items].sort((a, b) => a.price - b.price);
            else if (this.storeSort === 'desc')
                items = [...items].sort((a, b) => b.price - a.price);
            else {
                if (this.storeOrder.length !== this.products.length)
                    this.storeOrder = this.products.map((_, i) => i).sort(() => Math.random() - 0.5);
                const rank = new Map(this.storeOrder.map((v, i) => [this.products[v].id, i]));
                items = [...items].sort((a, b) => rank.get(a.id) - rank.get(b.id));
            }
            const total = items.length, pages = Math.max(1, Math.ceil(total / this.PAGE_SIZE));
            this.storePage = Math.min(this.storePage, pages);
            const from = (this.storePage - 1) * this.PAGE_SIZE;
            const pageItems = items.slice(from, from + this.PAGE_SIZE);
            this.renderStorePager(total, pages, from, pageItems.length);
            grid.innerHTML = pageItems.length
                ? pageItems.map((p) => `
            <div class="product-card">
              <div class="product-thumb">
                ${p.image_url ? `<img src="${p.image_url}" alt="" onerror="this.replaceWith(Object.assign(document.createElement('div'),{textContent:'🛒'}))">` : '🛒'}
                ${p.category ? `<div class="product-cat-badge">${this.escapeHtml(p.category)}</div>` : ''}
                <button type="button" class="product-heart${this.favorites.has(p.id) ? ' on' : ''}" data-fav="${p.id}" aria-label="Save"><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.5-9C.7 8.4 2.5 4.5 6.5 4.5c2 0 3.6 1.2 4.5 2.7C11.9 5.7 13.5 4.5 15.5 4.5c4 0 5.8 3.9 4 7.5-2.5 4.4-9.5 9-9.5 9z"/></svg></button>
              </div>
              <div class="product-info">
                <div class="product-name">${this.escapeHtml(p.name)}</div>
                <div class="product-stock ${p.stock > 0 ? 'ok' : 'out'}">${p.stock > 0 ? `In stock · ${p.stock} available` : 'Out of stock'}</div>
              </div>
              <div class="product-foot">
                <div class="product-price">${Number(p.price).toFixed(2)} TND</div>
                <button type="button" class="product-add-fab" data-id="${p.id}" ${p.stock > 0 ? '' : 'disabled'} aria-label="Add to cart">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h2l1.5 10.5h10L20 8H7"/><circle cx="9.5" cy="20" r="1"/><circle cx="17" cy="20" r="1"/></svg><span>Add to Cart</span>
                </button>
              </div>
            </div>`).join('')
                : `<div class="product-card"><div class="product-name">No products found.</div></div>`;
            grid.querySelectorAll('.product-add-fab').forEach((btn) => btn.addEventListener('click', () => this.addToCart(btn.dataset.id)));
            grid.querySelectorAll('.product-heart').forEach((btn) => btn.addEventListener('click', () => {
                const id = Number(btn.dataset.fav);
                this.favorites.has(id) ? this.favorites.delete(id) : this.favorites.add(id);
                btn.classList.toggle('on');
            }));
        }
        catch (err) {
            console.error('Erreur chargement store:', err);
            grid.innerHTML = `<div class="product-card"><div class="trainer-role">Unable to load store.</div></div>`;
        }
    }
    renderStorePager(total, pages, from, n) {
        const set = (id, s) => { const e = document.getElementById(id); if (e)
            e.textContent = s; };
        set('storeCount', `${total} product${total === 1 ? '' : 's'} available`);
        set('storeRange', total ? `Showing ${from + 1}-${from + n} of ${total} item(s)` : 'No items');
        const cur = this.storePage, list = [];
        for (let i = 1; i <= pages; i++)
            if (i === 1 || i === pages || Math.abs(i - cur) <= 1)
                list.push(i);
            else if (list[list.length - 1] !== '…')
                list.push('…');
        const html = pages < 2 ? '' : list.map(x => x === '…' ? '<span>…</span>' : `<button type="button" class="${x === cur ? 'on' : ''}" data-p="${x}">${x}</button>`).join('') + (cur < pages ? `<button type="button" data-p="${cur + 1}">›</button>` : '');
        document.querySelectorAll('.store-pager').forEach(el => el.innerHTML = html);
    }
    async openStoreSearch(query) {
        document.getElementById('storeResultsSearchInput') && (document.getElementById('storeResultsSearchInput').value = query);
        if (!this.products.length) {
            try {
                this.products = await this.storeApi.listProducts();
            }
            catch {
                this.products = [];
            }
        }
        goTo('page-store-search');
        this.renderStoreMasonry(query);
    }
    renderStoreMasonry(query) {
        const colA = document.getElementById('storeMasonryColA');
        const colB = document.getElementById('storeMasonryColB');
        const countEl = document.getElementById('storeResultsN');
        if (!colA || !colB)
            return;
        const q = query.trim().toLowerCase();
        const items = q ? this.products.filter(p => p.name.toLowerCase().includes(q)) : this.products;
        if (countEl)
            countEl.textContent = String(items.length);
        colA.innerHTML = '';
        colB.innerHTML = '';
        items.forEach((p, i) => {
            const active = this.favorites.has(p.id) ? ' active' : '';
            const card = document.createElement('div');
            card.className = 'pc-alt';
            card.innerHTML = `
        <div class="pc-alt-thumb" style="aspect-ratio:1/${i % 2 === 0 ? '1.05' : '0.9'}">${p.image ? `<img src="${p.image}" alt="">` : '<svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 3H18L20 8V19C20 20.1 19.1 21 18 21H6C4.9 21 4 20.1 4 19V8L6 3Z" stroke-linejoin="round"/></svg>'}</div>
        <div class="pc-alt-name">${this.escapeHtml(p.name)}</div>
        <div class="pc-alt-sub">${this.escapeHtml(p.category || '')}</div>
        <div class="pc-alt-foot">
          <span class="pc-alt-price">${Number(p.price).toFixed(2)} TND</span>
          <button type="button" class="pc-heart-btn${active}" data-id="${p.id}" aria-label="Save"><svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 21s-7-4.6-9.5-9C.7 8.4 2.5 4.5 6.5 4.5c2 0 3.6 1.2 4.5 2.7C11.9 5.7 13.5 4.5 15.5 4.5c4 0 5.8 3.9 4 7.5-2.5 4.4-9.5 9-9.5 9z"/></svg></button>
        </div>`;
            (i % 2 === 0 ? colA : colB).appendChild(card);
        });
        document.querySelectorAll('.pc-heart-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                const id = Number(btn.dataset.id);
                this.favorites.has(id) ? this.favorites.delete(id) : this.favorites.add(id);
                btn.classList.toggle('active');
            });
        });
    }
    addToCart(productId) {
        const id = Number(productId);
        const product = this.products.find(p => p.id === id);
        if (!product || product.stock <= 0)
            return;
        const currentQty = this.cart.get(id) || 0;
        if (currentQty >= product.stock) {
            showToast('No more stock available');
            return;
        }
        this.cart.set(id, currentQty + 1);
        this.renderCart();
        showToast(`${product.name} added to cart`);
    }
    changeCartQty(productId, delta) {
        const qty = (this.cart.get(productId) || 0) + delta;
        if (qty <= 0)
            this.cart.delete(productId);
        else
            this.cart.set(productId, qty);
        this.renderCart();
    }
    renderCart() {
        const feed = document.getElementById('cartPanelFeed');
        const foot = document.getElementById('cartPanelFoot');
        const dot = document.getElementById('cartDot');
        const totalEl = document.getElementById('cartPanelTotal');
        if (!feed)
            return;
        if (dot)
            dot.classList.toggle('active', this.cart.size > 0);
        if (this.cart.size === 0) {
            feed.innerHTML = `<div class="notif-row"><div class="notif-text">Your cart is empty.</div></div>`;
            if (foot)
                foot.style.display = 'none';
            return;
        }
        let total = 0;
        feed.innerHTML = Array.from(this.cart.entries()).map(([id, qty]) => {
            const p = this.products.find(x => x.id === id);
            if (!p)
                return '';
            total += p.price * qty;
            return `
        <div class="cart-row">
          <div><div class="cart-row-name">${this.escapeHtml(p.name)}</div><div class="cart-row-sub">${qty} × ${Number(p.price).toFixed(2)} TND</div></div>
          <div style="display:flex;align-items:center;gap:6px;">
            <button type="button" class="cart-qty-btn" data-id="${id}" data-delta="-1">−</button>
            <button type="button" class="cart-qty-btn" data-id="${id}" data-delta="1">+</button>
          </div>
        </div>`;
        }).join('');
        if (foot)
            foot.style.display = 'block';
        if (totalEl)
            totalEl.textContent = `${total.toFixed(2)} TND`;
        feed.querySelectorAll('.cart-qty-btn').forEach((btn) => {
            btn.addEventListener('click', () => this.changeCartQty(Number(btn.dataset.id), Number(btn.dataset.delta)));
        });
    }
    async checkoutCart() {
        if (this.cart.size === 0)
            return;
        const items = Array.from(this.cart.entries()).map(([product_id, quantity]) => ({ product_id, quantity }));
        try {
            await this.storeApi.checkout(items);
            this.cart.clear();
            this.renderCart();
            document.getElementById('cartPanel')?.classList.remove('open');
            showToast('Order placed — thank you!');
            await this.loadStore();
        }
        catch (err) {
            showToast(err?.error?.error || 'Checkout failed');
        }
    }
    async loadTrainers() {
        const widget = document.getElementById('trainerWidget');
        const page = document.getElementById('trainersGrid');
        try {
            const trainers = await this.classesApi.listTrainers();
            if (widget) {
                widget.innerHTML = trainers.length
                    ? trainers.slice(0, 3).map((t) => `
              <div class="trainer-row">
                <div class="trainer-avatar">${this.initials(t.name)}</div>
                <div><div class="trainer-name">${this.escapeHtml(t.name)}</div><div class="trainer-role">${this.escapeHtml(t.specialty || '')}</div></div>
              </div>`).join('')
                    : `<div class="trainer-row"><div class="trainer-role">No trainers found.</div></div>`;
            }
            if (page) {
                page.innerHTML = trainers.length
                    ? trainers.map((t) => `
              <div class="trainer-card">
                <div class="trainer-avatar">${this.initials(t.name)}</div>
                <div class="trainer-name">${this.escapeHtml(t.name)}</div>
                <div class="trainer-role">${this.escapeHtml(t.specialty || '')}</div>
                <div class="trainer-bio">${this.escapeHtml(t.bio || '')}</div>
                <button type="button" class="trainer-contact-btn" data-arg="${this.escapeHtml(t.name)}">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.7 2z"/></svg>
                  Contact
                </button>
              </div>`).join('')
                    : `<div class="trainer-role">No trainers found.</div>`;
                page.querySelectorAll('.trainer-contact-btn').forEach((btn) => {
                    btn.addEventListener('click', () => window['contactTrainer'](btn.dataset['arg']));
                });
            }
        }
        catch (err) {
            console.error('Erreur chargement entraineurs:', err);
            if (widget)
                widget.innerHTML = `<div class="trainer-row"><div class="trainer-role">Erreur de chargement.</div></div>`;
            if (page)
                page.innerHTML = `<div class="trainer-role">Erreur de chargement.</div>`;
        }
    }
    async loadPosters() {
        const feed = document.getElementById('posterFeed');
        if (!feed)
            return;
        try {
            const posters = await this.classesApi.listPosters();
            if (!posters.length) {
                feed.innerHTML = `<div class="poster-card"><div class="poster-meta">No announcements yet.</div></div>`;
                return;
            }
            feed.innerHTML = posters.map((p) => `
        <div class="poster-card">
          <div class="poster-head">
            <img class="poster-logo" src="assets/logo.svg" alt="EOS">
            <div>
              <div class="poster-user">${this.escapeHtml(p.username)}<svg class="poster-verified" viewBox="0 0 24 24" fill="none"><path d="M12 2L14.4 4.1L17.5 3.5L18.4 6.6L21.5 7.5L20.9 10.6L23 13L20.9 15.4L21.5 18.5L18.4 19.4L17.5 22.5L14.4 21.9L12 24L9.6 21.9L6.5 22.5L5.6 19.4L2.5 18.5L3.1 15.4L1 13L3.1 10.6L2.5 7.5L5.6 6.6L6.5 3.5L9.6 4.1L12 2Z" fill="currentColor" transform="translate(0,-1) scale(0.92) translate(1,1.2)"/><path d="M8.5 12.2L11 14.7L15.7 9.8" stroke="var(--charcoal)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
              ${p.location ? `<a class="poster-location" href="${this.escapeHtml(p.location)}" target="_blank" rel="noopener">Gym location</a>` : ''}
            </div>
          </div>
          <div class="poster-text">${this.escapeHtml(p.text)}</div>
          ${p.image_url ? `<img class="poster-image" src="${p.image_url}" alt="">` : ''}
        </div>`).join('');
        }
        catch (err) {
            console.error('Erreur chargement annonces:', err);
            feed.innerHTML = `<div class="poster-card"><div class="poster-meta">Erreur de chargement.</div></div>`;
        }
    }
    async loadNotifications() {
        const feed = document.getElementById('notifFeed');
        const bellFeed = document.getElementById('bellPanelFeed');
        const dot = document.getElementById('bellDot');
        try {
            const [ann, mine] = await Promise.all([
                this.classesApi.listNotifications().catch(() => []),
                this.classesApi.myNotifications().catch(() => []),
            ]);
            const items = [...mine, ...ann].sort((a, b) => +new Date(b.created_at || 0) - +new Date(a.created_at || 0));
            if (dot)
                dot.classList.toggle('active', mine.some((n) => !n.is_read));
            if (!items.length) {
                const empty = `<div class="notif-row"><div class="notif-text">No notifications.</div></div>`;
                if (feed)
                    feed.innerHTML = empty;
                if (bellFeed)
                    bellFeed.innerHTML = empty;
                return;
            }
            const rows = items.map((n) => {
                const thumb = n.image_url ? `<img class="notif-thumb" src="${n.image_url}" alt="">` : `<span class="notif-dot"></span>`;
                const text = n.description ?? n.message ?? '';
                const body = n.title ? `<b>${this.escapeHtml(n.title)}</b>${text ? ' — ' + this.escapeHtml(text) : ''}` : this.escapeHtml(text);
                const inner = `${thumb}<div class="notif-text">${body}</div>`;
                return n.link
                    ? `<a class="notif-row" href="${n.link}" target="_blank" rel="noopener">${inner}</a>`
                    : `<div class="notif-row">${inner}</div>`;
            }).join('');
            if (feed)
                feed.innerHTML = rows;
            if (bellFeed)
                bellFeed.innerHTML = rows;
        }
        catch (err) {
            console.error('Erreur chargement notifications:', err);
            const errHtml = `<div class="notif-row"><div class="notif-text">Erreur de chargement.</div></div>`;
            if (feed)
                feed.innerHTML = errHtml;
            if (bellFeed)
                bellFeed.innerHTML = errHtml;
        }
    }
    fmtTime(d) {
        return d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }
    async renderSchedulePills() {
        const pillsEl = document.getElementById('dayPills');
        if (!pillsEl)
            return;
        const self = this;
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const monday = new Date(today);
        monday.setDate(today.getDate() - ((today.getDay() + 6) % 7));
        const names = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        pillsEl.innerHTML = names.map((name, i) => {
            const d = new Date(monday);
            d.setDate(monday.getDate() + i);
            const selected = d.toDateString() === today.toDateString() ? ' selected' : '';
            const disabled = d < today ? ' disabled' : '';
            return `<div class="day-pill${selected}${disabled}" data-date="${d.toISOString()}"><div class="dname">${name}</div><div class="dnum">${d.getDate()}</div></div>`;
        }).join('');
        pillsEl.querySelectorAll('.day-pill').forEach((pill) => {
            pill.addEventListener('click', () => {
                if (pill.classList.contains('disabled'))
                    return;
                pillsEl.querySelectorAll('.day-pill').forEach((p) => p.classList.remove('selected'));
                pill.classList.add('selected');
                self.selectedScheduleDate = new Date(pill.dataset.date);
                self.loadScheduleForSelectedDate();
            });
        });
        await this.loadScheduleForSelectedDate();
    }
    static { this.CLASS_CATEGORIES = [
        'Pilates', 'Dance Orientale', 'Zumba', 'Dance Tunisienne', 'Body Attack',
        'Body Combat', 'Body Balance', 'Step', 'Lia', 'Yoga', 'Cardio Mix', 'CAF',
        'Abdo', 'Circuit Training', 'Zumba Kids', 'Cross Fit Kids', 'EMOM',
    ]; }
    renderCategoryFilters(classes) {
        const el = document.getElementById('categoryFilters');
        if (!el)
            return;
        if (this.categoryFiltersRendered)
            return;
        this.categoryFiltersRendered = true;
        const cats = DashboardComponent.CLASS_CATEGORIES;
        el.innerHTML = ['all', ...cats].map(cat => `<div class="chip ${cat === this.selectedCategory ? 'active' : ''}" data-category="${cat}">${cat === 'all' ? 'All' : cat}</div>`).join('');
        el.querySelectorAll('.chip').forEach((chip) => {
            chip.addEventListener('click', () => {
                this.selectedCategory = chip.dataset.category;
                el.querySelectorAll('.chip').forEach((c) => c.classList.remove('active'));
                chip.classList.add('active');
                this.renderScheduleGrid(this.lastScheduleClasses);
            });
        });
    }
    async loadScheduleForSelectedDate() {
        const grid = document.getElementById('scheduleClassGrid');
        if (!grid)
            return;
        grid.innerHTML = `<div class="class-card"><div class="class-info">Loading…</div></div>`;
        try {
            const start = new Date(this.selectedScheduleDate);
            start.setHours(0, 0, 0, 0);
            const end = new Date(this.selectedScheduleDate);
            end.setHours(23, 59, 59, 999);
            const [classes, bookings] = await Promise.all([
                this.classesApi.listClasses(start, end),
                this.classesApi.myBookings(),
            ]);
            this.myBookedClassIds = new Set(bookings.filter((b) => b.status === 'booked').map((b) => b.class_id));
            this.lastScheduleClasses = classes;
            this.renderCategoryFilters(classes);
            this.renderScheduleGrid(classes);
        }
        catch (err) {
            console.error('Erreur chargement planning:', err);
            grid.innerHTML = `<div class="class-card"><div class="class-info">Erreur de chargement.</div></div>`;
        }
    }
    renderScheduleGrid(allClasses) {
        const grid = document.getElementById('scheduleClassGrid');
        if (!grid)
            return;
        const classes = this.selectedCategory === 'all' ? allClasses : allClasses.filter((c) => c.category === this.selectedCategory);
        if (!classes.length) {
            grid.innerHTML = `<div class="class-card"><div class="class-info">No classes match this filter.</div></div>`;
            return;
        }
        grid.innerHTML = classes.map((c) => {
            const start = new Date(c.starts_at);
            const spotsClass = c.spots_left <= 3 ? 'low' : 'ok';
            const spotsText = c.spots_left <= 0 ? 'Full' : `${c.spots_left} spots left`;
            const isBooked = this.myBookedClassIds.has(c.id);
            const levelKey = this.levelKey(c.level);
            const levelBadge = levelKey ? `<span class="level-badge level-${levelKey}">${this.levelLabel(levelKey)}</span>` : '';
            const userKey = this.levelKey(this.realUserLevel);
            const locked = !!levelKey && this.levelRank(levelKey) > this.levelRank(userKey);
            const lockTitle = locked ? `title="Requires ${this.levelLabel(levelKey)} level"` : '';
            return `
          <div class="class-card">
            <div class="class-time-block"><div class="t1">${this.fmtTime(start)}</div><div class="t2">${start.toLocaleDateString('en-US', { weekday: 'short' })}</div></div>
            <div class="class-info">
              <div class="cname">${c.name}${levelBadge}</div>
              ${c.category ? `<span class="cat-badge">${c.category}</span>` : ''}
              <div class="cmeta">${c.trainer_name} · ${c.location || ''}</div>
              <div class="cbottom">
                <span class="cspots ${spotsClass}">${spotsText}</span>
                <button class="book-btn ${isBooked ? 'booked' : ''} ${locked ? 'locked' : ''}" data-class-id="${c.id}" data-booked="${isBooked}" ${lockTitle} ${isBooked || c.spots_left <= 0 || locked ? 'disabled' : ''}>
                  ${isBooked ? 'Booked ✓' : locked ? 'Locked' : 'Book'}
                </button>
              </div>
            </div>
          </div>`;
        }).join('');
        grid.querySelectorAll('.book-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (btn.disabled)
                    return;
                const c = this.lastScheduleClasses.find((x) => x.id === Number(btn.dataset['classId']));
                if (c)
                    this.openBookModal(btn, c);
            });
        });
    }
    levelKey(level) {
        const k = (level || '').toLowerCase();
        if (k.startsWith('init'))
            return 'initiation';
        if (k.startsWith('deb'))
            return 'debutant';
        if (k.startsWith('inter'))
            return 'intermediaire';
        if (k.startsWith('avan'))
            return 'avancee';
        if (k.startsWith('exp'))
            return 'expert';
        return '';
    }
    levelRank(key) {
        const order = { initiation: 1, debutant: 2, intermediaire: 3, avancee: 4, expert: 5 };
        return order[key] || 0;
    }
    levelLabel(key) {
        const labels = {
            initiation: 'Initiation', debutant: 'Débutant', intermediaire: 'Intermédiaire',
            avancee: 'Avancée', expert: 'Expert',
        };
        return labels[key] || '';
    }
    openBookModal(btn, c) {
        this.pendingBookBtn = btn;
        this.pendingBookClass = c;
        const start = new Date(c.starts_at);
        const nameEl = document.getElementById('bookModalName');
        const metaEl = document.getElementById('bookModalMeta');
        const spotsEl = document.getElementById('bookModalSpots');
        const statusEl = document.getElementById('bookModalStatus');
        const confirmBtn = document.getElementById('bookModalConfirm');
        if (nameEl)
            nameEl.textContent = c.name;
        if (metaEl)
            metaEl.textContent = `${this.fmtTime(start)} · ${c.trainer_name}${c.location ? ' · ' + c.location : ''}`;
        if (spotsEl) {
            spotsEl.textContent = c.spots_left <= 0 ? 'Full' : `${c.spots_left} spots left`;
            spotsEl.className = 'cspots ' + (c.spots_left <= 3 ? 'low' : 'ok');
        }
        if (statusEl) {
            statusEl.className = 'book-modal-status';
            statusEl.textContent = '';
        }
        if (confirmBtn)
            confirmBtn.removeAttribute('disabled');
        document.getElementById('bookModalBackdrop')?.classList.add('show');
    }
    closeBookModal() {
        document.getElementById('bookModalBackdrop')?.classList.remove('show');
        this.pendingBookBtn = null;
        this.pendingBookClass = null;
    }
    async confirmBookModal() {
        if (!this.pendingBookClass)
            return;
        const classId = this.pendingBookClass.id;
        const statusEl = document.getElementById('bookModalStatus');
        const confirmBtn = document.getElementById('bookModalConfirm');
        if (statusEl) {
            statusEl.className = 'book-modal-status loading';
            statusEl.textContent = 'Booking your spot…';
        }
        if (confirmBtn)
            confirmBtn.setAttribute('disabled', 'true');
        try {
            await this.classesApi.book(classId);
            if (statusEl) {
                statusEl.className = 'book-modal-status success';
                statusEl.textContent = 'Spot confirmed ✓';
            }
            await this.loadScheduleForSelectedDate();
            await this.loadTodaysClasses();
            await this.loadMembershipAndTodaysClasses();
            setTimeout(() => this.closeBookModal(), 900);
        }
        catch (err) {
            if (statusEl) {
                statusEl.className = 'book-modal-status error';
                statusEl.textContent = err?.error?.error || 'Booking failed. Please try again.';
            }
            if (confirmBtn)
                confirmBtn.removeAttribute('disabled');
        }
    }
    async onBookClick(btn) {
        const classId = Number(btn.dataset['classId']);
        const isBooked = btn.dataset['booked'] === 'true';
        btn.setAttribute('disabled', 'true');
        try {
            if (isBooked) {
                await this.classesApi.cancelBooking(classId);
            }
            else {
                await this.classesApi.book(classId);
            }
            await this.loadScheduleForSelectedDate();
            await this.loadTodaysClasses();
            await this.loadMembershipAndTodaysClasses();
        }
        catch (err) {
            alert(err?.error?.error || 'Erreur lors de la réservation');
            btn.removeAttribute('disabled');
        }
    }
    ngAfterViewInit() {
        const self = this;
        this.loadRealUser();
        const toastEl = document.getElementById('toast');
        const toastMsgEl = document.getElementById('toastMsg');
        let toastTimer = null;
        function showToast(msg) {
            clearTimeout(toastTimer);
            toastMsgEl.textContent = msg;
            toastEl.classList.add('show');
            toastTimer = setTimeout(() => toastEl.classList.remove('show'), 2400);
        }
        const ADMIN_WHATSAPP = '21671234567';
        function contactTrainer(trainerName) {
            const phoneField = document.querySelector('#page-editprofile input[type="tel"]');
            const userPhone = (phoneField && phoneField.value.trim()) || '+216 22 345 678';
            const message = `Hello EOS Administration, I would like to get in touch with trainer ${trainerName}. Please have them contact me. My phone number: ${userPhone}.`;
            window.open(`https://wa.me/${ADMIN_WHATSAPP}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
        }
        const WEIGHT_KEY = 'eos_weight_log';
        function loadWeights() {
            let log;
            try {
                log = JSON.parse(localStorage.getItem(WEIGHT_KEY));
            }
            catch (e) {
                log = null;
            }
            if (!Array.isArray(log) || !log.length) {
                const today = new Date();
                log = [-21, -14, -7, -3, 0].map(offset => {
                    const d = new Date(today);
                    d.setDate(d.getDate() + offset);
                    return { date: d.toISOString().slice(0, 10), weight: [76.4, 75.8, 75.1, 74.6, 74.2][[-21, -14, -7, -3, 0].indexOf(offset)] };
                });
                localStorage.setItem(WEIGHT_KEY, JSON.stringify(log));
            }
            return log.sort((a, b) => a.date.localeCompare(b.date));
        }
        function saveWeights(log) { localStorage.setItem(WEIGHT_KEY, JSON.stringify(log)); }
        const DIET_KEY = 'eos_diet_plan';
        function loadDiet() {
            try {
                return JSON.parse(localStorage.getItem(DIET_KEY));
            }
            catch (e) {
                return null;
            }
        }
        function saveDiet(plan) { localStorage.setItem(DIET_KEY, JSON.stringify(plan)); }
        const GOAL_LABEL = { cut: 'Cut', maintain: 'Maintain', bulk: 'Bulk' };
        const GOAL_NOTE = {
            cut: 'A moderate deficit to lose fat while keeping protein high to protect muscle.',
            maintain: 'Calories matched to your output — hold steady, recomp, or just fuel training.',
            bulk: 'A moderate surplus to support muscle growth without piling on excess fat.'
        };
        function calcDietPlan({ goal, sex, age, height, weight, activity }) {
            const bmr = sex === 'female'
                ? (10 * weight) + (6.25 * height) - (5 * age) - 161
                : (10 * weight) + (6.25 * height) - (5 * age) + 5;
            const tdee = bmr * activity;
            const calMult = { cut: 0.8, maintain: 1, bulk: 1.15 }[goal];
            const calories = Math.round(tdee * calMult);
            const proteinPerKg = { cut: 2.2, maintain: 2.0, bulk: 1.8 }[goal];
            const protein = Math.round(weight * proteinPerKg);
            const fat = Math.round((calories * 0.25) / 9);
            const carbsCals = calories - (protein * 4) - (fat * 9);
            const carbs = Math.round(Math.max(carbsCals, 0) / 4);
            return { goal, sex, age, height, weight, activity, bmr: Math.round(bmr), tdee: Math.round(tdee), calories, protein, carbs, fat };
        }
        function macroBarPct(grams, kcalPerG, totalCal) {
            return Math.min(100, Math.round((grams * kcalPerG / totalCal) * 100));
        }
        function renderDietResults(plan) {
            const box = document.getElementById('dietResults');
            if (!box)
                return;
            if (!plan) {
                box.innerHTML = '<div class="diet-empty">Fill in your details and hit calculate to get your daily calorie and macro targets.</div>';
                return;
            }
            box.innerHTML = `
          <div class="diet-cal-hero">
            <div class="num">${plan.calories.toLocaleString()}</div>
            <div class="lbl">Calories / day &middot; ${GOAL_LABEL[plan.goal]}</div>
            <div class="sub">${GOAL_NOTE[plan.goal]}</div>
          </div>
          <div class="macro-row">
            <div class="mr-top"><b>Protein</b><span>${plan.protein} g</span></div>
            <div class="macro-track"><div class="macro-fill protein" style="width:${macroBarPct(plan.protein, 4, plan.calories)}%"></div></div>
          </div>
          <div class="macro-row">
            <div class="mr-top"><b>Carbs</b><span>${plan.carbs} g</span></div>
            <div class="macro-track"><div class="macro-fill carbs" style="width:${macroBarPct(plan.carbs, 4, plan.calories)}%"></div></div>
          </div>
          <div class="macro-row">
            <div class="mr-top"><b>Fats</b><span>${plan.fat} g</span></div>
            <div class="macro-track"><div class="macro-fill fats" style="width:${macroBarPct(plan.fat, 9, plan.calories)}%"></div></div>
          </div>
          <div class="coach-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 4 6v6c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V6l-8-4z"/><path d="m9 12 2 2 4-4"/></svg>
            BMR ${plan.bmr.toLocaleString()} kcal &middot; TDEE ${plan.tdee.toLocaleString()} kcal
          </div>`;
        }
        function renderDietSummaryWidget() {
            const el = document.getElementById('dietSummaryWidget');
            if (!el)
                return;
            const plan = loadDiet();
            if (!plan) {
                el.innerHTML = `<div>
              <div class="dsw-goal">Diet plan</div>
              <div class="dsw-cal">Not set up yet</div>
            </div>
            <span class="dsw-link" onclick="goTo('page-diet')">Set your goal &amp; macros &rarr;</span>`;
                return;
            }
            el.innerHTML = `<div>
            <div class="dsw-goal">${GOAL_LABEL[plan.goal]} target</div>
            <div class="dsw-cal">${plan.calories.toLocaleString()} kcal / day</div>
          </div>
          <div class="dsw-macros">
            <span><b>${plan.protein}g</b> protein</span>
            <span><b>${plan.carbs}g</b> carbs</span>
            <span><b>${plan.fat}g</b> fat</span>
          </div>
          <span class="dsw-link" onclick="goTo('page-diet')">Adjust &rarr;</span>`;
        }
        const MEAL_SPLIT = [
            { name: 'Breakfast', pct: 0.25 },
            { name: 'Lunch', pct: 0.30 },
            { name: 'Dinner', pct: 0.30 },
            { name: 'Snack', pct: 0.15 }
        ];
        const FOOD_POOLS = {
            Breakfast: [
                'Greek yogurt, oats & berries',
                'Egg whites, whole eggs & avocado toast',
                'Protein oatmeal with banana & peanut butter',
                'Omelette with spinach, feta & whole-grain toast'
            ],
            Lunch: [
                'Grilled chicken, rice & steamed veg',
                'Tuna salad with quinoa & olive oil',
                'Turkey wrap with hummus & greens',
                'Beef & vegetable stir-fry with rice'
            ],
            Dinner: [
                'Salmon, sweet potato & asparagus',
                'Lean beef, couscous & roasted veg',
                'Grilled chicken breast, pasta & salad',
                'Baked cod, brown rice & broccoli'
            ],
            Snack: [
                'Protein shake & almonds',
                'Cottage cheese & fruit',
                'Rice cakes with peanut butter',
                'Greek yogurt with honey'
            ]
        };
        function renderMealPlan(shuffle) {
            const grid = document.getElementById('mealPlanGrid');
            if (!grid)
                return;
            const plan = loadDiet();
            if (!plan) {
                grid.innerHTML = '<div class="diet-empty" style="grid-column:1/-1;">Set up your diet goal on the Diet page to generate a daily meal plan.</div>';
                return;
            }
            if (shuffle || !window._mealPicks) {
                window._mealPicks = MEAL_SPLIT.map(m => Math.floor(Math.random() * FOOD_POOLS[m.name].length));
            }
            grid.innerHTML = MEAL_SPLIT.map((m, i) => {
                const cal = Math.round(plan.calories * m.pct);
                const protein = Math.round(plan.protein * m.pct);
                const carbs = Math.round(plan.carbs * m.pct);
                const fat = Math.round(plan.fat * m.pct);
                const food = FOOD_POOLS[m.name][window._mealPicks[i]];
                return `<div class="meal-card">
              <div class="mc-name">${m.name}<span>${Math.round(m.pct * 100)}%</span></div>
              <div class="mc-cal">${cal} kcal</div>
              <div class="mc-food">${food}</div>
              <div class="mc-macros"><span><b>${protein}g</b> P</span><span><b>${carbs}g</b> C</span><span><b>${fat}g</b> F</span></div>
            </div>`;
            }).join('');
        }
        const goalPills = document.getElementById('goalPills');
        let selectedGoal = 'maintain';
        if (goalPills) {
            goalPills.querySelectorAll('.goal-pill').forEach(p => {
                p.classList.toggle('selected', p.dataset.goal === selectedGoal);
                p.addEventListener('click', () => {
                    selectedGoal = p.dataset.goal;
                    goalPills.querySelectorAll('.goal-pill').forEach(x => x.classList.toggle('selected', x === p));
                });
            });
        }
        const dietForm = document.getElementById('dietForm');
        if (dietForm) {
            const existing = loadDiet();
            if (existing) {
                selectedGoal = existing.goal;
                goalPills.querySelectorAll('.goal-pill').forEach(p => p.classList.toggle('selected', p.dataset.goal === selectedGoal));
                document.getElementById('dietSex').value = existing.sex;
                document.getElementById('dietAge').value = existing.age;
                document.getElementById('dietHeight').value = existing.height;
                document.getElementById('dietWeight').value = existing.weight;
                document.getElementById('dietActivity').value = existing.activity;
                renderDietResults(existing);
            }
            dietForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const plan = calcDietPlan({
                    goal: selectedGoal,
                    sex: document.getElementById('dietSex').value,
                    age: parseFloat(document.getElementById('dietAge').value),
                    height: parseFloat(document.getElementById('dietHeight').value),
                    weight: parseFloat(document.getElementById('dietWeight').value),
                    activity: parseFloat(document.getElementById('dietActivity').value)
                });
                if (!plan.age || !plan.height || !plan.weight)
                    return;
                saveDiet(plan);
                renderDietResults(plan);
                showToast('Macro targets updated — synced to Progress');
            });
        }
        function renderWeightStats(log) {
            const wrap = document.getElementById('weightStats');
            if (!wrap)
                return;
            if (log.length < 1) {
                wrap.innerHTML = '';
                return;
            }
            const first = log[0].weight, last = log[log.length - 1].weight;
            const change = last - first;
            const avg7 = log.slice(-7).reduce((s, e) => s + e.weight, 0) / Math.min(log.length, 7);
            wrap.innerHTML = `
          <div class="weight-stat"><div class="num">${last.toFixed(1)} kg</div><div class="lbl">Current</div></div>
          <div class="weight-stat"><div class="num">${change <= 0 ? '' : '+'}${change.toFixed(1)} kg</div><div class="lbl">Since start</div></div>
          <div class="weight-stat"><div class="num">${avg7.toFixed(1)} kg</div><div class="lbl">7-entry avg</div></div>
          <div class="weight-stat"><div class="num">${log.length}</div><div class="lbl">Logged entries</div></div>`;
        }
        function renderWeightChart(log) {
            const svg = document.getElementById('weightChart');
            if (!svg)
                return;
            if (log.length < 2) {
                svg.innerHTML = `<foreignObject x="0" y="0" width="600" height="240"><div class="chart-empty" xmlns="http://www.w3.org/1999/xhtml">Log at least two weigh-ins to see your trend.</div></foreignObject>`;
                return;
            }
            const W = 600, H = 240, padL = 40, padR = 12, padT = 16, padB = 26;
            const weights = log.map(e => e.weight);
            let min = Math.min(...weights), max = Math.max(...weights);
            if (min === max) {
                min -= 1;
                max += 1;
            }
            const pad = (max - min) * 0.15;
            min -= pad;
            max += pad;
            const dayMs = 86400000;
            const toDay = d => Math.round(new Date(d + 'T00:00:00').getTime() / dayMs);
            const day0 = toDay(log[0].date);
            const totalDays = Math.max(toDay(log[log.length - 1].date) - day0, 1);
            const x = i => padL + ((toDay(log[i].date) - day0) / totalDays) * (W - padL - padR);
            const y = w => padT + (1 - (w - min) / (max - min)) * (H - padT - padB);
            const points = log.map((e, i) => `${x(i)},${y(e.weight)}`).join(' ');
            const gridLines = [0, 0.5, 1].map(t => {
                const gy = padT + t * (H - padT - padB);
                const val = (max - t * (max - min)).toFixed(1);
                return `<line x1="${padL}" y1="${gy}" x2="${W - padR}" y2="${gy}" stroke="rgba(245,244,240,0.08)" stroke-width="1"/>
                  <text x="4" y="${gy + 4}" font-size="10" fill="#9a988d" font-family="Poppins">${val}</text>`;
            }).join('');
            const dots = log.map((e, i) => `<circle cx="${x(i)}" cy="${y(e.weight)}" r="3.5" fill="#c9a227"/>`).join('');
            const areaPoints = `${padL},${H - padB} ${points} ${W - padR},${H - padB}`;
            svg.innerHTML = `
          <defs>
            <linearGradient id="wgGrad" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#c9a227" stop-opacity="0.35"/>
              <stop offset="100%" stop-color="#c9a227" stop-opacity="0"/>
            </linearGradient>
          </defs>
          ${gridLines}
          <polygon points="${areaPoints}" fill="url(#wgGrad)"/>
          <polyline points="${points}" fill="none" stroke="#c9a227" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
          ${dots}
          <text x="${padL}" y="${H - 6}" font-size="10" fill="#9a988d" font-family="Poppins">${log[0].date.slice(5)}</text>
          <text x="${W - padR}" y="${H - 6}" text-anchor="end" font-size="10" fill="#9a988d" font-family="Poppins">${log[log.length - 1].date.slice(5)}</text>`;
        }
        function renderWeightLogList(log) {
            const list = document.getElementById('weightLogList');
            if (!list)
                return;
            list.innerHTML = [...log].reverse().map(e => `<div class="weight-log-row"><span class="d">${e.date}</span><span class="w">${e.weight.toFixed(1)} kg</span></div>`).join('');
        }
        function renderProgressPage() {
            const log = loadWeights();
            renderDietSummaryWidget();
            renderWeightStats(log);
            renderWeightChart(log);
            renderWeightLogList(log);
            renderMealPlan(false);
        }
        const weightForm = document.getElementById('weightForm');
        if (weightForm) {
            const dateInput = document.getElementById('weightDate');
            if (dateInput)
                dateInput.value = new Date().toISOString().slice(0, 10);
            weightForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const date = document.getElementById('weightDate').value;
                const weight = parseFloat(document.getElementById('weightValue').value);
                if (!date || !weight)
                    return;
                let log = loadWeights().filter(entry => entry.date !== date);
                log.push({ date, weight });
                log.sort((a, b) => a.date.localeCompare(b.date));
                saveWeights(log);
                document.getElementById('weightValue').value = '';
                renderProgressPage();
                showToast('Weight logged — synced to your coach');
            });
        }
        const pages = document.querySelectorAll('.page');
        const sbLinks = document.querySelectorAll('.sb-link');
        const eyebrowMap = {
            'page-home': 'Good morning', 'page-schedule': 'Class schedule',
            'page-plans': 'Membership', 'page-profile': 'Account',
            'page-editprofile': 'Account', 'page-payment': 'Account',
            'page-bookinghistory': 'Account', 'page-notifications': 'Account', 'page-help': 'Account',
            'page-terms': 'Help & Support', 'page-privacy': 'Help & Support', 'page-cookies': 'Help & Support',
            'page-trainers': 'Home', 'page-progress': 'Home', 'page-diet': 'Home', 'page-store': 'Home', 'page-store-search': 'page-store'
        };
        const nameMap = {
            'page-home': 'Sarah Aziz', 'page-schedule': 'This Week',
            'page-plans': 'Choose Your Plan', 'page-profile': 'Profile & Settings',
            'page-editprofile': 'Edit Profile', 'page-payment': 'Payment Methods',
            'page-bookinghistory': 'Booking History', 'page-notifications': 'Notifications', 'page-help': 'Help & Support',
            'page-terms': 'Terms of Service', 'page-privacy': 'Privacy Policy', 'page-cookies': 'Cookie Policy',
            'page-trainers': 'Our Trainers', 'page-progress': 'Weight Progress', 'page-diet': 'Diet & Macros', 'page-store': 'Store', 'page-store-search': 'Search products'
        };
        window.goTo = function (target) {
            document.getElementById('mtMorePanel')?.classList.remove('show');
            document.querySelector('.mt-center')?.classList.remove('open');
            pages.forEach(p => p.classList.remove('active'));
            document.getElementById(target).classList.add('active');
            sbLinks.forEach(l => l.classList.toggle('active', l.dataset.target === target));
            document.querySelectorAll('.mt-item').forEach(m => m.classList.toggle('active', m.dataset.arg === target));
            document.getElementById('tbEyebrow').textContent = eyebrowMap[target] || '';
            document.getElementById('tbName').textContent = (target === 'page-home' && self.realUserName) ? self.realUserName : (nameMap[target] || '');
            if (target === 'page-progress')
                renderProgressPage();
            if (target === 'page-diet')
                renderDietResults(loadDiet());
            window.scrollTo({ top: 0, behavior: 'instant' });
        };
        sbLinks.forEach(l => l.addEventListener('click', () => { goTo(l.dataset.target); closeSidebar(); }));
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        function openSidebar() { document.body.classList.add('sidebar-open'); }
        function closeSidebar() { document.body.classList.remove('sidebar-open'); }
        window.toggleSidebar = function () { document.body.classList.toggle('sidebar-open'); };
        window.toggleMoreMenu = function (_arg, el) {
            const panel = document.getElementById('mtMorePanel');
            if (!panel)
                return;
            panel.classList.toggle('show');
            el?.classList.toggle('open');
        };
        document.addEventListener('click', (e) => {
            const panel = document.getElementById('mtMorePanel');
            const center = document.querySelector('.mt-center');
            if (panel?.classList.contains('show') && !panel.contains(e.target) && !center?.contains(e.target)) {
                panel.classList.remove('show');
                center?.classList.remove('open');
            }
        });
        if (sidebarBackdrop)
            sidebarBackdrop.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape')
            closeSidebar(); });
        window.addEventListener('resize', () => { if (window.innerWidth > 880)
            closeSidebar(); });
        const bellBtn = document.getElementById('bellBtn');
        const bellPanel = document.getElementById('bellPanel');
        const bellDot = document.getElementById('bellDot');
        bellBtn.addEventListener('click', e => {
            e.stopPropagation();
            bellPanel.classList.toggle('open');
            if (bellPanel.classList.contains('open') && bellDot) {
                bellDot.classList.remove('active');
                this.classesApi.markNotificationsRead().catch(() => { });
            }
        });
        document.addEventListener('click', e => {
            if (!bellBtn.contains(e.target))
                bellPanel.classList.remove('open');
        });
        const cartBtn = document.getElementById('cartBtn');
        const cartPanel = document.getElementById('cartPanel');
        if (cartBtn && cartPanel) {
            cartBtn.addEventListener('click', e => { e.stopPropagation(); cartPanel.classList.toggle('open'); });
            document.addEventListener('click', e => { if (!cartBtn.contains(e.target))
                cartPanel.classList.remove('open'); });
        }
        document.getElementById('cartCheckoutBtn')?.addEventListener('click', () => this.checkoutCart());
        const storeFilters = document.getElementById('storeFilters');
        if (storeFilters) {
            storeFilters.addEventListener('click', e => {
                const chip = e.target.closest('.chip');
                if (!chip)
                    return;
                storeFilters.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                this.loadStore(chip.dataset['filter'] || 'all');
            });
        }
        document.getElementById('storeSort')?.addEventListener('change', e => { this.storeSort = e.target.value; if (this.storeSort === 'random')
            this.storeOrder = []; this.loadStore(this.storeCategory); });
        const setView = (list) => {
            document.getElementById('storeGrid')?.classList.toggle('list', list);
            document.getElementById('storeViewList')?.classList.toggle('on', list);
            document.getElementById('storeViewGrid')?.classList.toggle('on', !list);
        };
        document.getElementById('storeViewList')?.addEventListener('click', () => setView(true));
        document.getElementById('storeViewGrid')?.addEventListener('click', () => setView(false));
        document.getElementById('page-store')?.addEventListener('click', e => {
            const b = e.target.closest('.store-pager button');
            if (!b)
                return;
            this.storePage = Number(b.dataset['p']);
            this.loadStore(this.storeCategory);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        const storeSearchInput = document.getElementById('storeSearchInput');
        if (storeSearchInput) {
            storeSearchInput.addEventListener('input', () => {
                this.storeSearch = storeSearchInput.value.trim();
                this.loadStore(this.storeCategory);
            });
        }
        document.getElementById('storeSearchGo')?.addEventListener('click', () => this.openStoreSearch(storeSearchInput?.value || ''));
        const storeResultsSearchInput = document.getElementById('storeResultsSearchInput');
        if (storeResultsSearchInput) {
            storeResultsSearchInput.addEventListener('input', () => this.renderStoreMasonry(storeResultsSearchInput.value));
        }
        document.querySelectorAll('.day-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                document.querySelectorAll('.day-pill').forEach(p => p.classList.remove('selected'));
                pill.classList.add('selected');
            });
        });
        document.querySelectorAll('.filter-chips .chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.filter-chips .chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
            });
        });
        function switchAppPlan(tab, btn) {
            document.querySelectorAll('.plans-tab').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            document.querySelectorAll('.plans-panel').forEach(p => p.classList.remove('is-active'));
            document.getElementById('app-panel-' + tab).classList.add('is-active');
        }
        const bookModalBackdrop = document.getElementById('bookModalBackdrop');
        document.getElementById('bookModalCancel')?.addEventListener('click', () => this.closeBookModal());
        bookModalBackdrop?.addEventListener('click', (e) => { if (e.target === bookModalBackdrop)
            this.closeBookModal(); });
        document.getElementById('bookModalConfirm')?.addEventListener('click', () => this.confirmBookModal());
        const epPhotoInput = document.getElementById('epPhotoInput');
        if (epPhotoInput) {
            epPhotoInput.addEventListener('change', () => {
                const file = epPhotoInput.files[0];
                if (!file)
                    return;
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('epAvatarPreview').style.cssText = `background:url(${e.target.result}) center/cover; color:transparent;`;
                };
                reader.readAsDataURL(file);
            });
        }
        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const name = document.getElementById('epName')?.value?.trim();
                const email = document.getElementById('epEmail')?.value?.trim();
                const fileInput = document.getElementById('epPhotoInput');
                const avatarFile = fileInput?.files?.[0];
                try {
                    const user = await this.auth.updateProfile(name, email, avatarFile);
                    this.applyUserToDom(user);
                    showToast('Profile updated');
                    goTo('page-profile');
                }
                catch (err) {
                    showToast(err?.error?.error || 'Erreur lors de la mise à jour');
                }
            });
        }
        const bhFilters = document.getElementById('bhFilters');
        if (bhFilters) {
            bhFilters.addEventListener('click', e => {
                const chip = e.target.closest('.chip');
                if (!chip)
                    return;
                bhFilters.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                const filter = chip.dataset.filter;
                document.querySelectorAll('#bhList .bh-row').forEach(row => {
                    row.style.display = (filter === 'all' || row.dataset.status === filter) ? 'flex' : 'none';
                });
            });
        }
        document.getElementById('logoutMenuItem').addEventListener('click', async () => {
            await this.auth.logout();
            this.router.navigate(['/login']);
        });
        document.getElementById('sbLogout').addEventListener('click', () => { goTo('page-profile'); closeSidebar(); });
        // expose functions referenced by data-action bindings in the template
        window['goTo'] = goTo;
        window['contactTrainer'] = contactTrainer;
        window['renderMealPlan'] = renderMealPlan;
        window['switchAppPlan'] = switchAppPlan;
    }
}

boot(DashboardComponent, [AuthService, Router, ClassesService, StoreService]);
