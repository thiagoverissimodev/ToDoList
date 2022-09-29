import React, { useState, useEffect } from "react";
import { FormControl, Select, MenuItem } from "@chakra-ui/react";
import { Input } from "@chakra-ui/react"

export function InsertTask({ onInsertTask, taskList }){
    const [lists, setLists] = useState([])
    const [selectLists, setSelectList] = useState('')
    const [taskName, setTaskName] = useState('')

    useEffect(() => {
        if(tasklist.length > 0){
            setLists(taskList)
        }
    }, [taskList])

    const handleChangeSelect = (event) => {
        setSelectList(event?.target.value)
    }

    const handleSubmit = async (event) => {
        event.preventDefault()

        await onInsertTask({
            'list_id': selectLists,
            'title': taskName,
            'status': 0
        })

        selectLists('')
        setTaskName('')
    }

    return (
        <div className="form">
            <strong>Cadastrar Tarefa</strong>
            <form noValidate autoComplete="off" onSubmit={handleSubmit}>
                <div>
                    <Input 
                        
                    />
                </div>
            </form>
        </div>
    )
}

