<?php $title = 'Register'; ?>

<?php include('Views/layout/header.php'); ?>

<div class="text-center">
  <div class="w-100 m-auto" style="max-width: 300px;">
    <form>
      <h1 class="h3 mb-3 fw-normal">Please login</h1>

      <div class="form-floating mb-1">
        <input type="email" class="form-control" id="floatingInput" placeholder=" " required>
        <label for="floatingInput">Email address</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" placeholder=" " required>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
  </div>
</div>

<?php include('Views/layout/footer.php'); ?>