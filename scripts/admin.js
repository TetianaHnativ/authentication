// Модальне вікно
const adminModal = document.getElementById("admin-modal");
const adminCloseButton = document.getElementById("admin-close-button");
const adminTitle = document.getElementById("admin-title");
const formAdmin = document.querySelector(".modal-form");

const nameEditLabel = document.getElementById("edit-name-label");
const nameEdit = document.getElementById("edit-name-input");
const blockingEdit = document.getElementById("edit-blocking");
const passwordRestrictionsEdit = document.getElementById(
  "edit-password-restrictions"
);

const buttonAdd = document.querySelector(".button-add");

adminCloseButton.addEventListener("click", function () {
  adminModal.style.display = "none";
  formAdmin.submit(); // Відправляємо форму
});

function gaps(event) {
  if (event.target.value.includes(" ")) {
    event.target.value = event.target.value.replace(/\s/g, "");
  }
}

formAdmin.addEventListener("input", gaps);

function editUser(row) {
  // Отримати дані з рядка таблиці
  let cells = row.cells;
  let name = cells[0].innerText;
  let blocking = cells[1].innerText;
  let passwordRestrictions = cells[2].innerText;

  blockingEdit.checked = blocking === "true";
  passwordRestrictionsEdit.checked = passwordRestrictions === "true";

  nameEditLabel.innerText = name;
  blockingEdit.value = blocking;
  passwordRestrictionsEdit.value = passwordRestrictions;

  adminModal.style.display = "flex";
}

formAdmin.addEventListener("submit", (e) => {
  adminModal.style.display = "none";
});

buttonAdd.addEventListener("click", () => {
  adminModal.style.display = "flex";
  nameEdit.type = "text";
});

function saveChanges() {
  if (nameEdit.type === "text" && !nameEdit.value) {
    alert("Будь ласка, введіть ім'я користувача.");
    return;
  }
  let name = nameEditLabel.textContent || nameEdit.value;
  let blocking = blockingEdit.checked;
  let passwordRestrictions = passwordRestrictionsEdit.checked;

  let data = {
    name: name,
    blocking: blocking,
    password_restrictions: passwordRestrictions,
  };

  // Виконуємо запит типу POST за допомогою Fetch API
  fetch("../php/databaseAdmin.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          "Сталася помилка при збереженні змін: " + response.statusText
        );
      }
      return response.json(); // Повертаємо результат у форматі JSON
    })
    .then((data) => {
      // Виводимо повідомлення про успішне збереження
      alert(JSON.stringify(data));
    })
    .catch((error) => {
      // Виводимо повідомлення про помилку
      alert(error.message);
    });
}
