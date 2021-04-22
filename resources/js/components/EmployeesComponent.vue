<template>
    <div class="">
        <div class="table-responsive">
            <table class="table table-hovered table-bordered ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tr v-if="employees.data && employees.data.length==0">
                    <td colspan="3">
                        <div class="bg-warning text-center">There no employees</div>
                    </td>
                </tr>
                    <tbody>
                        <tr v-for="user in employees.data" :key="user.id">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                        </tr>
                    </tbody>
            </table>
        </div>

        <div class="row table-responsive">
            <div class="col">
                <pagination :data="employees" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination';
export default {
    name:'employeesComponent',
    comments:{pagination},
    props:{
        companyId:{
            type:String,
            required:true
        }
    },
    data(){
        return{
            employees:{}
        }
    },

    created(){

        this.getResults()
    },

    methods:{
        getResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
    
            axios.get('/company/'+this.companyId+'employees/?page=' + page)
                .then(res => {
                    this.employees = res.data.employees;
                });
        },

        destroy(id){
          if(confirm("Do you want to delete this user?")){
              axios.delete('/admin/delete-user/'+id)
              .then(res=>{
                  if (res.data.success) {
                    this.getResults()
                    toastr.success(res.data.message);
                 }else{
                    toastr.error(res.data.message);
                 }
              }).catch(err => {
                toastr.error("An error occured, please try again")
                console.log(err);
            });
          }
        }
    }
}
</script>