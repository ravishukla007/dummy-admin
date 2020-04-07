 
<!-- The Modal -->
<div class="modal fade" id="add_category">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="{{ route('admin.category.store') }}" id="category_form" name="category_form"  method="post">
        @csrf
        <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" placeholder="Enter title" id="title" name="title" required="">
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </form>

    </div>
  </div>
</div>
 