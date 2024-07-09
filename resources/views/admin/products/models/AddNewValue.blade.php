<div class="modal fade modal-blur" id="AddNewValue" tabindex="-1" aria-labelledby="AddNewValue" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Value</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="AttributeValueForm" >
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">

                                        <label for="attribute">Attribute</label>
                                        <input type="hidden" name="attributeId" value="" id="attributeID">
                                        <input type="text" name="attributeName" value="" id="attributeName" class="form-control" readonly>
                                        <p class="error"></p>
                                    </div>
                                    <div class="mb-3">

                                        <label for="Value">Value</label>
                                        <input type="text" id="Value" required name="value" class="form-control" value="" placeholder="Value">
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
