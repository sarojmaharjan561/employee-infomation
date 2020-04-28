<template>
    <div class="card-body">
        <div class="form-group">
            <label for="department_name">Department Name</label>
            <input type="text" class="form-control " name="department_name" id="department_name" placeholder="e.g: Account" v-model="department_name" @keyup.enter="id==0?focusNext('saveDepartment'):focusNext('updateDepartment')">
            <div class="error text-danger" v-if="!$v.department_name.required && $v.department_name.$dirty">Department Name is required</div>
        </div>
        <button v-if="id==0" id="saveDepartment" class="btn btn-success float-right" @click="saveDepartment()">Save</button>
        <button v-else id="updateDepartment" class="btn btn-success float-right" @click="updateDepartment()">Update</button>
    </div>
</template>

<script>    
    import { required } from 'vuelidate/lib/validators';
    export default {
        data(){
            return {
                department_name : '', 
            }
        },
        validations: {
            department_name: {
              required
            },
        },
        props: ['id'],
        mounted() {
            let that = this;
            if(that.id > 0){
                that.fetchDataForEdit();
            }          
            that.focusNext('department_name');
        },
        methods:{
            focusNext(nextId){
                let next_focus_id = '#' + nextId;
                $(next_focus_id).focus();
            },
            saveDepartment(){
                let that = this;
                that.$v.$touch();
                if(that.$v.$invalid) {
                    console.log('validaion error');
                } else {                    
                    axios.post('/api/department', {
                        department_name: that.department_name
                    })
                    .then(function (response) {
                        that.department_name = '';
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
                axios.get('/api/department/edit/'+that.id)
                .then(function (response) {
                    that.department_name = response.data.department_info.name;
                })
                .catch(function (error) {
                    console.error(error);
                });
            },
            updateDepartment(){
                let that = this;
                that.$v.$touch();
                if(that.$v.$invalid) {
                    console.log('validaion error');
                } else {                    
                    axios.put('/api/department/update/'+that.id, {
                        department_name: that.department_name
                    })
                    .then(function (response) {
                        Swal.fire(
                                  'Success!',
                                  'Department Updated!',
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
