<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    const rightNavbar = document.getElementById('right-navbar');
    const userNavbar = document.getElementById('user-navbar');
    const userNameSpan = document.getElementById('user-name');
    const logoutBtn = document.getElementById('logout-btn');

    if (token) {
        if (rightNavbar) rightNavbar.style.setProperty('display', 'none', 'important');
        if (userNavbar) userNavbar.style.setProperty('display', 'block', 'important');

        user = JSON.parse(localStorage.getItem('user')).data;
        userNameSpan.textContent = user.surname + " " + user.name;

        if (logoutBtn) {
            logoutBtn.onclick = function(e) {
                e.preventDefault();
                localStorage.removeItem('token');
                window.location.reload();
            }
        }
    } else {
        if (rightNavbar) rightNavbar.style.setProperty('display', 'block', 'important');
        if (userNavbar) userNavbar.style.setProperty('display', 'none', 'important');
    }
});
</script>
