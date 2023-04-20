let togglePassword = document.getElementById("togglePassword");
let password = document.getElementById("input_password");
let isMobile = false;

if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i)) {
    isMobile = true;
    let loginBlock = document.getElementById('loginBox');
    IncreaseSize(loginBlock);
}

togglePassword.addEventListener('click', function() {
    let type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
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