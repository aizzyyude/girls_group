<aside class="main-sidebar sidebar-light elevation-4" id="mainSidebar">
    <div class="brand-link bg-warning" id="brandLink" style="cursor: default;">
        <img src="<?= base_url('assets/img/logo.png') ?>" 
             alt="Store Logo" 
             class="brand-image img-circle elevation-3" 
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="color: white">Vilma's Store</span>
    </div>
    
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('products') ?>" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('users') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="<?= base_url('pos') ?>" class="nav-link">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>POS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('log') ?>" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Activity Logs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>