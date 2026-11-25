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
    background: #ffffff;
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
    background-color: #ffffff;
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
    background-color: #ffffff;
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
    background-color: #ffffff;
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
    background-color: #ffffff;
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
    background-color: #ffffff;
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
</script>
@endsection

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