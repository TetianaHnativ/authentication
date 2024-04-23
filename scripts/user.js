//document.querySelector(".main-title").textContent = sessionStorage.getItem("main-title");

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

function gaps(event) {
  if (event.target.value.includes(" ")) {
    event.target.value = event.target.value.replace(/\s/g, "");
  }
}

adminForm.addEventListener("input", gaps);

function checkCharacters(form) {
  const regex = /^(?=.*[a-zA-Zа-яА-ЯіїєІЇЄ])(?=.*[+\-*\/]).+$/;
  if (regex.test(passwordInput.value)) {
    if (
      passwordConfirm.disabled === false &&
      passwordInput.value !== passwordConfirm.value
    ) {
      message.textContent = "Паролі не співпадають!";
    } else {
      message.textContent = "";

      const formData = {
        username: form.username.value,
        password: form.password.value,
      };

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
          if (data.trim() === "registration admin") {
            passwordConfirm.disabled = false;
          }
          if (data.trim() === "registration user") {
            passwordConfirm.disabled = false;
          } else if (data.trim() === "admin") {
            window.location.href = "mainAdmin.php";
          } else if (data.trim() === "user") {
            window.location.href = "mainUser.php";
          } else {
            message.textContent = data;
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
