<template>
    <div class="">
        <div class="table-responsive">
            <table class="table table-hovered ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.company.name}}</td>
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
        }
    }
}
</script>