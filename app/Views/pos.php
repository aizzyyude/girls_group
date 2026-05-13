<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System | Premium Experience</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --primary-accent: #6366f1;
            --success-accent: #22c55e;
            --danger-accent: #ef4444;
            --text-main: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: var(--text-main);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .glass-container {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--glass-border);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title i {
            color: var(--primary-accent);
        }

        .pos-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .pos-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Products Side */
        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: white;
            border-radius: 12px;
            padding: 14px 14px 14px 45px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-accent);
            font-size: 1.1rem;
        }

        .search-box input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-accent);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            outline: none;
            color: white;
        }

        .products-scroll {
            height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .products-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .products-scroll::-webkit-scrollbar-thumb {
            background: var(--glass-border);
            border-radius: 10px;
        }

        .product-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1rem;
            transition: transform 0.2s ease, background 0.2s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-accent);
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .product-price {
            color: var(--primary-accent);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .product-stock {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .product-card.selected {
            border-color: var(--primary-accent);
            background: rgba(96, 165, 250, 0.15);
            box-shadow: 0 0 15px rgba(96, 165, 250, 0.3);
            transform: translateY(-5px) scale(1.02);
        }

        .qty-badge {
            background: var(--primary-accent);
            box-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
            padding: 5px 8px;
            border-radius: 8px;
            font-size: 0.8rem;
        }

        /* Cart Side */
        .cart-section {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: 700px;
            border: 1px solid var(--glass-border);
        }

        .cart-items-container {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 1rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .cart-item-info h6 {
            margin: 0;
            font-size: 0.95rem;
        }

        .cart-item-info small {
            color: #94a3b8;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .cart-summary {
            background: var(--glass-bg);
            border-radius: 16px;
            padding: 1.25rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-row {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-accent);
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid var(--glass-border);
        }

        .btn-pay {
            background: var(--primary-accent);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 1rem;
            width: 100%;
        }

        .btn-pay:hover {
            background: #4f46e5;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
            transform: scale(1.02);
        }

        .btn-pay:disabled {
            background: #334155;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .empty-cart-state {
            text-align: center;
            padding: 3rem 0;
            color: #64748b;
        }

        .input-glass {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: white !important;
            border-radius: 10px !important;
        }

        .input-glass:focus {
            border-color: var(--primary-accent) !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>

<div class="glass-container">
    <!-- Header -->
    <div class="header-section">
        <div class="header-title">
            <i class="fas fa-bolt"></i>
            <span>ELITE POS SYSTEM</span>
        </div>
        <button class="btn btn-outline-light btn-sm" onclick="window.location.href='<?= base_url('dashboard') ?>'">
            <i class="fas fa-chevron-left mr-2"></i> Dashboard
        </button>
    </div>

    <div class="pos-grid">
        <!-- Products Column -->
        <div class="products-column">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="productSearch" class="form-control" placeholder="Search products by name or category...">
            </div>

            <div class="products-scroll">
                <div class="row" id="productList">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Cart Column -->
        <div class="cart-column">
            <div class="cart-section">
                <h5 class="mb-4"><i class="fas fa-shopping-cart mr-2"></i> Current Order</h5>
                
                <div class="cart-items-container" id="cartContainer">
                    <div class="empty-cart-state">
                        <i class="fas fa-shopping-basket fa-3x mb-3"></i>
                        <p>Your cart is empty</p>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">₱0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Items Count</span>
                        <span id="itemCount">0</span>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label class="small text-muted mb-1">Cash Received</label>
                        <input type="number" id="cashReceived" class="form-control input-glass" placeholder="0.00">
                    </div>

                    <div class="summary-row mt-2">
                        <span>Change</span>
                        <span id="changeDisplay">₱0.00</span>
                    </div>

                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="totalDisplay">₱0.00</span>
                    </div>

                    <button id="checkoutBtn" class="btn btn-pay" disabled>
                        Complete Transaction
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let allProducts = [];
    let cart = [];
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    $(document).ready(function() {
        loadProducts();

        // Search listener
        $('#productSearch').on('input', function() {
            renderProducts($(this).val());
        });

        // Cash received listener
        $('#cashReceived').on('input', calculateChange);

        // Checkout listener
        $('#checkoutBtn').click(handleCheckout);
    });

    function loadProducts() {
        console.log('Fetching products from: <?= base_url('products/getProducts') ?>');
        $.get('<?= base_url('products/getProducts') ?>')
            .done(function(res) {
                console.log('Server response:', res);
                if (res && res.data) {
                    allProducts = res.data;
                    console.log('Products assigned, length:', allProducts.length);
                    renderProducts();
                } else {
                    console.warn('Invalid data structure:', res);
                    $('#productList').html('<div class="col-12 text-center text-muted py-5">Invalid data received from server</div>');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
                $('#productList').html('<div class="col-12 text-center text-danger py-5">Failed to load products. Error: ' + error + '</div>');
            });
    }

    function renderProducts(filter = '') {
        const list = $('#productList');
        console.log('Rendering products with filter:', filter);
        list.empty();

        if (!allProducts || !Array.isArray(allProducts)) {
            console.error('allProducts is not an array:', allProducts);
            list.append('<div class="col-12 text-center text-muted py-5">Loading products...</div>');
            return;
        }

        const filtered = allProducts.filter(p => 
            (p.name && p.name.toLowerCase().includes(filter.toLowerCase())) || 
            (p.category && p.category.toLowerCase().includes(filter.toLowerCase()))
        );

        console.log('Filtered count:', filtered.length);

        if (filtered.length === 0) {
            list.append('<div class="col-12 text-center text-muted py-5">No products found</div>');
            return;
        }

        filtered.forEach(p => {
            const inCart = cart.find(item => item.id === p.id);
            const outOfStock = parseInt(p.stock) <= 0;
            const html = `
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="product-card ${outOfStock ? 'opacity-50' : ''} ${inCart ? 'selected' : ''}" 
                         onclick="${outOfStock ? '' : `addToCart('${p.id}')`}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="product-name">${p.name}</div>
                                <div class="small text-muted">${p.category || 'Uncategorized'}</div>
                            </div>
                            ${inCart ? `<span class="badge badge-primary qty-badge">${inCart.qty}</span>` : ''}
                        </div>
                        <div class="mt-2">
                            <div class="product-price">₱${parseFloat(p.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</div>
                            <div class="product-stock ${parseInt(p.stock) <= 5 ? 'text-danger' : ''}">
                                ${outOfStock ? 'Out of Stock' : `Stock: ${p.stock}`}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            list.append(html);
        });
    }

    function addToCart(productId) {
        const product = allProducts.find(p => p.id == productId);
        if (!product) return;

        const existing = cart.find(item => item.id === product.id);
        
        if (existing) {
            if (existing.qty >= parseInt(product.stock)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock Limit',
                    text: 'Cannot add more than available stock.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            }
            existing.qty++;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                qty: 1,
                stock: parseInt(product.stock)
            });
        }

        renderCart();
    }

    function updateQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if (!item) return;

        const newQty = item.qty + delta;
        
        if (newQty <= 0) {
            removeFromCart(id);
        } else if (newQty > item.stock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock Limit',
                text: 'Cannot exceed available stock.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            item.qty = newQty;
            renderCart();
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function renderCart() {
        const container = $('#cartContainer');
        container.empty();

        if (cart.length === 0) {
            container.append(`
                <div class="empty-cart-state">
                    <i class="fas fa-shopping-basket fa-3x mb-3"></i>
                    <p>Your cart is empty</p>
                </div>
            `);
            $('#subtotal, #totalDisplay').text('₱0.00');
            $('#itemCount').text('0');
            $('#checkoutBtn').prop('disabled', true);
            return;
        }

        let total = 0;
        let count = 0;

        cart.forEach(item => {
            const sub = item.price * item.qty;
            total += sub;
            count += item.qty;

            container.append(`
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h6>${item.name}</h6>
                        <small>₱${item.price.toLocaleString()} x ${item.qty}</small>
                    </div>
                    <div class="cart-item-controls">
                        <button class="qty-btn" onclick="updateQty('${item.id}', -1)">-</button>
                        <span>${item.qty}</span>
                        <button class="qty-btn" onclick="updateQty('${item.id}', 1)">+</button>
                        <button class="btn btn-link text-danger p-0 ml-2" onclick="removeFromCart('${item.id}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);
        });

        $('#subtotal, #totalDisplay').text('₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2}));
        $('#itemCount').text(count);
        $('#checkoutBtn').prop('disabled', false);
        calculateChange();
    }

    function calculateChange() {
        let total = 0;
        cart.forEach(i => total += i.price * i.qty);

        const cash = parseFloat($('#cashReceived').val()) || 0;
        const change = cash - total;

        $('#changeDisplay').text('₱' + (change > 0 ? change : 0).toLocaleString(undefined, {minimumFractionDigits: 2}));
        
        if (cash < total || total === 0) {
            $('#checkoutBtn').prop('disabled', true);
        } else {
            $('#checkoutBtn').prop('disabled', false);
        }
    }

    async function handleCheckout() {
        let total = 0;
        cart.forEach(i => total += i.price * i.qty);
        const cash = parseFloat($('#cashReceived').val()) || 0;

        if (cash < total) {
            Swal.fire('Error', 'Insufficient cash amount.', 'error');
            return;
        }

        const result = await Swal.fire({
            title: 'Confirm Transaction?',
            text: `Total: ₱${total.toLocaleString()}. Change: ₱${(cash - total).toLocaleString()}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            confirmButtonText: 'Yes, Complete it!'
        });

        if (result.isConfirmed) {
            const $btn = $('#checkoutBtn');
            const originalHtml = $btn.html();
            
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');

            $.ajax({
                url: '<?= site_url('sales/checkout') ?>',
                method: 'POST',
                data: {
                    cart: cart,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        // Prepare Receipt
                        generateReceipt(total, cash);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-print"></i> Print Receipt',
                            cancelButtonText: 'Done'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                printReceipt();
                            }
                            cart = [];
                            $('#cashReceived').val('');
                            renderCart();
                            loadProducts();
                        });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Failed to process transaction. Please check your connection.', 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    }

    function generateReceipt(total, cash) {
        const date = new Date().toLocaleString();
        const formatter = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2
        });

        let itemsHtml = '';
        cart.forEach(item => {
            itemsHtml += `
                <div class="receipt-row">
                    <span>${item.name} (x${item.qty})</span>
                    <span>${formatter.format(item.price * item.qty)}</span>
                </div>
            `;
        });

        $('#receiptContent').html(`
            <div class="receipt-header">
                <h4>VILMA'S STORE</h4>
                <p>123 Business Road, City</p>
                <p>Tel: (123) 456-7890</p>
                <hr>
                <p>Date: ${date}</p>
                <hr>
            </div>
            <div class="receipt-items">
                ${itemsHtml}
            </div>
            <hr>
            <div class="receipt-row total-row">
                <span>TOTAL</span>
                <span>${formatter.format(total)}</span>
            </div>
            <div class="receipt-row">
                <span>CASH RECEIVED</span>
                <span>${formatter.format(cash)}</span>
            </div>
            <div class="receipt-row">
                <span>CHANGE</span>
                <span>${formatter.format(cash - total)}</span>
            </div>
            <hr>
            <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>Please come again.</p>
            </div>
        `);
    }

    function printReceipt() {
        const printContent = document.getElementById('receiptArea').innerHTML;
        const printWindow = window.open('', '', 'height=600,width=400');
        
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: "Courier New", Courier, monospace; width: 300px; padding: 20px; }');
        printWindow.document.write('.receipt-header { text-align: center; margin-bottom: 10px; }');
        printWindow.document.write('.receipt-header h4 { margin: 0; }');
        printWindow.document.write('.receipt-header p { margin: 2px 0; font-size: 0.8rem; }');
        printWindow.document.write('.receipt-row { display: flex; justify-content: space-between; margin: 4px 0; font-size: 0.9rem; }');
        printWindow.document.write('.receipt-items { margin: 10px 0; }');
        printWindow.document.write('.total-row { font-weight: bold; font-size: 1.1rem; }');
        printWindow.document.write('.receipt-footer { text-align: center; margin-top: 20px; font-size: 0.8rem; }');
        printWindow.document.write('hr { border: 0; border-top: 1px dashed #000; }');
        printWindow.document.write('</style></head><body>');
        printWindow.document.write(document.getElementById('receiptContent').innerHTML);
        printWindow.document.write('</body></html>');
        
        printWindow.document.close();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>

<!-- Hidden Receipt Area -->
<div id="receiptArea" style="display:none;">
    <style>
        #receiptArea { font-family: 'Courier New', Courier, monospace; width: 300px; padding: 20px; color: #000; background: #fff; }
        .receipt-header { text-align: center; margin-bottom: 10px; }
        .receipt-header h4 { margin: 0; }
        .receipt-header p { margin: 2px 0; font-size: 0.8rem; }
        .receipt-row { display: flex; justify-content: space-between; margin: 4px 0; font-size: 0.9rem; }
        .receipt-items { margin: 10px 0; }
        .total-row { font-weight: bold; font-size: 1.1rem; }
        .receipt-footer { text-align: center; margin-top: 20px; font-size: 0.8rem; }
        @media print {
            body * { visibility: hidden; }
            #receiptArea, #receiptArea * { visibility: visible; }
            #receiptArea { position: absolute; left: 0; top: 0; width: 100%; display: block !important; }
        }
    </style>
    <div id="receiptContent"></div>
</div>

</body>
</html>