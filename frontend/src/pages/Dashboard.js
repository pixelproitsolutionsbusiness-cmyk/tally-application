import React from 'react';

const Dashboard = () => {
  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-4">Dashboard</h1>
      <div className="grid grid-cols-3 gap-4">
        <div className="bg-blue-500 text-white p-4 rounded shadow">
          <h2 className="text-lg font-bold">Total Revenue</h2>
          <p className="text-2xl">₹1,20,000</p>
        </div>
        <div className="bg-green-500 text-white p-4 rounded shadow">
          <h2 className="text-lg font-bold">Total GST</h2>
          <p className="text-2xl">₹18,000</p>
        </div>
        <div className="bg-yellow-500 text-white p-4 rounded shadow">
          <h2 className="text-lg font-bold">Total Sales</h2>
          <p className="text-2xl">150</p>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;