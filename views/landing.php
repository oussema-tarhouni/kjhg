<div class="page-root">
<nav class="nav" id="nav">
  <div class="wrap nav__row">
    <a class="nav__brand" href="#top">
      <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;">
    </a>
    <div class="nav__links">
      <a href="#about" data-i18n="nav.about">About</a>
      <a href="#programs" data-i18n="nav.programs">Programs</a>
      <a href="#plans" data-i18n="nav.plans">Plans</a>
      <a href="#locations" data-i18n="nav.locations">Locations</a>
      <a href="#membership" data-i18n="nav.membership">Membership</a>
    </div>
    <div class="nav__actions">
      <div class="lang" id="lang-switch">
        <button class="lang__btn" id="lang-btn" aria-haspopup="true" aria-expanded="false">
          <span id="lang-flag">🇬🇧</span><span id="lang-code">EN</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div class="lang__menu" id="lang-menu">
          <button type="button" data-lang="en"><span>🇬🇧</span>English</button>
          <button type="button" data-lang="fr"><span>🇫🇷</span>Français</button>
          <button type="button" data-lang="tn"><span>🇹🇳</span>تونسي</button>
        </div>
      </div>
      <a href="<?= url('login') ?>" class="btn btn--ghost" data-i18n="nav.login">Log In</a>
      <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
      <button class="nav__burger" id="nav-burger" aria-label="Menu">
        <span class="nav__burger-icon"><span></span><span></span><span></span></span>
      </button>
    </div>
  </div>
  <div id="mobile-menu" style="display:none;">
    <div class="wrap" style="display:flex; flex-direction:column; gap:2px; padding-top:16px;">
      <a href="#about" data-i18n="nav.about" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">About</a>
      <a href="#programs" data-i18n="nav.programs" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Programs</a>
      <a href="#plans" data-i18n="nav.plans" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Plans</a>
      <a href="#locations" data-i18n="nav.locations" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Locations</a>
      <a href="#membership" data-i18n="nav.membership" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Membership</a>
      <a href="<?= url('login') ?>" data-i18n="nav.login" style="padding:12px 0; border-top:1px solid var(--line); color:var(--white); font-weight:700;">Log In</a>
    </div>
  </div>
</nav>

<div id="top" class="hero">
  <div class="hero__bg">
    <video class="hero__bg-blur" src="<?= BASE ?>/assets/hero.mp4" autoplay muted loop playsinline></video>
    <video class="hero__bg-fg" src="<?= BASE ?>/assets/hero.mp4" autoplay muted loop playsinline></video>
  </div>
  <div class="hero__scrim"></div>
  <div class="wrap hero__content">
    <div class="hero__eyebrow">
      <div class="barbell barbell--left"><div class="plate small"></div><div class="plate"></div></div>
      <span class="eyebrow" data-i18n="hero.eyebrow">Strength · Pilates · Community</span>
    </div>
    <h1 data-i18n="hero.title">Train like the<br>work actually <span>matters</span></h1>
    <p class="lead" data-i18n="hero.lead">Free weights, a reformer pilates studio, and group classes under one roof — with a front desk that actually remembers your name. Open early, open late, three floors near you.</p>
    <div class="hero__ctas">
      <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
      <a href="#locations" class="btn btn--ghost" data-i18n="hero.findLocation">Find a Location</a>
    </div>
  </div>
  <div class="hero__scroll" data-i18n="hero.scroll">Scroll</div>
</div>

<div class="stats">
  <div class="wrap">
    <div class="stats__row">
      <div class="stat"><div class="stat__num">12k+</div><div class="stat__label" data-i18n="stats.members">Active Members</div></div>
      <div class="stat"><div class="stat__num">40+</div><div class="stat__label" data-i18n="stats.classes">Classes Weekly</div></div>
      <div class="stat"><div class="stat__num">3</div><div class="stat__label" data-i18n="stats.locations">Locations</div></div>
      <div class="stat"><div class="stat__num">5a–11p</div><div class="stat__label" data-i18n="stats.hours">Daily Hours</div></div>
    </div>
  </div>
</div>

