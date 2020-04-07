 
<!-- The Modal -->
<div class="modal fade" id="edit_category">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="{{ route('admin.category.update', 25) }}" id="edit_category_form" name="category_form"  method="post" enctype="multipart/form-data" >
        @csrf
        @method('PATCH')
        <!-- <input type="hidden" name="id", > -->
        <!-- Modal body -->
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
                  <option value="contest">Contest</option>
                  <option value="image_gallery">Image Gallery</option>
                  <option value="resources">Resources</option>
                  <option value="magazines">Magazines</option>
              </select>
            </div>

            <div class="form-group">
              <label for="title">Image:</label> <br />
              <input type="file" id="edit_image" name="image">
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </form>

    </div>
  </div>
</div>
 