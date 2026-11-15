<div class="auth-body">
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><filter id="eos-logo-light" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="2.1641 0.3112 -2.4753 0 0  1.1641 1.3112 -2.4753 0 0  1.1641 0.3112 -1.4753 0 0  0 0 0 1 0"/></filter></svg>

  <div class="auth">
    <div class="auth__panel auth__panel--full">
      <div class="auth__navbar auth__navbar--split">
        <a class="auth__back" href="<?= url('login') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
          Back
        </a>
        <div class="nav-right">
          <button type="button" class="theme-btn" id="theme-btn" aria-label="Toggle theme"><svg class="i-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M20 14.5A8 8 0 0 1 9.5 4 8 8 0 1 0 20 14.5Z"/></svg><svg class="i-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/></svg></button>
          <a class="auth__navbar-brand" href="<?= url('login') ?>">
          <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" style="height: auto; width: 60px; display: block;">
        </a>
        </div>
      </div>

      <div class="auth__panel-scroll">
        <div class="auth__card">
          <div class="auth__barbell">
            <span class="plate"></span><span class="plate small"></span>
          </div>

          <?php if (!$done): ?><div>
            <div class="auth__head">
              <h1>New password</h1>
              <p>Choose a new password for your account.</p>
            </div>
            <form class="auth-form" novalidate method="post">
              <div class="field">
                <label for="rp-pw">New password</label>
                <div class="field__control">
                  <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                  <input id="rp-pw" name="password" type="password" autocomplete="new-password" required />
                  <button type="button" class="field__toggle" data-for="rp-pw" aria-label="Show password"></button>
                </div>
              </div>
              <div class="field">
                <label for="rp-pw2">Confirm password</label>
                <div class="field__control">
                  <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                  <input id="rp-pw2" name="confirm" type="password" autocomplete="new-password" required />
                  <button type="button" class="field__toggle" data-for="rp-pw2" aria-label="Show password"></button>
                </div>
              </div>
              <span class="field__error<?= $error ? " field__error--show" : "" ?>"><?= h($error) ?></span>
              <button type="submit" class="auth-form__submit" >
                <span class="btn-label">Reset password</span>
              </button>
            </form></div><?php else: ?><div class="auth__head">
            <h1>Password updated</h1>
            <p>You can now log in with your new password.</p>
          </div><?php endif; ?>

          <p class="auth__foot">
            Remembered it? <a href="<?= url('login') ?>">Back to login</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
