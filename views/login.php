<div class="auth-body">
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><filter id="eos-logo-light" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="2.1641 0.3112 -2.4753 0 0  1.1641 1.3112 -2.4753 0 0  1.1641 0.3112 -1.4753 0 0  0 0 0 1 0"/></filter></svg>

<div class="auth">

  <div class="auth__visual" id="auth-visual">
    <div class="auth__slide-layer" id="auth-slide-layer"></div>
    <div class="auth__scrim"></div>
    <div class="auth__visual-content">
      <a class="auth__brand" href="<?= url('') ?>">
      <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;">
      </a>

      <div class="auth__caption">
        <p class="auth__caption-eyebrow" id="auth-caption-eyebrow">Strength</p>
        <h2 id="auth-caption-title">Train like the work actually matters</h2>
        <p id="auth-caption-text">Free weights, machines, and a floor built for serious lifting — open early, open late.</p>
        <div class="auth__dots" id="auth-dots"></div>
      </div>
    </div>
  </div>

  <div class="auth__panel">
    <button type="button" class="theme-btn" id="theme-btn" aria-label="Toggle theme">
      <svg class="i-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M20 14.5A8 8 0 0 1 9.5 4 8 8 0 1 0 20 14.5Z"/></svg>
      <svg class="i-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/></svg>
    </button>
    <div class="auth__navbar">
      <a class="auth__navbar-brand" href="<?= url('') ?>">
        <img src="<?= BASE ?>/assets/logo.svg" alt="EOS">
      </a>
    </div>

    <div class="auth__panel-scroll">
    <div class="auth__card">

      <div class="auth__barbell">
        <div class="plate small"></div><div class="plate"></div><div class="plate small"></div>
      </div>

      <div class="auth__head">
        <h1>Welcome back</h1>
        <p>Log in to book classes, track your membership, and keep training. New here? <a href="<?= url('signup') ?>">Create an account</a></p>
      </div>

      <form class="auth-form" id="login-form">
        <div id="login-error" style="display:none; color:#e5484d; margin-bottom:12px; font-size:14px;"></div>
        <div class="field">
          <label for="login-email">Email</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
            <input type="email" id="login-email" name="email" placeholder="you@example.com" required autocomplete="email" />
          </div>
        </div>

        <div class="field field--password">
          <label for="login-password">Password</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            <input type="password" id="login-password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <button type="button" class="field__toggle" data-for="login-password" aria-label="Show password"></button>
          </div>
        </div>

        <div class="auth-form__row">
          <label class="checkbox">
            <input type="checkbox" name="remember" checked />
            <span class="checkbox__box">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
            </span>
            Remember me
          </label>
          <a href="/forgot-password">Forgot password?</a>
        </div>

        <button type="submit" class="auth-form__submit" id="login-submit">
          <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-9-9"/></svg>
          <span class="btn-label">Log In</span>
        </button>
      </form>


    </div>
    </div>
  </div>

</div>
</div>