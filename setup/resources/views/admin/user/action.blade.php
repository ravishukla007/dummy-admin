<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_category" 
  data-url="{{ route('admin.category.update', $_id ) }}"
  data-title="">
  <i class="fa fa-edit"></i>
</button>

<button class="btn btn-danger btn-sm" data-action="trash" data-id="{{ $_id }}"
  data-reloadlist="true"
  data-confirm="Are you sure you want to delete this record?"
  data-confirmation="true" data-url="{{ route('admin.user.destroy', $_id ) }}">
  <i class="fa fa-trash"></i>
</button>

