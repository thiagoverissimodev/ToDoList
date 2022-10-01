import React, { useState } from "react";
import { Input } from '@chakra-ui/react';

export function InsertList({ onInsertList }) {
    const [listName, setListName] = useState('')

    const handleSubmit = async (event) => {
        event.preventDefault()

        await onInsertList({
            "title": listName,
            "status": 0
        })

        setListName('')
    }

    return (
        <div className="form">
            <strong>Cadastrar Lista</strong>
            <form noValidate autoComplete="off" onSubmit={handleSubmit}>
                <Input 
                    name="listName"
                    id="listName"
                    label="Titulo da Lista de Tarefas"
                    className="TextFieldBlock"
                    value={listName}
                    onChange={e => setListName(e.target.value)}
                    required
                />
                <button type="submit">Salvar</button>
            </form>
        </div>
    )
}