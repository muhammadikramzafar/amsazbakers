// Admin sidebar toggle
const sidebar = document.getElementById('adminSidebar');
const toggle  = document.getElementById('sidebarToggle');
if (toggle && sidebar) {
  toggle.addEventListener('click', () => sidebar.classList.toggle('is-open'));
}
