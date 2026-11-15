<div class="auth-body">
  <div class="auth">
    <div class="auth__panel auth__panel--full">
      <div class="auth__navbar auth__navbar--split">
        <a class="auth__back" href="<?= url('login') ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
          Back
        </a>
        <a class="auth__navbar-brand" href="<?= url('login') ?>">
          <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" style="height: auto; width: 60px; display: block;">
        </a>
      </div>

      <div class="auth__panel-scroll">
        <div class="auth__card">
          <div class="auth__barbell">
            <span class="plate"></span><span class="plate small"></span>
          </div>

          <div class="auth__head">
            <h1>Verify your phone</h1>
            <p>We sent a 6-digit code to <strong id="otp-phone-display"></strong></p>
          </div>

          <form id="otp-form" class="auth-form" novalidate>
            <div class="field">
              <label for="otp-code">Verification code</label>
              <div class="field__control">
                <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
                <input id="otp-code" type="text" inputmode="numeric" maxlength="6" placeholder="000000" autocomplete="one-time-code" required />
              </div>
              <div id="otp-error" class="field__error"></div>
            </div>

            <button id="otp-submit" type="submit" class="auth-form__submit">
              <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="9" stroke-opacity=".25"/><path d="M21 12a9 9 0 0 0-9-9"/></svg>
              <span class="btn-label">Verify</span>
            </button>
          </form>

          <div class="auth-form__row">
            <span>Didn't get it? Check spam or <a href="#" id="otp-resend">Resend code</a></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
