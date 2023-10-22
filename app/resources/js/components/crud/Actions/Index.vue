<template>
  <div>
    <sidebar></sidebar>
    <div class="divMinSideabar ml-64">
      <div
        class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg"
      >
        <a
          href="#"
          :class="(sensors.temp == 0) ? 'text-bootstrapGrey border-bootstrapGrey' : (!switches.temp == 0) ? 'gradGreen text-white':'bg-transparent text-green border-green'"
          class="block float-left rounded-full w-20 h-20 flex items-center justify-center border cursor-default"
        >
          <i class="block fas fa-thermometer-quarter mt-2 text-4xl"></i>
        </a>

        <div class="h-32 ml-16 float-left w-1/2 h-auto">
          <h1 class="text-3xl">Temperature</h1>
          <p class="mb-4">
            Plugs labeled as a temperatue devices will go off/on after the degrees go
            <span class="font-semibold text-green">above or below 27°C</span>
          </p>

          <ul class="text-dimmedTxt pt-3 border-t border-bootstrapGrey">
            <li v-if="temps.length" v-for="temp in temps">
              <span class="inline-block text-xxs pr-3 pb-1 align-middle">&#9679;</span>
              {{ temp.name }}
            </li>
          </ul>
        </div>

        <div class="text-right float-right w-1/6">
          <label
            class="text-2xl"
            :class="(sensors.temp == 1) ?'text-dimmedTxt':'text-bootstrapGrey'"
            for="temp"
          >{{temp}} °C</label>

          <input class id="temp" type="hidden" v-model="temp" />
          <input class id="tempSensors" type="hidden" v-model="sensors.temp" />
          <input class id="tempSwitch" type="hidden" v-model="switches.temp" />

          <a
            @click.prevent="toggleSensor('temp', sensors.temp, temps.length != 0)"
            :class="(temps.length) ? 'cursor-pointer hover:bg-gray-100 text-gray-800 border-gray-400' : 'text-bootstrapGrey border-bootstrapGrey cursor-default'"
            class="block w-26 text-center bg-white mt-2 py-1 border rounded-full shadow no-underline text-sm"
          >
            <span v-if="sensors.temp == 1">Disable action</span>
            <span v-if="sensors.temp == 0">Enable action</span>
          </a>
        </div>
      </div>

      <div
        class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg"
      >
        <a
          href="#"
          v-bind:class="(!sensors.lights == 0) ? 'text-green border-green':'text-bootstrapGrey border-bootstrapGrey'"
          class="block float-left rounded-full w-20 h-20 flex items-center justify-center border cursor-default"
        >
          <i class="block far fa-lightbulb mt-2 text-4xl"></i>
        </a>

        <div class="h-32 ml-16 float-left w-1/2 h-auto">
          <h1 class="text-3xl">Lights</h1>
          <p class="mb-4">
            Plugs labeled as a light devices will go off/on when it's
            <span class="font-semibold text-green">dark or light</span>
          </p>

          <ul class="text-dimmedTxt pt-3 border-t border-bootstrapGrey">
            <li v-if="lights.length" v-for="light in lights">
              <span class="inline-block text-xxs pr-3 pb-1 align-middle">&#9679;</span>
              {{ light }}
            </li>
          </ul>
        </div>

        <div class="text-right float-right w-1/6">
          <label
            class="text-2xl"
            :class="(sensors.lights == 1) ?'text-dimmedTxt':'text-bootstrapGrey'"
          >
            <i class="fas fa-sun"></i>
          </label>
          <input class id="light" type="hidden" v-model="sensors.lights" />

          <!-- <input class="" type="hidden"> -->
          <a
            @click.prevent="toggleSensor('light', sensors.lights, lights.length != 0)"
            :class="(lights.length) ? 'cursor-pointer hover:bg-gray-100 text-gray-800 border-gray-400' : 'text-bootstrapGrey border-bootstrapGrey cursor-default'"
            class="block w-26 text-center bg-white mt-2 py-1 border rounded-full shadow no-underline text-sm"
          >
            <span v-if="sensors.lights == 0">Enable action</span>
            <span v-if="sensors.lights == 1">Disable action</span>
          </a>
        </div>
      </div>

      <div
        class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg"
      >
        <a
          href="#"
          :class="(cordsTotalStatus.val == 0) ?'bg-transparent text-red border-red' : (sensors.cords == 0) ? 'text-bootstrapGrey border-bootstrapGrey' : (switches.cords == 0) ?  'bg-transparent text-green border-green':'gradGreen text-white'"
          class="block float-left rounded-full w-20 h-20 flex items-center justify-center border cursor-default"
        >
          <i class="block fas fa-bolt mt-2 text-4xl"></i>
        </a>
        <div class="h-32 ml-16 float-left w-1/2 h-auto">
          <h1 class="text-3xl">Extention cables</h1>
          <p class="mb-4">
            Plugs labeled as extention cables will be turned off when they reach
            <span class="font-semibold text-green">a low of 300 mW</span>
          </p>

          <ul class="text-dimmedTxt pt-3 border-t border-bootstrapGrey">
            <li v-if="cords.length" v-for="cord in cords">
              <span class="inline-block text-xxs pr-3 pb-1 align-middle">&#9679;</span>
              {{ cord.name }}
            </li>
          </ul>
        </div>

        <div class="text-right float-right w-1/6">
          <label
            v-if="cordsTotalStatus.val == 1"
            :class="(sensors.cords == 1) ?'text-dimmedTxt':'text-bootstrapGrey'"
            class="text-2xl"
            for="totalMw"
          >
            <span v-if="totalMw !== 0"></span>
            {{totalMw}} mW
          </label>
          <label v-else class="text-xl text-red" for="cordsTotalStatus">{{cordsTotalStatus.text}}</label>

          <input class id="totalMw" type="hidden" v-model="totalMw" />
          <input class id="cordSensors" type="hidden" v-model="sensors.cords" />
          <input class id="cordSwitch" type="hidden" v-model="switches.cords" />
          <input class id="cordsTotalStatus" type="hidden" v-model="cordsTotalStatus" />

          <a
            @click.prevent="toggleSensor('cord',sensors.cords, cords.length != 0)"
            :class="(!cords.length) ? 'text-bootstrapGrey border-bootstrapGrey cursor-default' : ( cordsTotalStatus.val == 0) ? 'text-bootstrapGrey border-bootstrapGrey cursor-default':'cursor-pointer hover:bg-gray-100 text-gray-800 border-gray-400'"
            class="block w-26 text-center bg-white mt-2 py-1 border rounded-full shadow no-underline text-sm"
          >
            <span v-if="sensors.cords == 0">Enable action</span>
            <span v-if="sensors.cords == 1">Disable action</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "../../partials/Sidebar";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Outlet from "../../../services/Outlet/Outlet";
