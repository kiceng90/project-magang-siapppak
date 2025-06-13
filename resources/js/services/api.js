import axios from 'axios';

export default () => {
  const _token = localStorage.getItem('dp5a-token');
  const instance =  axios.create({
    baseURL: apiUrl,
    headers: {
        Authorization: _token ? 'Bearer ' + _token : '',
    }
  });
return instance
}
