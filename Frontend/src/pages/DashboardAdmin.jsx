// src/pages/DashboardAdmin.jsx
import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import Navbar from "../components/Navbar.jsx";
import logoxd from "../assets/mari.png";
import "./DashboardAdmin.css";

function DashboardAdmin() {
  const navigate = useNavigate();
  const [users, setUsers] = useState([
    { id: 1, name: "Estudiante Ejemplo", email: "alumno@flagsec.com", plan: "Free" },
  ]);
  const [cursos, setCursos] = useState([
    { id: 1, title: "Curso de Bash" },
    { id: 2, title: "Ciberseguridad" },
    { id: 3, title: "Hacking Ético" },
  ]);
  const [isOpen, setIsOpen] = useState(false);

  // Aquí luego puedes hacer fetch a la API para traer usuarios y cursos reales
  useEffect(() => {
    // fetch("/api/users")...
    // setUsers(data);
    // fetch("/api/cursos")...
    // setCursos(data);
  }, []);

  return (
    <div className="dashboard-container">
      {/* Header */}
      <header className="dashboard-header">
        <div className="navbar-logo">
          <img src={logoxd} alt="Logo FlagSec" className="navbar-logo-img" />
          <span className="navbar-brand">FLAGSEC ADMIN</span>
        </div>

        <div className="navbar-actions">
          <button className="logout-link" onClick={() => navigate("/")}>
            Logout
          </button>
        </div>
      </header>

      {/* Navbar lateral */}
      <Navbar isOpen={isOpen} setIsOpen={setIsOpen} />

      {/* Contenido principal */}
      <main className="dashboard-main">
        <h1 className="dashboard-title">Panel de Administrador</h1>
        <p className="dashboard-description">
          Desde aquí puedes gestionar usuarios, cursos y configuraciones del sitio.
        </p>

        {/* Sección de usuarios */}
        <section className="admin-users">
          <h3>Usuarios Registrados</h3>
          <div className="users-container">
            {users.map(user => (
              <div key={user.id} className="user-card">
                <h4>{user.name}</h4>
                <p>Email: {user.email}</p>
                <p>Plan: {user.plan}</p>
                <button onClick={() => alert(`Editando usuario: ${user.name}`)}>
                  Editar
                </button>
              </div>
            ))}
          </div>
        </section>

        {/* Sección de cursos */}
        <section className="admin-cursos">
          <h3>Cursos Disponibles</h3>
          <div className="cursos-container">
            {cursos.map(curso => (
              <div key={curso.id} className="curso-card">
                <h4>{curso.title}</h4>
                <button onClick={() => alert(`Editando curso: ${curso.title}`)}>
                  Editar
                </button>
              </div>
            ))}
          </div>
        </section>
      </main>
    </div>
  );
}

export default DashboardAdmin;

