<template>
<div>
<sidebar></sidebar>
<div class="divMinSideabar ml-64">
      <div class="float-left relative bg-white m-6 px-6 pt-12 pb-6 w-full h-auto shadow-lg rounded-lg">

          <div class="m-auto w-2/3">
                    <h2 class="text-3xl w-full text-center mb-6">

                         <span v-bind:class="(plug.status == 1)?'gradGreen text-white':'bg-transparent text-green'" class="inline-block shadow rounded-full mx-1 w-10 h-10 border border-green items-center justify-center">
                                <i class="block fas fa-power-off mt-2 text-2xl"></i>
                        </span>

                        {{plug.alias}}
                        
                        
                        </h2>

                               

                    <form action="w-full mb-12">
                            <div class="mb-12">
                            <label class="block text-dimmedTxt text-sm mb-2" for="alias">
                                Title
                            </label>
                            <input class="border rounded-lg w-full border-box py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline" id="alias" type="text" v-model="plug.alias">
                            </div>    


                              <div class="mb-12">
                            <label class="block text-dimmedTxt text-sm mb-2" for="category">
                                CHOOSE TYPE OF DEVICE YOUR OUTLET IS CURRENTLY USING
                            </label>
                             <v-select class="border rounded-lg w-full focus:outline-none focus:shadow-outline" label="name" :options="select" v-model="plug.category"></v-select>

                            </div> 

                                  <button v-on:click="update()" class="block w-40 m-auto mb-12 gradGreen text-white font-medium py-3 px-4 rounded-full focus:outline-none focus:shadow-outline" type="button">
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
    name: 'edit',

    components: {
        Sidebar,
        FontAwesomeIcon,
        vSelect
    },

    data() {

        return {

            plug: {
                alias: '',
                device_id: '',
                status: Number,
                category: {
                  id: '',
                  name: '',
                }
            },

             select: [],

        };
    },

    created() {

    this.getSelection()

    Outlet.getToken().then(tokenRes => {

    let id = this.$route.params.id

    Outlet.outletInfo(tokenRes.data.result.token, id).then(resState => {

            let toParse = JSON.parse(resState.data.result.responseData);
            this.plug.device_id = id;
           this.plug.status = toParse.system.get_sysinfo.relay_state;

              axios.request({
                        baseURL: 'http://localhost:8000/api/v1/devices/' + id,
                        method: 'get',
                }).then(res => {


                    this.plug.alias = res.data[0].alias
                    this.plug.category.id = res.data[0].category_id


                    axios.request({
                        baseURL: 'http://localhost:8000/api/v1/categories/' + res.data[0].category_id,
                        method: 'get',
                }).then(resC => {

                    this.plug.category.name = resC.data[0].name
                    console.log(this.plug)
                })
                })

        })

  })






    },
    
        
    methods: {

              update(){


                          this.plug.category_id = this.plug.category.id
                          delete this.plug.category

                           axios.request({
                                    baseURL: 'http://localhost:8000/api/v1/devices/' + this.$route.params.id,
                                    method: 'put',
                                    data: this.plug
                                }).then(() => {
                                        this.$router.push({ name: 'home' })
                                }) 

              },

               getSelection(){
              

                           axios.request({
                                    baseURL: 'http://localhost:8000/api/v1/categories/',
                                    method: 'get',
                                }).then(res => {

                                    

                                        for (let i = 0; i < Object.keys(res.data).length; i++) {

                                            let selectObj = {
                                            id: '',
                                            name: '',
                                            };

                                            selectObj.name = res.data[i].name
                                            selectObj.id = res.data[i].id

                                            this.select.push(selectObj)
                                             console.log(this.select)

                                        }
                                     
                                })


                 

              }

    }

    }
</script>
