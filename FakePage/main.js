let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");
let loginBtn = document.getElementById("loginBtn");
let isMobile = false;

if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i)) {
    isMobile = true;
    let loginBlock = document.getElementById('loginBox');
    MobileStyle(loginBlock);
}

togglePassword.addEventListener('click', function (e){
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

loginBtn.addEventListener('mousedown', function (e){
    loginBtn.style.margin = '22px 0 0 0';
});

loginBtn.addEventListener('mouseup', function (e){
    loginBtn.style.margin = '20px 0 2px 0';
});

window.addEventListener('resize', Resize);

function Resize(){
    let viewport_width = window.innerWidth;
    let loginBlock = document.getElementById('loginBox');
    if (isMobile || viewport_width <= 540)
        MobileStyle(loginBlock);
    else
        DesktopStyle(loginBlock);
}

function MobileStyle(loginBlock){
    document.querySelector("link[href='styleComputer.css']").href = "styleMobile.css";

}

function DesktopStyle(loginBlock){
    document.querySelector("link[href='styleMobile.css']").href = "styleComputer.css";
}

Resize();