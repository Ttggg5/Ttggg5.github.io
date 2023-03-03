function gotoYoutube(){
    window.open("https://www.youtube.com/@hololive").focus();
}

function gotoTwitter(){
    window.open("https://twitter.com/hololivetv").focus();
}

function gotoFacebook(){
    window.open("https://www.facebook.com/hololivetv/").focus();
}

function resize(){
    document.getElementById("soraGif").width = window.innerWidth - 600;
    document.getElementById("gura").width = window.innerWidth - 800;
    let blue = document.getElementById("blueBlock");
    if(window.innerWidth < 700)
        document.getElementById("mainText").style.fontSize = "180%";
    else
        document.getElementById("mainText").style.fontSize = "330%";

    if(window.innerWidth < 800)
        blue.style.setProperty("--blueBlockHeight", "200px");
    else if(window.innerWidth < 950)
        blue.style.setProperty("--blueBlockHeight", "300px");
    else
        blue.style.setProperty("--blueBlockHeight", "400px");
}

window.onresize = resize;
resize();