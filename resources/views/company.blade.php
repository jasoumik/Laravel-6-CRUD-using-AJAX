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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
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
                <th width="15%">Ownership Type</th>
                <th width="25%">Date Started</th>
                <th width="25%">Date Ended</th>
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
            <label class="control-label col-md-4" >Company Name : </label>
            <div class="col-md-8">
             <input type="text" name="company_name" id="company_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Ownership Type : </label>
            <div class="col-md-8">
             <input type="text" name="ownership_type" id="ownership_type" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Date Started : </label>
            <div class="col-md-8">
             <input type="text" name="date_started" id="date_started" class="form-control date" />
             <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Date Ended : </label>
            <div class="col-md-8">
             <input type="text" name="date_ended" id="date_ended" class="form-control date" />
             <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
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
<script type="text/javascript">
    $('.date').datepicker({  
       format: 'yyyy-mm-dd'
     });  
</script>

<script>
$(document).ready(function(){

 $('#company_table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "{{ route('company.index') }}",
  },
  columns: [
   {
    data: 'company_name',
    name: 'company_name'
   },
   {
    data: 'ownership_type',
    name: 'ownership_type'
   },
   {
    data: 'date_started',
    name: 'date_started'
   },
   {
    data: 'date_ended',
    name: 'date_ended'
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
   action_url = "{{ route('company.store') }}";
  }

  if($('#action').val() == 'Edit')
  {
   action_url = "{{ route('company.update') }}";
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
   url :"/company/"+id+"/edit",
   dataType:"json",
   success:function(data)
   {
    $('#company_name').val(data.result.company_name);
    $('#ownership_type').val(data.result.ownership_type);
    $('#date_started').val(data.result.date_started);
    $('#date_ended').val(data.result.date_ended);
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


