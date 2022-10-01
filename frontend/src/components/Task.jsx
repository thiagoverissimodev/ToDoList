import React, {useState, useEffect} from "react";
import { FiTrash } from "react-icons/fi";
import { Checkbox, FormControl, FormLabel, Grid, Stack } from "@chakra-ui/react";

import { api } from "../services/Api";

// const GreenCheckBox

export function Task({list, listId}){
    const [token] = useState(localStorage.getItem('token'))
    const [tasks, setTasks] = useState([])

    useEffect(() => {
        getTasks()
    }, [list])

    useEffect(() => {
        if(list === listId){
            getTasks()
        }
    },[listId])

    const getTasks = async(list_id='') => {
        const getList = list_id === '' ? list : list_id
        const response = await api.get(`api/v1/list/tasks/${getList}`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
        if(response.data){
            return setTasks(response.data.data)
        }
        setTasks([])
    }

    const handleChange = async (event) => {
        event.preventDefault()
        const taskId = parseInt(event.target.value)

        api.put(`api/v1/task/close/${taskId}`, {}, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }).then(response => {
            getTasks(response.data.data.list_id)
        }).catch(err => {
            alert(err)
        })
    }
    const handleDelete = async (task) => {
        api.delete(`api/v1/tasks/${task}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }).then(response => {
            getTasks(response.data.data.list_id)
        }).catch(err => {
            alert(err)
        })
    }
    return (
        <React.Fragment>
            {tasks.length > 0 ? tasks.map((task) =>
            (
                <Grid container key={task.id}>
                    <Grid item xs={10}>
                        <FormControl component="fieldset">
                            <Stack spacing={3} direction='row'>
                                <FormLabel 
                                    value={task.id}
                                    control={<Checkbox color="#f00" onChange={handleChange} />}
                                    label={task.title}
                                    labelPlacement="end"
                                />
                            </Stack>
                        </FormControl>
                    </Grid>
                    <Grid item xs={2}>
                        <FiTrash className="floatRight deleteIcon" onClick={() => handleDelete(task.id)} size={18} />
                    </Grid>
                </Grid>
            )) : null }
        </React.Fragment>
    )
}