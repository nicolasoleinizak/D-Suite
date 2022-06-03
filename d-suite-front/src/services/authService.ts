import { api } from "./config/api"

export const login = async (email: String, password: String): Promise<any> => {
    return api.post('/login', {
        email,
        password,
    }).then(response => {
        return response.data;
    });
}

export const me = async () => {
    return api.get('/me').then( response => {
        return response.data;
    })
}