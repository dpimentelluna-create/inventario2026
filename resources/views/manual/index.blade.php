@extends('layouts.app')

@section('title', 'Manual de Usuario | Inventario 2026')

@section('content')
<style>
  .manual-blanco-wrap {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 16px 20px 40px 20px;
    box-sizing: border-box;
    font-family: inherit;
    color: #1e293b;
  }

  .manual-blanco-hero {
    background: #d1fae5;
    border: 1px solid #e2e8f0;
    border-left: 6px solid #16a34a;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  }

  .manual-blanco-tag {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #15803d;
    margin-bottom: 6px;
  }

  .manual-blanco-hero h1 {
    margin: 0 0 6px 0;
    font-size: 23px;
    font-weight: 700;
    color: #0f172a;
  }

  .manual-blanco-hero p {
    margin: 0;
    font-size: 14px;
    color: #475569;
  }

  .manual-blanco-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
  }

  .manual-blanco-input {
    flex: 1;
    min-width: 220px;
    padding: 9px 13px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background-color: #ecfdf5;
    color: #0f172a;
    font-size: 14px;
    outline: none;
  }

  .manual-blanco-input::placeholder {
    color: #64748b;
  }

  .manual-blanco-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 14px;
  }

  .manual-blanco-btn {
    padding: 8px 13px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background-color: #ecfdf5;
    color: #0f172a;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
  }

  .manual-blanco-btn.activa,
  .manual-blanco-btn:hover {
    background-color: #16a34a;
    border-color: #16a34a;
    color: #ffffff;
  }

  .manual-blanco-card {
    background-color: #ecfdf5;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 14px;
    color: #1e293b;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  }

  .manual-blanco-card h2 {
    margin: 0 0 12px 0;
    padding-bottom: 8px;
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
    border-bottom: 1px solid #e2e8f0;
  }

  .manual-blanco-card h3 {
    margin: 14px 0 6px 0;
    font-size: 15px;
    font-weight: 700;
    color: #15803d;
  }

  .manual-blanco-card p,
  .manual-blanco-card li {
    font-size: 14px;
    line-height: 1.6;
    color: #334155;
  }

  .manual-blanco-card strong {
    color: #0f172a;
  }

  .manual-blanco-card ul,
  .manual-blanco-card ol {
    margin: 6px 0 12px 0;
    padding-left: 22px;
  }

  .manual-blanco-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
    font-size: 13.5px;
  }

  .manual-blanco-table th {
    background-color: #f8fafc;
    color: #0f172a;
    padding: 9px 12px;
    text-align: left;
    border: 1px solid #e2e8f0;
  }

  .manual-blanco-table td {
    background-color: #ecfdf5;
    color: #1e293b;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    vertical-align: top;
  }

  .manual-blanco-table tr:nth-child(even) td {
    background-color: #f8fafc;
  }

  .manual-blanco-pdf {
    width: 100%;
    height: 760px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background-color: #ecfdf5;
    display: block;
  }
</style>

