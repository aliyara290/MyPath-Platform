import React from 'react'
import { Route, Routes } from 'react-router-dom'
import Home from '../pages/home/Home'
import Layouts from '../components/layout/Layouts'

const AppRoutes = () => {
  
  return (
    <Routes>
        <Route path='/' element={<Layouts />}>
            <Route index element={<Home />} />
        </Route>
    </Routes>
  )
}

export default AppRoutes