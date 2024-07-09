<div class="modal fade modal-blur" id="Add_new_Attribute" tabindex="-1" aria-labelledby="Add_new_Attribute" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Attribute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="AttributeForm" >
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="hidden" name="category_id" value="{{!empty($product->category_id) ? $product->category_id :'' }}" id="AttributeCategoryId">

                                        <label for="name">Name</label>
                                        <input type="text" name="name"  id="name" class="form-control " placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                    <div class="mb-3">

                                        <label for="Value">Value</label>
                                        <input type="text" id="Value" required name="values[]" class="form-control" value="" placeholder="Value">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-fill-out btn-primary ">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
