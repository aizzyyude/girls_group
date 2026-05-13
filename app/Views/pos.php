<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background: #000000;
        }

        .pos-wrapper {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pos-card {
            width: 900px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .pos-header {
            background: #303131;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        
        
        .pos-body {
            padding: 20px;
        }

        .product-box {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
        }

        .cart-box {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dddddd;
            padding: 10px;
            border-radius: 10px;
        }

        .summary {
            margin-top: 10px;
        }

        .btn-checkout {
            background: #32b944;
            color: #ffffff;
            font-size: 18px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<form id="posForm" class="pos-wrapper" onsubmit="return false;">

    <div class="pos-card">

        <!-- HEADER -->
        <div class="pos-header">
            <i class="fas fa-cash-register"></i> POINT OF SALE SYSTEM
        </div>

        <!-- BODY -->
        <div class="pos-body">

            <!-- SEARCH -->
            <div class="form-group">
                <input type="text" id="searchProduct" class="form-control"
                    placeholder="Search product...">
            </div>

            <h6>Products</h6>
            <div class="product-box row" id="productList"></div>

            <hr>

            <h6>Cart</h6>
            <div class="cart-box">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        <tr>
                            <td colspan="4" class="text-center">Cart Empty</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="summary">

                <h5>
                    Total: ₱<span id="cartTotal">0.00</span>
                </h5>

                <!-- hidden field to submit total -->
                <input type="hidden" name="total" id="totalInput">

                <div class="form-group">
                    <label>Cash</label>
                    <input type="number" name="cash" id="cashAmount" class="form-control" required>
                </div>

                <h6>
                    Change: ₱<span id="changeAmount">0.00</span>
                </h6>

                <!-- hidden field for change -->
                <input type="hidden" name="change" id="changeInput">

                <!-- checkout -->
                <button type="submit" id="checkoutBtn"
                    class="btn btn-success btn-block btn-checkout mt-3">
                    Checkout
                </button>

                <!-- back button (not submitting form) -->
                <button type="button" onclick="goBack()"
                    class="btn btn-secondary btn-block btn-checkout mt-3">
                    <i class="fas fa-arrow-left"></i> Back
                </button>

            </div>

        </div>
    </div>

</form>

<script>
let cart = [];
const baseUrl = "<?= base_url() ?>/";
function goBack() {
    window.location.href = "<?= base_url('dashboard') ?>";
}

$(document).ready(function() {
    loadPOSProducts();
});

// PRODUCTS
function loadPOSProducts() {
    $.get(baseUrl + 'products/getProducts', function(res) {

        let html = '';

        res.data.forEach(p => {
            html += `
            <div class="col-md-4 mb-2">
                <div class="card p-2 text-center">
                    <strong>${p.name}</strong>
                    <div>₱${parseFloat(p.price).toFixed(2)}</div>
                    <small>Stock: ${p.stock}</small>

                    <button class="btn btn-primary btn-sm mt-2"
                        onclick='addToCart(${JSON.stringify(p)})'>
                        Add
                    </button>
                </div>
            </div>`;
        });

        $('#productList').html(html);
    });
}

// CART
function addToCart(p) {
    let item = cart.find(x => x.id == p.id);

    if (item) item.qty++;
    else cart.push({ id: p.id, name: p.name, price: p.price, qty: 1 });

    renderCart();
}

function renderCart() {

    let html = '';
    let total = 0;

    if (cart.length === 0) {
        html = `<tr><td colspan="4" class="text-center">Cart Empty</td></tr>`;
    } else {

        cart.forEach((c, i) => {

            let sub = c.price * c.qty;
            total += sub;

            html += `
            <tr>
                <td>${c.name}</td>
                <td>${c.qty}</td>
                <td>₱${sub.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm"
                        onclick="removeItem(${i})">X</button>
                </td>
            </tr>`;
        });
    }

    $('#cartItems').html(html);
    $('#cartTotal').text(total.toFixed(2));
    calcChange();
}

function removeItem(i) {
    cart.splice(i, 1);
    renderCart();
}

// CHANGE
$('#cashAmount').on('input', calcChange);

function calcChange() {
    let total = 0;

    cart.forEach(c => total += c.price * c.qty);

    let cash = parseFloat($('#cashAmount').val()) || 0;

    $('#changeAmount').text((cash - total > 0 ? cash - total : 0).toFixed(2));
}

// CHECKOUT
$('#checkoutBtn').click(function() {

    $.post(baseUrl + 'sales/checkout', { cart }, function() {

        alert('Success');

        cart = [];
        renderCart();
        $('#cashAmount').val('');
        $('#changeAmount').text('0.00');

    });
});
</script>

</body>
</html>