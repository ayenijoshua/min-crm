<template>
    <form method="post" :action="postAction" @submit.prevent>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" v-model="form.name" placeholder="name" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <input type="email" class="form-control" v-model="form.email" placeholder="email" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3">
            <input type="submit" value="submit" class="btn btn-primary" @click="submit()">
        </div>
        
    </form>
</template>

<script>
export default {
  
    name:'EditEmployeeComponent',
    props:{
        panelTitle:{
            default:'Edit',
            type:String,
            required:true
        },
        postAction:{
            type:String,
            required:true
        },
        userId:{
            type:String,
            required: true
        }
        
    },
    data(){
        return{
            user:{},
            companies:[],
            form:{
                email:'',
                name:'',
            },

        }
    },

    computed:{

    },

    created(){

        //get user
        axios.get('/employee/user/'+this.userId)
        .then(res=>{
            if (res.data.success) {
                this.user = res.data.user
                this.form.email = this.user.email
                this.form.name = this.user.name
            }else{
                 toastr.error(res.data.message);
            }
        })
        .catch(err => {
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