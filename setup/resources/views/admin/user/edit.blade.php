 
<!-- The Modal -->
<div class="modal fade" id="edit_category">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="{{ route('admin.category.update', 25) }}" id="edit_category_form" name="category_form"  method="post">
        @csrf
        @method('PATCH')
        <!-- <input type="hidden" name="id", > -->
        <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" placeholder="Enter title" id="title" name="title" required="">
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </form>

    </div>
  </div>
</div>
 