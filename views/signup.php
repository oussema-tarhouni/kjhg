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
        <p class="auth__caption-eyebrow" id="auth-caption-eyebrow">Get started</p>
        <h2 id="auth-caption-title">Your first rep starts here</h2>
        <p id="auth-caption-text">Create a free account and set up your membership in under a minute.</p>
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
        <h1>Create your account</h1>
        <p>Join EOS to book classes, message your trainer, and track your progress. Already a member? <a href="<?= url('login') ?>">Log in</a></p>
      </div>

      <form class="auth-form" id="signup-form">
        <div class="field">
          <label for="su-name">Full name</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.25"/><path d="M5 20a7 7 0 0 1 14 0"/></svg>
            <input type="text" id="su-name" name="name" placeholder="Sarah Aziz" required autocomplete="name" />
          </div>
        </div>

        <div class="field">
          <label for="su-email">Email</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
            <input type="email" id="su-email" name="email" placeholder="you@example.com" required autocomplete="email" />
          </div>
        </div>

        <div class="field">
          <label for="su-phone">Phone number</label>
          <div class="field__control field__control--phone">
            <span class="field__prefix">+216</span>
            <input type="tel" id="su-phone" name="phone" placeholder="20 123 456" required maxlength="8" inputmode="numeric" pattern="[0-9]{8}" autocomplete="tel-national" />
          </div>
          <span class="field__error" id="phone-error">Enter a valid 8-digit Tunisian number</span>
        </div>

        <div class="field field--password">
          <label for="su-password">Password</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            <input type="password" id="su-password" name="password" placeholder="Create a password" required minlength="8" autocomplete="new-password" />
            <button type="button" class="field__toggle" data-for="su-password" aria-label="Show password"></button>
          </div>
          <div class="strength">
            <div class="strength__bar"></div>
            <div class="strength__bar"></div>
            <div class="strength__bar"></div>
            <div class="strength__bar"></div>
          </div>
          <span class="field__hint" id="strength-label">Use 8+ characters with a mix of letters, numbers &amp; symbols</span>
        </div>

        <div class="field field--password">
          <label for="su-confirm">Confirm password</label>
          <div class="field__control">
            <svg class="field__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            <input type="password" id="su-confirm" name="confirm" placeholder="Re-enter your password" required autocomplete="new-password" />
            <button type="button" class="field__toggle" data-for="su-confirm" aria-label="Show password"></button>
          </div>
          <span class="field__error" id="confirm-error">Passwords don't match</span>
        </div>

        <label class="checkbox">
          <input type="checkbox" name="terms" required />
          <span class="checkbox__box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
          </span>
          <span>I agree to EOS Fitness &amp; Pilates' <a href="<?= url('terms') ?>">Terms of Service</a> and <a href="<?= url('privacy') ?>">Privacy Policy</a></span>
        </label>

        <button type="submit" class="auth-form__submit" id="signup-submit">
          <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-9-9"/></svg>
          <span class="btn-label">Create Account</span>
        </button>
      </form>

      <form class="auth-form otp-form" id="otp-form" style="display:none;">
        <p class="otp-intro">Enter the 6-digit code sent to <b id="otp-phone-display"></b></p>
        <div class="field">
          <label for="otp-code">Verification code</label>
          <div class="field__control">
            <input type="text" id="otp-code" name="otp" placeholder="123456" required maxlength="6" inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code" />
          </div>
          <span class="field__error" id="otp-error">Incorrect code, try again</span>
        </div>
        <button type="submit" class="auth-form__submit" id="otp-submit">
          <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-9-9"/></svg>
          <span class="btn-label">Verify &amp; Create Account</span>
        </button>
        <p class="otp-resend">Didn't get it? <a href="#" id="otp-resend">Resend code</a></p>
      </form>

      <div class="signup-success" id="signup-success" style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
        <h2>Account created!</h2>
        <p>Redirecting you to log in…</p>
      </div>


    </div>
    </div>
  </div>

</div>

</div>

<style>
#auth-slide-layer,#auth-dots{display:none!important}
#eos-slides{position:absolute;inset:0;overflow:hidden}
#eos-slides i{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.2s ease}
#eos-slides i.on{opacity:1}
#eos-dots{display:flex;gap:8px;margin-top:18px}
#eos-dots b{width:8px;height:8px;border-radius:99px;background:rgba(255,255,255,.4);transition:all .3s}
#eos-dots b.on{width:24px;background:var(--gold)}
</style>
<script>
(function(){
var B="<?= BASE ?>/assets/gym/pilates-",N=[5,2,8];
var v=document.getElementById('auth-visual'),l=document.getElementById('auth-slide-layer'),d=document.getElementById('auth-dots');
if(!v||!l)return;
var w=document.createElement('div');w.id='eos-slides';
w.innerHTML=N.map(function(n){return '<i style="background-image:url('+B+n+'.jpg)"></i>'}).join('');
l.parentNode.insertBefore(w,l.nextSibling);
var dd=document.createElement('div');dd.id='eos-dots';dd.innerHTML=N.map(function(){return '<b></b>'}).join('');
if(d)d.parentNode.insertBefore(dd,d.nextSibling);
var s=w.children,p=dd.children,k=0;
var C=[["Pilates","Retrouvez équilibre et force","Un studio reformer lumineux, avec des coachs attentifs à chaque mouvement."],["Reformer","Des séances qui vous ressemblent","Reformer, Cadillac, Wunda Chair ou Barrel : choisissez votre appareil."],["Studio","Un espace pensé pour vous","Petits groupes, ambiance calme, ouvert tous les jours de 8h à 22h."]];
var cap=document.querySelector('.auth__caption'),o=['auth-caption-eyebrow','auth-caption-title','auth-caption-text'].map(function(i){return document.getElementById(i)}),n=[];
o.forEach(function(e,i){if(!e)return;e.style.display='none';var c=document.createElement(e.tagName);c.className=e.className;c.style.transition='opacity .35s';e.parentNode.insertBefore(c,e);n[i]=c});
function go(){var t=C[k%C.length];n.forEach(function(c){c.style.opacity=0});
for(var j=0;j<s.length;j++){s[j].className=j==k?'on':'';p[j].className=j==k?'on':''}
setTimeout(function(){n.forEach(function(c,i){c.textContent=t[i];c.style.opacity=1})},350);k=(k+1)%s.length}
go();setInterval(go,5000);
})();
</script>
