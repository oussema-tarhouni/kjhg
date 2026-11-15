<div class="auth-body">
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><filter id="eos-logo-light" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="2.1641 0.3112 -2.4753 0 0  1.1641 1.3112 -2.4753 0 0  1.1641 0.3112 -1.4753 0 0  0 0 0 1 0"/></filter></svg>

<div class="auth">
  <div class="auth__visual" id="auth-visual">
    <div class="auth__scrim"></div>
    <div class="auth__visual-content">
      <a class="auth__brand" href="<?= url('') ?>"><img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;"></a>
      <div class="auth__caption">
        <p class="auth__caption-eyebrow">Last step</p>
        <h2>Pick your membership</h2>
        <p>Choose the plan that fits your goals.</p>
      </div>
    </div>
  </div>

  <div class="auth__panel">
    <button type="button" class="theme-btn" id="theme-btn" aria-label="Toggle theme">
      <svg class="i-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M20 14.5A8 8 0 0 1 9.5 4 8 8 0 1 0 20 14.5Z"/></svg>
      <svg class="i-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/></svg>
    </button>
    <div class="auth__navbar">
      <a class="auth__navbar-brand" href="<?= url('') ?>"><img src="<?= BASE ?>/assets/logo.svg" alt="EOS"></a>
    </div>

    <div class="auth__panel-scroll">
    <div class="auth__card">
      <div class="auth__head">
        <h1>Choose your plan</h1>
        <p>Membership is activated once the admin approves your account</p>
      </div>

      <?php include __DIR__ . "/plan_body.php"; ?><button type="submit" class="auth-form__submit" id="plan-continue">
        <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-9-9"/></svg>
        <span class="btn-label">Confirm & Submit</span>
      </button></form>
    </div>
    </div>
  </div>
</div>
</div>
