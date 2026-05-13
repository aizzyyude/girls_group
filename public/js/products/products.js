// Toast notification function
function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

// Add Product Form Submission
$('#addProductForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'products/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addProductForm')[0].reset();
                showToast('success', 'Product added successfully!');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('error', response.message || 'Failed to add product.');
            }
        },
        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});

// Edit Product Button Click
$(document).on('click', '.edit-btn', function () {
    const productId = $(this).data('id');
    $.ajax({
        url: baseUrl + 'products/edit/' + productId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data) {
                $('#editProductModal #productId').val(response.data.id);
                $('#editProductModal #name').val(response.data.name);
                $('#editProductModal #category').val(response.data.category);
                $('#editProductModal #price').val(response.data.price);
                $('#editProductModal #stock').val(response.data.stock);
                $('#editProductModal #unit').val(response.data.unit);
                $('#editProductModal #description').val(response.data.description);
                $('#editProductModal #status').val(response.data.status);
                $('#editProductModal').modal('show');
            } else {
                showToast('error', 'Error fetching product data');
            }
        },
        error: function () {
            showToast('error', 'Error fetching product data');
        }
    });
});

// Update Product Form Submission
$(document).ready(function () {
    $('#editProductForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: baseUrl + 'products/update',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#editProductModal').modal('hide');
                    showToast('success', 'Product Updated successfully!');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', response.message || 'Error updating product');
                }
            },
            error: function (xhr) {
                showToast('error', 'Error updating product');
                console.error(xhr.responseText);
            }
        });
    });
});

// Delete Product Button Click
$(document).on('click', '.delete-btn', function () {
    const productId = $(this).data('id');
    const csrfName = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: baseUrl + 'products/delete/' + productId,
            method: 'POST',
            data: {
                _method: 'DELETE',
                [csrfName]: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    showToast('success', 'Product deleted successfully.');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', response.message || 'Failed to delete.');
                }
            },
            error: function () {
                showToast('error', 'Something went wrong while deleting.');
            }
        });
    }
});

// Initialize DataTable
$(document).ready(function () {
    const $table = $('#productsTable');

    const csrfName = 'csrf_test_name';
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + 'products/fetchRecords',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        },
        columns: [
            { data: 'row_number' },
            { data: 'id', visible: false },
            { data: 'name' },
            { data: 'category' },
            { data: 'price' },
            { data: 'stock' },
            { data: 'status' },
            { data: 'created_at' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    `;
                }
            }
        ],
        responsive: true,
        autoWidth: false
    });
});