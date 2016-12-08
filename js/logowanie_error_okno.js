var okno = document.getElementById('index_logowanie_error_body');

okno.style.display = "block";

window.onclick = function(event) {
    if (event.target == okno) {
        okno.style.display = "none";
    }
}
setTimeout(function() {
    $('#index_logowanie_error_body').fadeOut('fast');
}, 3000); // <-- time in milliseconds
