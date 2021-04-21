<template>
    <div class="">
        <div class="table-responsive">
            <table class="table table-hovered table-bordered ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.company.name}}</td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">action</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                                        <a class="dropdown-item" :href="'edit-user/'+user.id">Edit</a>
                                        <a class="dropdown-item" @click="destroy(user.id)">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>

        <div class="row table-responsive">
            <div class="col">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination';
export default {
    name:'UsersComponent',
    comments:{pagination},
    data(){
        return{
            users:{}
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
    
            axios.get('/admin/all-users?page=' + page)
                .then(res => {
                    this.users = res.data.users;
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