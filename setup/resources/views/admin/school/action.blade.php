<a class="btn btn-primary btn-sm" href="{{ route('admin.school.edit', $_id ) }}">
  <i class="fa fa-edit"></i>
</a>
<a class="btn btn-info btn-sm" href="{{ route('admin.school.show', $_id ) }}">
  <i class="fa fa-eye"></i>
</a>

<button class="btn btn-danger btn-sm" data-action="trash" data-id="{{ $_id }}"
  data-reloadlist="true"
  data-confirm="Are you sure you want to delete this record?"
  data-confirmation="true" data-url="{{ route('admin.school.destroy', $_id ) }}">
  <i class="fa fa-trash"></i>
</button>

