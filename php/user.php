<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="../styles/index.css" />
  <link rel="stylesheet" href="../styles/user.css" />
</head>

<body>
  <main>
    <h1 class="main-title">Аутентифікація</h1>
    <form action="" class="data-form">
      <input id="username" type="text" class="input-field" name="username" placeholder="Введіть ім'я" required />
      <input id="password-input" type="password" class="input-field" name="password" placeholder="Введіть пароль" minlength="8" required />
      <input id="password-confirm" type="password" class="input-field" name="passwordConfirm" placeholder="Підтвердьте пароль" minlength="8" disabled />
      <p class="message"></p>
      <button type="submit" class="button-submit">Увійти</button>
    </form>
    <?php include './database.php' ?>
    <?php include './passwordRestrictions.php' ?>
  </main>
  <script src="../scripts/user.js"></script>
</body>

</html>