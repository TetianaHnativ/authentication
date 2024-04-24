//document.querySelector(".main-title").textContent = sessionStorage.getItem("main-title");
let regex = /^(?=.*[a-zA-Zа-яА-ЯіїєІЇЄ])(?=.*[+\-*\/]).+$/;

let count = 0;

const currentPageURL = window.location.href;
const targetURL = "user.php";

function gaps(event) {
  if (event.target.value.includes(" ")) {
    event.target.value = event.target.value.replace(/\s/g, "");
  }
}

function exitUser() {
  window.location.href = "/Authentication/";
  sessionStorage.clear();
}

async function passwordsRestrictions(formData) {
  try {
    const response = await fetch("../php/passwordRestrictions.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    });
    const data = await response.text();
    if (data.trim() === "password_restrictions") {
      regex = /^(?=.*[a-zA-Zа-яА-ЯіїєІЇЄ])(?=.*[+\-*\/]).+$/;
      //console.log(regex);
    } else if (data.trim() === "without_restrictions") {
      regex = /./;
      // console.log(regex);
    }
    return regex;
  } catch (error) {
    console.error("Помилка:", error);
    throw error;
  }
}

if (currentPageURL.indexOf(targetURL) !== -1) {
  const adminForm = document.querySelector(".data-form");

  const username = document.getElementById("username");

  const passwordInput = document.getElementById("password-input");

  const passwordConfirm = document.getElementById("password-confirm");

  const message = document.querySelector(".message");

  window.addEventListener("unload", function () {
    username.value = "";
    passwordInput.value = "";
    passwordConfirm.value = "";
    passwordConfirm.disabled = true;
  });

  adminForm.addEventListener("submit", (e) => {
    e.preventDefault();
    checkCharacters(adminForm);
  });

  adminForm.addEventListener("input", gaps);

  async function checkCharacters(form) {
    const formData = {
      username: form.username.value,
      password: form.password.value,
      passwordConfirm: form.passwordConfirm.value,
    };

    await passwordsRestrictions(formData);

    if (regex.test(passwordInput.value)) {
      if (
        passwordConfirm.disabled === false &&
        passwordInput.value !== passwordConfirm.value
      ) {
        message.textContent = "Паролі не співпадають!";
      } else {
        message.textContent = "";

        // Відправляємо дані на сервер за допомогою fetch
        fetch("../php/database.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
        })
          .then((response) => response.text())
          .then((data) => {
            if (data.trim() === "registration") {
              passwordConfirm.disabled = false;
            } else if (
              data.trim() === "registration admin" ||
              data.trim() === "admin"
            ) {
              sessionStorage.setItem(
                "username",
                JSON.stringify(formData.username)
              );
              window.location.href = "mainAdmin.php";
            } else if (
              data.trim() === "registration user" ||
              data.trim() === "user"
            ) {
              sessionStorage.setItem(
                "username",
                JSON.stringify(formData.username)
              );
              window.location.href = "mainUser.php";
            } else {
              message.textContent = data;
              if (count === 2) {
                exitUser();
              } else {
                count++;
              }
            }
          })
          .catch((error) => {
            console.error("Помилка:", error);
          });
      }
    } else {
      message.textContent =
        "Пароль має містити букви та знаки арифметичних операцій";
    }
  }
} else {
  //Зміна паролю
  const passwordModal = document.getElementById("password-modal");
  const userCloseButton = document.getElementById("user-close-button");
  const passwordForm = document.getElementById("password-form");

  const buttonChangePassword = document.querySelector(
    ".button-change-password"
  );

  const oldPassword = document.getElementById("old-password");
  const newPassword = document.getElementById("new-password");
  const passwordConfirm = document.getElementById("modal-password-confirm");

  const modalMessage = document.querySelector(".modal-message");

  userCloseButton.addEventListener("click", function () {
    passwordModal.style.display = "none";
    passwordForm.submit(); // Відправляємо форму
  });

  passwordForm.addEventListener("input", gaps);

  passwordForm.addEventListener("submit", (e) => {
    e.preventDefault();
    passwordChange(passwordForm);
  });

  buttonChangePassword.addEventListener("click", () => {
    passwordModal.style.display = "flex";
  });

  async function passwordChange(form) {
    const formData = {
      username: JSON.parse(sessionStorage.getItem("username")),
      oldPassword: form.oldPassword.value,
      newPassword: form.newPassword.value,
      passwordConfirm: form.passwordConfirm.value,
    };

    await passwordsRestrictions(formData);
    if (regex.test(newPassword.value)) {
      // Відправляємо дані на сервер за допомогою fetch
      fetch("../php/changePassword.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.trim() === "success") {
            modalMessage.textContent = "";
            passwordForm.submit(); // Відправляємо форму
            passwordModal.style.display = "none";
          } else {
            modalMessage.textContent = data;
            //console.log(data.trim());
          }
        })
        .catch((error) => {
          console.error("Помилка:", error);
        });
    } else {
      modalMessage.textContent =
        "Пароль має містити букви та знаки арифметичних операцій";
    }
  }
}
