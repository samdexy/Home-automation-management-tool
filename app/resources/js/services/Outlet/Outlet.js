import axios from 'axios';

class Outlet {
  
    

    async outletRequest(tokenRes, state, deviceId) {

        return axios.request({
            baseURL: `https://eu-wap.tplinkcloud.com/?token=` + tokenRes + `&appName=Kasa_Android&termID=5CD852A5-125F-40E1-8D4A-B89B1A0E1F74&appVer=1.4.4.607&ospf=Android+6.0.1&netType=wifi&locale=
            en_US`,
            method: 'post',
            headers:{
                "Content-Type": "application/json",
  
            },
            data: {
                "method":"passthrough",
                "params":{
                "deviceId": deviceId,
                "requestData":"{\"system\":{\"set_relay_state\":{\"state\":" + state + "}}}"
                }
            }
          });

    }

    async getToken() {

        let authEmail = process.env.TP_LINK_EMAIL;
        let authPass = process.env.TP_LINK_PASS;


        return axios.request({
            baseURL: 'https://wap.tplinkcloud.com',
            method: 'post',
            data: {
                    "method": "login",
                    "params": {
                    "appType": "Kasa_Android",
                    "cloudUserName": authEmail,
                    "cloudPassword": authPass,
                    "terminalUUID": "2adb9a64-3371-47e8-b1aa-cb78abb0d301"
                    }
            },
        })
       

    }

    async outletGetList(tokenRes) {

        return axios.request({
            baseURL: 'https://eu-wap.tplinkcloud.com/?token=' + tokenRes,
            method: 'post',
            data: {
                "method":"getDeviceList"
            },
        })
       

    }

    async outletInfo(tokenRes, deviceId) {

        return axios.request({
            baseURL: `https://eu-wap.tplinkcloud.com/?token=` + tokenRes,
            method: 'post',
            data: {
                "method": "passthrough",
                "params": {
                "deviceId": deviceId,
                "requestData": "{\"system\":{\"get_sysinfo\":null}}"
                }
            }
          });

    }

    async outletUsage(tokenRes, deviceId) {

        return axios.request({
            baseURL: `https://eu-wap.tplinkcloud.com/?token=` + tokenRes,
            method: 'post',
            data: {
                "method": "passthrough",
                "params": {
                "deviceId": deviceId,
                "requestData": "{\"emeter\":{\"get_realtime\":{}}}"
            }
            }
          });

    }

    async outletDaystat(tokenRes, deviceId, month, year) {

        return axios.request({
            baseURL: `https://eu-wap.tplinkcloud.com/?token=` + tokenRes,
            method: 'post',
            data: {
                "method": "passthrough",
                "params": {
                "deviceId": deviceId,
                "requestData": "{\"emeter\":{\"get_daystat\":{\"month\":" + month + ",\"year\":" + year + "}}}"
            }
            }
          });

    }

}

export default new Outlet();