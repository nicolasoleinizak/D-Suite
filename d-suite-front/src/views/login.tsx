import React, { useState } from 'react';
import { login, me } from '../services/authService';

export function Login() {

    const initialData = {
        email: '',
        password: '',
    }

    const [accessData, setAccessData] = useState(initialData);
    const [userData, setUserData] = useState();

    const handleInputChange = (e: any) => {
        setAccessData({
            ...accessData,
            [e.target.name]: e.target.value
        })
    }

    const handleSubmit = async () => {
        login(accessData.email, accessData.password).then( (response: any) => {
            console.log(response);
            localStorage.accessToken = response.access_token;
            me().then( response => {
                setUserData(response);
            })
        })
    }

    return (
        <div>
            <label>Email: <input type="email" value={accessData.email} name="email" onChange={handleInputChange}/></label>
            <label>Contraseña: <input type="password" value={accessData.password} name="password" onChange={handleInputChange}/></label>
            <button onClick={handleSubmit}>Iniciar sesión</button>
        </div>
    )

}