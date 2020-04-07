<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_category" 
  data-url="{{ route('admin.category.update', $_id ) }}"
  data-type="{{ @$type }}"
  data-title="{{ $title }}">
  <i class="fa fa-edit"></i>
</button>
<a class="btn btn-info btn-sm" href="{{ route('admin.category.index') . '?parent_id=' .$_id }}">
  <i class="fa fa-eye"></i>
</a>

<button class="btn btn-danger btn-sm" data-action="trash" data-id="{{ $_id }}"
  data-reloadlist="true"
  data-confirm="Are you sure you want to delete this record?"
  data-confirmation="true" data-url="{{ route('admin.category.destroy', $_id ) }}">
  <i class="fa fa-trash"></i>
</button>

