<?php $title = 'Login'; ?>

<?php 
  include join(DIRECTORY_SEPARATOR, [
    __DIR__,
    '..',
    'layout',
    'header.php',
  ]);
?>

<div class="text-center">
  <div class="w-100 m-auto" style="max-width: 300px;">
    <form action="/login" method="post">
      <h1 class="h3 mb-3 fw-normal">Please login</h1>

      <div class="form-floating mb-3">
        <input
          type="string"
          class="form-control <?php if (isset($_SESSION['errors']['email'])) echo ' is-invalid'; ?>"
          id="floatingInput"
          placeholder=" "
          name="email"
          <?php if (isset($_SESSION['old']['email'])): ?>
            value="<?= $_SESSION['old']['email'] ?>"
            <?php unset($_SESSION['old']['email']); ?>
          <?php endif; ?>
        >
        <label for="floatingInput">Email address</label>
        <?php if (isset($_SESSION['errors']['email'])): ?>
          <?php foreach($_SESSION['errors']['email'] as $error): ?>
            <div class="invalid-feedback text-start"><?= $error ?></div>
          <?php endforeach; ?>
          <?php unset($_SESSION['errors']['email']); ?>
        <?php endif; ?>
      </div>

      <div class="form-floating mb-3">
        <input
          type="password"
          class="form-control <?php if (isset($_SESSION['errors']['password'])) echo 'is-invalid'; ?>"
          id="floatingPassword"
          placeholder=" "
          name="password"
          <?php if (isset($_SESSION['old']['password'])): ?>
            value="<?= $_SESSION['old']['password'] ?>"
            <?php unset($_SESSION['old']['password']); ?>
          <?php endif; ?>
        >
        <label for="floatingPassword">Password</label>
        <?php if (isset($_SESSION['errors']['password'])): ?>
          <?php foreach ($_SESSION['errors']['password'] as $error): ?>
            <div class="invalid-feedback text-start"><?= $error ?></div>
          <?php endforeach; ?>
          <?php unset($_SESSION['errors']['password']); ?>
        <?php endif; ?>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
    </form>
  </div>
</div>

<?php 
  include join(DIRECTORY_SEPARATOR, [
    __DIR__,
    '..',
    'layout',
    'footer.php',
  ]);
?>