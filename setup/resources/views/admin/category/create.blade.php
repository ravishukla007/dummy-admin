 
<!-- The Modal -->
<div class="modal fade" id="add_category">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="{{ route('admin.category.store') }}" id="category_form" name="category_form"  method="post" enctype="multipart/form-data">
        @csrf
        <!-- Modal body -->
        <input type="hidden" name="parent_id" value="{{ request()->input('parent_id') }}">
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" placeholder="Enter title" id="title" name="title" required="">
            </div>
            <div class="form-group">
              <label for="title">Type:</label>
              <select class="form-control" name="type" required="">
                  <option value="">Select category</option>
                  <option value="post">Post</option>
                  <option value="image_gallery">Image Gallery</option>
                  <option value="contest">Contest</option>
                  <option value="resources">Resources</option>
                  <option value="magazines">Magazines</option>
              </select>
            </div>
            <div class="form-group">
              <label for="title">Image:</label> <br />
              <input type="file" id="image" name="image" required="">
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </form>

    </div>
  </div>
</div>
 