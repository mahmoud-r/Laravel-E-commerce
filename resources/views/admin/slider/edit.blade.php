<div class="modal fade modal-blur" id="edit_slide" tabindex="-1" aria-labelledby="edit_slide" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Slide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="SliderUpdateForm">
                <input type="hidden" value="{{$slider->id}}" name="slider_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input class="form-control title" value="{{$slider->title}}" name="title" type="text" id="title">
                        <p class="error"></p>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input class="form-control link" value="{{$slider->link}}" placeholder="https://"name="link" type="text" id="link">
                        <p class="error"></p>
                    </div>
                    <div class="mb-3">
                        <label for="button_text" class="form-label">Button text</label>
                        <input class="form-control button_text" value="{{$slider->button_text}}" placeholder="Ex: Shop now" name="button_text" type="text" id="button_text">
                        <p class="error"></p>
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <textarea class="form-control subtitle"  rows="4" placeholder="Enter subtitle" name="subtitle" cols="50" id="subtitle">{{$slider->subtitle}}</textarea>
                        <p class="error"></p>
                    </div>
                    <div class="mb-3">
                        <label for="sort" class="form-label">Sort order</label>
                        <input class="form-control sort" value="{{$slider->sort}}" placeholder="Order by" name="sort" type="number" id="sort">
                        <p class="error"></p>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control status">
                            <option value="1" {{$slider->status ==1 ?'selected':'' }}> Publish</option>
                            <option value="0" {{$slider->status ==0 ?'selected':'' }}> Draft</option>
                            <p class="error"></p>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="image"  value="" class="image image_id">
                        <label for="image">Image<span class="text-danger">*</span></label>
                        <div  class="dropzone dz-clickable image image_dropzone">
                            <div class="dz-message needsclick">
                             @if(!empty($slider->image))
                              <div>
                               <img src="{{asset('uploads/home_slider/images/'.$slider->image)}}">
                              </div>
                                   @else
                                    <br>Drop files here or click to upload.<br><br>
                                    @endif

                            </div>
                        </div>
                        <p class="error"></p>
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

