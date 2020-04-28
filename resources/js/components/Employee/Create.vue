<template>    
    <div class="card-body">
        <div class="form-group">
            <label for="employee_name">Name</label>
            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="e.g: Ram Bahadur Thapa" v-model="employee_name" @keyup.enter="focusNext('employee_email')">
            <div class="error text-danger" v-if="!$v.employee_name.required && $v.employee_name.$dirty">Employee Name is required</div>
        </div>
        <div class="form-group">
            <label for="employee_email">Email</label>
            <input type="email" class="form-control" name="employee_email" id="employee_email" placeholder="name@example.com" v-model="employee_email" @change="changeEmail()" @keyup.enter="focusNext('employee_department')">
            <div class="error text-danger" v-if="!$v.employee_email.required && $v.employee_email.$dirty">Employee Email is required</div>
            <div class="error text-danger" v-if="check_email != 0">Employee Email already taken</div>
        </div>

        <div class="form-group">
            <label for="employee_department">Department</label>
            <select class="form-control" id="employee_department" name="employee_department" v-model="employee_department">
            <option v-for="department in department_list" :value="department.id">{{department.name}}</option>
            </select>
            <div class="error text-danger" v-if="!$v.employee_department.required && $v.employee_department.$dirty">Employee Department is required</div>
        </div>
        <div class="form-group">
            <label for="employee_joined_date">Joined Date</label>
            <VueCtkDateTimePicker name="employee_joined_date" :only-date=true v-model="employee_joined_date" />
            <div class="error text-danger" v-if="!$v.employee_joined_date.required && $v.employee_joined_date.$dirty">Employee Joined Date is required</div>
        </div>
        <button v-if="id==0" class="btn btn-success float-right" @click="saveEmployee()">Save</button>
        <button v-else class="btn btn-success float-right" @click="updateEmployee()">Update</button>
    </div>                
</template>

<script>
    import { required } from 'vuelidate/lib/validators';
    export default {
        data(){
            return {
                department_list: [],
                employee_name : '', 
                employee_email : '', 
                employee_department : '', 
                employee_joined_date : '', 
                check_email: 0,
            }
        },
        validations: {
            employee_name: { required},
            employee_email: { required},
            employee_department: { required},
            employee_joined_date: { required},
        },
        props: ['id'],
        mounted() {
            let that = this;
            that.fetchDepartment();
            if(that.id > 0){
                that.fetchDataForEdit();
            } 
            that.focusNext('employee_name');
        },
        methods:{
            focusNext(nextId){
                let next_focus_id = '#' + nextId;
                $(next_focus_id).focus();
            },
            fetchDepartment(){
                let that = this;
                axios.get('/api/department/list/')
                .then(function (response) {
                    that.department_list = response.data.department_list;
                })
                .catch(function (error) {
                    console.error(error);
                });
            },
            changeEmail(){
                let that = this;
                axios.post('/api/employee/check_email/',{
                    employee_email : that.employee_email,
                    id : that.id
                })
                .then(function (response) {
                    that.check_email = response.data.email_exist;
                })
                .catch(function (error) {
                    console.error(error);
                });
            },
            saveEmployee(){
                let that = this;
                that.$v.$touch();
                if(that.$v.$invalid || that.check_email != 0) {
                    console.log('validaion error');
                } else { 
                    axios.post('/api/employee', {
                        employee_name: that.employee_name,
                        employee_email: that.employee_email,
                        employee_department: that.employee_department,
                        employee_joined_date: that.employee_joined_date
                    })
                    .then(function (response) {
                        that.employee_name = '';
                        that.employee_email = '';
                        that.employee_department = '';
                        that.employee_joined_date = '';
                        that.check_email = 0;

                        Swal.fire(
                                  'Success!',
                                  'Department Saved!',
                                  'success'
                                );
                        that.$v.$reset();
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                }
            },
            fetchDataForEdit(){
                let that = this;
                axios.get('/api/employee/edit/'+that.id)
                .then(function (response) {
                    that.employee_name = response.data.employee_info.name;
                    that.employee_email = response.data.employee_info.email;
                    that.employee_department = response.data.employee_info.department_id;
                    that.employee_joined_date = response.data.employee_info.joined_date;
                })
                .catch(function (error) {
                    console.error(error);
                });
            },
            updateEmployee(){
                let that = this;
                that.$v.$touch();
                if(that.$v.$invalid || that.check_email != 0) {
                    console.log('validaion error');
                } else { 
                    axios.put('/api/employee/update/'+that.id, {
                        employee_name: that.employee_name,
                        employee_email: that.employee_email,
                        employee_department: that.employee_department,
                        employee_joined_date: that.employee_joined_date
                    })
                    .then(function (response) {
                        Swal.fire(
                                  'Success!',
                                  'Department Saved!',
                                  'success'
                                );
                        that.$v.$reset();
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                }
            },
        }
    }
</script>
