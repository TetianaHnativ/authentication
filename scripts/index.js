const admin = document.getElementById("admin");
const user = document.getElementById("user");

admin.addEventListener("click", () => {
    sessionStorage.setItem("main-title", "Увійти як адміністратор");
})

user.addEventListener("click", () => {
    sessionStorage.setItem("main-title", "Увійти");
})

