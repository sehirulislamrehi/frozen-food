<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Stock Entry</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row data-indicator">
        <ul>
            <li>{{ $product_details->group->name }}</li>
            <li>></li>
            <li>{{ $product_details->company->name }}</li>
            <li>></li>
            <li>{{ $product_details->location->name }}</li>
        </ul>
    </div>

    <form class="ajax-form" method="post" action="{{ route('products.details.stock.add', encrypt($product_details->id)) }}">
        @csrf

        <div class="row">

            <!-- Type -->
            <div class="col-md-12 col-12 form-group">
                <label>Type</label><span class="require-span">*</span>
                <select name="type" class="form-control">
                    <option value="In">In</option>                
                    <option value="Out">Out</option>                
                </select>
            </div>

            <!-- quantity -->
            <div class="col-md-12 form-group">
                <label>Quantity (kg)</label>
                <input type="number" class="form-control" name="quantity" step=".01">
            </div>

            <!-- Cartoon Name -->
            <div class="col-md-12 form-group">
                <label>Cartoon Name</label>
                <input type="text" class="form-control" name="cartoon_name">
            </div>

            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    Add
                </button>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