<div class="manual-blanco-wrap">
  <div class="manual-blanco-hero">
    <span class="manual-blanco-tag">Guía Integrada en el Sistema</span>
    <h1>Manual de Usuario: Inventario de Equipos Tecnológicos 2026</h1>
    <p>Consulta módulos, íconos de la barra lateral, filtros, tablas, fichas y el PDF oficial sin salir del sistema.</p>
  </div>

  <div class="manual-blanco-bar">
    <input id="mbBuscar" class="manual-blanco-input" type="text" placeholder="Buscar en el manual (préstamos, ubicaciones, filtros, accesorios, catálogos)...">
    <button id="mbTodo" class="manual-blanco-btn" type="button">Ver todo</button>
  </div>

  <div class="manual-blanco-tabs">
    <button type="button" class="manual-blanco-btn mb-tab activa" data-sec="mb1">1. Flujo e Interfaz</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb2">2. Íconos Sidebar</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb3">3. Inicio</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb4">4. Préstamos</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb5">5. Equipos</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb6">6. Accesorios</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb7">7. Catálogos</button>
    <button type="button" class="manual-blanco-btn mb-tab" data-sec="mb8">8. PDF Oficial</button>
  </div>

  <div id="mb1" class="manual-blanco-card mb-sec mb-find">
    <h2>1. Introducción, Flujo de Trabajo y Navegación</h2>
    <p>El sistema <strong>Inventario de Equipos Tecnológicos 2026</strong> centraliza el registro, control operativo, préstamos y ubicación de equipos y accesorios.</p>
    <h3>Secuencia lógica recomendada</h3>
    <ol>
      <li><strong>Catálogos base:</strong> Registra primero <em>Tipos de Equipos</em> y <em>Ubicaciones</em> físicas (Aulas AIP, Aula de Cómputo, Carritos de Carga).</li>
      <li><strong>Activos:</strong> Registra <em>Equipos</em> individuales y sus <em>Accesorios</em> vinculados o independientes.</li>
      <li><strong>Personal:</strong> Da de alta a docentes y personal en <em>Solicitantes</em>.</li>
      <li><strong>Operación diaria:</strong> Gestiona <em>Préstamos</em>, devoluciones, impresión de fichas, actas en PDF y exportaciones a Excel.</li>
    </ol>
    <h3>Controles generales de la interfaz</h3>
    <ul>
      <li><strong>Botón ≡:</strong> Contrae o expande el menú lateral para ampliar el espacio horizontal de las tablas.</li>
      <li><strong>Sección activa:</strong> Resalta en el menú lateral el módulo donde te encuentras.</li>
      <li><strong>Menú lateral:</strong> Permite acceder a cada módulo y gestionar la sesión desde la parte inferior.</li>
      <li><strong>Perfil de usuario:</strong> Permite cambiar contraseña o cerrar sesión desde la esquina inferior izquierda.</li>
    </ul>
  </div>

  <div id="mb2" class="manual-blanco-card mb-sec mb-find">
    <h2>2. Íconos de la Barra Lateral</h2>
    <table class="manual-blanco-table">
      <thead>
        <tr>
          <th>Ícono</th>
          <th>Sección</th>
          <th>Función</th>
        </tr>
      </thead>
      <tbody>
        <tr><td><strong>Menú (≡)</strong></td><td>Barra lateral</td><td>Expande o contrae el menú de navegación.</td></tr>
        <tr><td><strong>Casita</strong></td><td>Inicio</td><td>Panel de control con indicadores, resúmenes y accesos rápidos.</td></tr>
        <tr><td><strong>Portapapeles</strong></td><td>Préstamos</td><td>Entregas temporales, horarios, devoluciones y actas PDF.</td></tr>
        <tr><td><strong>Monitor</strong></td><td>Equipos</td><td>Catálogo de dispositivos, series, estados y fichas técnicas.</td></tr>
        <tr><td><strong>Dispositivo</strong></td><td>Accesorios Equipo</td><td>Cargadores, cables y complementos vinculados o libres.</td></tr>
        <tr><td><strong>Personas</strong></td><td>Solicitantes</td><td>Directorio de solicitantes y su historial de préstamos.</td></tr>
        <tr><td><strong>Etiqueta</strong></td><td>Tipos Equipos</td><td>Categorías generales de clasificación del hardware.</td></tr>
        <tr><td><strong>Pin</strong></td><td>Ubicaciones</td><td>Aulas, laboratorios o espacios y auditoría de equipos asignados.</td></tr>
        <tr><td><strong>Documento</strong></td><td>Manual del Usuario</td><td>Abre esta guía dentro de tu sistema.</td></tr>
        <tr><td><strong>Perfil</strong></td><td>Cuenta</td><td>Administra la sesión activa del usuario.</td></tr>
      </tbody>
    </table>
  </div>

  <div id="mb3" class="manual-blanco-card mb-sec mb-find">
    <h2>3. Módulo 1: Inicio (Panel de Control)</h2>
    <ul>
      <li><strong>Indicadores principales:</strong> <em>Total Equipos</em>, <em>En Buen Estado</em> (verde), <em>Estado Regular</em> (amarillo), <em>Equipos Malogrados</em> (rojo), <em>Equipos Dados de Baja</em> (gris), <em>Préstamos Activos</em> (ámbar) y <em>Sin Clasificar / Ubicaciones</em>.</li>
      <li><strong>Tablas resumidas:</strong> <em>Equipos por Tipo</em> y <em>Equipos por Ubicación</em> con botones <strong>VER</strong>, <strong>VER MÁS</strong>, <strong>VER TIPOS</strong> y <strong>VER UBICACIONES</strong>.</li>
      <li><strong>Accesos rápidos e Información del Sistema:</strong> Botones <strong>INGRESAR →</strong> a cada módulo y panel lateral con totales y estado de sesión.</li>
    </ul>
  </div>

  <div id="mb4" class="manual-blanco-card mb-sec mb-find">
    <h2>4. Módulo 2: Préstamos</h2>
    <ul>
      <li><strong>Controles superiores:</strong> Botón <strong>+ Registrar Préstamo</strong> y menú <strong>Exportar</strong> (Excel o PDF).</li>
      <li><strong>Filtros avanzados (FILTROS):</strong> Filtra por <em>Solicitante</em>, <em>Cargo</em>, <em>Equipo</em>, <em>Estado</em>, <em>Fecha</em> (con <strong>HOY</strong>) y <em>Horario Desde / Horario Hasta</em>, con <strong>(X)</strong>, <strong>LIMPIAR FILTROS</strong> y <strong>APLICAR FILTROS</strong>.</li>
      <li><strong>Registro en 3 partes y detalle:</strong> (1) Datos del préstamo, (2) Selección de equipos, (3) Equipos seleccionados y <strong>GUARDAR PRÉSTAMO</strong>, más ficha con <strong>IMPRIMIR FICHA</strong>, <strong>EXPORTAR</strong> y <strong>← VOLVER</strong>.</li>
    </ul>
  </div>

  <div id="mb5" class="manual-blanco-card mb-sec mb-find">
    <h2>5. Módulo 3: Equipos</h2>
    <ul>
      <li><strong>Búsqueda y filtros:</strong> Botón <strong>+ Registrar Nuevo Equipo</strong>, <strong>Exportar</strong> (Excel / PDF), contador de coincidencias y filtros por <em>Tipo</em>, <em>Marca</em>, <em>Modelo</em>, <em>Ubicación</em>, <em>Estado</em>, <em>Situación Administrativa</em>, <em>N.º Serie</em> y <em>Fecha</em> (con <strong>HOY</strong>).</li>
      <li><strong>Registro en 3 partes y ficha:</strong> Parte 1 (<em>Datos del Equipo</em>), Parte 2 (<em>Especificaciones</em>) y Parte 3 (<em>Accesorios del Equipo</em> con <strong>+ AGREGAR ACCESORIO</strong>), además de ficha técnica con <strong>IMPRIMIR FICHA</strong>.</li>
    </ul>
  </div>

  <div id="mb6" class="manual-blanco-card mb-sec mb-find">
    <h2>6. Módulo 4: Accesorios de Equipo</h2>
    <ul>
      <li><strong>Indicadores y filtros:</strong> Resumen de <em>Total Accesorios</em>, <em>Buen Estado</em>, <em>Estado Regular</em> y <em>Malogrados</em>, con <strong>FILTROS</strong> por equipo, ubicación, tipo, marca, serie, estado y observaciones.</li>
      <li><strong>Registro (+ Registrar Accesorio):</strong> Permite vincular a un equipo (hereda ubicación) o dejar como <em>SIN EQUIPO</em>, guardando con <strong>GUARDAR</strong> o <strong>CANCELAR</strong>.</li>
    </ul>
  </div>

  <div id="mb7" class="manual-blanco-card mb-sec mb-find">
    <h2>7. Módulos de Catálogos Base</h2>
    <p><strong>Solicitantes:</strong> registro, ficha con <strong>IMPRIMIR FICHA</strong>, resumen e historial de préstamos. <strong>Tipos de Equipos:</strong> categorías (<em>Laptops, Estabilizadores CDP, Proyectores, Televisores, Parlantes, XO</em>) y ficha con estadísticas. <strong>Ubicaciones:</strong> aulas, laboratorios o carritos, ficha con <strong>IMPRIMIR</strong>, tarjetas por estado, barras de progreso, tabla de equipos asignados y formulario (<em>Nombre*</em> obligatorio, <em>Tipo</em> opcional).</p>
  </div>

  <div id="mb8" class="manual-blanco-card mb-sec">
    <h2>8. Visor del Manual en PDF</h2>
    <p>Documento PDF oficial integrado (<code>public/manual/manual_usuario.pdf</code>):</p>
    <iframe src="{{ asset('manual/manual_usuario.pdf') }}" class="manual-blanco-pdf" title="Manual de Usuario PDF"></iframe>
  </div>
