import React, { useEffect, useState } from 'react';
import axios from '../config/axios';

const ProductManagement = () => {
  const [products, setProducts] = useState([]);
  const [form, setForm] = useState({ name: '', hsn_code: '', gst_rate: '', stock: '' });
  const [error, setError] = useState('');

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const response = await axios.get('/products');
      setProducts(response.data);
    } catch (err) {
      setError('Failed to fetch products');
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/products/create', form);
      setForm({ name: '', hsn_code: '', gst_rate: '', stock: '' });
      fetchProducts();
    } catch (err) {
      setError('Failed to add product');
    }
  };

  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-4">Product Management</h1>
      {error && <p className="text-red-500 mb-4">{error}</p>}

      <form onSubmit={handleSubmit} className="mb-8">
        <div className="grid grid-cols-2 gap-4">
          <input
            type="text"
            placeholder="Product Name"
            value={form.name}
            onChange={(e) => setForm({ ...form, name: e.target.value })}
            className="p-2 border rounded"
            required
          />
          <input
            type="text"
            placeholder="HSN Code"
            value={form.hsn_code}
            onChange={(e) => setForm({ ...form, hsn_code: e.target.value })}
            className="p-2 border rounded"
            required
          />
          <input
            type="number"
            placeholder="GST Rate"
            value={form.gst_rate}
            onChange={(e) => setForm({ ...form, gst_rate: e.target.value })}
            className="p-2 border rounded"
            required
          />
          <input
            type="number"
            placeholder="Stock"
            value={form.stock}
            onChange={(e) => setForm({ ...form, stock: e.target.value })}
            className="p-2 border rounded"
            required
          />
        </div>
        <button type="submit" className="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
          Add Product
        </button>
      </form>

      <table className="w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th className="border border-gray-300 p-2">Name</th>
            <th className="border border-gray-300 p-2">HSN Code</th>
            <th className="border border-gray-300 p-2">GST Rate</th>
            <th className="border border-gray-300 p-2">Stock</th>
          </tr>
        </thead>
        <tbody>
          {products.map((product) => (
            <tr key={product.id}>
              <td className="border border-gray-300 p-2">{product.name}</td>
              <td className="border border-gray-300 p-2">{product.hsn_code}</td>
              <td className="border border-gray-300 p-2">{product.gst_rate}</td>
              <td className="border border-gray-300 p-2">{product.stock}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ProductManagement;