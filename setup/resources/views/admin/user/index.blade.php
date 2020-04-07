@extends('admin.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
 
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User List</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary" title="Collapse" >
                  <i class="fas fa-plus"></i> Add</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="category-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#ID</th> 
                  <th>Name</th> 
                  <th>Email</th> 
                  <th>Mobile Number</th> 
                  <th>Created At</th> 
                  <th>Status</th> 
                  <th>Action</th> 
                </tr>
                </thead>
                <tbody>
              
                </tbody>
                 
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
           
  </div>

@endsection

@section('js')

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script>

  $(function () {
    window.table = $("#category-table").DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.user.index') }}",
      order: [[ 0, "desc" ]],
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        { data: 'name', name: 'title' }, 
        { data: 'email', name: 'email' }, 
        { data: 'mobile_number', name: 'mobile_number' }, 
        { data: 'created_at', name: 'created_at' }, 
        { data: 'status', name: 'status', default:'' }, 
        { data: 'action', name: 'action', orderable: false }, 
      ]
       
    });
    
  });
</script>

@endsection

@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@endsection