</div>

<script>
(function () {
  var secs = document.querySelectorAll('.mb-sec');
  var tabs = document.querySelectorAll('.mb-tab');
  var buscar = document.getElementById('mbBuscar');
  var btnTodo = document.getElementById('mbTodo');
  var verTodo = false;

  function mostrar(id) {
    verTodo = false;
    if (btnTodo) btnTodo.textContent = 'Ver todo';
    tabs.forEach(function (t) {
      t.classList.toggle('activa', t.getAttribute('data-sec') === id);
    });
    secs.forEach(function (s) {
      s.style.display = (s.id === id) ? 'block' : 'none';
    });
  }

  tabs.forEach(function (t) {
    t.addEventListener('click', function () {
      if (buscar) buscar.value = '';
      mostrar(t.getAttribute('data-sec'));
    });
  });

  if (btnTodo) {
    btnTodo.addEventListener('click', function () {
      verTodo = !verTodo;
      if (buscar) buscar.value = '';
      tabs.forEach(function (t) { t.classList.remove('activa'); });
      secs.forEach(function (s) {
        s.style.display = verTodo ? 'block' : 'none';
      });
      if (!verTodo) mostrar('mb1');
      else btnTodo.textContent = 'Por pestañas';
    });
  }

  if (buscar) {
    buscar.addEventListener('input', function () {
      var q = this.value.trim().toLowerCase();
      if (!q) {
        if (!verTodo) mostrar('mb1');
        return;
      }
      document.querySelectorAll('.mb-find').forEach(function (s) {
        s.style.display = s.innerText.toLowerCase().indexOf(q) !== -1 ? 'block' : 'none';
      });
    });
  }

  mostrar('mb1');
})();
</script><!-- MANUAL_EQUIPOS_INTERACTIVO_START -->
<section id="manual-equipos-interactivo" class="meq-shell" aria-label="Manual interactivo del módulo equipos">
  <style>
    .meq-shell {
      margin-top: 1.5rem;
      background: #111827;
      color: #f8fafc;
      border: 1px solid #334155;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35);
      font-family: inherit;
    }
    body.light-mode .meq-shell,
    body[data-theme="light"] .meq-shell {
      background: #d1fae5;
      color: #0f172a;
      border-color: #cbd5e1;
      box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    }
    .meq-header {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-start;
      gap: 1rem;
      border-bottom: 1px solid #334155;
      padding-bottom: 1rem;
      margin-bottom: 1.2rem;
    }
    body.light-mode .meq-header,
    body[data-theme="light"] .meq-header {
      border-color: #e2e8f0;
    }
    .meq-kicker {
      display: inline-block;
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      color: #34d399;
      background: rgba(16, 185, 129, 0.14);
      border: 1px solid rgba(52, 211, 153, 0.35);
      padding: 0.25rem 0.65rem;
      border-radius: 999px;
      margin-bottom: 0.45rem;
    }
    body.light-mode .meq-kicker,
    body[data-theme="light"] .meq-kicker {
      color: #047857;
      background: #ecfdf5;
      border-color: #a7f3d0;
    }
    .meq-title {
      margin: 0;
      font-size: 1.4rem;
      font-weight: 800;
      color: #f8fafc;
    }
    body.light-mode .meq-title,
    body[data-theme="light"] .meq-title {
      color: #0f172a;
    }
    .meq-subtitle {
      margin: 0.25rem 0 0;
      font-size: 0.9rem;
      color: #cbd5e1;
    }
    body.light-mode .meq-subtitle,
    body[data-theme="light"] .meq-subtitle {
      color: #475569;
    }
    .meq-controls {
      display: flex;
      flex-wrap: wrap;
      gap: 0.6rem;
      margin-bottom: 1rem;
    }
    .meq-search {
      flex: 1 1 260px;
      padding: 0.6rem 0.85rem;
      border-radius: 10px;
      border: 1px solid #475569;
      background: #0f172a;
      color: #f8fafc;
      font-size: 0.9rem;
    }
    body.light-mode .meq-search,
    body[data-theme="light"] .meq-search {
      background: #f8fafc;
      color: #0f172a;
      border-color: #cbd5e1;
    }
    .meq-btn {
      padding: 0.55rem 0.9rem;
      border-radius: 10px;
      border: 1px solid #334155;
      background: #1e293b;
      color: #e2e8f0;
      font-size: 0.84rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .meq-btn:hover {
      border-color: #10b981;
      color: #ffffff;
    }
    .meq-btn.is-active {
      background: #059669;
      border-color: #10b981;
      color: #ffffff;
    }
    body.light-mode .meq-btn,
    body[data-theme="light"] .meq-btn {
      background: #f1f5f9;
      color: #1e293b;
      border-color: #cbd5e1;
    }
    body.light-mode .meq-btn.is-active,
    body[data-theme="light"] .meq-btn.is-active {
      background: #059669;
      color: #ffffff;
      border-color: #059669;
    }
    .meq-tabs {
      display: flex;
      flex-wrap: wrap;
      gap: 0.45rem;
      margin-bottom: 1.25rem;
    }
    .meq-item {
      border: 1px solid #293548;
      background: #0f172a;
      border-radius: 12px;
      margin-bottom: 0.75rem;
      overflow: hidden;
    }
    body.light-mode .meq-item,
    body[data-theme="light"] .meq-item {
      background: #f8fafc;
      border-color: #e2e8f0;
    }
    .meq-item-head {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 0.75rem;
      padding: 0.9rem 1.1rem;
      background: transparent;
      border: 0;
      color: #f8fafc;
      font-size: 0.98rem;
      font-weight: 700;
      text-align: left;
      cursor: pointer;
    }
    body.light-mode .meq-item-head,
    body[data-theme="light"] .meq-item-head {
      color: #0f172a;
    }
    .meq-item-body {
      display: none;
      padding: 0 1.1rem 1.1rem;
      color: #e2e8f0;
      font-size: 0.9rem;
      line-height: 1.55;
      border-top: 1px solid rgba(148, 163, 184, 0.14);
    }
    .meq-item.is-open .meq-item-body {
      display: block;
      padding-top: 0.9rem;
    }
    body.light-mode .meq-item-body,
    body[data-theme="light"] .meq-item-body {
      color: #334155;
    }
    .meq-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0.7rem 0;
      font-size: 0.86rem;
    }
    .meq-table th,
    .meq-table td {
      border: 1px solid #334155;
      padding: 0.55rem 0.7rem;
      text-align: left;
    }
    .meq-table th {
      background: #1e293b;
      color: #34d399;
    }
    body.light-mode .meq-table th,
    body[data-theme="light"] .meq-table th {
      background: #e2e8f0;
      color: #065f46;
    }
    body.light-mode .meq-table td,
    body.light-mode .meq-table th,
    body[data-theme="light"] .meq-table td,
    body[data-theme="light"] .meq-table th {
      border-color: #cbd5e1;
    }
    .meq-sim {
      margin-top: 1.25rem;
      background: #0b1322;
      border: 1px solid #10b981;
      border-radius: 14px;
      padding: 1.15rem;
    }
    body.light-mode .meq-sim,
    body[data-theme="light"] .meq-sim {
      background: #f0fdf4;
      border-color: #10b981;
    }
    .meq-sim-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 0.85rem;
      margin: 0.85rem 0;
    }
    .meq-field label {
      display: block;
      font-size: 0.8rem;
      font-weight: 700;
      margin-bottom: 0.3rem;
      color: #a7f3d0;
    }
    body.light-mode .meq-field label,
    body[data-theme="light"] .meq-field label {
      color: #065f46;
    }
    .meq-field select,
    .meq-field input {
      width: 100%;
      padding: 0.5rem 0.65rem;
      border-radius: 8px;
      border: 1px solid #475569;
      background: #111827;
      color: #f8fafc;
      font-size: 0.86rem;
    }
    body.light-mode .meq-field select,
    body.light-mode .meq-field input,
    body[data-theme="light"] .meq-field select,
    body[data-theme="light"] .meq-field input {
      background: #d1fae5;
      color: #0f172a;
      border-color: #cbd5e1;
    }
    .meq-note {
      margin-top: 0.6rem;
      padding: 0.7rem 0.85rem;
      border-radius: 8px;
      background: rgba(16, 185, 129, 0.12);
      border-left: 3px solid #10b981;
      font-size: 0.85rem;
    }
    kbd {
      background: #1e293b;
      border: 1px solid #475569;
      border-radius: 5px;
      padding: 0.1rem 0.4rem;
      font-size: 0.8rem;
      color: #34d399;
    }
  </style>

  <div class="meq-header">
    <div>
      <span class="meq-kicker">Guía Interactiva • Módulo Equipos</span>
      <h2 class="meq-title">Manual de Usuario: Módulo Equipos</h2>
      <p class="meq-subtitle">Registro en 3 partes, consulta, filtros combinados, exportación, acciones, atajos de teclado y simulación guiada.</p>
    </div>
    <div style="display:flex;gap:0.45rem;flex-wrap:wrap;">
      <button type="button" class="meq-btn" id="meqExpandAll">Expandir todo</button>
      <button type="button" class="meq-btn" id="meqCollapseAll">Contraer todo</button>
    </div>
  </div>

  <div class="meq-controls">
    <input type="search" id="meqSearchInput" class="meq-search" placeholder="Buscar en el manual (ej. Laptop, serie, Shift, DE BAJA, Excel, +)...">
    <button type="button" class="meq-btn" id="meqClearSearch">Limpiar</button>
  </div>

  <div class="meq-tabs" id="meqCategoryTabs">
    <button type="button" class="meq-btn is-active" data-cat="all">Todo</button>
    <button type="button" class="meq-btn" data-cat="objetivo">1. Objetivo</button>
    <button type="button" class="meq-btn" data-cat="registro">2.1 Registro (3 partes)</button>
    <button type="button" class="meq-btn" data-cat="consulta">2.2 Búsqueda y orden</button>
    <button type="button" class="meq-btn" data-cat="filtros">2.3 Filtros y estados</button>
    <button type="button" class="meq-btn" data-cat="exportar">2.4 Exportar</button>
    <button type="button" class="meq-btn" data-cat="acciones">2.5 Acciones y 3. Form</button>
    <button type="button" class="meq-btn" data-cat="atajos">2.6 Atajos y 4. Tips</button>
  </div>

  <div id="meqAccordionList">
    <article class="meq-item is-open" data-cat="objetivo" data-keywords="objetivo equipos especificaciones ubicacion estado situacion administrativa accesorios busqueda filtros ordenamiento exportacion">
      <button type="button" class="meq-item-head">
        <span>1. Objetivo del módulo</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <p>El módulo <strong>Equipos</strong> permite registrar, consultar, organizar y administrar los equipos tecnológicos de la institución. Facilita el control de sus características, especificaciones técnicas, ubicación, estado, situación administrativa y accesorios relacionados.</p>
        <p>Además, incorpora herramientas de búsqueda, filtros, ordenamiento y exportación de información, con el propósito de agilizar las consultas y mantener actualizado el inventario.</p>
      </div>
    </article>

    <article class="meq-item is-open" data-cat="registro" data-keywords="2.1 registrar nuevo equipo parte 1 datos tipo otro numero de serie marca modelo ubicacion fecha hoy parte 2 especificaciones laptop procesador ram disco duro sistema operativo color estado bueno regular malogrado observaciones otros equipos descripcion parte 3 accesorios agregar tacho autocompletar">
      <button type="button" class="meq-item-head">
        <span>2.1. Registrar un nuevo equipo (Formulario en 3 partes)</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <p>El botón <strong>Registrar nuevo equipo</strong> abre un formulario dividido en tres partes consecutivas. Para avanzar, es necesario completar los campos obligatorios de cada parte.</p>
        <p><strong>Parte 1. Datos del equipo:</strong></p>
        <ul>
          <li><strong>Tipo de equipo:</strong> permite buscar y seleccionar un tipo existente. Si no está registrado, usa la opción <strong>Otro</strong> para especificarlo y registrarlo directamente desde el formulario.</li>
          <li><strong>Número de serie:</strong> identifica al equipo mediante su número de serie real.</li>
          <li><strong>Marca y modelo:</strong> registran la información correspondiente al fabricante y modelo del equipo.</li>
          <li><strong>Ubicación:</strong> permite seleccionar una ubicación previamente registrada (las nuevas ubicaciones se administran desde el módulo <em>Ubicaciones</em>).</li>
          <li><strong>Fecha de registro:</strong> se genera automáticamente con la fecha actual y puede modificarse escribiéndola, usando el calendario o el botón <strong>Hoy</strong>.</li>
        </ul>
        <p><strong>Parte 2. Especificaciones:</strong> los campos dependen del tipo de equipo seleccionado:</p>
        <table class="meq-table">
          <thead>
            <tr><th>Tipo de equipo</th><th>Información solicitada</th></tr>
          </thead>
          <tbody>
            <tr><td><strong>Laptop</strong></td><td>Procesador, memoria RAM, disco duro, sistema operativo, color, estado y observaciones.</td></tr>
            <tr><td><strong>Otros equipos</strong></td><td>Descripción, color, estado y observaciones.</td></tr>
          </tbody>
        </table>
        <p>El <strong>estado</strong> permite seleccionar <strong>BUENO</strong>, <strong>REGULAR</strong> o <strong>MALOGRADO</strong>. Las <strong>observaciones</strong> permiten información adicional respetando el límite de caracteres.</p>
        <p><strong>Parte 3. Accesorios:</strong> permite registrar accesorios relacionados o guardar sin accesorios. Al presionar <strong>+ Agregar accesorio</strong> se muestran tipo, marca, modelo, número de serie, estado y observaciones (con opción <strong>Otro</strong> para nuevos tipos y botón de ícono de <strong>tacho</strong> con confirmación o cancelación). Al guardar, redirige al listado principal resaltando el equipo recién registrado.</p>
        <div class="meq-note"><strong>Importante:</strong> El formulario puede autocompletar algunos campos a partir de registros anteriores del mismo tipo de equipo o accesorio para agilizar el ingreso. Verifica siempre los datos autocompletados antes de guardar.</div>
      </div>
    </article>

    <article class="meq-item" data-cat="consulta" data-keywords="2.2 consultar buscar equipos registros por pagina 5 10 25 100 encabezados ordenar ascendente descendente shift paginacion">
      <button type="button" class="meq-item-head">
        <span>2.2. Consultar y buscar equipos</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <ul>
          <li><strong>Buscar:</strong> búsquedas rápidas en los campos disponibles de la tabla.</li>
          <li><strong>Selector de registros por página:</strong> muestra <strong>5</strong>, <strong>10</strong>, <strong>25</strong> o <strong>100</strong> registros por página.</li>
          <li><strong>Encabezados de la tabla:</strong> ordenan de forma ascendente, descendente o vuelven al orden predeterminado. Mantén presionada la tecla <kbd>Shift</kbd> al seleccionar encabezados adicionales para ordenar por dos o más columnas.</li>
          <li><strong>Paginación:</strong> navegación mediante primera página (<code>&lt;&lt;</code>), anterior (<code>&lt;</code>), páginas numeradas, siguiente (<code>&gt;</code>) y última página (<code>&gt;&gt;</code>).</li>
        </ul>
      </div>
    </article>

    <article class="meq-item" data-cat="filtros" data-keywords="2.3 filtrar informacion filtros tipo marca modelo ubicacion estado bueno regular malogrado situacion administrativa en inventario de baja todos ugel numero de serie fecha limpiar filtros aplicar filtros">
      <button type="button" class="meq-item-head">
        <span>2.3. Filtrar información y situaciones administrativas</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <p>El botón <strong>Filtros</strong> abre un formulario con criterios combinables y botón <strong>X</strong> individual para limpiar cada campo:</p>
        <table class="meq-table">
          <thead>
            <tr><th>Campo</th><th>Función</th></tr>
          </thead>
          <tbody>
            <tr><td><strong>Tipo</strong></td><td>Busca o selecciona un tipo de equipo existente.</td></tr>
            <tr><td><strong>Marca</strong></td><td>Busca o selecciona marcas disponibles para el tipo elegido (se habilita tras elegir Tipo).</td></tr>
            <tr><td><strong>Modelo</strong></td><td>Busca o selecciona modelos disponibles para la marca elegida (se habilita tras elegir Marca).</td></tr>
            <tr><td><strong>Ubicación</strong></td><td>Filtra por una ubicación registrada.</td></tr>
            <tr><td><strong>Estado</strong></td><td>Filtra por <strong>BUENO</strong>, <strong>REGULAR</strong> o <strong>MALOGRADO</strong>.</td></tr>
            <tr><td><strong>Situación administrativa</strong></td><td>Consulta equipos <strong>EN INVENTARIO</strong>, <strong>DE BAJA</strong> o <strong>TODOS</strong>.</td></tr>
            <tr><td><strong>Número de serie</strong></td><td>Busca un equipo por su número de serie.</td></tr>
            <tr><td><strong>Fecha</strong></td><td>Selecciona fecha escribiéndola, con el calendario o presionando <strong>Hoy</strong>.</td></tr>
          </tbody>
        </table>
        <p>Acciones del filtro: <strong>Limpiar filtros</strong> (borra criterios) y <strong>Aplicar filtros</strong> (actualiza la tabla según filtros, ordenamiento y búsqueda).</p>
        <ul>
          <li><strong>EN INVENTARIO:</strong> equipo registrado que permanece en una ubicación de la institución.</li>
          <li><strong>DE BAJA:</strong> equipo dado de baja y entregado a la UGEL u otra institución, según corresponda.</li>
          <li><strong>TODOS:</strong> consulta ambas situaciones, incluyendo dados de baja y su última ubicación registrada.</li>
        </ul>
      </div>
    </article>

    <article class="meq-item" data-cat="exportar" data-keywords="2.4 exportar informacion excel cinco hojas pdf consulta actual filtros busqueda ordenamiento">
      <button type="button" class="meq-item-head">
        <span>2.4. Exportar información (Excel y PDF)</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <ul>
          <li><strong>Excel:</strong> exporta información detallada en un archivo con <strong>cinco hojas de cálculo</strong>.</li>
          <li><strong>PDF:</strong> genera un documento con la información principal de los equipos, sin incluir todos los detalles.</li>
        </ul>
        <p>La exportación refleja la <strong>consulta actual</strong> de la tabla, por lo que filtros, búsquedas y ordenamiento modifican el resultado exportado.</p>
      </div>
    </article>

    <article class="meq-item" data-cat="acciones" data-keywords="2.5 ver editar eliminar equipos ficha imprimir pdf confirmar atras cancelar guardar asterisco obligatorio">
      <button type="button" class="meq-item-head">
        <span>2.5. Ver, editar y eliminar equipos — 3. Acciones del formulario</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <ul>
          <li><strong>Ver:</strong> abre la ficha detallada del equipo y sus accesorios relacionados, con botón <strong>Imprimir</strong> (para imprimir o guardar como PDF).</li>
          <li><strong>Editar:</strong> abre el formulario de edición con las mismas reglas de validación; retroceder o cancelar solicita confirmación.</li>
          <li><strong>Eliminar:</strong> solicita confirmación previa para evitar eliminaciones accidentales.</li>
        </ul>
        <p><strong>Acciones del formulario de registro y edición:</strong></p>
        <ul>
          <li><strong>Atrás</strong> y <strong>Cancelar:</strong> solicitan confirmación antes de salir o abandonar el formulario.</li>
          <li><strong>Guardar:</strong> registra los datos y redirige al listado principal. Los campos con asterisco (<code>*</code>) son obligatorios.</li>
        </ul>
      </div>
    </article>

    <article class="meq-item" data-cat="atajos" data-keywords="2.6 atajos de teclado tecla + f 4 recomendaciones serie autocompletados marca modelo filtros confirmar exportar">
      <button type="button" class="meq-item-head">
        <span>2.6. Atajos de teclado y 4. Recomendaciones para el usuario</span>
        <span>▾</span>
      </button>
      <div class="meq-item-body">
        <p><strong>Atajos de teclado:</strong> <kbd>+</kbd> abre el formulario de registro de un nuevo equipo; <kbd>F</kbd> abre o cierra el formulario de filtros.</p>
        <p><strong>Recomendaciones clave:</strong></p>
        <ol>
          <li>Verifica que el número de serie corresponda al equipo físico.</li>
          <li>Revisa los datos autocompletados antes de guardar (serie, ubicación y características).</li>
          <li>Comprueba que tipo, marca y modelo sean correctos.</li>
          <li>Combina filtros para localizar equipos específicos más rápido.</li>
          <li>Confirma siempre antes de eliminar o salir de un formulario.</li>
          <li>Revisa filtros y búsquedas activas antes de exportar a Excel o PDF.</li>
        </ol>
      </div>
    </article>
  </div>

  <div class="meq-sim">
    <strong style="color:#34d399;">Simulador rápido de Parte 2 (Especificaciones según Tipo de Equipo)</strong>
    <div class="meq-sim-grid">
      <div class="meq-field">
        <label for="meqSimTipo">Simular Tipo de Equipo</label>
        <select id="meqSimTipo">
          <option value="laptop">Laptop</option>
          <option value="otro">Otros equipos (ej. Proyector, Estabilizador, Impresora)</option>
        </select>
      </div>
      <div class="meq-field">
        <label for="meqSimEstado">Simular Estado</label>
        <select id="meqSimEstado">
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALOGRADO">MALOGRADO</option>
        </select>
      </div>
      <div class="meq-field">
        <label for="meqSimSituacion">Simular Situación Administrativa</label>
        <select id="meqSimSituacion">
          <option value="EN INVENTARIO">EN INVENTARIO (en ubicación institucional)</option>
          <option value="DE BAJA">DE BAJA (entregado a UGEL u otra institución)</option>
          <option value="TODOS">TODOS (incluye baja y última ubicación)</option>
        </select>
      </div>
    </div>
    <div id="meqSimOutput" class="meq-note"></div>
  </div>
