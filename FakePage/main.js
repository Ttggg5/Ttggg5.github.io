let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");

togglePassword.addEventListener("click", function (){
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute("type", type);
    this.classList.toggle('fa-eye-slash');
});