
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var globalAjax = (that, callback) => {

    var fname = that.getAttribute('name');
    var fid = that.getAttribute('id');

    $(that).find('button[name="submit"]').attr("disabled", true);
    $(that).find('button[name="submit"]').text('Loading...');
    
    // $('span[name="btn-loader"]').removeClass('d-none');

    $.ajax({
        url: that.getAttribute('action'),
        method: that.getAttribute('method'),             
        data: new FormData(that),
        dataType: 'JSON',
        contentType: false,
        cache: false,             
        processData: false,  
        success: function(resp) {
          
          if(resp.success == true) {

            callback(resp);
           
           // successToast(resp.message);
          } else if(resp.success == false) {
            alert(resp.message);
          } else {
            // errorToast(resp.message);
          }

          $('button[name="submit"]').attr("disabled", false);
          $('button[name="submit"]').text('Submit');
          // $('span[name="btn-loader"]').addClass('d-none');
        },
      error: function(resp) {
        if(resp.status == 422){   

          Object.keys(resp.responseJSON.message).forEach(field_name => {
              $(`#`+fid+`[name=${field_name}]`).addClass('is-invalid').siblings(`.invalid-feedback`).html(
                `<i class="fa fa-times-circle-o"></i> ${resp.responseJSON.message[field_name]}`
              );
          });
        }
        $('button[name="submit"]').attr("disabled", false);
        $('button[name="submit"]').text('Submit');
        // $('span[name="btn-loader"]').addClass('d-none');
      }
    });
  }

  $('#category_form').submit(function(e){
    e.preventDefault();
    globalAjax(this, function(res){
      $('#add_category').modal('hide');
        window.table.ajax.reload();
    });
  })

  $('#edit_category_form').submit(function(e){
    e.preventDefault();
    globalAjax(this, function(res){
      $('#edit_category').modal('hide');
        window.table.ajax.reload(null, false);
    });
  })


// Delete activity

$('body').on("click", '[data-action="trash"]', function(){
  // alert(this.getAttribute('data-id'))

  let that = this;
  if(confirm(this.getAttribute('data-confirm'))) {
    $.ajax({
        url: this.getAttribute('data-url'),
        method: 'DELETE',
        dataType: 'JSON',
        contentType: false,
        cache: false,             
        processData: false,  
        success: function(resp) {
          if(that.getAttribute('data-reloadlist') == "true") {
            window.table.ajax.reload(null, false);
          }
        }
      });
  }

});


$('#add_category').on('show.bs.modal', function (event) {

  document.getElementById('category_form').reset();
});
$('#edit_category').on('show.bs.modal', function (event) {

  document.getElementById('edit_category_form').reset();
  var button = $(event.relatedTarget) // Button that triggered the modal

  var modal = $(this);

  modal.find('form').attr('action', button.data('url'))
  modal.find('[name="title"]').val( button.data('title'))
  modal.find('[name="type"]').val( button.data('type'))
});


$('#post_category').change(function(){
    
    $('#title_container').show();
    $('#description_container').show();

    switch($(this).find(':selected').attr('data-type')) {
      case 'post':
        // code block
        break;
      case 'contest':
        // code block
        break;
      case 'image_gallery':
          $('#title_container').hide();
          $('#asseturl_container').hide();
          $('#description_container').hide();
          $('#post_type').val('0');

        break;
      case 'resources':
        // code block
        break;
      case 'magazines':
        $('#title_container').hide();
          $('#asseturl_container').hide();
          $('#description_container').hide();
          $('#post_type').val('2');
        break;
      default:
        // code block
      break;
    }

});