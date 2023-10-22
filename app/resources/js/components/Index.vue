<template>
  <div>
    <sidebar></sidebar>
    <div class="divMinSideabar ml-64">
      <div
        v-for="plug in plugs"
        class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-32 shadow-lg rounded-lg"
      >
        <a href="#"
          @click.prevent="toggleOutlet(plug.device_id)"
          v-bind:class="(plug.status == 1)?'gradGreen':'gradRed'"
     
          class="block float-left shadow rounded-full w-20 h-20 flex items-center justify-center"
        >
           <i class="block box-sizing-off fas fa-power-off mt-2 text-2xl text-white"></i>
        </a>

        <div class="h-32 mx-16 float-left">
          <h1 class="text-3xl">{{plug.alias}}</h1>

          <p class="text-dimmedTxt" v-if="plug.category_id == 1">

             <i class="fas fa-thermometer-quarter pr-2 text-green text-lg"></i> Temperature device
             
          </p>
          <p class="text-dimmedTxt" v-if="plug.category_id == 2">

            <i class="far fa-lightbulb pr-2 text-green text-lg"></i> Lighting
          
          </p>
          <p class="text-dimmedTxt" v-if="plug.category_id == 3">

            <i class="fas fa-bolt pr-2 text-green text-lg"></i> Extention cable

          </p>
          <p class="text-dimmedTxt" v-if="plug.category_id == 4">

            <i class="fas fa-cog pr-2 text-green text-lg"></i> Device

          </p>

          <input v-model="plug.status" type="hidden">

        </div>



        <router-link
          tag="a"
          class-active="active"
          class="block link m-auto absolute inset-y-0 right-0 p-8 text-darkgrey h-5"
          :to="{ name: 'home.edit', params: { id: plug.device_id }}"
        >
          <i class="fas fa-chevron-right fa-lg"></i>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import Outlet from "../services/Outlet/Outlet";
import Sidebar from "./partials/Sidebar";
import Edit from "./crud/Home/Edit";
import axios from "axios";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "home",

  components: {
    Sidebar,
    FontAwesomeIcon,
    Edit
  },

  data() {
    return {
      plugs: [],
      xprops: {
        module: "indexHome",
        route: "home",
      }
    };
  },

  created() {
    this.plugs = [];

    Outlet.getToken().then(tokenRes => {
      Outlet.outletGetList(tokenRes.data.result.token).then(resDevices => {
        let arrDevices = resDevices.data.result.deviceList;
        let newChangedDeviceDB = [];

        axios
          .request({
            baseURL: "http://localhost:8000/api/v1/devices",
            method: "get"
          })
          .then(res => {
            if (res.data.length) {
                //console.log("NOT EMPTY")
              for (let i = 0; i < Object.keys(res.data).length; i++) {
                let dataDB = {};

               

                dataDB.name = res.data[i].name;
                dataDB.alias = res.data[i].alias;
                dataDB.device_id = res.data[i].device_id;
                dataDB.category_id = res.data[i].category_id;
                newChangedDeviceDB.push(dataDB);
                

              }


              axios.request({
                baseURL: "http://localhost:8000/api/v1/devices",
                method: "delete"
              });

              for (let i = 0; i < arrDevices.length; i++) {
                let outlet = {};

                outlet.name = arrDevices[i].alias;
                outlet.device_id = arrDevices[i].deviceId;
                outlet.alias = arrDevices[i].alias;
                outlet.category_id = arrDevices[i].category_id;

                    if(newChangedDeviceDB.length){

                for (let g = 0; g < newChangedDeviceDB.length; g++) {

                  if (arrDevices[i].deviceId == newChangedDeviceDB[g].device_id) {

                    outlet.alias = newChangedDeviceDB[g].alias;
                    outlet.category_id = newChangedDeviceDB[g].category_id;
                    
                  }


                }
                        
                    }


                    axios.request({
                    baseURL: "http://localhost:8000/api/v1/devices",
                    method: "post",
                    data: outlet
                  });
                

                let outletForFront = outlet

                Outlet.outletInfo(
                  tokenRes.data.result.token,
                  outletForFront.device_id
                ).then(resState => {
                
                  let toParse = JSON.parse(resState.data.result.responseData);
                  outletForFront.status = toParse.system.get_sysinfo.relay_state;
             

                this.plugs.push(outletForFront);

                });

                
              }
            } else {

                //console.log("EMPTY")

              for (let i = 0; i < arrDevices.length; i++) {

                let newDevice = {
                  name: arrDevices[i].alias,
                  device_id: arrDevices[i].deviceId,
                  alias: arrDevices[i].alias,
                  category_id: 4,
                  status: 0
                };

                 Outlet.outletInfo(
                 tokenRes.data.result.token,
                newDevice.device_id
                ).then(resState => {

               // console.log(resState, '  <<<< resState if db empty')
                
                  let toParse = JSON.parse(resState.data.result.responseData);
                  newDevice.status = toParse.system.get_sysinfo.relay_state;
                });

                this.plugs.push(newDevice);
                axios.request({
                  baseURL: "http://localhost:8000/api/v1/devices",
                  method: "post",
                  data: newDevice
                });
              }
            }
          });
      });
    });
  },

  methods: {
    toggleOutlet(deviceId) {
      for (let i = 0; i < this.plugs.length; i++) {
        if (deviceId == this.plugs[i].device_id) {
          if (this.plugs[i].status == 0) {
            //console.log(this.plugs[i].deviceId)
            this.plugs[i].status = 1;

            Outlet.getToken().then(tokenRes => {
              Outlet.outletRequest(
                tokenRes.data.result.token,
                1,
                this.plugs[i].device_id
              ).then(res => {
                let toParse = JSON.parse(res.data.result.responseData);
                this.plugs[i].status = toParse.system.get_sysinfo.relay_state;
              });
            });
          } else if (this.plugs[i].status == 1) {
            //console.log(this.plugs[i].deviceId)
            this.plugs[i].status = 0;

            Outlet.getToken().then(tokenRes => {
              Outlet.outletRequest(
                tokenRes.data.result.token,
                0,
                this.plugs[i].device_id
              ).then(res => {
                let toParse = JSON.parse(res.data.result.responseData);
                //this.plugs[i].status = toParse.system.get_sysinfo.relay_state;
              });
            });
          }
        }
      }

 

      //this.reloadPage();
    },
  getCategory() {




      },
    reloadPage() {
      window.location.reload();
    }
  }
};
</script>
