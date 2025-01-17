import React, { useEffect, useState } from "react";
import { NavLink, Link } from "react-router";

const API_URL = "http://localhost:8000/data.php";

function StudentList() {
  const [users, setUsers] = useState([]);

  const fetchUsers = async () => {
    try {
      const response = await fetch(API_URL);
      const data = await response.json();
      setUsers(data);
    } catch (error) {
      console.error("Failed to fetch users:", error);
    }
  };

  const handleDelete = async (id) => {
    try {
      await fetch(API_URL, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      });
      fetchUsers();
    } catch (error) {
      console.error("Failed to delete user:", error);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  return (
    <div className="flex-1 p-8">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">
        Daftar Mahasiswa
      </h1>
      <div className="overflow-x-auto">
        <table className="w-full border-collapse border border-gray-300">
          <thead>
            <tr className="bg-gray-700 text-white">
              <th className="border border-gray-300 px-4 py-2 text-left">No.</th>
              <th className="border border-gray-300 px-4 py-2 text-left">Nama</th>
              <th className="border border-gray-300 px-4 py-2 text-left">Email</th>
              <th className="border border-gray-300 px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {users.map((user, index) => (
              <tr
                key={user.id}
                className="odd:bg-white even:bg-gray-50 hover:bg-gray-100"
              >
                <td className="border border-gray-300 px-4 py-2 text-center">
                  {index + 1}
                </td>
                <td className="border border-gray-300 px-4 py-2">{user.name}</td>
                <td className="border border-gray-300 px-4 py-2">{user.email}</td>
                <td className="border border-gray-300 px-4 py-2 text-center">
                  <Link to={`edit-student/${user.id}`}
                    className="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition mr-2"
                  >
                    Edit
                  </Link>
                  <button
                    onClick={() => handleDelete(user.id)}
                    className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      {users.length === 0 && (
        <p className="text-center text-gray-500 mt-6">
          No users found. Please add some users.
        </p>
      )}
    </div>
  );
}

export default StudentList;
