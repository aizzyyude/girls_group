<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    
    <title><?= $title ?? 'Vilma\'s Store' ?> | POS System</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.css') ?>">
    
    <style>
        /* Minimal Professional Design */
        body { font-size: 14px; }
        .card { border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-header { background: transparent; border-bottom: 1px solid #e9ecef; }
        .btn { border-radius: 3px; padding: 5px 12px; }
        .table thead th { background: #f8f9fa; border-bottom: 2px solid #dee2e6; }
        .badge { padding: 4px 8px; border-radius: 3px; }
        
        /* Dark Mode */
        body.dark-mode { background: #1a1a2e; }
        body.dark-mode .card { background: #16213e; border-color: #0f3460; }
        body.dark-mode .table { color: #eee; }
        body.dark-mode .table thead th { background: #0f3460; color: #fff; }
        body.dark-mode .modal-content { background: #16213e; }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    
    <?= $this->include('theme/navbar') ?>
    <?= $this->include('theme/sidebar') ?>
    
    <?= $this->renderSection('content') ?>
    
    <footer class="main-footer text-center">
        <strong>Copyright &copy; <?= date('Y') ?> Vilma's Store</strong>
    </footer>
</div>

<!-- Scripts -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.js') ?>"></script>

<script>
// Theme Toggle
const themeToggle = document.getElementById('themeToggle');
const navbar = document.getElementById('mainNavbar');
const sidebar = document.getElementById('mainSidebar');
const brandLink = document.getElementById('brandLink');

function setTheme(theme) {
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        if(navbar) { navbar.classList.remove('navbar-warning'); navbar.classList.add('navbar-dark', 'bg-dark'); }
        if(sidebar) { sidebar.classList.remove('sidebar-light'); sidebar.classList.add('sidebar-dark-primary'); }
        if(brandLink) { brandLink.classList.remove('bg-warning'); brandLink.classList.add('bg-dark'); }
        if(themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        if(navbar) { navbar.classList.remove('navbar-dark', 'bg-dark'); navbar.classList.add('navbar-warning'); }
        if(sidebar) { sidebar.classList.remove('sidebar-dark-primary'); sidebar.classList.add('sidebar-light'); }
        if(brandLink) { brandLink.classList.remove('bg-dark'); brandLink.classList.add('bg-warning'); }
        if(themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        localStorage.setItem('theme', 'light');
    }
}

const savedTheme = localStorage.getItem('theme') || 'light';
setTheme(savedTheme);

if(themeToggle) {
    themeToggle.addEventListener('click', () => {
        setTheme(document.body.classList.contains('dark-mode') ? 'light' : 'dark');
    });
}

// Toastr Config
toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 3000 };
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>