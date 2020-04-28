<template>    
    <div class="card-body">
        <table class="table table-bordered" id="employee-table">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Joined Date</th>
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
            $('#employee-table').DataTable({
                    "processing": true,
                    "serverSide":false,
                    "bLengthChange": false,
                    "ajax": {
                    "url": '/api/employee'
                },
                "columns": [
                    { "width":"23%","data": "name" },
                    { "width":"20%","data": "email" },
                    { "width":"18%","data": "department" },
                    { "width":"22%","data": "joined_date" },
                    { "width":"17%","data": "action" }
                ],
                "drawCallback": function() {                
                    $(".deleteEmployee").click(function(event) {
                        var employee_id = $(this).data('id');
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
                                axios.post('/api/employee/delete/'+employee_id).then((response)=>{
                                  Swal.fire(
                                    'Deleted!',
                                    'employee has been deleted.',
                                    'success'
                                  )                                    
                                  $('#employee-table').DataTable().ajax.reload();
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
