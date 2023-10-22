<template>
<div>
<sidebar></sidebar>
<div class="divMinSideabar ml-64">
      <div class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg">

          <div class="m-auto w-full m-6">
              <div class="h-16">
                    <h2 class="block float-left text-2xl w-1/2 text-left">Admin panel</h2>
                     <button @click.prevent="toCreate()" class="block float-right w-auto gradGreen text-center text-white font-medium py-3 px-4 rounded-full focus:outline-none focus:shadow-outline" type="button">
                                   <i class="fas fa-plus-circle pr-2"></i>  Add user
                     </button> 
              </div>


                    <table class="w-full userTable mt-16">
                        <thead class="h-12">
                        <tr class="text-medgrey border-b-2 border-bootstrapGrey font-normal text-left">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user, index in users" class="h-12 border-b-2 border-bootstrapGrey">
                            <td>{{user.id}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.role}}</td>
                            <td class="text-green">
                                <a href="#" class="inline-block mr-8" @click.prevent="toEdit(user.id)">
                                     <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="inline-block" @click.prevent="toDelete(index, user.id)">
                                     <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                  
          </div>

</div>
</div>
</div>
</template>

<script>
import Sidebar from '../../partials/Sidebar';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Outlet from '../../../services/Outlet/Outlet';
import axios from "axios";


    export default {
    name: 'users',

    components: {
        Sidebar,
        FontAwesomeIcon
    },

    data() {

        return {

        users: [],
        xprops: {
        module: "indexUsers",
        route: "admin.users",
      }
    

        };
    },

    created() {


                    axios.request({
                            baseURL: 'http://localhost:8000/api/v1/users',
                            method: 'get',
                    }).then(res => {


                    for (let i = 0; i < Object.keys(res.data).length; i++) {

                    let userObj = {};

                    console.log(i, Object.keys(res.data).length);
                    console.log(res.data);

                        userObj.id = res.data[i].id
                        userObj.name = res.data[i].name
                        userObj.email = res.data[i].email


                    axios.request({
                            baseURL: 'http://localhost:8000/api/v1/roles',
                            method: 'get',
                    }).then(resRoles => {

                    let roleId = res.data[i].role[0].id;


                    for (let o = 0; o < Object.keys(resRoles.data).length; o++) {

                     if(roleId == resRoles.data[o].id){

                          userObj.role = resRoles.data[o].title;
                          this.users.push(userObj)

                        console.log(this.users)

                        }


                    }

                
                    })
                        
                        
                    }

                    })

    },
    
        
    methods: {

              toEdit(userId){
                   this.$router.push({ name: 'admin.users.edit', params: { id: userId}})


              },
               toDelete(index, userId){
                   axios.request({
                            baseURL: 'http://localhost:8000/api/v1/roles/' + userId,
                            method: 'delete',
                    }).then(res => {

                        this.users.splice(index, 1)

                    })

              },

               toCreate(){
                this.$router.push({ name: 'admin.users.create' })

              }


    }

    }
</script>
