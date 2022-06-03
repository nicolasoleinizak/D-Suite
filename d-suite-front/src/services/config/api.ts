import axios from 'axios';

const headers = {
    'Authorization': localStorage.accessToken? `bearer ${localStorage.accessToken}` : ''
}

export const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    timeout: 5000,
    headers
})