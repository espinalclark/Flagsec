import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import logoxd from '../assets/mari.png';
import Navbar from '../components/Navbar.jsx';
import './Home.css';

// Importar imágenes de los cursos
import curso1 from '../assets/bash.jpg';
import curso2 from '../assets/ciberseguridad.jpg';
import curso3 from '../assets/hackeretico.png';
import curso4 from '../assets/intro-ciberseguridad.jpg';
import curso5 from '../assets/powershell.webp';
import curso6 from '../assets/python.jpg';

function Home() {
  const [isOpen, setIsOpen] = useState(false); // controla el menú lateral
  const navigate = useNavigate();

  // Lista de cursos
  const cursos = [
    { id: 1, img: curso1, title: "Curso de Bash", desc: "Aprende comandos de Linux y scripting." },
    { id: 2, img: curso2, title: "Ciberseguridad", desc: "Fundamentos esenciales para proteger sistemas." },
    { id: 3, img: curso3, title: "Hacking Ético", desc: "Conviértete en un hacker ético certificado." },
    { id: 4, img: curso4, title: "Introducción a Ciberseguridad", desc: "Primeros pasos en seguridad informática." },
    { id: 5, img: curso5, title: "PowerShell", desc: "Automatiza tareas y administra sistemas Windows." },
    { id: 6, img: curso6, title: "Python para Pentesting", desc: "Aprende Python aplicado a la seguridad." },
  ];

  return (
    <div className="home-container">
      {/* Header */}
      <header className="home-header">
        <div className="navbar-logo">
          <img src={logoxd} alt="Logo FlagSec" className="navbar-logo-img" />
          <span className="navbar-brand">FLAGSEC</span>
        </div>

        {/* Contenedor de acciones (Login, Hamburguesa) */}
        <div className="navbar-actions">
          <span className="login-link" onClick={() => navigate("/login")}>
            Login
          </span>

          <button className="hamburger-btn" onClick={() => setIsOpen(true)}>
            ☰
          </button>
        </div>
      </header>

      {/* Navbar lateral */}
      <Navbar isOpen={isOpen} setIsOpen={setIsOpen} />

      {/* Sección principal */}
      <main className="home-main">
        <h1 className="hero-title">Aprende Ciberseguridad desde Cero</h1>
        <p className="hero-description"></p>
        <p className="hero-description"></p>
        <p className="hero-description">
          ¿Te apasiona la ciberseguridad y el hacking ético? En Flagsec
          encontrarás los mejores cursos online para formarte desde cero
          y dominar el pentesting al mejor precio.
        </p>
        <p className="hero-description"></p>
        <button className="hero-button">
          Ver Cursos
        </button>

        {/* Sección de cursos */}
        <div className="cursos-container">
          {cursos.map(curso => (
            <div key={curso.id} className="curso-card">
              <img src={curso.img} alt={curso.title} className="curso-img" />
              <h3 className="curso-title">{curso.title}</h3>
              <p className="curso-desc">{curso.desc}</p>
              <button className="curso-btn" onClick={() => navigate("/login")}>
                Quiero este curso
              </button>
            </div>
          ))}
        </div>
      </main>
    </div>
  );
}

export default Home;

