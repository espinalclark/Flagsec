// src/pages/DashboardStudent.jsx
import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import Navbar from "../components/Navbar";
import './DashboardStudent.css';

// Ejemplo de cursos iniciales (opcional)
import curso1 from '../assets/bash.jpg';
import curso2 from '../assets/ciberseguridad.jpg';
import curso3 from '../assets/hackeretico.png';

function DashboardStudent() {
  const [isOpen, setIsOpen] = useState(false);
  const [user, setUser] = useState(null);
  const [cursos, setCursos] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const navigate = useNavigate();
  const API_URL = import.meta.env.VITE_API_URL || "http://127.0.0.1:8000/api";

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login");
      return;
    }

    const fetchData = async () => {
      try {
        // Traer datos del usuario
        const userRes = await axios.get(`${API_URL}/user`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setUser(userRes.data);

        // Traer cursos del usuario
        const cursosRes = await axios.get(`${API_URL}/user/cursos`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setCursos(cursosRes.data.length ? cursosRes.data : [
          { id: 1, img: curso1, title: "Curso de Bash" },
          { id: 2, img: curso2, title: "Ciberseguridad" },
          { id: 3, img: curso3, title: "Hacking Ético" },
        ]);
      } catch (err) {
        console.error(err);
        setError("Error al cargar datos, intenta iniciar sesión nuevamente");
        localStorage.removeItem("token");
        navigate("/login");
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [navigate, API_URL]);

  if (loading) return <div className="loading">Cargando datos...</div>;
  if (error) return <div className="error">{error}</div>;

  return (
    <div className="dashboard-container">
      {/* Header */}
      <header className="dashboard-header">
        <h2 className="dashboard-title">Panel del Estudiante</h2>
        <button className="hamburger-btn" onClick={() => setIsOpen(true)}>
          ☰
        </button>
      </header>

      {/* Navbar lateral */}
      <Navbar isOpen={isOpen} setIsOpen={setIsOpen} />

      {/* Contenido principal */}
      <main className="dashboard-main">
        {/* Perfil del estudiante */}
        <section className="student-profile">
          <h3>Bienvenido, {user?.name}</h3>
          <p>Plan: {user?.plan || "Gratis"}</p>
        </section>

        {/* Cursos del estudiante */}
        <section className="student-cursos">
          <h3>Tus Cursos</h3>
          <div className="cursos-container">
            {cursos.length > 0 ? (
              cursos.map((curso) => (
                <div key={curso.id} className="curso-card">
                  <img src={curso.img || "/placeholder.png"} alt={curso.title} className="curso-img" />
                  <h4 className="curso-title">{curso.title}</h4>
                  <button
                    className="curso-btn"
                    onClick={() => alert(`Entrando al curso: ${curso.title}`)}
                  >
                    Ir al curso
                  </button>
                </div>
              ))
            ) : (
              <p>No tienes cursos asignados</p>
            )}
          </div>
        </section>
      </main>
    </div>
  );
}

export default DashboardStudent;

