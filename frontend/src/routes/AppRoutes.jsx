import React from 'react';
import { Route, Routes } from 'react-router-dom';
import Home from '../pages/home/Home';
import Layouts from '../components/layout/Layouts';
import AdminLayout from '../components/layout/AdminLayout';
import CoursesManagement from '../pages/admin/CoursesManagement';
import CategoriesManagement from '../pages/admin/CategoriesManagement';
import TagsManagement from '../pages/admin/TagsManagement';
import CourseDetail from '../pages/courses/CourseDetail';
// import NotFound from '../pages/NotFound';

const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<Layouts />}>
        <Route index element={<Home />} />
        <Route path="courses/:id" element={<CourseDetail />} />
      </Route>

      <Route path="/admin" element={<AdminLayout />}>
        <Route index element={<CoursesManagement />} />
        <Route path="courses" element={<CoursesManagement />} />
        <Route path="categories" element={<CategoriesManagement />} />
        <Route path="tags" element={<TagsManagement />} />
      </Route>

      {/* <Route path="*" element={<NotFound />} /> */}
    </Routes>
  );
};

export default AppRoutes;