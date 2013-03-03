function redirect(location) {
    window.location.href = "/" + location;
}

$(document).ready(function() {
    $('#registerBtn').click(function() {
        redirect('register');
    });
    $('#loginBtn').click(function() {
        redirect('login');
    });
});