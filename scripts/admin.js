const adminUser = JSON.parse(sessionStorage.getItem("username"));

const buttonAdd = document.querySelector(".button-add");
const buttonDelete = document.querySelector(".button-delete");

if (adminUser === "MANAGER") {
  buttonDelete.disabled = false;
} else {
  buttonDelete.disabled = true;
}

// Модальне вікно
const adminModal = document.getElementById("admin-modal");
const adminCloseButton = document.getElementById("admin-close-button");
const adminTitle = document.getElementById("admin-title");
const formAdmin = document.getElementById("admin-modal-form");

const nameEditLabel = document.getElementById("edit-name-label");
const nameEdit = document.getElementById("edit-name-input");
const blockingEdit = document.getElementById("edit-blocking");
const passwordRestrictionsEdit = document.getElementById(
  "edit-password-restrictions"
);

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

// Модальне вікно для видалення
const managerModal = document.getElementById("manager-modal");
const managerCloseButton = document.getElementById("manager-close-button");
const formManager = document.getElementById("manager-modal-form");
const nameDelete = document.getElementById("manager-name-input");
const modalDeleteButton = document.getElementById("modal-delete-button");

managerCloseButton.addEventListener("click", function () {
  managerModal.style.display = "none";
  formManager.submit(); // Відправляємо форму
});
managerModal.addEventListener("input", gaps);

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

buttonDelete.addEventListener("click", () => {
  managerModal.style.display = "flex";
});

function Delete() {
  if (!nameDelete.value) {
    alert("Будь ласка, введіть ім'я користувача.");
    return;
  }

  let data = {
    name: nameDelete.value,
  };

  // Виконуємо запит типу POST за допомогою Fetch API
  fetch("../php/deleteUser.php", {
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
      return response.json();
    })
    .then((data) => {
      alert(JSON.stringify(data));
    })
    .catch((error) => {
      alert(error.message);
    });
}

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
      return response.json();
    })
    .then((data) => {
      alert(JSON.stringify(data));
    })
    .catch((error) => {
      alert(error.message);
    });
}
