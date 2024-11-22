<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Product update</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class=" mb-3">
                    <label for="product">Product name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="product"><i class="fa-solid fa-bag-shopping"></i></span>
                        <input type="text" class="form-control name_update" placeholder="Product" aria-label="Product" aria-describedby="name" id="name_update">
                    </div>
                    <span class="name text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="product">Quantity <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="quantity"><i class="fa-solid fa-arrow-down-wide-short"></i></span>
                        <input type="number" min="0" class="form-control quantity_update" placeholder="Quantity" aria-label="quantity" aria-describedby="quantity" id="quantity_update">
                    </div>
                    <span class="quantity text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="product">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="price"><i class="fa-solid fa-money-bill"></i></span>
                        <input type="number" min="0" step="any" class="form-control price_update" placeholder="Price" aria-label="price" aria-describedby="price" id="price_update">
                    </div>
                    <span class="price text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update_product">Save changes</button>
            </div>
        </div>
    </div>
</div>