<section class="about" id="about">
  <div class="wrap about__grid">
    <div class="about__media">
      <img src="https://images.unsplash.com/photo-1517130038641-a774d04afb3c?auto=format&fit=crop&w=1000&q=80" alt="Instructor coaching a member through a lift" />
      <div class="about__badge">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.4 6.9L21 11l-6.6 2.1L12 20l-2.4-6.9L3 11l6.6-2.1z"/></svg>
        <div><b data-i18n="about.badge.title">Est. 2014</b><span data-i18n="about.badge.sub">Locally owned, still coached</span></div>
      </div>
    </div>
    <div class="about__text">
      <div class="eyebrow" data-i18n="about.eyebrow">About Us</div>
      <h2 class="display" style="font-size:clamp(30px,4vw,44px); margin-top:12px;" data-i18n="about.title">A gym built by people who actually train here</h2>
      <p data-i18n="about.p1">EOS started as a single strength floor and a stubborn belief that a gym should feel like it belongs to its members, not the other way around. A decade later that hasn't changed — the same coaches who designed the programming are still on the floor spotting sets and correcting form.</p>
      <p data-i18n="about.p2">We built three things under one roof: a serious free-weight and machine floor, a reformer pilates studio led by instructors who watch every rep, and a class schedule people actually show up for. No matter which door you walk through, someone knows your name and your goals.</p>
      <div class="about__pillars">
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5 17.5 17.5M4 4l3 3M20 20l-3-3M2 8l2-2M22 16l-2 2M8 2l-2 2M16 22l2-2"/></svg>
          <b data-i18n="about.pillar1.title">Strength Floor</b><span data-i18n="about.pillar1.desc">Free weights &amp; machines, zero waiting.</span>
        </div>
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/></svg>
          <b data-i18n="about.pillar2.title">Pilates Studio</b><span data-i18n="about.pillar2.desc">Reformer &amp; mat, small class sizes.</span>
        </div>
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <b data-i18n="about.pillar3.title">Community</b><span data-i18n="about.pillar3.desc">Members-only app &amp; real front desk.</span>
        </div>
      </div>
    </div>
  </div>

  <div class="wrap" style="margin-top:64px; margin-bottom:12px;">
    <div class="eyebrow" data-i18n="team.eyebrow">Meet The Team</div>
    <h2 class="display" style="font-size:clamp(24px,3vw,32px); margin-top:12px;" data-i18n="team.title">Administration &amp; Coaches</h2>
  </div>
  <div class="about__team">
    <div class="team__grid">
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Sami Ben Amor" /><b>Sami Ben Amor</b><span data-i18n="team.gm">General Manager</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Leila Haddad" /><b>Leila Haddad</b><span data-i18n="team.ops">Operations Director</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Karim Mejri" /><b>Karim Mejri</b><span data-i18n="team.strength">Head Strength Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Nour Ayari" /><b>Nour Ayari</b><span data-i18n="team.pilates">Pilates Instructor</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Yassine Trabelsi" /><b>Yassine Trabelsi</b><span data-i18n="team.group">Group Fitness Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/profile.png" alt="Rania Chebbi" /><b>Rania Chebbi</b><span data-i18n="team.nutrition">Nutrition Coach</span></div>
    </div>
  </div>
</section>

