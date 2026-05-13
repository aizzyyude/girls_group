<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Products</h3>
              <div class="float-right">
                <a href="<?= site_url('pos') ?>" class="btn btn-md btn-success mr-2">
                  <i class="fas fa-cash-register"></i> Go to POS
                </a>
                <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle fa fw"></i> Add New
                </button>
              </div>
            </div>
            <div class="card-body">
               <table id="productsTable" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add New Modal -->
    <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="addProductForm">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-plus-circle fa fw"></i> Add New Product</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category" required>
                  <option value="">Select Category</option>
                  <option value="Beverages">Beverages</option>
                  <option value="Snacks">Snacks</option>
                  <option value="Food">Food</option>
                  <option value="Groceries">Groceries</option>
                  <option value="Household">Household</option>
                  <option value="Dairy">Dairy</option>
                  <option value="Personal Care">Personal Care</option>
                </select>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Unit</label>
                    <select class="form-control" name="unit">
                      <option value="piece">Piece</option>
                      <option value="pack">Pack</option>
                      <option value="bottle">Bottle</option>
                      <option value="sachet">Sachet</option>
                      <option value="kilogram">Kilogram</option>
                      <option value="liter">Liter</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                      <option value="Available">Available</option>
                      <option value="Out of Stock">Out of Stock</option>
                      <option value="Discontinued">Discontinued</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProductModalLabel"><i class="far fa-edit fa fw"></i> Edit Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="editProductForm">
            <?= csrf_field() ?>
            <div class="modal-body">
              <input type="hidden" id="productId" name="id">

              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category" id="category" required>
                  <option value="Beverages">Beverages</option>
                  <option value="Snacks">Snacks</option>
                  <option value="Food">Food</option>
                  <option value="Groceries">Groceries</option>
                  <option value="Household">Household</option>
                  <option value="Dairy">Dairy</option>
                  <option value="Personal Care">Personal Care</option>
                </select>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Unit</label>
                    <select class="form-control" name="unit" id="unit">
                      <option value="piece">Piece</option>
                      <option value="pack">Pack</option>
                      <option value="bottle">Bottle</option>
                      <option value="sachet">Sachet</option>
                      <option value="kilogram">Kilogram</option>
                      <option value="liter">Liter</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      <option value="Available">Available</option>
                      <option value="Out of Stock">Out of Stock</option>
                      <option value="Discontinued">Discontinued</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="toasts-top-right fixed" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script> const baseUrl = "<?= base_url() ?>"; </script>
<script src="<?= base_url('js/products/products.js') ?>"></script>
<?= $this->endSection() ?>