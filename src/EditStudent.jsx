import React, { useState } from "react";
import { useParams } from "react-router";

const API_URL = "http://localhost:8000/data.php";

function AddStudent() {
    let params = useParams();
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [gender, setGender] = useState("male");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await fetch(API_URL, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id:params.id, name, email, gender }),
      });
      setName("");
      setEmail("");
      setGender("male");
      alert("Data successfully added!");
    } catch (error) {
      console.error("Failed to add data:", error);
    }
  };

  return (
    <div className="flex-1 p-8">
      <h1 className="text-3xl font-bold mb-6 text-center text-gray-800">
        Add New Student
      </h1>
      <form
        onSubmit={handleSubmit}
        className="max-w-lg mx-auto bg-white p-6 shadow rounded"
      >
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Name</label>
          <input
            type="text"
            value={name}
            onChange={(e) => setName(e.target.value)}
            className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Enter student name"
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Email</label>
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Enter student email"
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Gender</label>
          <select
            value={gender}
            onChange={(e) => setGender(e.target.value)}
            className="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
          >
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <button
          type="submit"
          className="w-full bg-blue-500 text-white font-bold py-3 rounded hover:bg-blue-600 transition"
        >
          Add Student
        </button>
      </form>
    </div>
  );
}

export default AddStudent;
