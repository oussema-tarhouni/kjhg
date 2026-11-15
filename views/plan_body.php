<div class="plan-tabs">
  <?php foreach ($categories as $c): ?>
    <a class="plan-tab<?= $c['key'] === $activeCat['key'] ? ' plan-tab--active' : '' ?>" href="<?= h(url('select-plan') . '?cat=' . rawurlencode($c['key'])) ?>"><?= h($c['label']) ?></a>
  <?php endforeach; ?>
</div>
<form method="post" action="">
<input type="hidden" name="category" value="<?= h($activeCat['key']) ?>">
<div class="plan-groups">
  <?php foreach ($activeCat['groups'] as $g): ?>
    <div class="plan-group">
      <h3 class="plan-group__title"><?= h($g['title']) ?></h3>
      <?php foreach ($g['tiers'] as $t): $ok = !empty($t['planId']); ?>
        <label class="plan-row<?= $ok ? '' : ' plan-row--disabled' ?>">
          <input type="radio" name="planId" value="<?= h($t['planId']) ?>" <?= !$ok ? 'disabled' : '' ?> <?= $ok && (int)$t['planId'] === $selected ? 'checked' : '' ?>>
          <span class="plan-row__label"><?= h($t['label']) ?></span>
          <span class="plan-row__price"><?= h($t['price']) ?> DT</span>
        </label>
      <?php endforeach; ?>
      <?php if (!empty($g['note'])): ?><p class="plan-group__note"><?= h($g['note']) ?></p><?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<span class="field__error<?= $error ? ' field__error--show' : '' ?>"><?= h($error) ?></span>
