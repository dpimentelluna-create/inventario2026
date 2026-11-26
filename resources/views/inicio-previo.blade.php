<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio | Inventario de Equipos Tecnológicos 2026</title>
<style>
  * { box-sizing: border-box; }
  body {
    margin: 0;
    min-height: 100vh;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    background:
      radial-gradient(circle at 12% 18%, rgba(16, 185, 129, 0.24), transparent 42%),
      radial-gradient(circle at 88% 82%, rgba(37, 99, 235, 0.22), transparent 45%),
      #070d19;
    color: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
  }
  .wrap {
    width: 100%;
    max-width: 920px;
    background: #111827;
    border: 1px solid #334155;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 25px 65px rgba(0, 0, 0, 0.65);
  }
  .top {
    background: linear-gradient(125deg, #065f46 0%, #047857 52%, #0f172a 100%);
    padding: 2.2rem 2.4rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
  }
  .pill {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.55);
    border: 1px solid rgba(167, 243, 208, 0.35);
    color: #a7f3d0;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    margin-bottom: 0.8rem;
  }
  .top h1 {
    margin: 0 0 0.5rem;
    font-size: 2rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
  }
  .top p {
    margin: 0;
    color: #f1f5f9;
    font-size: 1rem;
    line-height: 1.55;
    max-width: 680px;
  }
  .content {
    padding: 2rem 2.4rem 2.3rem;
  }
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.1rem;
    margin-bottom: 1.8rem;
  }
  .card-item {
    background: #0f172a;
    border: 1px solid #293548;
    border-radius: 14px;
    padding: 1.15rem;
  }
  .card-item h2 {
    margin: 0 0 0.4rem;
    font-size: 1rem;
    font-weight: 700;
    color: #34d399;
  }
  .card-item p {
    margin: 0;
    font-size: 0.88rem;
    color: #e2e8f0;
    line-height: 1.5;
  }
  .bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    border-top: 1px solid #1e293b;
    padding-top: 1.3rem;
  }
  .btn-go {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.85rem 1.6rem;
    background: #10b981;
    color: #052e22;
    font-weight: 800;
    font-size: 0.96rem;
    text-decoration: none;
    border-radius: 10px;
    transition: background 0.15s ease, transform 0.15s ease;
  }
  .btn-go:hover {
    background: #34d399;
    transform: translateY(-1px);
  }
  .sublink {
    color: #cbd5e1;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
  }
  .sublink:hover { color: #ffffff; }
</style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <div class="pill">COORDINACIÓN Y SERVICIO DE TECNOLOGÍA • 2026</div>
      <h1>Inventario de Equipos Tecnológicos</h1>
      <p>Plataforma institucional para el control de equipos, accesorios, ubicaciones, préstamos, fichas técnicas y reportes.</p>
    </div>
    <div class="content">
      <div class="cards">
        <div class="card-item">
          <h2>Equipos y Accesorios</h2>
          <p>Registro completo, especificaciones técnicas, estados operativos, bajas y exportación a Excel y PDF.</p>
        </div>
        <div class="card-item">
          <h2>Aulas y Ubicaciones</h2>
          <p>Organización por espacios y ambientes institucionales con seguimiento claro de cada activo.</p>
        </div>
        <div class="card-item">
          <h2>Préstamos y Control</h2>
          <p>Gestión ágil de asignaciones, devoluciones, actas y consulta rápida desde cualquier módulo.</p>
        </div>
      </div>
      <div class="bar">
        <a class="btn-go" href="/login">Continuar a iniciar sesión →</a>
        <a class="sublink" href="/manual-usuario">Ver Manual de Usuario</a>
      </div>
    </div>
  </div>
</body>
</html>