import React from "react";
import { Link } from "react-router-dom";
import { FaHome } from "react-icons/fa"; // Import home icon from react-icons

function Sidebar() {
  return (
    <div className="h-screen w-64 bg-gray-800 text-white flex flex-col p-4">
      <h1 className="text-2xl font-bold mb-8">Dashboard</h1>
      <nav>
        <Link
          to="/"
          className="block py-2 px-4 rounded hover:bg-gray-700 transition mb-4 flex items-center"
        >
          <FaHome className="mr-2" /> {/* Add the icon with some margin */}
          Home
        </Link>
        <Link
          to="/add-student"
          className="w-12 h-12 flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white text-xl font-bold rounded-full transition"
          title="Create"
        >
          +
        </Link>
      </nav>
    </div>
  );
}

export default Sidebar;
