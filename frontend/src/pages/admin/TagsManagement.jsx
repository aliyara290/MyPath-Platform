import React, { useState, useEffect } from 'react';
import { tags } from '../../services/api';

const TagsManagement = () => {
  const [tagsList, setTagsList] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [editingTag, setEditingTag] = useState(null);

  const initialFormState = {
    name: '',
    color: '#6366F1'
  };

  const tagColors = [
    { name: 'Blue', value: '#3B82F6' },
    { name: 'Indigo', value: '#6366F1' },
    { name: 'Purple', value: '#8B5CF6' },
    { name: 'Pink', value: '#EC4899' },
    { name: 'Red', value: '#EF4444' },
    { name: 'Orange', value: '#F97316' },
    { name: 'Yellow', value: '#EAB308' },
    { name: 'Green', value: '#22C55E' },
    { name: 'Teal', value: '#14B8A6' },
    { name: 'Cyan', value: '#06B6D4' },
  ];
  
  const [formData, setFormData] = useState(initialFormState);
  const [formErrors, setFormErrors] = useState({});

  useEffect(() => {
    fetchTags();
  }, []);

  useEffect(() => {
    if (editingTag) {
      setFormData({
        name: editingTag.name || '',
        color: editingTag.color || '#6366F1',
      });
      setShowForm(true);
    }
  }, [editingTag]);

  const fetchTags = async () => {
    try {
      setLoading(true);
      const response = await tags.getAll();
      setTagsList(response.data.data);
      setLoading(false);
    } catch (err) {
      setError('Failed to fetch tags');
      setLoading(false);
      console.error('Error fetching tags:', err);
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
    // Clear error for this field when user types
    if (formErrors[name]) {
      setFormErrors({
        ...formErrors,
        [name]: null
      });
    }
  };

  const validateForm = () => {
    const errors = {};
    
    if (!formData.name.trim()) {
      errors.name = 'Name is required';
    }
    
    setFormErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!validateForm()) {
      return;
    }
    
    try {
      setLoading(true);
      
      if (editingTag) {
        await tags.update(editingTag.id, formData);
      } else {
        await tags.create(formData);
      }
      
      // Reset form and refresh data
      setFormData(initialFormState);
      setShowForm(false);
      setEditingTag(null);
      fetchTags();
      
      setLoading(false);
    } catch (err) {
      setError('Failed to save tag');
      setLoading(false);
      console.error('Error saving tag:', err);
    }
  };

  const handleEdit = (tag) => {
    setEditingTag(tag);
  };

  const handleDelete = async (id) => {
    if (window.confirm('Are you sure you want to delete this tag? This may affect courses associated with this tag.')) {
      try {
        setLoading(true);
        await tags.delete(id);
        setTagsList(tagsList.filter(tag => tag.id !== id));
        setLoading(false);
      } catch (err) {
        setError('Failed to delete tag');
        setLoading(false);
        console.error('Error deleting tag:', err);
      }
    }
  };

  const handleCancel = () => {
    setFormData(initialFormState);
    setFormErrors({});
    setShowForm(false);
    setEditingTag(null);
  };

  if (loading && tagsList.length === 0) {
    return (
      <div className="flex justify-center items-center h-64">
        <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  return (
    <div className="bg-white rounded-lg shadow-sm p-6">
      <div className="sm:flex sm:items-center sm:justify-between mb-6">
        <h1 className="text-2xl font-bold text-gray-900">Tags Management</h1>
        <button
          onClick={() => {
            setShowForm(!showForm);
            setEditingTag(null);
            setFormData(initialFormState);
            setFormErrors({});
          }}
          className="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
          {showForm ? 'Cancel' : 'Add New Tag'}
        </button>
      </div>

      {error && (
        <div className="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          <p>{error}</p>
        </div>
      )}

      {showForm && (
        <div className="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
          <h2 className="text-lg font-medium text-gray-900 mb-4">
            {editingTag ? 'Edit Tag' : 'Add New Tag'}
          </h2>
          
          <form onSubmit={handleSubmit}>
            <div className="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <div>
                <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">
                  Tag Name*
                </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                  className={`w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm ${
                    formErrors.name ? 'border-red-500' : 'border-gray-300'
                  }`}
                />
                {formErrors.name && (
                  <p className="mt-1 text-sm text-red-600">{formErrors.name}</p>
                )}
              </div>

              <div>
                <label htmlFor="color" className="block text-sm font-medium text-gray-700 mb-1">
                  Tag Color
                </label>
                <div className="grid grid-cols-5 gap-2">
                  {tagColors.map((color) => (
                    <div 
                      key={color.value}
                      onClick={() => setFormData({...formData, color: color.value})} 
                      className={`h-8 w-8 rounded-full cursor-pointer ${formData.color === color.value ? 'ring-2 ring-offset-2 ring-gray-500' : ''}`} 
                      style={{backgroundColor: color.value}}
                      title={color.name}
                    />
                  ))}
                </div>
              </div>
            </div>

            <div className="mt-6 flex items-center justify-end space-x-3">
              <button
                type="button"
                onClick={handleCancel}
                className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
              >
                Cancel
              </button>
              <button
                type="submit"
                className="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
              >
                {editingTag ? 'Update' : 'Create'} Tag
              </button>
            </div>
          </form>
        </div>
      )}

      {/* Tags List */}
      <div className="overflow-x-auto">
        <table className="min-w-full divide-y divide-gray-200">
          <thead className="bg-gray-50">
            <tr>
              <th
                scope="col"
                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                Tag
              </th>
              <th
                scope="col"
                className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody className="bg-white divide-y divide-gray-200">
            {tagsList.length > 0 ? (
              tagsList.map((tag) => (
                <tr key={tag.id}>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <div className="flex items-center">
                      <div 
                        className="w-4 h-4 rounded-full mr-3" 
                        style={{backgroundColor: tag.color || '#6366F1'}}
                      ></div>
                      <div className="text-sm font-medium text-gray-900">{tag.name}</div>
                    </div>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button
                      onClick={() => handleEdit(tag)}
                      className="text-indigo-600 hover:text-indigo-900 mr-4"
                    >
                      Edit
                    </button>
                    <button
                      onClick={() => handleDelete(tag.id)}
                      className="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="2" className="px-6 py-4 text-center text-sm text-gray-500">
                  No tags found. Create your first tag by clicking the "Add New Tag" button.
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default TagsManagement;