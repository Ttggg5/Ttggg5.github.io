let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");

togglePassword.addEventListener("click", PasswordChangeType);

function PasswordChangeType(){
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute("type", type);
}