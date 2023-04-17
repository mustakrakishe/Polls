<?php $title = 'Personal'; ?>

<?php 
  include join(DIRECTORY_SEPARATOR, [
    __DIR__,
    '..',
    'layout',
    'header.php',
  ]);
?>

<h1 class="h3 mb-3 fw-normal">Personal</h1>

<?php if (isset($parameters['token'])): ?>
  <div class="alert alert-warning" role="alert">
    <p>Your personal api token:</p>
    <p><?= $parameters['token'] ?></p>
    <p>Set a "token" query parameter with it to authorize your api actions.</p>
    <p>Store it, cause you will never see it again. You can only refresh it on a personal page.</p>
  </div>
<?php endif; ?>

<?php 
  include join(DIRECTORY_SEPARATOR, [
    __DIR__,
    '..',
    'layout',
    'footer.php',
  ]);
?>