<section class="programs" id="programs">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="programs.eyebrow">Programs</div>
      <h2 data-i18n="programs.title">Train your way</h2>
      <p data-i18n="programs.lead">Three floors, one membership. Move between them as your training changes.</p>
    </div>
    <div class="programs__grid">
      <div class="card">
        <div class="card__media"><img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=800&q=80" alt="Strength training floor with free weights" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c1.tag">Strength</div>
          <h3 data-i18n="programs.c1.title">Strength &amp; Conditioning</h3>
          <p data-i18n="programs.c1.desc">A full floor of free weights, plate-loaded machines, and platforms for serious lifting — plus programming if you want it.</p>
        </div>
      </div>
      <div class="card">
        <div class="card__media"><img src="https://images.unsplash.com/photo-1754257319747-df51c384c0fa?auto=format&fit=crop&w=800&q=80" alt="Reformer pilates class in session" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c2.tag">Pilates</div>
          <h3 data-i18n="programs.c2.title">Reformer &amp; Mat Pilates</h3>
          <p data-i18n="programs.c2.desc">Small classes led by instructors who watch your form rep by rep — reformer, mat, and everything between.</p>
        </div>
      </div>
      <div class="card">
        <div class="card__media"><img src="https://images.unsplash.com/photo-1571731956672-f2b94d7dd0cb?auto=format&fit=crop&w=800&q=80" alt="Group fitness class" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c3.tag">Group Classes</div>
          <h3 data-i18n="programs.c3.title">HIIT, Cycle &amp; More</h3>
          <p data-i18n="programs.c3.desc">40+ classes a week across every floor. Book your spot in the app before it fills up.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="plans" id="plans">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="plans.eyebrow">Plans</div>
      <h2 data-i18n="plans.title">Pricing built to move you</h2>
      <p data-i18n="plans.lead">Strength, pilates, or both — pick your track. Promo prices shown where available.</p>
    </div>
    <div class="plans__tabs">
      <button class="plans__tab is-active" data-tab="musc" data-action="switchPlan" data-arg="musc" onclick="__page.__run(event)" data-i18n="plans.tabMusc">Musculation</button>
      <button class="plans__tab" data-tab="pilates" data-action="switchPlan" data-arg="pilates" onclick="__page.__run(event)" data-i18n="plans.tabPilates">Pilates</button>
    </div>

    <div class="plans__panel is-active" id="panel-musc">
      <div class="price-grid">
        <div class="price-block">
          <h3 data-i18n="plans.membership">Membership</h3>
          <table class="price-table">
            <tr><td>1 Month</td><td>90 DT</td></tr>
            <tr><td>2 Months</td><td>160 DT</td></tr>
            <tr><td>3 Months</td><td><s>225 DT</s>180 DT<span class="promo">Promo</span></td></tr>
            <tr><td>6 Months</td><td><s>420 DT</s>340 DT<span class="promo">Promo</span></td></tr>
            <tr><td>12 Months</td><td>700 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3 data-i18n="plans.privateCoaching">Private Coaching</h3>
          <table class="price-table">
            <tr><td>1 Session</td><td>30 DT</td></tr>
            <tr><td>8 Sessions</td><td>200 DT</td></tr>
            <tr><td>16 Sessions</td><td>320 DT</td></tr>
          </table>
          <p class="price-note" data-i18n="plans.dropIn">Drop-in floor session — 10 DT</p>
        </div>
      </div>
    </div>

    <div class="plans__panel" id="panel-pilates">
      <div class="price-grid">
        <div class="price-block">
          <h3 data-i18n="plans.essentiel">Reformer — Essentiel</h3>
          <table class="price-table">
            <tr><td>8 sessions · 30 days</td><td>260 DT</td></tr>
            <tr><td>12 sessions · 45 days</td><td>360 DT</td></tr>
            <tr><td>24 sessions · 90 days</td><td>550 DT</td></tr>
            <tr><td>48 sessions · 180 days</td><td>1050 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3 data-i18n="plans.premium">Reformer + Privé — Premium</h3>
          <table class="price-table">
            <tr><td>5R + 3P · 30 days</td><td>290 DT</td></tr>
            <tr><td>7R + 5P · 45 days</td><td>420 DT</td></tr>
            <tr><td>16R + 8P · 90 days</td><td>750 DT</td></tr>
            <tr><td>38R + 10P · 180 days</td><td>1300 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3 data-i18n="plans.integral">Pilates + Musculation — Intégral</h3>
          <table class="price-table">
            <tr><td>1 Month · 8 R</td><td>320 DT</td></tr>
            <tr><td>3 Months · 24 R</td><td>700 DT</td></tr>
            <tr><td>6 Months · 48 R</td><td>1350 DT</td></tr>
            <tr><td>12 Months · 100 R</td><td>2650 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3 data-i18n="plans.privateSessions">Private Sessions</h3>
          <table class="price-table">
            <tr><td>Reformer</td><td>35 DT</td></tr>
            <tr><td>Private (any machine)</td><td>45 DT</td></tr>
            <tr><td>8 Private sessions</td><td>340 DT</td></tr>
          </table>
          <p class="price-note" data-i18n="plans.rpLegend">R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)</p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="banner">
  <div class="banner__bg"><img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?auto=format&fit=crop&w=1600&q=80" alt="" /></div>
  <div class="banner__scrim"></div>
  <div class="wrap banner__inner">
    <div class="barbell barbell--center"><div class="plate small"></div><div class="plate"></div><div class="plate small"></div></div>
    <h2 data-i18n="banner.title">A gym that knows your name</h2>
    <p data-i18n="banner.text">Group classes, a members-only app, and a front desk that remembers your goals — not just your card number.</p>
  </div>
</div>

