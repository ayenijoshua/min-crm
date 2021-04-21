<template>
    <div class="container-fluid">
        <div class="row main-content bg-success text-center">
            <div class="col-md-4 text-center company__info">
                <span class="company__logo"><h2><span class="fa fa-android"></span></h2></span>
                <h4 class="company_title"><a href="/" >Mini-CRM</a></h4>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                <div class="container-fluid">
                    <div class="row">
                        <h2>{{panelTitle}}</h2>
                    </div>
                    <div class="row">
                        <form method="post" :action="postAction" class="form-group" @submit.prevent>
                            <div class="row">
                                <input type="text" v-model="loginForm.email" id="username" class="form__input" placeholder="Eail">
                            </div>
                            <div class="row">
                                <!-- <span class="fa fa-lock"></span> -->
                                <input type="password" v-model="loginForm.password" id="password" class="form__input" placeholder="Password">
                            </div>
                            
                            <div class="row">
                                <input type="submit" value="Submit" class="btn" @click="submit()">
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <p>Don't have an account? <a href="#">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'LoginComponent',
    props:{
        panelTitle:{
            default:'login',
            type:String,
            required:true
        },
        postAction:{
            type:String,
            required:true
        }
    },
    data(){
        return{
            loginForm:{
                email:'',
                password:''
            }
        }
    },

    methods: {
        submit(){
            axios.post(this.postAction, this.loginForm)
            .then(res => {
                if (res.data.success) {
                 location = res.data.redirect_url
                } else {
                    toastr.error(res.data.message);
                }
            })
            .catch(err => {
                if(err.response && err.response.status === 422){
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