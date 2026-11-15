<?php
$sections = json_decode(file_get_contents(__DIR__ . '/../data/terms.json'), true);
layout_begin('Terms of Service · EOS Gym', ['legal']);
?>
    <div class="legal-page">
      <button type="button" class="theme-btn" aria-label="Toggle theme" id="theme-btn"><svg class="i-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M20 14.5A8 8 0 0 1 9.5 4 8 8 0 1 0 20 14.5Z"/></svg><svg class="i-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5L19 19M5 19l1.5-1.5M17.5 6.5L19 5"/></svg></button>
      <div class="legal-card">
        <a href="<?= url('signup') ?>" class="legal-back">← Back</a>
        <h1>Terms of Service</h1>
        <p class="legal-updated">Last updated: August 2026</p>

        <?php foreach ($sections as $s): ?><h2><?= h($s["title"]) ?></h2><p><?= h($s["body"]) ?></p><?php endforeach; ?>
      </div>
    </div>
  <?php theme_script(); layout_end();
