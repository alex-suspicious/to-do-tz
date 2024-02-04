import axios from 'axios';

export async function api_request(method, uri, body = {}) {
    var token = localStorage.getItem('USER_TOKEN');

    let config = {
      headers: { Authorization: `Bearer ${token}` }
    };


    if( method == 'get' ){
        config.params = body;
        return await axios.get(uri,config);
    }
    else
        return await axios.post(uri,body,config);
}
