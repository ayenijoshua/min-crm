<template>
    <form method="post" :action="postAction" @submit.prevent>
        <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="form.name" placeholder="name" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="form.email" placeholder="email" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <label for="basic-url" class="form-label">Company</label>
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example">
                <option selected>Select company</option>
                <option v-for="(company, index) in companies" :key="index" :value="company.id">{{company.name}}</option>
            </select>
        </div>
        <div class="input-group mb-3">
            <input type="submit" value="submit" class="btn btn-primary" @click="submit()">
        </div>
        
    </form>
</template>

<script>
//import Input from '../../../vendor/laravel/breeze/stubs/inertia/resources/js/Components/Input.vue';
export default {
  //components: { Input },
    name:'CreateUserComponent',
    props:{
        panelTitle:{
            default:'Create',
            type:String,
            required:true
        },
        postAction:{
            type:String,
            required:true
        },
        
    },
    data(){
        return{
            form:{
                email:'',
                name:'',
                password:'password'
            },

            companies:[],

        }
    },

    created(){
        axios.get('/companies')
        .then(res=>{
            if (res.data.success) {
                this.companies = res.data.companies
            }else{
                 toastr.error(res.data.message);
            }
        }).catch(err => {
            toastr.error("An error occured, please try again")
            console.log(err);
        });
    },

    methods: {
        submit(){
            axios.post(this.postAction, this.form)
            .then(res => {
                if (res.data.success) {
                    toastr.success(res.data.message);
                } else {
                    toastr.warning(res.data.message);
                }
            })
            .catch(err => {
                if(err.response && err.response.status === 422){
                    //alert('ki')
                    toastr.error(err.response.data.message)
                }else{
                    toastr.error("An error occured, please try again")
                    console.log(err);
                }
            });
        }
    }


}
</script>