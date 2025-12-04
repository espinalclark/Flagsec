import axios from "axios";

const API_URL = import.meta.env.VITE_API_URL;

export const login = async (email, password) => {
  const res = await axios.post(`${API_URL}/login`, { email, password });
  localStorage.setItem("token", res.data.token);
  return res.data;
};

export const getCursos = async () => {
  const token = localStorage.getItem("token");
  const res = await axios.get(`${API_URL}/cursos`, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return res.data;
};

