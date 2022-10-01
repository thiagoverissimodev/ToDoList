import { Route, Routes } from "react-router-dom";

import { Logon } from './pages/Logon/Logon';
import { Register } from "./pages/Register/Register";
// import Register from './pages/Register';
import { Lists } from './pages/Lists/Lists';

export function Router()
{
    return (
        <Routes>
                <Route path="/" element={<Logon />} />
                <Route path="/register" element={<Register />} />
                <Route path="/lists" element={<Lists />} />
                {/* <Route path="/" element={<Subscribe />} /> */}
        </Routes>
    )
}