@extends('admin.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Content</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Content</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Content</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form action="{{ route('admin.content.update', request()->segment(3)) }}" id="content_form" method="post">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group" id="title_container">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" placeholder="Enter Title" name="title" 
                    value="{{ $post->title }}" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea class="form-control" placeholder="Enter Description" name="content" id="content">{{ $post->content }}</textarea>
                  </div>
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  <a href="{{ route('admin.post.index') }}" class="btn btn-danger">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


  </div>

@endsection

@section('js')

<script src="{{ url('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>

$(function () {
  
  $('#content_form').validate({
    rules: {
      title: {
        required: true,
        minlength: 10
      },
      description: {
        required: true,
        minlength: 50
      }
    }, 
    submitHandler: function (form) {
      
      globalAjax(form, function(res){
        
          window.location.assign('{{ route("admin.content.index") }}') 
      });
    }
  });

  $('#post_category').trigger('change');
  try {
    var editor = CKEDITOR.replace( 'content' );
    
    editor.on( 'change', function( evt ) {
        // getData() returns CKEditor's HTML content.
        $('#content').val( evt.editor.getData() );
    });
  }catch(e) { }


    
});

</script>

@endsection

@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@endsection