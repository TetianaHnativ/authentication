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
  <link rel="stylesheet" href="../styles/admin.css" />
</head>

<body>
  <main>
    <h1 class="main-title admin-title">Адміністратор</h1>
    <div class="buttons">
      <button class="button-add">Додати нового користувача</button>
      <button class="button-change-password">Змінити пароль</button>
    </div>
    <h2 class="edit-title">Для редагування даних натисніть на рядок таблиці</h2>
    <div class="modal-container" id="admin-modal">
      <div id="edit-form" class="container">
        <button class="modal-close-button" id="admin-close-button">x</button>
        <h3 class="modal-title" id="admin-title">Редагування даних</h3>
        <form class="modal-form">
          <label for="name" id="edit-name-label" class="modal-label"></label>
          <input type="hidden" name="name" id="edit-name-input" class="modal-field-input" value="" placeholder="Iм'я користувача">
          <div class="modal-checkbox">
            <label for="blocking" class="modal-label">Блокування облікового запису</label>
            <input type="checkbox" name="blocking" id="edit-blocking" class="modal-field-checkbox">
          </div>
          <div class="modal-checkbox">
            <label for="password-restrictions" class="modal-label">Обмеження на паролі</label>
            <input type="checkbox" name="password-restrictions" id="edit-password-restrictions" class="modal-field-checkbox">
          </div>
          <button class="modal-form-button" onclick='saveChanges()'>Зберегти</button>
        </form>
      </div>
    </div>
    <?php include './databaseAdmin.php' ?>
  </main>
  <script src="../scripts/admin.js"></script>
</body>

</html>