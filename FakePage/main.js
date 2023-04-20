let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");

togglePassword.addEventListener('click', function (){
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

window.addEventListener('resize', function() {
    let viewport_width = window.innerWidth;
    let loginBlock = document.getElementById('loginBox');
    if (viewport_width <= 540){
        loginBlock.style.width = '100%';
        loginBlock.style.height = 'auto';
        loginBlock.style.marginTop = '0';
        loginBlock.style.padding = '36px 24px 36px 0px';
    }
    else{
        loginBlock.style.width = '312px';
        loginBlock.style.height = '100%';
        loginBlock.style.marginTop = '8rem';
        loginBlock.style.padding = '36px 24px 36px 24px';
    }
});