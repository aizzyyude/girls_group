<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Total Products -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="totalProducts">0</h3>
                            <p>Total Products</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="<?= base_url('products') ?>" class="small-box-footer">
                            View Products <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="lowStock">0</h3>
                            <p>Low Stock Items</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <a href="<?= base_url('products') ?>" class="small-box-footer">
                            Check Stock <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Value -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="totalValue">₱0</h3>
                            <p>Total Inventory Value</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="<?= base_url('products') ?>" class="small-box-footer">
                            View Products <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="outOfStock">0</h3>
                            <p>Out of Stock</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <a href="<?= base_url('products') ?>" class="small-box-footer">
                            Restock Now <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Recent Products Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Products</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('products') ?>" class="btn btn-sm btn-primary">
                                    View All <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="recentProducts">
                                    <tr>
                                        <td colspan="5" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const baseUrl = "<?= base_url() ?>";

$(document).ready(function() {
    loadDashboardStats();
    loadRecentProducts();
});

function loadDashboardStats() {
    $.ajax({
        url: baseUrl + 'dashboard/getStats',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#totalProducts').text(response.totalProducts || 0);
                $('#lowStock').text(response.lowStock || 0);
                $('#outOfStock').text(response.outOfStock || 0);
                $('#totalValue').text('₱' + formatNumber(response.totalValue || 0));
            }
        },
        error: function(xhr) {
            console.log('Error loading stats:', xhr);
        }
    });
}

function loadRecentProducts() {
    $.ajax({
        url: baseUrl + 'dashboard/getRecentProducts',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let html = '';
            if (response.data && response.data.length > 0) {
                response.data.forEach(product => {
                    let stockBadge = '';
                    let statusBadge = '';
                    
                    // Stock badge
                    if (product.stock <= 0) {
                        stockBadge = '<span class="badge badge-danger">0</span>';
                    } else if (product.stock <= 10) {
                        stockBadge = '<span class="badge badge-warning">' + product.stock + '</span>';
                    } else {
                        stockBadge = '<span class="badge badge-success">' + product.stock + '</span>';
                    }
                    
                    // Status badge
                    if (product.status === 'Available') {
                        statusBadge = '<span class="badge badge-success">Available</span>';
                    } else if (product.status === 'Out of Stock') {
                        statusBadge = '<span class="badge badge-danger">Out of Stock</span>';
                    } else {
                        statusBadge = '<span class="badge badge-secondary">Discontinued</span>';
                    }
                    
                    html += `
                        <tr>
                            <td><strong>${escapeHtml(product.name)}</strong></td>
                            <td>${escapeHtml(product.category)}</td>
                            <td>₱${formatNumber(product.price)}</td>
                            <td>${stockBadge}</td>
                            <td>${statusBadge}</td>
                        </tr>
                    `;
                });
            } else {
                html = '<tr><td colspan="5" class="text-center">No products found</td></tr>';
            }
            $('#recentProducts').html(html);
        },
        error: function() {
            $('#recentProducts').html('<tr><td colspan="5" class="text-center text-danger">Error loading products</td></tr>');
        }
    });
}

function formatNumber(num) {
    return parseFloat(num).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>
<?= $this->endSection() ?>