import axios from "axios";
import db from "../../../config/firebaseInit";

export default {
  name: "actions",

  components: {
    Sidebar,
    FontAwesomeIcon
  },

  data() {
    return {
      temps: [],
      lights: [],
      cords: [],

      tempDevStatus: Number,

      cordsTotalStatus: {
        val: 0,
        text: "Outlets offline"
      },

      temp: "",
      emeterData: [],
      totalMw: null,

      sensors: {
        temp: 0,
        lights: 0,
        cords: 0
      },

      switches: {
        temp: 0,
        lights: 0,
        cords: 0
      }
    };
  },
  mounted() {},
  created() {
    this.checkTemp();
    this.getLists();
    this.getCableData();
  },

  methods: {
    checkTemp() {
      if (this.sensors.temp == 1) {
        console.log("this.tempDevStatus", this.tempDevStatus);

        axios
          .request({
            baseURL: "https://wot-2ex.firebaseio.com/temp/value.json",
            method: "get"
          })
          .then(resTemp => {
            this.temp = resTemp.data.toFixed(1);

            if (this.temp <= "27") {
              console.log(this.temp);
              console.log(this.tempDevStatus);

              // colder than 27
              // all off

              this.switches.temp = 0;

              if (!this.tempDevStatus == 0) {
                for (let i = 0; i < this.temps.length; i++) {
                  console.log(this.temps[i].device_id, "OFF");
                  this.manageTempDevices(this.temps[i].device_id, 0);
                }

                this.tempDevStatus = 0;
              } else {
                this.tempDevStatus = 0;
              }
            } else {
              // warmer than 27
              // all on

              this.switches.temp = 1;

              console.log("this.tempDevStatus", this.tempDevStatus);

              if (!this.tempDevStatus == 1) {
                for (let i = 0; i < this.temps.length; i++) {
                  console.log(this.temps[i].device_id, "ON");
                  this.manageTempDevices(this.temps[i].device_id, 1);
                }

                this.tempDevStatus = 1;
              } else {
                this.tempDevStatus = 1;
              }
            }
          });
      }
    },
    manageTempDevices(devId, status) {
      Outlet.getToken().then(tokenRes => {
        Outlet.outletRequest(tokenRes.data.result.token, status, devId).then(
          res => {
            let toParse = JSON.parse(res.data.result.responseData);
            console.log("dev: ", toParse);
          }
        );
      });
    },

    freshCableUsage() {
      if (!this.sensors.cords == 0 && this.cordsTotalStatus.val == 1) {
        Outlet.getToken().then(tokenRes => {
          Outlet.outletGetList(tokenRes.data.result.token).then(resDevices => {
            let arrDevices = resDevices.data.result.deviceList;

            let nr = 0;

            for (let i = 0; i < this.emeterData.length; i++) {
              for (let o = 0; o < arrDevices.length; o++) {
                if (arrDevices[o].deviceId == this.emeterData[i].device_id) {
                  Outlet.outletUsage(
                    tokenRes.data.result.token,
                    arrDevices[o].deviceId
                  ).then(resUsage => {
                    let toParse = JSON.parse(resUsage.data.result.responseData);
                    if (!Number(toParse.emeter.get_realtime.power_mw) == 0) {
                      nr += Number(toParse.emeter.get_realtime.power_mw);
                      this.totalMw = nr;
                    }

                    if (this.totalMw < 300) {
                      this.switches.cords = 0;
                      this.turnOffCords();
                    }
                  });
                }
              }
            }
          });
        });
      } else {
        return false;
      }
    },

    turnOffCords() {
      for (let i = 0; i < this.cords.length; i++) {
        Outlet.getToken().then(tokenRes => {
          Outlet.outletRequest(
            tokenRes.data.result.token,
            0,
            this.cords[i].device_id
          ).then(res => {
            this.cordsTotalStatus.val = 0;

            let toParse = JSON.parse(res.data.result.responseData);
            console.log("all cords turned off");
          });
        });
      }
    },

    getCableData() {
      Outlet.getToken().then(tokenRes => {
        Outlet.outletGetList(tokenRes.data.result.token).then(resDevices => {
          let arrDevices = resDevices.data.result.deviceList;

          axios
            .request({
              baseURL: "http://localhost:8000/api/v1/devices",
              method: "get"
            })
            .then(res => {
              if (res.data.length) {
                for (let i = 0; i < arrDevices.length; i++) {
                  let apiDeviceId = arrDevices[i].deviceId;

                  let objExCord = {
                    device_id: apiDeviceId,
                    name: arrDevices[i].alias,
                    status: 0,
                    emeter: {}
                  };

                  for (let o = 0; o < Object.keys(res.data).length; o++) {
                    if (apiDeviceId == res.data[o].device_id) {
                      if (res.data[o].category_id == 3) {
                        Outlet.outletInfo(
                          tokenRes.data.result.token,
                          apiDeviceId
                        ).then(resState => {
                          let toParse = JSON.parse(
                            resState.data.result.responseData
                          );
                          objExCord.status =
                            toParse.system.get_sysinfo.relay_state;

                          if (objExCord.status == 1) {
                            this.cordsTotalStatus.val = 1;
                          }

                          Outlet.outletUsage(
                            tokenRes.data.result.token,
                            apiDeviceId
                          ).then(resUsage => {
                            let toParse = JSON.parse(
                              resUsage.data.result.responseData
                            );

                            objExCord.emeter = toParse.emeter.get_realtime;

                            this.totalMw += Number(
                              toParse.emeter.get_realtime.power_mw
                            );

                            if (this.totalMw > 300) {
                              this.switches.cords = 1;
                            }

                            this.emeterData.push(objExCord);

                            console.log(this.emeterData);
                          });
                        });
                      }
                    }
                  }
                }
              }
            });
        });
      });
    },

    toggleSensor(type, status, hasDataBool) {
      console.log(type, status, hasDataBool);
      if (hasDataBool == true) {
        if (type == "temp") {
          if (status == 0) {
            this.sensors.temp = 1;
            setInterval(this.checkTemp, 1000);
          } else {
            this.sensors.temp = 0;
          }
        } else if (type == "light") {
          if (status == 0) {
            this.sensors.lights = 1;
          } else {
            this.sensors.lights = 0;
          }
        } else if (type == "cord") {
          if (status == 0) {
            this.sensors.cords = 1;

            setInterval(this.freshCableUsage, 1000);
          } else {
            this.sensors.cords = 0;
          }
        }
      }
    },
    getLists() {
      axios
        .request({
          baseURL: "http://localhost:8000/api/v1/devices",
          method: "get"
        })
        .then(res => {
          for (let o = 0; o < Object.keys(res.data).length; o++) {
            if (res.data[o].category_id == 1) {
              this.temps.push({
                device_id: res.data[o].device_id,
                name: res.data[o].alias
              });
            } else if (res.data[o].category_id == 2) {
              this.lights.push(res.data[o].alias);
            } else if (res.data[o].category_id == 3) {
              this.cords.push({
                device_id: res.data[o].device_id,
                name: res.data[o].alias
              });
            }
          }
        });
    }
  }
};
</script>