</section>

<script id="manual-equipos-interactivo-js">
(function () {
  var root = document.getElementById("manual-equipos-interactivo");
  if (!root) return;

  var items = Array.prototype.slice.call(root.querySelectorAll(".meq-item"));
  var tabs = Array.prototype.slice.call(root.querySelectorAll("#meqCategoryTabs .meq-btn"));
  var searchInput = document.getElementById("meqSearchInput");
  var clearBtn = document.getElementById("meqClearSearch");
  var expandAllBtn = document.getElementById("meqExpandAll");
  var collapseAllBtn = document.getElementById("meqCollapseAll");

  var activeCat = "all";

  function applyFilters() {
    var q = (searchInput && searchInput.value ? searchInput.value : "").trim().toLowerCase();
    items.forEach(function (item) {
      var cat = item.getAttribute("data-cat") || "";
      var kw = (item.getAttribute("data-keywords") || "").toLowerCase();
      var txt = (item.textContent || "").toLowerCase();
      var matchCat = (activeCat === "all" || cat === activeCat);
      var matchQ = (!q || kw.indexOf(q) !== -1 || txt.indexOf(q) !== -1);
      var show = matchCat && matchQ;
      item.style.display = show ? "" : "none";
      if (q && show) {
        item.classList.add("is-open");
      }
    });
  }

  root.querySelectorAll(".meq-item-head").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var parent = btn.closest(".meq-item");
      if (parent) parent.classList.toggle("is-open");
    });
  });

  tabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      tabs.forEach(function (t) { t.classList.remove("is-active"); });
      tab.classList.add("is-active");
      activeCat = tab.getAttribute("data-cat") || "all";
      applyFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener("input", applyFilters);
  }
  if (clearBtn) {
    clearBtn.addEventListener("click", function () {
      if (searchInput) searchInput.value = "";
      activeCat = "all";
      tabs.forEach(function (t) {
        t.classList.toggle("is-active", t.getAttribute("data-cat") === "all");
      });
      applyFilters();
    });
  }
  if (expandAllBtn) {
    expandAllBtn.addEventListener("click", function () {
      items.forEach(function (it) { if (it.style.display !== "none") it.classList.add("is-open"); });
    });
  }
  if (collapseAllBtn) {
    collapseAllBtn.addEventListener("click", function () {
      items.forEach(function (it) { it.classList.remove("is-open"); });
    });
  }

  var simTipo = document.getElementById("meqSimTipo");
  var simEstado = document.getElementById("meqSimEstado");
  var simSit = document.getElementById("meqSimSituacion");
  var simOut = document.getElementById("meqSimOutput");

  function renderSim() {
    if (!simTipo || !simEstado || !simSit || !simOut) return;
    var campos = simTipo.value === "laptop"
      ? "Procesador, Memoria RAM, Disco duro, Sistema operativo, Color, Estado y Observaciones."
      : "Descripción, Color, Estado y Observaciones.";
    var descSit = simSit.value === "DE BAJA"
      ? "Dado de baja y entregado a la UGEL u otra institución."
      : (simSit.value === "TODOS"
          ? "Incluye equipos en inventario y dados de baja con su última ubicación registrada."
          : "Permanece en una ubicación de la institución.");
    simOut.innerHTML = "<strong>Campos de Parte 2:</strong> " + campos +
      "<br><strong>Estado:</strong> " + simEstado.value +
      " | <strong>Situación:</strong> " + descSit;
  }

  [simTipo, simEstado, simSit].forEach(function (el) {
    if (el) el.addEventListener("change", renderSim);
  });
  renderSim();
})();
</script>
<!-- MANUAL_EQUIPOS_INTERACTIVO_END -->@endsection

