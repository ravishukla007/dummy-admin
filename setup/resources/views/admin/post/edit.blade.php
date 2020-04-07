@extends('admin.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Post</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Post</li>
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
                <h3 class="card-title">Edit Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form action="{{ route('admin.post.update', request()->segment(3)) }}" id="post_form" method="post">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control" id="post_category">
                          <option value="">Select Category</option>
                          @foreach($categories as $category)
                            <option value="{{ $category->_id }}" data-type="{{ $category->type }}"
                              @if($post->category == $category->_id)
                                selected="selected"
                              @endif
                              >{{ $category->title }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Age Group</label> <br />
                         <select name="age_group" class="form-control" >
                            <option value="">Select age group</option>
                            <option value="3-to-5"
                              @if($post->getOriginal('age_group') == '3-to-5')
                                selected="selected"
                              @endif >3 to 5</option>
                            <option value="6-to-7"
                              @if($post->getOriginal('age_group') == '6-to-7')
                                selected="selected"
                              @endif >6 to 7</option>
                            <option value="8-to-13"
                              @if($post->getOriginal('age_group') == '8-to-13')
                                selected="selected"
                              @endif >8 to 13</option>
                         </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group" id="title_container">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" placeholder="Enter Title" name="title" 
                    value="{{ $post->title }}" />
                  </div>

                  <div class="form-group" id="asseturl_container">
                    <label for="exampleInputEmail1">Image/Video/PDF URL</label>
                    <input type="text" class="form-control" placeholder="Enter Asset URL" name="asset_url" 
                      value="{{ $post->asset_url }}" />
                  </div>
                  <div class="form-group">
                    <label>Preview Image</label> <br />
                     <input type="text" class="form-control" placeholder="Preview image url" name="preview_image" value={{ $post->image }} /> 
                  </div>

                  <div class="form-group" id="description_container">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea class="form-control" placeholder="Enter Description" name="description" id="description">{{ $post->description }}</textarea>
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
  
  $('#post_form').validate({
    rules: {
      title: {
        required: true,
        minlength: 10
      },
      asset_url: {
        required: true,
        url: true
      },
      description: {
        required: true,
        minlength: 50
      },
      category: {
        required: true,
      },
    }, 
    submitHandler: function (form) {
      
      globalAjax(form, function(res){
        
          window.location.assign('{{ route("admin.post.index") }}') 
      });
    }
  });

  $('#post_category').trigger('change');
  try {
    var editor = CKEDITOR.replace( 'description' );
    
    editor.on( 'change', function( evt ) {
        // getData() returns CKEditor's HTML content.
        $('#description').val( evt.editor.getData() );
    });
  }catch(e) { }


    
});

</script>

@endsection

@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@endsection