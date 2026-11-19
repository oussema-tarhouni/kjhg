<div class="gate-shell">
  <form class="gate-card" method="post">
    <h2>Admin Access</h2>
    <label>Username
      <input value="<?= h($username) ?>" name="username" required />
    </label>
    <label>Password
      <input type="password" value="<?= h($password) ?>" name="password" required />
    </label>
    <?php if ($error): ?><p class="gate-error"><?= h($error) ?></p><?php endif; ?>
    <button type="submit" >Continue</button>
  </form>
</div>