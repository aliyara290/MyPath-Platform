import React, { useState, useEffect } from "react";
import { courses, categories, tags } from "../../services/api";
import { Link } from "react-router-dom";

const Home = () => {
  const [coursesList, setCoursesList] = useState([]);
  const [categoriesList, setCategoriesList] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedCategory, setSelectedCategory] = useState("all");

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const [coursesResponse, categoriesResponse] = await Promise.all([
          courses.getAll(),
          categories.getAll(),
        ]);

        setCoursesList(coursesResponse.data.courses);
        setCategoriesList(categoriesResponse.data.data);
        setLoading(false);
      } catch (err) {
        setError("Failed to fetch data");
        setLoading(false);
        console.error("Error fetching data:", err);
      }
    };

    fetchData();
  }, []);

  const filteredCourses =
    selectedCategory === "all"
      ? coursesList
      : coursesList.filter((course) => course.category_id === selectedCategory);

  if (loading) {
    return (
      <div className="flex justify-center items-center min-h-screen">
        <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="text-center py-10">
        <h2 className="text-2xl font-bold text-red-600 mb-2">Error</h2>
        <p className="text-gray-700">{error}</p>
      </div>
    );
  }

  return (
    <div className="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
      <div className="max-w-7xl mx-auto">
        <div className="text-center mb-12">
          <h1 className="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
            Discover Our Courses
          </h1>
          <p className="max-w-xl mt-5 mx-auto text-xl text-gray-500">
            Expand your knowledge with our comprehensive selection of courses
            designed to help you achieve your goals.
          </p>
        </div>

        <div className="mb-8">
          <div className="flex flex-wrap items-center justify-center gap-2">
            <button
              onClick={() => setSelectedCategory("all")}
              className={`px-4 py-2 rounded-full ${
                selectedCategory === "all"
                  ? "bg-primary-600 text-white"
                  : "bg-gray-200 text-gray-800 hover:bg-gray-300"
              } transition-colors duration-200`}
            >
              All Courses
            </button>

            {categoriesList.map((category) => (
              <button
                key={category.id}
                onClick={() => setSelectedCategory(category.id)}
                className={`px-4 py-2 rounded-full ${
                  selectedCategory === category.id
                    ? "bg-primary-600 text-white"
                    : "bg-gray-200 text-gray-800 hover:bg-gray-300"
                } transition-colors duration-200`}
              >
                {category.name}
              </button>
            ))}
          </div>
        </div>

        {/* Courses Grid */}
        <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
          {filteredCourses.length > 0 ? (
            filteredCourses.map((course) => (
              <div
                key={course.id}
                className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
              >
                <div className="h-48 bg-gray-300 relative">
                  {course.image ? (
                    <img
                      src={course.image}
                      alt={course.title}
                      className="w-full h-full object-cover"
                    />
                  ) : (
                    <div className="flex items-center justify-center h-full bg-gray-200">
                      <span className="text-gray-500">No image available</span>
                    </div>
                  )}

                  {course.price && (
                    <div className="absolute top-4 right-4 bg-primary-600 text-white text-sm font-bold py-1 px-3 rounded-full">
                      ${course.price}
                    </div>
                  )}
                </div>

                <div className="p-5">
                  {course.category && (
                    <div className="mb-2">
                      <span className="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                        {categoriesList.find(
                          (cat) => cat.id === course.category_id
                        )?.name || "Uncategorized"}
                      </span>
                    </div>
                  )}

                  <h3 className="text-xl font-bold text-gray-900 mb-2">
                    {course.title}
                  </h3>

                  <p className="text-gray-600 mb-4 line-clamp-2">
                    {course.description}
                  </p>

                  <div className="flex items-center justify-between">
                    <Link
                      to={`/courses/${course.id}`}
                      className="text-primary-600 hover:text-primary-800 font-medium"
                    >
                      View Details
                    </Link>

                    <div className="flex items-center">
                      <svg
                        className="w-4 h-4 text-yellow-400 mr-1"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                      </svg>
                      <span className="text-gray-600 text-sm">
                        {course.rating || "N/A"}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            ))
          ) : (
            <div className="col-span-full text-center py-10">
              <h3 className="text-xl font-medium text-gray-700">
                No courses found
              </h3>
              <p className="mt-2 text-gray-500">
                Try selecting a different category or check back later.
              </p>
            </div>
          )}
        </div>

        {/* Admin Action Link */}
        <div className="mt-12 text-center">
          <Link
            to="/admin/courses"
            className="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700"
          >
            Manage Courses
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-5 w-5 ml-2"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fillRule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clipRule="evenodd"
              />
            </svg>
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Home;