<style id="fix-all-tables-dark">
  html.home-dark table.dataTable thead th,
  html.home-dark table thead th,
  body.dark-mode table.dataTable thead th,
  body.dark table.dataTable thead th,
  [data-bs-theme="dark"] table.dataTable thead th,
  [data-theme="dark"] table.dataTable thead th {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  html.home-dark .dataTables_wrapper .dataTables_length select,
  html.home-dark .dataTables_wrapper .dataTables_filter input,
  body.dark-mode .dataTables_wrapper .dataTables_length select,
  body.dark-mode .dataTables_wrapper .dataTables_filter input,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
</style>
<style id="manual-tema-verde-completo">
  /* Fondo general del manual en verde menta */
  body,
  main,
  .container,
  .container-fluid,
  .manual-wrapper,
  .manual-container {
    background-color: #dcfce7 !important;
    color: #052e16 !important;
  }

  /* Barra de búsqueda y botón Limpiar en verde */
  input[placeholder*="Buscar en el manual"],
  .manual-search input,
  .manual-buscador input,
  input.form-control[type="search"],
  input.form-control[type="text"] {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #34d399 !important;
  }

  input[placeholder*="Buscar en el manual"]::placeholder {
    color: #166534 !important;
    opacity: 1 !important;
  }

  /* Botones / píldoras de navegación rápida (1. Objetivo, 2.1 Registro, etc.) y botón Limpiar */
  main button:not(.btn-primary):not(.btn-danger),
  main .btn:not(.btn-primary):not(.btn-danger),
  main a.badge,
  main span.badge,
  .filtro-seccion,
  .nav-pill-manual,
  .btn-filtro-manual {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #22c55e !important;
  }

  main button:not(.btn-primary):not(.btn-danger):hover,
  main .btn:not(.btn-primary):not(.btn-danger):hover,
  .filtro-seccion:hover,
  .filtro-seccion.active,
  .nav-pill-manual.active {
    background-color: #059669 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border-color: #047857 !important;
  }

  /* Acordeones, tarjetas y secciones del manual (1. Objetivo del módulo, 2.1, 2.2...) */
  main .card,
  main .card-header,
  main .card-body,
  main .accordion,
  main .accordion-item,
  main .accordion-header,
  main .accordion-button,
  main .accordion-collapse,
  main .accordion-body,
  main .alert,
  main .callout,
  main .nota-importantes,
  main [class*="simulador"],
  main [class*="seccion"],
  main [class*="bloque"] {
    background-color: #d1fae5 !important;
    background: #d1fae5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  /* Encabezados de acordeones / secciones con un tono verde ligeramente más marcado para distinguirlos */
  main .accordion-button,
  main .accordion-button:not(.collapsed),
  main .card-header {
    background-color: #a7f3d0 !important;
    background: #a7f3d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  main .accordion-button::after {
    filter: none !important;
  }

  /* Textos, listas, strong y párrafos dentro de las secciones del manual */
  main .card-body *,
  main .accordion-body *,
  main .alert *,
  main [class*="simulador"] * {
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  /* Selects dentro del simulador rápido */
  main select,
  main .form-select {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #22c55e !important;
  }

  /* Tabla dentro del manual */
  main table thead th {
    background-color: #a7f3d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  main table tbody td {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #86efac !important;
  }

  /* Impresión en blanco limpio */
  @media print {
    html, body, main, .card, .card-body, .accordion-item, .accordion-button, .accordion-body, table, table td, table th, .btn {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      -webkit-text-fill-color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<script id="manual-tema-verde-js">
(function() {
  function pintarManualVerde() {
    document.querySelectorAll("main div, main section, main article, main button, main a, main input, main select").forEach(el => {
      if (el.closest("#sidebar") || el.closest("aside") || el.closest(".navbar")) return;
      const bg = getComputedStyle(el).backgroundColor;
      const m = bg && bg.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
      if (!m) return;
      const r = parseInt(m[1], 10), g = parseInt(m[2], 10), b = parseInt(m[3], 10);
      if (r + g + b < 130) {
        const esBoton = (el.tagName === "BUTTON" || el.classList.contains("btn"));
        const nuevoBg = esBoton ? "#bbf7d0" : "#d1fae5";
        el.style.setProperty("background-color", nuevoBg, "important");
        el.style.setProperty("background", nuevoBg, "important");
        el.style.setProperty("color", "#052e16", "important");
        el.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
        el.style.setProperty("border-color", "#34d399", "important");
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", pintarManualVerde);
  } else {
    pintarManualVerde();
  }
  setTimeout(pintarManualVerde, 150);
  setTimeout(pintarManualVerde, 500);
})();
</script>