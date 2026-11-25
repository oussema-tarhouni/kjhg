<div class="page-root">
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><filter id="eos-logo-light" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="2.1641 0.3112 -2.4753 0 0  1.1641 1.3112 -2.4753 0 0  1.1641 0.3112 -1.4753 0 0  0 0 0 1 0"/></filter></svg>

<div class="bg-fixed"></div>

<div class="app-shell">

  <div class="sidebar" id="sidebar">
    <a class="sb-brand" href="<?= url('') ?>">
      <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="35" style="display:block;">
    </a>

    <div class="sb-nav" id="sbNav">
      <div class="sb-link active" data-target="page-home">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 11L12 4L20 11V19C20 19.6 19.6 20 19 20H15V14H9V20H5C4.4 20 4 19.6 4 19V11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
        Home
      </div>
      <div class="sb-link" data-target="page-schedule">
        <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 3V7M16 3V7M4 10H20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        Schedule
      </div>
      <div class="sb-link" data-target="page-store">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 8L5.5 4H18.5L20 8" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M4 8H20V19C20 19.6 19.6 20 19 20H5C4.4 20 4 19.6 4 19V8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12C9 13.7 10.3 15 12 15C13.7 15 15 13.7 15 12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        Store
      </div>
      <div class="sb-link" data-target="page-diet">
        <svg viewBox="0 0 24 24" fill="none"><path d="M12 8C9 8 6.5 10.7 6.5 14.5C6.5 18 8.5 21 12 21C15.5 21 17.5 18 17.5 14.5C17.5 10.7 15 8 12 8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M12 8C12 6 13 4.5 15 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        Diet
      </div>
      <div class="sb-link" data-target="page-progress">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19H20M8 15L11 11L14 13L19 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Progress
      </div>
      <div class="sb-link" data-target="page-trainers">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.7"/><path d="M3 20C3 16.7 5.7 14 9 14C12.3 14 15 16.7 15 20M16 8.5C17.2 8.5 18.2 7.5 18.2 6.2C18.2 5 17.2 4 16 4M17 14.2C19.4 14.6 21 16.3 21 19" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Trainers
      </div>
      <div class="sb-link" data-target="page-profile">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.7"/><path d="M5 20C5 16.3 8.1 13.5 12 13.5C15.9 13.5 19 16.3 19 20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        Profile
      </div>
    </div>

    <div class="sb-foot" id="sbLogout">
      <div class="sb-avatar" id="sbAvatar">SA</div>
      <div class="sb-foot-info">
        <div class="sb-foot-name" id="sbFootName">Sarah Aziz</div>
        <div class="sb-foot-tier">Gold Member</div>
      </div>
    </div>
  </div>

  <nav class="mobile-tabbar" id="mobileTabbar">
    <div class="mt-item active" data-action="goTo" data-arg="page-home" onclick="__page.__run(event)">
      <svg viewBox="0 0 24 24" fill="none"><path d="M4 11L12 4L20 11V19C20 19.6 19.6 20 19 20H15V14H9V20H5C4.4 20 4 19.6 4 19V11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
      <span>Home</span>
    </div>
    <div class="mt-item" data-action="goTo" data-arg="page-schedule" onclick="__page.__run(event)">
      <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 3V7M16 3V7M4 10H20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
      <span>Schedule</span>
    </div>

    <div class="mt-center" data-action="toggleMoreMenu" onclick="__page.__run(event)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
    </div>

    <div class="mt-item" data-action="goTo" data-arg="page-progress" onclick="__page.__run(event)">
      <svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19H20M8 15L11 11L14 13L19 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <span>Progress</span>
    </div>
    <div class="mt-item" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)">
      <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.7"/><path d="M5 20C5 16.3 8.1 13.5 12 13.5C15.9 13.5 19 16.3 19 20" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
      <span>Profile</span>
    </div>

    <div class="mt-more-panel" id="mtMorePanel">
      <div class="mt-more-item" data-action="goTo" data-arg="page-plans" onclick="__page.__run(event)">
        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10H21" stroke="currentColor" stroke-width="1.7"/></svg>
        Plans
      </div>
      <div class="mt-more-item" data-action="goTo" data-arg="page-diet" onclick="__page.__run(event)">
        <svg viewBox="0 0 24 24" fill="none"><path d="M12 8C9 8 6.5 10.7 6.5 14.5C6.5 18 8.5 21 12 21C15.5 21 17.5 18 17.5 14.5C17.5 10.7 15 8 12 8Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M12 8C12 6 13 4.5 15 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        Diet
      </div>
      <div class="mt-more-item" data-action="goTo" data-arg="page-trainers" onclick="__page.__run(event)">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.7"/><path d="M3 20C3 16.7 5.7 14 9 14C12.3 14 15 16.7 15 20M16 8.5C17.2 8.5 18.2 7.5 18.2 6.2C18.2 5 17.2 4 16 4M17 14.2C19.4 14.6 21 16.3 21 19" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Trainers
      </div>
    </div>
  </nav>

  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <div class="book-modal-backdrop" id="bookModalBackdrop">
    <div class="book-modal">
      <div class="book-modal-title">Confirm your booking</div>
      <div class="book-modal-sub">You're about to reserve a spot in this class.</div>
      <div class="book-modal-info">
        <div class="cname" id="bookModalName"></div>
        <div class="cmeta" id="bookModalMeta"></div>
        <div class="cspots" id="bookModalSpots"></div>
      </div>
      <div class="book-modal-status" id="bookModalStatus"></div>
      <div class="book-modal-actions">
        <button type="button" class="book-modal-cancel" id="bookModalCancel">Cancel</button>
        <button type="button" class="book-modal-confirm" id="bookModalConfirm">Confirm Spot</button>
      </div>
    </div>
  </div>

  <div class="mobile-topbar">
    <a class="mt-brand" href="<?= url('') ?>">
      <img src="<?= BASE ?>/assets/logo.svg" alt="">
    </a>
  </div>

  <div class="main">

    <div class="topbar">
      <div class="tb-title">
        <div class="tb-eyebrow" id="tbEyebrow">Good morning</div>
        <div class="tb-name" id="tbName">Sarah Aziz</div>
      </div>
      <div class="tb-right">
        <div class="tb-search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21L16.65 16.65" stroke-linecap="round"/></svg>
          <input type="text" placeholder="Search classes, trainers...">
        </div>
        <div class="bell" id="cartBtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 5H6L7.5 15.5C7.6 16.3 8.3 17 9.1 17H18C18.8 17 19.5 16.4 19.6 15.6L21 8H6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9.5" cy="20.5" r="1.4" fill="currentColor"/><circle cx="17.5" cy="20.5" r="1.4" fill="currentColor"/></svg>
          <div class="dot" id="cartDot"></div>
          <div class="bell-panel" id="cartPanel">
            <div class="bell-panel-title">Your Cart</div>
            <div id="cartPanelFeed"><div class="notif-row"><div class="notif-text">Your cart is empty.</div></div></div>
            <div class="cart-panel-foot" id="cartPanelFoot" style="display:none;">
              <div class="cart-total-row"><span>Total</span><span id="cartPanelTotal">0 TND</span></div>
              <button type="button" class="form-save" id="cartCheckoutBtn">Checkout</button>
            </div>
          </div>
        </div>
        <div class="bell" id="bellBtn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 3C9.5 3 7.5 5 7.5 7.5V11L5.5 14.5H18.5L16.5 11V7.5C16.5 5 14.5 3 12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9.5 17.5C9.5 18.9 10.6 20 12 20C13.4 20 14.5 18.9 14.5 17.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg><div class="dot" id="bellDot"></div>
          <div class="bell-panel" id="bellPanel">
            <div class="bell-panel-title">Notifications</div>
            <div id="bellPanelFeed"><div class="notif-row"><div class="notif-text">Loading…</div></div></div>
          </div>
        </div>
      </div>
    </div>

    <div class="content">

      <div class="page active" id="page-home">
        <div class="home-grid">

          <div class="home-col-top">
            <div class="membership-card">
              <div class="mc-top">
                <div>
                  <div class="mc-tier" id="mcTier">MEMBERSHIP</div>
                  <div class="mc-sub" id="mcSub">Member since — · Auto-renew enabled</div>
                </div>
                <div class="mc-status" id="mcStatus">Active</div>
              </div>
              <div class="mc-bottom">
                <div class="mc-progress">
                  <div class="mc-progress-label"><span>Classes used this month</span><b id="mcQuota">— / —</b></div>
                  <div class="progress-track"><div class="progress-fill" id="mcProgressFill" style="width:0%"></div></div>
                </div>
                <div class="mc-renew">Renews on<b id="mcRenewDate">—</b></div>
              </div>
            </div>

            <div class="quick-actions">
              <div class="qa-item" data-action="goTo" data-arg="page-schedule" onclick="__page.__run(event)">
                <div class="qa-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M8 3V6M16 3V6M4 9H20M6 5H18C19.1 5 20 5.9 20 7V19C20 20.1 19.1 21 18 21H6C4.9 21 4 20.1 4 19V7C4 5.9 4.9 5 6 5Z" stroke="#e6cc7a" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                <div class="qa-label">Book Class</div>
              </div>
              <div class="qa-item" data-action="goTo" data-arg="page-diet" onclick="__page.__run(event)">
                <div class="qa-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M12 8C9 8 6.5 10.7 6.5 14.5C6.5 18 8.5 21 12 21C15.5 21 17.5 18 17.5 14.5C17.5 10.7 15 8 12 8Z" stroke="#8fc25f" stroke-width="1.6" stroke-linejoin="round"/><path d="M12 8C12 6 13 4.5 15 4" stroke="#8fc25f" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                <div class="qa-label">Diet</div>
              </div>
              <div class="qa-item" data-action="goTo" data-arg="page-progress" onclick="__page.__run(event)">
                <div class="qa-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20V14M9 20V9M14 20V13M19 20V4" stroke="#e6cc7a" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                <div class="qa-label">Progress</div>
              </div>
              <div class="qa-item" data-action="goTo" data-arg="page-trainers" onclick="__page.__run(event)">
                <div class="qa-icon"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.2" stroke="#8fc25f" stroke-width="1.6"/><path d="M5 20C5 16.5 8.1 14 12 14C15.9 14 19 16.5 19 20" stroke="#8fc25f" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                <div class="qa-label">Trainers</div>
              </div>
            </div>
          </div>

          <div class="side-col">
            <div class="section-title">TODAY'S CLASSES</div>
            <div class="section-link" data-action="goTo" data-arg="page-schedule" onclick="__page.__run(event)">See all</div>
            <div class="hclass-grid" id="hclassGrid">
              <div class="hclass-card"><div class="hclass-meta">Loading…</div></div>
            </div>

            <div class="widget">
              <div class="widget-title" style="cursor:pointer" data-action="goTo" data-arg="page-trainers" onclick="__page.__run(event)">Your Trainers</div>
              <div id="trainerWidget">
                <div class="trainer-row"><div class="trainer-role">Loading…</div></div>
              </div>
            </div>
          </div>

          <div class="home-col-rest">
            <div class="barbell"><span class="plate small"></span><span class="plate"></span><span></span><span class="plate"></span><span class="plate small"></span></div>

            <div class="section-title">ANNOUNCEMENTS</div>
            <div class="poster-feed" id="posterFeed">
              <div class="poster-card"><div class="poster-meta">Loading…</div></div>
            </div>
          </div>

        </div>
      </div>

      <div class="page" id="page-store">
        <div class="section-title">STORE</div>
        <div class="coming-soon" style="text-align:center;padding:90px 20px;">
          <svg viewBox="0 0 24 24" width="56" height="56" fill="none" stroke="#e6cc7a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          <h2 style="margin:18px 0 8px;font-size:28px;">Coming soon</h2>
          <p style="opacity:.7;">Our store is on its way. Stay tuned!</p>
        </div>
        <div style="display:none" aria-hidden="true">
        <div class="store-search-row">
          <div class="store-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21L16.65 16.65" stroke-linecap="round"/></svg>
            <input type="text" id="storeSearchInput" placeholder="Search products...">
          </div>
          <button type="button" class="store-search-go" id="storeSearchGo" aria-label="Search"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21L16.65 16.65" stroke-linecap="round"/></svg></button>
        </div>
        <div class="filter-chips" id="storeFilters">
          <div class="chip active" data-filter="all">All</div>
          <div class="chip" data-filter="supplements">Supplements</div>
          <div class="chip" data-filter="apparel">Apparel</div>
          <div class="chip" data-filter="accessories">Accessories</div>
        </div>
        <div class="store-toolbar">
          <div class="store-views"><button type="button" id="storeViewList" aria-label="List"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button><button type="button" id="storeViewGrid" class="on" aria-label="Grid"><svg viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/></svg></button></div>
          <div class="store-count" id="storeCount"></div>
          <select id="storeSort" class="store-sort"><option value="random">Random</option><option value="asc">Price: low to high</option><option value="desc">Price: high to low</option></select>
        </div>
        <div class="store-bar"><span id="storeRange"></span><div class="store-pager"></div></div>
        <div class="store-grid" id="storeGrid"><div class="product-card">Loading…</div></div>
        <div class="store-bar"><span></span><div class="store-pager"></div></div>
        </div>
      </div>

      <div class="page" id="page-store-search">
        <div class="store-results-header">
          <div class="subpage-back" data-action="goTo" data-arg="page-store" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Store</div>
          <div class="store-results-avatar" id="storeResultsAvatar"></div>
        </div>
        <div class="store-search-row">
          <div class="store-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21L16.65 16.65" stroke-linecap="round"/></svg>
            <input type="text" id="storeResultsSearchInput" placeholder="Search products...">
          </div>
          <button type="button" class="store-search-go" aria-label="Filters"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7H20M8 12H16M11 17H13"/></svg></button>
        </div>
        <div class="store-results-count" id="storeResultsCount">Found <span id="storeResultsN">0</span> results</div>
        <div class="store-masonry">
          <div class="store-masonry-col" id="storeMasonryColA"></div>
          <div class="store-masonry-col" id="storeMasonryColB"></div>
        </div>
      </div>

      <div class="page" id="page-trainers">
        <div class="section-title">OUR TRAINERS</div>
        <div class="trainers-grid" id="trainersGrid">
          <div class="trainer-card"><div class="trainer-role">Loading…</div></div>
        </div>
      </div>

      <div class="page" id="page-progress">
        <div class="section-title">WEIGHT PROGRESS</div>

        <div class="diet-summary-widget" id="dietSummaryWidget"></div>

        <div class="weight-stats" id="weightStats"></div>

        <div class="progress-layout">
          <div class="chart-card">
            <div class="widget-title">Weight over time</div>
            <svg id="weightChart" viewBox="0 0 600 240" style="width:100%; height:auto; overflow:visible;"></svg>
            <div class="coach-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 4 6v6c0 5 3.4 8.7 8 10 4.6-1.3 8-5 8-10V6l-8-4z"/><path d="m9 12 2 2 4-4"/></svg>
              Your weight log is automatically shared with your coach.
            </div>
          </div>

          <div class="widget">
            <div class="widget-title">Log today's weight</div>
            <form id="weightForm">
              <div class="form-field">
                <label>Date</label>
                <input type="date" id="weightDate" required>
              </div>
              <div class="form-field">
                <label>Weight (kg)</label>
                <input type="number" id="weightValue" step="0.1" min="30" max="300" placeholder="e.g. 72.5" required>
              </div>
              <button type="submit" class="form-save">Save Weight</button>
            </form>
            <div class="weight-log-list" id="weightLogList"></div>
          </div>
        </div>

        <div class="meal-plan-head">
          <div class="widget-title">Today's Meal Plan</div>
          <div class="meal-plan-shuffle" data-action="renderMealPlan" data-arg="true" onclick="__page.__run(event)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 3h5v5"/><path d="M4 20 21 3"/><path d="M21 16v5h-5"/><path d="M15 15l6 6"/><path d="M4 4l5 5"/></svg>
            Shuffle meals
          </div>
        </div>
        <div class="meal-plan-grid" id="mealPlanGrid"></div>
      </div>

      <div class="page" id="page-diet">
        <div class="section-title">DIET & MACROS</div>

        <div class="diet-layout">
          <div class="widget">
            <div class="widget-title">Your details</div>
            <form id="dietForm">
              <div class="form-field">
                <label>Goal</label>
                <div class="goal-pills" id="goalPills">
                  <div class="goal-pill" data-goal="cut">Cut</div>
                  <div class="goal-pill" data-goal="maintain">Maintain</div>
                  <div class="goal-pill" data-goal="bulk">Bulk</div>
                </div>
              </div>
              <div class="diet-grid2">
                <div class="form-field">
                  <label>Sex</label>
                  <select id="dietSex">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
                <div class="form-field">
                  <label>Age</label>
                  <input type="number" id="dietAge" min="14" max="90" placeholder="e.g. 27" required>
                </div>
                <div class="form-field">
                  <label>Height (cm)</label>
                  <input type="number" id="dietHeight" min="120" max="230" placeholder="e.g. 175" required>
                </div>
                <div class="form-field">
                  <label>Weight (kg)</label>
                  <input type="number" id="dietWeight" step="0.1" min="30" max="300" placeholder="e.g. 72.5" required>
                </div>
              </div>
              <div class="form-field">
                <label>Activity level</label>
                <select id="dietActivity">
                  <option value="1.2">Sedentary (little/no exercise)</option>
                  <option value="1.375">Light (1-3 days/week)</option>
                  <option value="1.55" selected>Moderate (3-5 days/week)</option>
                  <option value="1.725">Active (6-7 days/week)</option>
                  <option value="1.9">Very active (physical job/2x day)</option>
                </select>
              </div>
              <button type="submit" class="form-save">Calculate My Macros</button>
            </form>
          </div>

          <div class="widget" id="dietResults">
            <div class="diet-empty">Fill in your details and hit calculate to get your daily calorie and macro targets.</div>
          </div>
        </div>
      </div>

      <div class="page" id="page-schedule">
        <div class="section-title">CLASS SCHEDULE</div>
        <div class="day-pills" id="dayPills"></div>
        <div class="category-chips" id="categoryFilters">
          <div class="chip active" data-category="all">All</div>
        </div>

        <div class="plans-tabs" id="scheduleTabs">
          <button type="button" class="plans-tab is-active" data-sched-tab="collectifs">Cours collectifs</button>
          <button type="button" class="plans-tab" data-sched-tab="pilates">Cours pilates</button>
        </div>

        <div class="plans-panel is-active" id="sched-panel-collectifs">
          <div class="class-grid" id="scheduleClassGrid" data-group="collectifs">
            <div class="class-card"><div class="class-info">Loading…</div></div>
          </div>
        </div>

        <div class="plans-panel" id="sched-panel-pilates">
          <div class="class-grid" id="schedulePilatesGrid" data-group="pilates">
            <div class="class-card"><div class="class-info">Loading…</div></div>
          </div>
        </div>
        <script>
        document.getElementById('scheduleTabs').addEventListener('click',function(e){
          var b=e.target.closest('[data-sched-tab]'); if(!b) return;
          var t=b.dataset.schedTab;
          document.querySelectorAll('#scheduleTabs .plans-tab').forEach(function(x){x.classList.toggle('is-active',x===b);});
          ['collectifs','pilates'].forEach(function(k){
            document.getElementById('sched-panel-'+k).classList.toggle('is-active',k===t);
          });
        });
        </script>
      </div>

      <div class="page" id="page-plans">
        <div class="section-title">CHOOSE YOUR PLAN</div>

        <div class="plans-tabs">
          <button type="button" class="plans-tab is-active" data-tab="musc" data-action="switchAppPlan" data-arg="musc" onclick="__page.__run(event)">Musculation</button>
          <button type="button" class="plans-tab" data-tab="pilates" data-action="switchAppPlan" data-arg="pilates" onclick="__page.__run(event)">Pilates</button>
        </div>

        <div class="plans-panel is-active" id="app-panel-musc">
          <div class="price-grid">
            <div class="price-block">
              <h3>Membership</h3>
              <table class="price-table">
                <tr><td>1 Month</td><td>90 DT</td></tr>
                <tr><td>2 Months</td><td>160 DT</td></tr>
                <tr><td>3 Months</td><td><s>225 DT</s>180 DT<span class="promo">Promo</span></td></tr>
                <tr><td>6 Months</td><td><s>420 DT</s>340 DT<span class="promo">Promo</span></td></tr>
                <tr><td>12 Months</td><td>700 DT</td></tr>
              </table>
            </div>
            <div class="price-block">
              <h3>Private Coaching</h3>
              <table class="price-table">
                <tr><td>1 Session</td><td>30 DT</td></tr>
                <tr><td>8 Sessions</td><td>200 DT</td></tr>
                <tr><td>16 Sessions</td><td>320 DT</td></tr>
              </table>
              <p class="price-note">Drop-in floor session — 10 DT</p>
            </div>
          </div>
        </div>

        <div class="plans-panel" id="app-panel-pilates">
          <div class="price-grid">
            <div class="price-block">
              <h3>Reformer — Essentiel</h3>
              <table class="price-table">
                <tr><td>8 sessions · 30 days</td><td>260 DT</td></tr>
                <tr><td>12 sessions · 45 days</td><td>360 DT</td></tr>
                <tr><td>24 sessions · 90 days</td><td>550 DT</td></tr>
                <tr><td>48 sessions · 180 days</td><td>1050 DT</td></tr>
              </table>
            </div>
            <div class="price-block">
              <h3>Reformer + Privé — Premium</h3>
              <table class="price-table">
                <tr><td>5R + 3P · 30 days</td><td>290 DT</td></tr>
                <tr><td>7R + 5P · 45 days</td><td>420 DT</td></tr>
                <tr><td>16R + 8P · 90 days</td><td>750 DT</td></tr>
                <tr><td>38R + 10P · 180 days</td><td>1300 DT</td></tr>
              </table>
            </div>
            <div class="price-block">
              <h3>Pilates + Musculation — Intégral</h3>
              <table class="price-table">
                <tr><td>1 Month · 8 R</td><td>320 DT</td></tr>
                <tr><td>3 Months · 24 R</td><td>700 DT</td></tr>
                <tr><td>6 Months · 48 R</td><td>1350 DT</td></tr>
                <tr><td>12 Months · 100 R</td><td>2650 DT</td></tr>
              </table>
            </div>
            <div class="price-block">
              <h3>Private Sessions</h3>
              <table class="price-table">
                <tr><td>Reformer</td><td>35 DT</td></tr>
                <tr><td>Private (any machine)</td><td>45 DT</td></tr>
                <tr><td>8 Private sessions</td><td>340 DT</td></tr>
              </table>
              <p class="price-note">R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)</p>
            </div>
          </div>
        </div>
      </div>

      <div class="page" id="page-profile">
        <div class="section-title">PROFILE &amp; SETTINGS</div>
        <div class="profile-grid" style="margin-top:16px;">
          <div class="profile-card">
            <div class="avatar-lg" id="profileAvatarLg">SA</div>
            <div class="profile-name-wrap">
              <div class="profile-name" id="profileNameText">Sarah Aziz</div>
              <div class="profile-tier" id="profileTierText">Gold Member since 2024</div>
              <div class="pstat-row">
                <div class="pstat"><div class="n">128</div><div class="l">Workouts</div></div>
                <div class="pstat"><div class="n">6</div><div class="l">Streak</div></div>
                <div class="pstat"><div class="n">2.1y</div><div class="l">Member</div></div>
              </div>
            </div>
          </div>

          <div class="menu-list">
            <div class="menu-item" data-action="goTo" data-arg="page-editprofile" onclick="__page.__run(event)">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="3.2" stroke="#e6cc7a" stroke-width="1.6"/><path d="M5 20C5 16.5 8.1 14 12 14C15.9 14 19 16.5 19 20" stroke="#e6cc7a" stroke-width="1.6" stroke-linecap="round"/></svg></div>
              <div class="menu-text">Edit Profile</div>
              <div class="menu-arrow">›</div>
            </div>
            <div class="menu-item" data-action="goTo" data-arg="page-payment" onclick="__page.__run(event)">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="13" rx="2" stroke="#8fc25f" stroke-width="1.6"/><path d="M3 10H21" stroke="#8fc25f" stroke-width="1.6"/></svg></div>
              <div class="menu-text">Payment Methods</div>
              <div class="menu-arrow">›</div>
            </div>
            <div class="menu-item" data-action="goTo" data-arg="page-bookinghistory" onclick="__page.__run(event)">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 8L12 3L20 8V16L12 21L4 16V8Z" stroke="#e6cc7a" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
              <div class="menu-text">Booking History</div>
              <div class="menu-arrow">›</div>
            </div>
            <div class="menu-item" data-action="goTo" data-arg="page-notifications" onclick="__page.__run(event)">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3C9.5 3 7.5 5 7.5 7.5V11L5.5 14.5H18.5L16.5 11V7.5C16.5 5 14.5 3 12 3Z" stroke="#8fc25f" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
              <div class="menu-text">Notifications</div>
              <div class="menu-arrow">›</div>
            </div>
            <div class="menu-item" data-action="goTo" data-arg="page-help" onclick="__page.__run(event)">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#e6cc7a" stroke-width="1.6"/><path d="M12 8V12L15 14" stroke="#e6cc7a" stroke-width="1.6" stroke-linecap="round"/></svg></div>
              <div class="menu-text">Help &amp; Support</div>
              <div class="menu-arrow">›</div>
            </div>
            <div class="menu-item" id="themeMenuItem" style="cursor:pointer;">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M20 14.5A8 8 0 0 1 9.5 4 8 8 0 1 0 20 14.5Z" stroke="#e6cc7a" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
              <div class="menu-text">Dark Mode</div>
              <div class="theme-switch" id="themeSwitch" role="switch" aria-label="Dark mode"></div>
            </div>
            <div class="menu-item" id="logoutMenuItem" style="cursor:pointer;">
              <div class="menu-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M9 6L4 12L9 18M4 12H16M16 4H19C20.1 4 21 4.9 21 6V18C21 19.1 20.1 20 19 20H16" stroke="#d97d5a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
              <div class="menu-text logout">Log Out</div>
            </div>
          </div>
        </div>
      </div>

      <div class="page" id="page-editprofile">
        <div class="subpage-back" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Profile</div>
        <div class="section-title">EDIT PROFILE</div>

        <form class="form-card" style="margin-top:16px;" id="editProfileForm">
          <div class="ep-photo-row">
            <div class="ep-avatar-wrap">
              <div class="avatar-lg" id="epAvatarPreview">SA</div>
              <label class="ep-photo-btn" for="epPhotoInput">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h3l2-2h6l2 2h3v11H4z"/><circle cx="12" cy="13.5" r="3.2"/></svg>
              </label>
              <input type="file" id="epPhotoInput" accept="image/*" style="display:none">
            </div>
            <div class="ep-photo-info"><b>Profile photo</b><span>Tap the camera to update</span></div>
          </div>

          <div class="form-field"><label>Full name</label><input type="text" id="epName" value="Sarah Aziz" required></div>
          <div class="form-field"><label>Email</label><input type="email" id="epEmail" value="sarah.aziz@email.com" required></div>
          <div class="form-field"><label>Phone</label><input type="tel" id="epPhone" value="+216 22 345 678" required></div>

          <div class="form-divider">Emergency contact</div>
          <div class="form-field"><label>Contact name</label><input type="text" placeholder="e.g. Yasmine Aziz"></div>
          <div class="form-field"><label>Contact phone</label><input type="tel" placeholder="+216 XX XXX XXX"></div>

          <button type="submit" class="form-save">Save Changes</button>
        </form>
      </div>

      <div class="page" id="page-payment">
        <div class="subpage-back" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Profile</div>
        <div class="section-title">PAYMENT METHODS</div>

        <div class="form-divider" style="margin-top:16px;">Accepted at checkout</div>
        <div class="pm-badges">
          <div class="pm-badge"><div class="pm-icon pm-d17">D17</div><span>D17</span></div>
          <div class="pm-badge"><div class="pm-icon pm-flouci">FLC</div><span>Flouci</span></div>
          <div class="pm-badge"><div class="pm-icon pm-visa">VISA</div><span>Visa</span></div>
          <div class="pm-badge"><div class="pm-icon pm-mc">MC</div><span>Mastercard</span></div>
        </div>
        <p class="pm-note">Pay for classes, sessions, and membership renewals with any of the above — chosen at checkout. For your security, EOS Fitness &amp; Pilates never stores your card or wallet details in the app.</p>

        <div class="form-divider" style="margin-top:26px;">Your plan</div>
        <div class="plan-summary">
          <div class="mc-tier">GOLD MEMBERSHIP</div>
          <div class="ps-row"><span>Monthly price</span><b>240 DT / mo</b></div>
          <div class="ps-row"><span>Billing cycle</span><b>Annual</b></div>
          <div class="ps-row"><span>Renews on</span><b>Sept 14, 2026</b></div>
          <button type="button" class="form-save" data-action="goTo" data-arg="page-plans" onclick="__page.__run(event)">View Plans</button>
        </div>
      </div>

      <div class="page" id="page-bookinghistory">
        <div class="subpage-back" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Profile</div>
        <div class="section-title">BOOKING HISTORY</div>

        <div class="filter-chips" id="bhFilters">
          <div class="chip active" data-filter="all">All</div>
          <div class="chip" data-filter="completed">Completed</div>
          <div class="chip" data-filter="cancelled">Cancelled</div>
          <div class="chip" data-filter="noshow">No-show</div>
        </div>

        <div class="bh-list" id="bhList">
          <div class="bh-row" data-status="completed">
            <div class="bh-date"><div class="d1">12</div><div class="d2">Aug</div></div>
            <div class="bh-info"><div class="bh-name">Strength Circuit</div><div class="bh-meta">Karim Trabelsi · Main Floor</div></div>
            <div class="bh-status completed">Completed</div>
          </div>
          <div class="bh-row" data-status="completed">
            <div class="bh-date"><div class="d1">10</div><div class="d2">Aug</div></div>
            <div class="bh-info"><div class="bh-name">Reformer Pilates</div><div class="bh-meta">Nour Ben Salem · Studio B</div></div>
            <div class="bh-status completed">Completed</div>
          </div>
          <div class="bh-row" data-status="noshow">
            <div class="bh-date"><div class="d1">7</div><div class="d2">Aug</div></div>
            <div class="bh-info"><div class="bh-name">Mat Pilates Flow</div><div class="bh-meta">Nour Ben Salem · Studio B</div></div>
            <div class="bh-status noshow">No-show</div>
          </div>
          <div class="bh-row" data-status="cancelled">
            <div class="bh-date"><div class="d1">3</div><div class="d2">Aug</div></div>
            <div class="bh-info"><div class="bh-name">Strength Lab</div><div class="bh-meta">Wassim Gharbi · Weight Room</div></div>
            <div class="bh-status cancelled">Cancelled</div>
          </div>
          <div class="bh-row" data-status="completed">
            <div class="bh-date"><div class="d1">29</div><div class="d2">Jul</div></div>
            <div class="bh-info"><div class="bh-name">Express Core</div><div class="bh-meta">Nour Ben Salem · Studio A</div></div>
            <div class="bh-status completed">Completed</div>
          </div>
        </div>
      </div>

      <div class="page" id="page-notifications">
        <div class="subpage-back" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Profile</div>
        <div class="section-title">NOTIFICATIONS</div>
        <div id="notifFeed" style="margin-top:12px;"></div>

        <div class="form-divider" style="margin-top:16px;">Classes</div>
        <div class="notif-group">
          <div class="notif-toggle-row"><div class="nt-text"><b>Class reminders</b><span>Alert before a booked class starts</span></div><label class="switch"><input type="checkbox" checked><span class="switch-track"></span></label></div>
          <div class="notif-toggle-row"><div class="nt-text"><b>Booking confirmations</b><span>When a booking is confirmed or booked</span></div><label class="switch"><input type="checkbox" checked><span class="switch-track"></span></label></div>
          <div class="notif-toggle-row"><div class="nt-text"><b>New classes added</b><span>New sessions on the schedule</span></div><label class="switch"><input type="checkbox"><span class="switch-track"></span></label></div>
        </div>

        <div class="form-divider">Membership</div>
        <div class="notif-group">
          <div class="notif-toggle-row"><div class="nt-text"><b>Renewal reminders</b><span>Before your membership renews</span></div><label class="switch"><input type="checkbox" checked><span class="switch-track"></span></label></div>
          <div class="notif-toggle-row"><div class="nt-text"><b>Promotions &amp; offers</b><span>Discounts and member perks</span></div><label class="switch"><input type="checkbox"><span class="switch-track"></span></label></div>
        </div>

        <div class="form-divider">Delivery</div>
        <div class="notif-group">
          <div class="notif-toggle-row"><div class="nt-text"><b>Push notifications</b><span>On this device</span></div><label class="switch"><input type="checkbox" checked><span class="switch-track"></span></label></div>
          <div class="notif-toggle-row"><div class="nt-text"><b>Email</b><span>sarah.aziz.gmail.com</span></div><label class="switch"><input type="checkbox" checked><span class="switch-track"></span></label></div>
          <div class="notif-toggle-row"><div class="nt-text"><b>SMS</b><span>+216 22 345 678</span></div><label class="switch"><input type="checkbox"><span class="switch-track"></span></label></div>
        </div>
      </div>

      <div class="page" id="page-help">
        <div class="subpage-back" data-action="goTo" data-arg="page-profile" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Profile</div>
        <div class="section-title">HELP &amp; SUPPORT</div>

        <div class="form-divider" style="margin-top:16px;">Contact us</div>
        <div class="help-contact" style="margin-bottom:22px;">
          <a class="help-contact-btn" href="https://wa.me/21654088881" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="#8fc25f" stroke-width="1.7"><path d="M4 20l1.4-4.2A8 8 0 1 1 8.7 19L4 20z"/></svg>WhatsApp</a>
          <a class="help-contact-btn" href="mailto:support.eosfitness.tn"><svg viewBox="0 0 24 24" fill="none" stroke="#e6cc7a" stroke-width="1.7"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>Email us</a>
          <a class="help-contact-btn" href="tel:+21654088881"><svg viewBox="0 0 24 24" fill="none" stroke="#e6cc7a" stroke-width="1.7"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.7 2z"/></svg>Call gym</a>
        </div>

        <div class="form-divider">Legal</div>
        <div class="help-list" style="margin-bottom:22px;">
          <div class="help-link" data-action="goTo" data-arg="page-terms" onclick="__page.__run(event)">Terms of Service<span class="menu-arrow">›</span></div>
          <div class="help-link" data-action="goTo" data-arg="page-privacy" onclick="__page.__run(event)">Privacy Policy<span class="menu-arrow">›</span></div>
          <div class="help-link" data-action="goTo" data-arg="page-cookies" onclick="__page.__run(event)">Cookie Policy<span class="menu-arrow">›</span></div>
        </div>

        <div class="form-divider">FAQ</div>
        <div class="help-list">
          <div class="acc-item">
            <div class="acc-head" data-action="toggleParentOpen" onclick="__page.__run(event)">How do I cancel a booking?<span class="chev">⌄</span></div>
            <div class="acc-body"><p>Cancel up to 2 hours before class starts from Schedule → your booking, or from the Booking History page.</p></div>
          </div>
          <div class="acc-item">
            <div class="acc-head" data-action="toggleParentOpen" onclick="__page.__run(event)">How do I freeze or cancel my membership?<span class="chev">⌄</span></div>
            <div class="acc-body"><p>Membership freezes and cancellations are handled at the front desk or via WhatsApp/email above.</p></div>
          </div>
          <div class="acc-item">
            <div class="acc-head" data-action="toggleParentOpen" onclick="__page.__run(event)">I lost my membership card — what now?<span class="chev">⌄</span></div>
            <div class="acc-body"><p>Your app is your digital membership card — just show your Profile at check-in, no reissue needed.</p></div>
          </div>
        </div>
      </div>

      <div class="page" id="page-terms">
        <div class="subpage-back" data-action="goTo" data-arg="page-help" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Help &amp; Support</div>
        <div class="section-title">TERMS OF SERVICE</div>
        <div class="legal-body" style="margin-top:16px;">
          <div class="lupdated">Last updated: August 2026</div>
          <h3>1. Membership</h3>
          <p>Your membership grants access to EOS Fitness &amp; Pilates according to the plan you choose (Basic, Gold, or Elite). Access hours, class allowances, and perks follow the plan details shown on the Plans page at the time of purchase or renewal.</p>
          <h3>2. Bookings &amp; Cancellations</h3>
          <p>Classes can be booked through the app subject to available spots. Cancel at least 2 hours before class starts to free your spot for other members. Repeated late cancellations or no-shows may affect your future booking priority.</p>
          <h3>3. Billing &amp; Renewal</h3>
          <p>Memberships renew automatically at the end of each billing cycle unless cancelled beforehand. You can review your renewal date anytime from the Payment Methods page.</p>
          <h3>4. Studio Conduct</h3>
          <p>Members are expected to follow instructor guidance, respect equipment and studio spaces, and treat staff and other members courteously. EOS Fitness &amp; Pilates reserves the right to suspend access for conduct that endangers others.</p>
          <h3>5. Changes to These Terms</h3>
          <p>We may update these terms from time to time to reflect changes to our services. Continued use of the app after an update means you accept the revised terms.</p>
        </div>
      </div>

      <div class="page" id="page-privacy">
        <div class="subpage-back" data-action="goTo" data-arg="page-help" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Help &amp; Support</div>
        <div class="section-title">PRIVACY POLICY</div>
        <div class="legal-body" style="margin-top:16px;">
          <div class="lupdated">Last updated: August 2026</div>
          <h3>1. What We Collect</h3>
          <p>Your name, email, phone number, and the emergency contact you choose to provide, along with your class bookings, attendance, and membership plan.</p>
          <h3>2. How We Use It</h3>
          <p>To run your account, manage bookings and check-ins, send reminders and renewal notices, and keep your membership status up to date. We never sell your personal data to third parties.</p>
          <h3>3. Payment Information</h3>
          <p>Payments made through D17, Flouci, Visa, or Mastercard are processed by those providers directly — EOS Fitness &amp; Pilates does not store your card numbers or wallet credentials in the app.</p>
          <h3>4. Your Choices</h3>
          <p>You can update your personal info anytime from Edit Profile, adjust what you're notified about from Notifications, and request account deletion by contacting us.</p>
          <h3>5. Data Retention</h3>
          <p>We keep your account and booking history for as long as your membership is active, plus a limited period afterward for billing and legal record-keeping.</p>
        </div>
      </div>

      <div class="page" id="page-cookies">
        <div class="subpage-back" data-action="goTo" data-arg="page-help" onclick="__page.__run(event)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Help &amp; Support</div>
        <div class="section-title">COOKIE POLICY</div>
        <div class="legal-body" style="margin-top:16px;">
          <div class="lupdated">Last updated: August 2026</div>
          <h3>1. Essential Cookies</h3>
          <p>Used to keep you logged in, remember your session, and make the app function correctly. These can't be turned off without affecting core functionality.</p>
          <h3>2. Preference Cookies</h3>
          <p>Remember small choices like your last-viewed page or selected filters, so the app feels consistent between visits.</p>
          <h3>3. Analytics Cookies</h3>
          <p>Help us understand which features are used most, so we can improve the booking flow and class scheduling. This data is aggregated and not shared for advertising purposes.</p>
          <h3>4. Managing Cookies</h3>
          <p>You can opt out of analytics cookies anytime by contacting us at support eosfitness.tn or through the front desk.</p>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="toast" id="toast"><span class="tdot"></span><span id="toastMsg"></span></div>

</div>