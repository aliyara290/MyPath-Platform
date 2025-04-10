import React, { useState, useEffect } from "react";
import { Link, useLocation } from "react-router-dom";

const Header = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
  const location = useLocation();

  // Check if the current route is active
  const isActive = (path) => {
    return location.pathname === path;
  };

  // Handle scroll event to change header appearance
  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 10) {
        setIsScrolled(true);
      } else {
        setIsScrolled(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  return (
    <header className={`sticky top-0 z-50 bg-white ${isScrolled ? 'shadow-sm' : ''}`}>
      <nav className="px-4 lg:px-6 py-3">
        <div className="flex justify-between items-center mx-auto max-w-screen-xl">
          <Link to="/" className="flex items-center">
            <span className="text-xl font-bold text-gray-800">
              CourseHub
            </span>
          </Link>
          
          <div className="flex items-center lg:order-2">
            <Link
              to="/login"
              className="text-gray-700 font-medium text-sm px-4 py-2 mr-2"
            >
              Log in
            </Link>
            <Link
              to="/register"
              className="text-white bg-primary-600 font-medium rounded-md text-sm px-4 py-2"
            >
              Get started
            </Link>
            <button
              type="button"
              className="inline-flex items-center p-2 ml-2 text-gray-500 rounded-md lg:hidden"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            >
              <span className="sr-only">Open menu</span>
              {!isMobileMenuOpen ? (
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              ) : (
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              )}
            </button>
          </div>
          
          <div
            className={`${
              isMobileMenuOpen ? 'block' : 'hidden'
            } justify-between items-center w-full lg:flex lg:w-auto lg:order-1`}
            id="mobile-menu-2"
          >
            <ul className="flex flex-col mt-4 lg:flex-row lg:space-x-6 lg:mt-0 lg:ml-8">
              <li>
                <Link
                  to="/"
                  className={`block py-2 px-3 ${
                    isActive('/')
                      ? 'text-primary-600 font-medium'
                      : 'text-gray-700 hover:text-primary-600'
                  }`}
                >
                  Home
                </Link>
              </li>
              <li>
                <Link
                  to="/admin"
                  className={`block py-2 px-3 ${
                    location.pathname.includes('/admin')
                      ? 'text-primary-600 font-medium'
                      : 'text-gray-700 hover:text-primary-600'
                  }`}
                >
                  Admin
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header;