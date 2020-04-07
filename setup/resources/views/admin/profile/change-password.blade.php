@extends('admin.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
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
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.changepassword') }}" id="change_password_form" method="post">
                @csrf
                <div class="card-body">
                  
                  <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" class="form-control" placeholder="Current Password" name="current_password" />
                  </div>

                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" placeholder="New Password" name="password"  id="password" />
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm  Password" name="confirm_password" />
                  </div>
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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

<script>

$(function () {
  
  $('#change_password_form').validate({
    rules: {
      current_password: {
        required: true
      },
      password: {
        required: true,
        custom_password: true
      },
      confirm_password: {
        required: true,
        equalTo: "#password"
      }
    },    
    submitHandler: function (form) {
      
      globalAjax(form, function(res){
          if(res.success == true) {
            document.getElementById('change_password_form').reset();
          }
          alert(res.message);
      });
    }
  });

    
});

</script>

@endsection

@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@endsection