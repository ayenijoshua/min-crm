<template>
    <div class="">
        <div class="table-responsive">
            <table class="table table-hovered table-bordered ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>logo</th>
                        <th>url</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr v-for="company in companies.data" :key="company.id">
                            <td>{{company.name}}</td>
                            <td>{{company.email}}</td>
                            <td>
                                <img :src="company.logo_path" height="100" width="100">
                            </td>
                            <td>{{company.url}}</td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">action</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="dropdown-item" :href="'edit-company/'+company.id">Edit</a>
                                        <a class="dropdown-item" @click="destroy(company.id)">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>

        <div class="row table-responsive">
            <div class="col">
                <pagination :data="companies" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination';
export default {
    name:'companiesComponent',
    comments:{pagination},
    data(){
        return{
            companies:{}
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
    
            axios.get('/companies/paginate=true?page=' + page)
                .then(res => {
                    this.companies = res.data.companies;
                });
        },

        destroy(id){
          if(confirm("Do you want to delete this company?")){
              axios.delete('/admin/delete-company/'+id)
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