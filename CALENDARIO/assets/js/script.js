document.querySelector("#show-login").addEventListener("click",function(){
    document.querySelector(".popup").classList.add("active");
    document.getElementById("fondo-negro").style.display = "flex";
    $('html,body').css('overflow', 'hidden');
});
document.querySelector(".popup .close-btn").addEventListener("click",function(){
    document.querySelector(".popup").classList.remove("active");
    document.getElementById("fondo-negro").style.display = "none";
    $("html, body").css("overflow","auto");
});
//cerrar ventana de login haciendo click fuera
document.querySelector("#fondo-negro").addEventListener("click",function(){
    document.querySelector(".popup").classList.remove("active");
    document.getElementById("fondo-negro").style.display = "none";
    $("html, body").css("overflow","auto");
});

//cerrar la ventana de login con la tecla escape
window.addEventListener("keyup",function(e){
    if(e.keyCode==27) {
        document.querySelector(".popup").classList.remove("active");
        document.getElementById("fondo-negro").style.display = "none";
        $("html, body").css("overflow","auto");
    }
});
