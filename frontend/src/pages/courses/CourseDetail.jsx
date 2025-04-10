import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { courses } from '../../services/api';

const CourseDetail = () => {
  const { id } = useParams();
  const [course, setCourse] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [activeVideoIndex, setActiveVideoIndex] = useState(0);

  useEffect(() => {
    const fetchCourseData = async () => {
      try {
        setLoading(true);
        const response = await courses.getById(id);
        
        const courseData = response.data.data;
        setCourse(courseData);
        setLoading(false);
      } catch (err) {
        setError('Failed to load course details');
        setLoading(false);
        console.error('Error fetching course details:', err);
      }
    };

    fetchCourseData();
  }, [id]);

  const formatDuration = (minutes) => {
    if (!minutes) return '';
    const hours = Math.floor(minutes / 60);
    const mins = Math.floor(minutes % 60);
    if (hours > 0) {
      return `${hours}h ${mins > 0 ? `${mins}m` : ''}`;
    }
    return `${mins}m`;
  };

  const getDifficultyColor = (level) => {
    switch(level) {
      case 'beginner':
        return 'bg-green-100 text-green-800';
      case 'intermediate':
        return 'bg-blue-100 text-blue-800';
      case 'advanced':
        return 'bg-purple-100 text-purple-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const sortedVideos = course?.videos?.sort((a, b) => {
    const aMatch = a.title.match(/Video (\d+)/);
    const bMatch = b.title.match(/Video (\d+)/);
    if (aMatch && bMatch) {
      return parseInt(aMatch[1]) - parseInt(bMatch[1]);
    }
    return a.title.localeCompare(b.title);
  });

  if (loading) {
    return (
      <div className="flex justify-center items-center min-h-screen">
        <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="container mx-auto px-4 py-8">
        <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <p>{error}</p>
        </div>
        <Link to="/" className="text-primary-600 hover:text-primary-700">
          ← Back to Home
        </Link>
      </div>
    );
  }

  if (!course) {
    return (
      <div className="container mx-auto px-4 py-8">
        <div className="text-center">
          <h2 className="text-2xl font-bold text-gray-900 mb-4">Course Not Found</h2>
          <p className="text-gray-600 mb-4">The course you're looking for does not exist or has been removed.</p>
          <Link
            to="/"
            className="inline-block px-6 py-2 bg-primary-600 text-white font-medium rounded-md hover:bg-primary-700"
          >
            Back to Home
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="mb-6">
        <Link to="/" className="text-primary-600 hover:text-primary-700 flex items-center">
          <svg
            className="w-5 h-5 mr-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth={2}
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            ></path>
          </svg>
          Back to Courses
        </Link>
      </div>

      <div className="flex flex-col lg:flex-row">
        <div className="w-full lg:w-2/3 lg:pr-8">
          <div className="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
            <div className="relative w-full aspect-video bg-black">
              {sortedVideos && sortedVideos.length > 0 ? (
                <div className="w-full h-full">
                  <iframe
                    src={sortedVideos[activeVideoIndex]?.url || ''}
                    title={sortedVideos[activeVideoIndex]?.title || ''}
                    className="w-full h-full"
                    allowFullScreen
                  ></iframe>
                </div>
              ) : course.cover ? (
                <img
                  src={course.cover}
                  alt={course.title}
                  className="w-full h-full object-cover"
                />
              ) : (
                <div className="flex items-center justify-center h-full bg-gray-800 text-white">
                  No video or image available
                </div>
              )}
            </div>

            <div className="p-6">
              <div className="flex flex-wrap items-center mb-4">
                {course.level && (
                  <span className={`${getDifficultyColor(course.level)} text-xs font-semibold mr-2 px-2.5 py-0.5 rounded`}>
                    {course.level.charAt(0).toUpperCase() + course.level.slice(1)}
                  </span>
                )}
                
                {course.tags && course.tags.map(tag => (
                  <span
                    key={tag.id}
                    className="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                  >
                    {tag.name}
                  </span>
                ))}
              </div>

              <h1 className="text-3xl font-bold text-gray-900 mb-4">{course.title}</h1>

              <div className="flex items-center mb-6">
                <div className="flex items-center text-gray-500 mr-6">
                  <svg className="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{formatDuration(course.duration)}</span>
                </div>
                
                <div className="flex items-center text-gray-500">
                  <svg className="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  <span>{course.videos ? course.videos.length : 0} videos</span>
                </div>
              </div>

              <div className="prose max-w-none mb-8">
                <h2 className="text-xl font-semibold text-gray-900 mb-2">Description</h2>
                <p className="text-gray-700 mb-4">{course.description}</p>
                {course.content && (
                  <>
                    <h2 className="text-xl font-semibold text-gray-900 mb-2 mt-6">About this course</h2>
                    <p className="text-gray-700 whitespace-pre-line">{course.content}</p>
                  </>
                )}
              </div>
            </div>
          </div>

          {/* Course Content Section */}
          {sortedVideos && sortedVideos.length > 0 && (
            <div className="bg-white shadow-sm rounded-lg overflow-hidden mb-8">
              <div className="px-6 py-4 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-900">Course Content</h2>
                <div className="text-sm text-gray-500 mt-1">
                  {sortedVideos.length} videos • {formatDuration(course.duration)}
                </div>
              </div>
              
              <div className="divide-y divide-gray-200">
                {sortedVideos.map((video, index) => (
                  <div 
                    key={video.id}
                    className={`px-6 py-4 hover:bg-gray-50 cursor-pointer ${activeVideoIndex === index ? 'bg-gray-50' : ''}`}
                    onClick={() => setActiveVideoIndex(index)}
                  >
                    <div className="flex items-center">
                      <div className={`flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full ${activeVideoIndex === index ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-500'}`}>
                        {activeVideoIndex === index ? (
                          <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                          </svg>
                        ) : (
                          <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        )}
                      </div>
                      <div className="ml-4 flex-1">
                        <h3 className="text-sm font-medium text-gray-900">{video.title}</h3>
                        {video.description && (
                          <p className="text-sm text-gray-500 mt-1">{video.description}</p>
                        )}
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>

        {/* Sidebar */}
        <div className="w-full lg:w-1/3">
          <div className="bg-white shadow-sm rounded-lg p-6 sticky top-8">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Course Details</h3>
            
            <ul className="space-y-3 mb-6">
              {course.level && (
                <li className="flex items-center">
                  <svg
                    className="w-5 h-5 text-gray-500 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M13 10V3L4 14h7v7l9-11h-7z"
                    ></path>
                  </svg>
                  <span className="text-gray-700">
                    Level: <span className="font-medium capitalize">{course.level}</span>
                  </span>
                </li>
              )}
              
              {course.duration && (
                <li className="flex items-center">
                  <svg
                    className="w-5 h-5 text-gray-500 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                  </svg>
                  <span className="text-gray-700">
                    Duration: <span className="font-medium">{formatDuration(course.duration)}</span>
                  </span>
                </li>
              )}
              
              {course.videos && (
                <li className="flex items-center">
                  <svg
                    className="w-5 h-5 text-gray-500 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                    ></path>
                  </svg>
                  <span className="text-gray-700">
                    Videos: <span className="font-medium">{course.videos.length}</span>
                  </span>
                </li>
              )}
              
              {course.createdAt && (
                <li className="flex items-center">
                  <svg
                    className="w-5 h-5 text-gray-500 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    ></path>
                  </svg>
                  <span className="text-gray-700">
                    Published: <span className="font-medium">{new Date(course.createdAt).toLocaleDateString()}</span>
                  </span>
                </li>
              )}
            </ul>

            <div className="mb-6">
              <h4 className="text-sm font-semibold text-gray-900 mb-2">Tags</h4>
              <div className="flex flex-wrap gap-2">
                {course.tags && course.tags.length > 0 ? (
                  course.tags.map(tag => (
                    <span
                      key={tag.id}
                      className="inline-block px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800"
                    >
                      {tag.name}
                    </span>
                  ))
                ) : (
                  <span className="text-gray-500">No tags</span>
                )}
              </div>
            </div>

            <div className="border-t border-gray-200 pt-6">
              <button className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 w-full">
                Enroll Now
              </button>
              
              <div className="mt-4">
                <button className="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full">
                  <svg
                    className="w-5 h-5 mr-2 text-gray-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    ></path>
                  </svg>
                  Add to Wishlist
                </button>
              </div>
              
              <div className="mt-4">
                <button className="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full">
                  <svg
                    className="w-5 h-5 mr-2 text-gray-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                    ></path>
                  </svg>
                  Share Course
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CourseDetail;