let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");
let isMoblie = false;

if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i)) {
    isMoblie = true;
    let loginBlock = document.getElementById('loginBox');
    IncreaseSize(loginBlock);
}

togglePassword.addEventListener('click', function() {
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

window.addEventListener('resize', function() {
    let viewport_width = window.innerWidth;
    let loginBlock = document.getElementById('loginBox');
    if (!isMoblie && viewport_width <= 540)
        IncreaseSize(loginBlock);
    else
        DecreaseSize(loginBlock);
});

function IncreaseSize(loginBlock){
    loginBlock.style.width = '100%';
    loginBlock.style.height = 'auto';
    loginBlock.style.margin = '0 auto 0 auto';
    loginBlock.style.padding = '100px 24px 40px 0px';
}

function  DecreaseSize(loginBlock){
    loginBlock.style.width = '312px';
    loginBlock.style.height = '100%';
    loginBlock.style.marginTop = '8rem auto 300 auto';
    loginBlock.style.padding = '36px 24px 36px 24px';
}