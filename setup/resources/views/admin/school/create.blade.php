@extends('admin.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">School</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">School</li>
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
                <h3 class="card-title">Create School</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.school.store') }}" id="school_form" method="post">
                @csrf
                <div class="card-body">
                  
                  <div class="form-group" id="title_container">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name" name="name" />
                  </div>

                  <div class="form-group" id="asseturl_container">
                    <label for="exampleInputEmail1">Logo</label>
                    <input type="text" class="form-control" placeholder="Enter Logo URL" name="logo" />
                  </div>                  

                  <div class="form-group" id="description_container">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea class="form-control" placeholder="Enter Description" name="description" id="description"></textarea>
                  </div>
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  <a href="{{ route('admin.school.index') }}" class="btn btn-danger">Cancel</a>
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
  
  $('#school_form').validate({
    rules: {
      name: {
        required: true,
        minlength: 10
      },
      logo: {
        required: true,
        url: true
      },
      description: {
        required: true,
        minlength: 50
      }
    },
    submitHandler: function (form) {      
      globalAjax(form, function(res){        
          window.location.assign('{{ route("admin.school.index") }}') 
      });
    }
  });

  var editor = CKEDITOR.replace( 'description' );
  
  editor.on( 'change', function( evt ) {
      // getData() returns CKEditor's HTML content.
      $('#description').val( evt.editor.getData() );
  });

});

</script>

@endsection

@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@endsection