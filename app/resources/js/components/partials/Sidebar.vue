<template>
<div>

    <div class="float-left bg-darkgrey h-screen w-64">

    <h1 class="block m-autotext-white p-8">MENU</h1>
    <ul class="block text-white">
        <li class="block text-white py-4 px-8 border-b border-gray-400" @click.prevent="toHome"><a href="#"><i class="fas fa-home pr-2"></i><span>Home</span></a></li>
        <li class="block text-white py-4 px-8 border-b border-gray-400" v-if='role == "Administrator"' @click.prevent="toStats"><a href="#"><i class="fas fa-chart-bar pr-2"></i><span>Stats</span></a></li>
        <li class="block text-white py-4 px-8 border-b border-gray-400"><a href="#" @click.prevent="toActions"><i class="fas fa-play-circle pr-2"></i><span>Actions</span></a></li>
        <li class="block text-white py-4 px-8 border-b border-gray-400" v-if='role == "Administrator"' @click.prevent="toAdmin"><a href="#"><i class="fas fa-users pr-2"></i><span>Users</span></a></li>
        <li class="block text-white py-4 px-8 border-b border-gray-400"><a href="#" @click.prevent="logout"><i class="fas fa-sign-out-alt pr-2"></i><span>Logout</span></a></li>

    </ul>

    </div>
</div>
</template>

<script>

import axios from 'axios';

    export default {
        data: () => ({
             csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
             role: ''
             }),   
             created(){
               
               const userData = JSON.parse(localStorage.getItem('auth_user'))
                this.role = userData[0].role[0].title

             },
        methods:{
            logout:function(){
                
               axios.post('logout')
               window.location.reload()
            },
            toAdmin:function(){
              this.$router.push({ name: 'admin.users' })
            },
            toHome:function(){
              this.$router.push({ name: 'home' })
            },
            toStats:function(){
              this.$router.push({ name: 'stats' })
            },
            toActions:function(){
              this.$router.push({ name: 'actions' })
            },

        },
    }
</script>
