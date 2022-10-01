import React, {useState, useEffect} from "react";
import { useNavigate } from "react-router-dom";
import { Header } from '../../components/Header'
import { Task } from '../../components/Task'
import { InsertList } from '../../components/InsertList'
import { InsertTask } from '../../components/InsertTask'
import { Container, Grid } from "@chakra-ui/react";

import './styles.css';
import { api } from "../../services/Api";

export function Lists(){
    const [token] = useState(localStorage.getItem('token'))
    const [taskList, setTaskList] = useState([])
    const [listId, setListId] = useState('')

    const navigate = useNavigate();

    useEffect(() => {
        api.get('api/v1/tasklist', {
            headers: {
                Authorizatoin: `Bearer ${token}`,
            }
        }).then(response => {
            if(response.data.status && response.data.status === (401 || 498)){
                localStorage.clear();
                navigate('/', {replace: true})
            }else{
                setTaskList(response.data.data)
            }
        }).catch(err => {
            alert(err)
        })
    }, [token]);

    async function onInsertList(data){
        api.post('/api/v1/tasklist', data, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }).then(response => {
            if(response.data.status && response.data.status === (401 || 498)){
                localStorage.clear()
                navigate('/', {replace: true})
            }
            setTaskList([...taskList, response.data.data])
        }).catch(err => {
            alert(err)
        })
    }
    async function onInsertTask(data){
        await setListId('')
        await api.post('/api/v1/tasklist', data, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }).then(response => {
            console.log(response)
            if(response.data.status && response.data.status === (401 || 498)){
                localStorage.clear()
                navigate('/', {replace: true})
            }
            setListId(response.data.data.list_id)
        }).catch(err => {
            alert(err)
        })
    }

    return (
        <React.Fragment>
            <Header />

            <Container maxWidth="x1">
                <Grid container>
                    <Grid item xs={3}>
                        <InsertList onInsertList={onInsertList}/>
                        <InsertTask onInsertTask={onInsertList} taskList={taskList}/>
                    </Grid>

                    <Grid item xs={8}>
                        <Container maxWidth="xl">
                            <Grid container>
                                {taskList.length > 0 ? taskList.map((list) => (
                                    <Grid item xs={4} key={list.id}>
                                        <div className="ListContainer">
                                            <div className="ListHeader">
                                                {list.status === "À Fazer" ? (
                                                    <h3 className="ListTitle">{list.title}</h3>
                                                ) : (
                                                    <h3 className="ListTitle">{list.title} - Finalizado</h3>
                                                )}

                                            </div>
                                            <div className="Tasks">
                                                <div className="TaskItem">
                                                    <Container maxWidth="xl">
                                                        <Task list={list.id}></Task>
                                                    </Container>
                                                </div>
                                            </div>
                                        </div>
                                    </Grid>
                                )) : null
                            }
                            </Grid>
                        </Container>
                    </Grid>
                </Grid>
            </Container>
        </React.Fragment>
    )
}