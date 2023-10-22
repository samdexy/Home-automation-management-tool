import './bootstrap.js';

import Vue from 'vue';
import router from './routes'
import indexHome from './components/Index';
import Sidebar from './components/partials/Sidebar';
import editOutlet from './components/crud/Home/Edit';
import indexUsers from './components/crud/Admin/Index';
import createUser from './components/crud/Admin/Create';
import editUser from './components/crud/Admin/Edit';
import stats from './components/crud/Stats/Index';
import actions from './components/crud/Actions/Index';
import { firestorePlugin } from 'vuefire'



import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import ApexCharts from 'apexcharts'
import VueApexCharts from 'vue-apexcharts'

Vue.use(VueApexCharts, firestorePlugin)


Vue.config.productionTip = false        
Pusher.logToConsole = true;


router.beforeEach(
    (to, from, next) => {
        const userData = JSON.parse(localStorage.getItem('auth_user'))

    if (userData) {
      if (!to.meta.authUser) {

        if(userData[0].role[0].title === 'User') {
            next('/') 

        } else {
        next()
      }
            
        } else next()
      }
    }
  ) 

  Pusher.logToConsole = true;

  var firebaseConfig = {
    apiKey: "AIzaSyD-FrzeC-azgzmYsPKIibDl0kf0d_iL1uo",
    authDomain: "wot-2ex.firebaseapp.com",
    databaseURL: "https://wot-2ex.firebaseio.com",
    projectId: "wot-2ex",
    storageBucket: "",
    messagingSenderId: "388088760008",
    appId: "1:388088760008:web:1f84130ae6d00641"
  };


  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);


new Vue({
    el: '#app',
    router,
    components: {
        indexHome,
        Sidebar,
        FontAwesomeIcon,
        editOutlet,
        indexUsers,
        createUser,
        editUser,
        stats,
        actions,
        ApexCharts
        
    },

});
