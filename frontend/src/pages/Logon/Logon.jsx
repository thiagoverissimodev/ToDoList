import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { FiLogIn } from 'react-icons/fi';

import '../../services/Api';

import './styles.css';
import { api } from '../../services/Api';

export function Logon(){
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    // const history = useHistory();

    async function handleLogin(e){
        e.preventDefault()

        try{
            const response = await api.post('api/login', {email, password});
            localStorage.setItem('token', response.data.token);

            navigate('/lists', {replace: true});
        }catch(err){
            alert('Falha no login, tente novamente.');
        }
    }

    return (
        <div className='logon-container'>
            <section className='form'>

                <form onSubmit={handleLogin}>
                    <input 
                        placeholder='Digite seu e-mail'
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                    />
                    <input 
                        placeholder='Digite sua senha'
                        type='password'
                        value={password}
                        onChange={e => setPassword(e.target.value)}
                    />

                    <button className='button' type='submit'>Entrar</button>

                    <Link className='back-link' to='/register'>
                        <FiLogIn size={16} color='#3498db' />
                        Não tenho cadastro
                    </Link>
                </form>
            </section>
        </div>
    )
}