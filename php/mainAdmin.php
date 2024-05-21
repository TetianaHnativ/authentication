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
  <link rel="stylesheet" href="../styles/admin.css" />
</head>

<body>
  <main>
    <h1 class="main-title admin-title">Адміністратор</h1>
    <button class="button-exit" onclick="exitUser()">Вийти</button>
    <div class="buttons">
      <button class="button-add">Додати користувача</button>
      <button class="button-change-password">Змінити пароль</button>
    </div>
    <button class="button-delete" disabled>Видалити користувача</button>

    <h2 class="edit-title">Для редагування даних натисніть на рядок таблиці</h2>

    <div class="modal-container" id="admin-modal">
      <div id="edit-form" class="container">
        <button class="modal-close-button" id="admin-close-button">x</button>
        <h3 class="modal-title" id="admin-title">Модифікація даних</h3>
        <form class="modal-form" id="admin-modal-form">
          <label for="name" id="edit-name-label" class="modal-label"></label>
          <input type="hidden" name="name" id="edit-name-input" class="modal-field-input" value="" placeholder="Iм'я користувача">
          <div class="modal-checkbox">
            <label for="blocking" class="modal-label blocking-label">Блокування облікового запису</label>
            <input type="checkbox" name="blocking" id="edit-blocking" class="modal-field-checkbox">
          </div>
          <div class="modal-checkbox">
            <label for="password-restrictions" class="modal-label password-label">Обмеження на паролі</label>
            <input type="checkbox" name="password-restrictions" id="edit-password-restrictions" class="modal-field-checkbox">
          </div>
          <p class="admin-modal-message"></p>
          <button class="modal-form-button" onclick='saveChanges()'>Зберегти</button>
        </form>
      </div>
    </div>

    <div class="modal-container" id="manager-modal">
      <div id="delete-form" class="container">
        <button class="modal-close-button" id="manager-close-button">x</button>
        <h3 class="modal-title" id="manager-title">Видалення даних</h3>
        <form class="modal-form" id="manager-modal-form">
          <input type="text" name="name" id="manager-name-input" class="modal-field-input" value="" placeholder="Iм'я користувача">
          <p class="admin-modal-message" id="delete-message"></p>
          <button class="modal-form-button" id="modal-delete-button" onclick="Delete()">Видалити</button>
        </form>
      </div>
    </div>

    <div class="modal-container" id="password-modal">
      <div id="change-password-form" class="container">
        <button class="modal-close-button" id="user-close-button">x</button>
        <h3 class="modal-title" id="user-title">Зміна паролю</h3>
        <form class="modal-form" id="password-form">
          <input id="old-password" type="password" class="modal-field-input" name="oldPassword" placeholder="Старий пароль" minlength="8" required />
          <input id="new-password" type="password" class="modal-field-input" name="newPassword" placeholder="Новий пароль" minlength="8" required />
          <input id="modal-password-confirm" type="password" class="modal-field-input" name="passwordConfirm" placeholder="Підтвердьте пароль" minlength="8" required />
          <p class="modal-message"></p>
          <button class="modal-form-button">Зберегти</button>
        </form>
      </div>
    </div>
    <?php include './passwordRestrictions.php' ?>
    <?php include './changePassword.php' ?>
    <?php include './databaseAdmin.php' ?>
  </main>
  <script src="../scripts/user.js"></script>
  <script src="../scripts/admin.js"></script>
</body>

</html>