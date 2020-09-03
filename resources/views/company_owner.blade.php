<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 6 CRUD using Ajax</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 
</head>
 <body>
  <div class="container">    
     <br />
     <h3 align="center">Laravel 6 CRUD using Ajax</h3>
     <br />
     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
     </div>
     <br />
   <div class="table-responsive">
    <table id="company_table" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="15%">Company Name</th>
                <th width="15%">Owner Type</th>
                <th width="25%">Owner Name</th>
                <th width="25%">Ownership Percentage</th>
                <th width="20%"></th>
      </tr>
     </thead>
    </table>
   </div>
   <br />
   <br />
  </div>
 </body>
</html>

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4">Company Name : </label>
            <div class="col-md-8">
             <select name="company_id" id="company_id" class="form-control">
                <option value="">Select Company</option>
                @foreach($company as $comp)
                <option value="{{ $comp->id}}">{{ $comp->company_name }}</option>
                @endforeach
             </select>
             
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Owner Type : </label>
            <div class="col-md-8">
             <input type="text" name="owner_type" id="owner_type" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Owner Name : </label>
            <div class="col-md-8">
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Select Company Owner</option>
                    @foreach($user as $comp)
                    <option value="{{ $comp->id}}">{{ $comp->user_name }}</option>
                    @endforeach
                 </select>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Ownership Percentage(%) : </label>
            <div class="col-md-8">
             <input type="text" name="ownership_percentage" id="ownership_percentage" class="form-control" >
             
            </div>
           </div>
                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                </div>
         </form>
        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){

 $('#company_table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "{{ route('company_owner.index') }}",
  },
  columns: [
   {
    data: 'company_name',
    name: 'company_name'
   },
   {
    data: 'owner_type',
    name: 'owner_type'
   },
   {
    data: 'user_name',
    name: 'user_name'
   },
   {
    data: 'ownership_percentage',
    name: 'ownership_percentage'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 $('#create_record').click(function(){
  $('.modal-title').text('Add New Record');
  $('#action_button').val('Add');
  $('#action').val('Add');
  $('#form_result').html('');

  $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  var action_url = '';

  if($('#action').val() == 'Add')
  {
   action_url = "{{ route('company_owner.store') }}";
  }

  if($('#action').val() == 'Edit')
  {
   action_url = "{{ route('company_owner.update') }}";
  }

  $.ajax({
   url: action_url,
   method:"POST",
   data:$(this).serialize(),
   dataType:"json",
   success:function(data)
   {
    var html = '';
    if(data.errors)
    {
     html = '<div class="alert alert-danger">';
     for(var count = 0; count < data.errors.length; count++)
     {
      html += '<p>' + data.errors[count] + '</p>';
     }
     html += '</div>';
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     $('#company_table').DataTable().ajax.reload();
     setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#company_table').DataTable().ajax.reload();
     alert('New Company Added');
    }, 20);
    }
    $('#form_result').html(html);
   }
  });
 });

 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url :"/company_owner/"+id+"/edit",
   dataType:"json",
   success:function(data)
   {
    $('#company_id').val(data.result.company_id);
    $('#owner_type').val(data.result.owner_type);
    $('#user_id').val(data.result.user_id);
    $('#ownership_percentage').val(data.result.ownership_percentage);
    $('#hidden_id').val(id);
    $('.modal-title').text('Edit Record');
    $('#action_button').val('Edit');
    $('#action').val('Edit');
    $('#formModal').modal('show');
    
   }
  })
 });

 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"company/destroy/"+user_id,
   beforeSend:function(){
    $('#ok_button').text('Deleting...');
   },
   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#company_table').DataTable().ajax.reload();
     alert('Data Deleted');
    }, 20);
   }
  })
 });

});
</script>


