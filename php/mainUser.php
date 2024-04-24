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
        <h1 class="main-title">Користувач</h1>
        <div class="buttons">
            <button class="button-change-password">Змінити пароль</button>
            <button class="button-exit" onclick="exitUser()">Вийти</button>
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
    </main>
    <script src="../scripts/user.js"></script>
</body>

</html>