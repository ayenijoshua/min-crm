<template>
    <form method="post" :action="postAction" @submit.prevent enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" v-model="form.name" placeholder="name" aria-label="companyname" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <input type="email" class="form-control" v-model="form.email" placeholder="email" aria-label="Recipient's name" aria-describedby="basic-addon2">
        </div>

        <label for="basic-url" class="form-label">Url</label>
        <div class="input-group mb-3">
            <input type="test" class="form-control" v-model="form.url" placeholder="url" aria-label="Recipient's name" aria-describedby="basic-addon2">
        </div>

        <label for="basic-url" class="form-label">Logo</label>
        <div class="input-group mb-3">
            <input type="file" @change="onImageChange" class="form-control" placeholder="url" aria-label="Recipient's name" aria-describedby="basic-addon2">
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
    name:'CreateCompanyComponent',
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
                url:'',
                logo_path:'',
                password:'password'
            },
            hasFile:false,

        }
    },

    created(){
        
    },

    methods: {
         onImageChange(e){
            console.log(e.target.files[0]);
            this.form.logo_path = e.target.files[0];
            this.hasFile = true;
        },
        submit(){
            let formData = new FormData();
            if(this.hasFile){
                formData.append("logo_path", this.form.logo_path);
                formData.append("name",this.form.name);
                formData.append("email",this.form.email);
                formData.append("url",this.form.url);
                formData.append("password",this.form.password);
            }
            axios.post(this.postAction, (this.hasFile ? formData : this.form))
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