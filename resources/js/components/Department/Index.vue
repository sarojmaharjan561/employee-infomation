<template>
  <div class="card-body">
    <table class="table table-bordered" id="department-table">
      <thead>
         <tr>
            <th>Name</th>
            <th>Action</th>
         </tr>
      </thead>
   </table>
  </div>                
</template>

<script>
    export default {
        mounted() {
            let that = this;
            that.initializeDatatable();
        },
        methods:{
          initializeDatatable(){
          let that = this;
          $('#department-table').DataTable({
              "processing": true,
              "serverSide":false,
              "bLengthChange": false,
              "ajax": {
                "url": '/api/department'
              },
              "columns": [
                { "width":"80%","data": "name" },
                { "width":"20%","data": "action" }
              ],
              "drawCallback": function() {                
                $(".deleteDepartment").click(function(event) {
                  var department_id = $(this).data('id');
                  Swal.fire({
                              title: 'Are you sure?',
                              text: "You won't be able to revert this!",
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes, delete it!'
                            })
                            .then((result) => {
                              if (result.value) {
                                axios.post('/api/department/delete/'+department_id).then((response)=>{
                                  Swal.fire(
                                    'Deleted!',
                                    'Department has been deleted.',
                                    'success'
                                  )                                    
                                  $('#department-table').DataTable().ajax.reload();
                                });
                              }
                            })
                });
              }
          });
        },
      }
    }
</script>
