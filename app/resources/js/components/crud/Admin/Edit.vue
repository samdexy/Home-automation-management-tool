<template>
<div>
<sidebar></sidebar>
<div class="divMinSideabar ml-64">
      <div class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg">

          <div class="m-auto w-2/3">
                    <h2 class="text-3xl w-full text-center mb-6">Edit user</h2>

                               
                    <form action="w-full mb-12">

                            <div class="mb-8">
                            <label class="block text-dimmedTxt text-sm mb-2" for="desc">
                                NAME
                            </label>
                            <input class="border border-box rounded-lg w-full py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline" id="desc" type="text" v-model="user.name">
                            </div>  

                            <div class="mb-8">
                            <label class="block text-dimmedTxt text-sm mb-2" for="email">
                                EMAIL
                            </label>
                            <input class="border border-box rounded-lg w-full py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline" id="email" type="email" v-model="user.email">
                            </div>  
                            <div class="mb-8">
                            <label class="block text-dimmedTxt text-sm mb-2" for="password">
                                PASSWORD
                            </label>
                            <input class="border border-box rounded-lg w-full py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline" id="password" type="password" v-model="user.password">
                            </div>    

                            <div class="mb-12">
                            <label class="block text-dimmedTxt text-sm mb-2" for="password">
                                ROLE
                            </label>
                             <v-select class="border rounded-lg w-full focus:outline-none focus:shadow-outline" label="title" :options="select" v-model="user.role"></v-select>

                            </div> 




                                  <button v-on:click="updateUser()" class="block w-40 m-auto mb-12 gradGreen text-white font-medium py-3 px-4 rounded-full focus:outline-none focus:shadow-outline" type="button">
                                    Save
                                  </button>          

                    </form>
          </div>

</div>
</div>
</div>
</template>

<script>
import Sidebar from '../../partials/Sidebar';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Outlet from '../../../services/Outlet/Outlet';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

    export default {
    name: 'create',

    components: {
        Sidebar,
        FontAwesomeIcon,
        vSelect
    },

    data() {

        return {

            user: {
                name: '',
                email: '',
                role: {
                  id: '',
                  title: '',
                }
            },
            select: [],
      
      
    

        };
    },

    created() {

                axios.request({
                        baseURL: 'http://localhost:8000/api/v1/roles',
                        method: 'get',
                }).then(res => {
                     
                    for (let i = 0; i < Object.keys(res.data).length; i++) {
                    
                    let roleObj = {
                        id: '',
                        title: '',
                         
                    };

                    roleObj.title = res.data[i].title
                    roleObj.id = res.data[i].id

                    this.select.push(roleObj)
                    console.log(this.select)

                }
                })

                let id = this.$route.params.id

                 axios.request({
                        baseURL: 'http://localhost:8000/api/v1/users/' + id,
                        method: 'get',
                }).then(res => {

                    this.user.name = res.data[0].name;
                    this.user.email = res.data[0].email
                    this.user.role.title = res.data[0].role[0].title;
                    this.user.role.id = res.data[0].role[0].id;



                })


    },
    
        
    methods: {

              updateUser(){

                    this.user.role = this.user.role.id
                    

                    console.log('new user: ', this.user)


                          axios.request({
                                    baseURL: 'http://localhost:8000/api/v1/users/' + this.$route.params.id,
                                    method: 'put',
                                    data: this.user
                                }).then(() => {
                                        this.$router.push({ name: 'admin.users' })
                                });


              }
  

    }

    }
</script>