<section class="locations" id="locations">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="locations.eyebrow">Location</div>
      <h2 data-i18n="locations.title">Find us on the map</h2>
      <p data-i18n="locations.lead">One floor, open early, open late. Drop in whenever training calls.</p>
    </div>
    <div class="loc__grid" style="grid-template-columns:1fr; max-width:840px; margin:0 auto;">
      <div class="loc">
        <div class="loc__media">
          <iframe src="https://www.google.com/maps?q=Eos+gym+fitness+%26+pilates,+Bizerte&output=embed" width="100%" height="100%" style="border:0; display:block;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <div class="loc__pin"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        </div>
        <div class="loc__body">
          <h3>EOS Gym</h3>
          <p class="addr" data-i18n="locations.addr">Fitness &amp; Pilates<br>Bizerte Governorate, Tunisia</p>
          <div class="loc__hours">
            <div><span data-i18n="locations.weekdays">Weekdays</span>6:00a – 10:00p</div>
            <div><span data-i18n="locations.weekends">Weekends</span>8:00a – 8:00p</div>
          </div>
          <a class="loc__link" href="https://www.google.com/maps/place/Eos+gym+%7C+fitness+%26+pilates/@35.7609098,10.8309126,18z/data=!4m6!3m5!1s0x130213328e932abf:0x3764c48c05d7556c!8m2!3d35.7609098!4d10.8322001!16s%2Fg%2F11z22ls4df" target="_blank" rel="noopener" data-i18n="locations.directions">Get Directions
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M7 7h10v10"/></svg>
          </a>
          <div class="loc__socials">
            <a href="https://wa.me/21600000000" target="_blank" rel="noopener" aria-label="WhatsApp" class="soc soc--wa">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.3c1.4.8 3.1 1.3 4.8 1.3 5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.5 0-3-.4-4.2-1.2l-.3-.2-3.1.8.8-3-.2-.3C4.4 15 4 13.5 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8zm4.4-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1-.2.2-.6.8-.8 1-.1.2-.3.2-.5.1-.2-.1-1-.4-2-1.2-.7-.6-1.2-1.4-1.4-1.6-.1-.2 0-.4.1-.5.1-.1.2-.3.4-.4.1-.1.2-.3.2-.4.1-.2 0-.3 0-.5-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.2-.9.9-.9 2.2 0 1.3.9 2.5 1.1 2.7.1.2 1.8 2.8 4.4 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.6.1.5-.1 1.4-.6 1.6-1.1.2-.5.2-1 .1-1.1-.1-.1-.2-.2-.5-.3z"/></svg>
            </a>
            <a href="https://facebook.com/eosfitness" target="_blank" rel="noopener" aria-label="Facebook" class="soc">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
            </a>
            <a href="https://instagram.com/eosfitness" target="_blank" rel="noopener" aria-label="Instagram" class="soc">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="membership" class="cta">
  <div class="barbell barbell--center" style="margin-bottom:22px;"><div class="plate small"></div><div class="plate"></div><div class="plate small"></div></div>
  <h2 data-i18n="cta.title">Your first rep starts here</h2>
  <p data-i18n="cta.text">Create a free account and set up your membership in under a minute — book classes, track workouts, and manage everything from the app.</p>
  <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
</div>

<footer>
  <div class="wrap">
    <div class="foot__grid">
      <div>
        <div class="foot__brand">
          <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;">
        </div>
        <p style="max-width:280px; color:var(--gray); font-size:14px; line-height:1.7;" data-i18n="foot.tagline">Strength, pilates, and group classes across three floors — built for people who actually train.</p>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.explore">Explore</h4>
        <a href="#about" data-i18n="nav.about">About</a>
        <a href="#programs" data-i18n="nav.programs">Programs</a>
        <a href="#locations" data-i18n="nav.locations">Locations</a>
        <a href="#membership" data-i18n="nav.membership">Membership</a>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.account">Account</h4>
        <a href="<?= url('login') ?>" data-i18n="nav.login">Log In</a>
        <a href="<?= url('signup') ?>" data-i18n="nav.join">Join Now</a>
        <a href="#" data-i18n="foot.schedule">Class Schedule</a>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.contact">Contact</h4>
        <p>hello.eosfitness.examplee</p>
        <p>(555) 019-2280</p>
      </div>
    </div>
    <div class="foot__bottom">
      <span data-i18n="foot.rights">© 2026 EOS Fitness &amp; Pilates. All rights reserved.</span>
      <span>Monastir, Tunisia</span>
    </div>
  </div>
</footer>

</div>