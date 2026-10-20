@extends('layouts.app')

@section('template_title')
Usuario {{ $usuario->name }}
@endsection

@section('content')
<div class="container-fluid usuario-show-container">
    <div class="row">
        <div class="col-12">

            <div class="card usuario-show-card">

                {{-- ENCABEZADO --}}
                <div class="card-header usuario-show-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="usuario-show-titulo">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-badge-fill usuario-show-icono"></i>
                                <span>FICHA DEL USUARIO</span>
                            </div>

                            <small>
                                Información de la cuenta y trazabilidad de sus operaciones.
                            </small>
                        </div>

                        <div class="usuario-show-estado">
                            <span
                                class="usuario-estado-badge {{ $usuario->activo ? 'estado-activo' : 'estado-inactivo' }}">
                                <span class="usuario-estado-punto"></span>
                                {{ $usuario->activo ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="card-body usuario-show-body">

                    {{-- RESUMEN DE ACTIVIDAD --}}
                    <div class="row g-3 mb-4">

                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="usuario-metrica">
                                <div class="usuario-metrica-icono metrica-verde">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div>
                                    <div class="usuario-metrica-etiqueta">
                                        OPERACIONES REGISTRADAS
                                    </div>
                                    <div class="usuario-metrica-valor">
                                        {{ number_format($totalAuditorias) }}
                                    </div>
                                    <div class="usuario-metrica-detalle">
                                        Eventos asociados a esta cuenta
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="usuario-metrica">
                                <div class="usuario-metrica-icono metrica-azul">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <div class="usuario-metrica-etiqueta">
                                        ÚLTIMA ACTIVIDAD REGISTRADA
                                    </div>
                                    <div class="usuario-metrica-valor usuario-metrica-fecha">
                                        {{ $ultimaActividad
        ? $ultimaActividad->created_at->format('d/m/Y')
        : 'Sin actividad' }}
                                    </div>
                                    <div class="usuario-metrica-detalle">
                                        {{ $ultimaActividad
        ? $ultimaActividad->created_at->format('h:i:s A')
        : 'Todavía no existen eventos' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="usuario-metrica">
                                <div class="usuario-metrica-icono metrica-morado">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="usuario-metrica-etiqueta">
                                        FECHA DE REGISTRO
                                    </div>
                                    <div class="usuario-metrica-valor usuario-metrica-fecha">
                                        {{ $usuario->created_at
        ? $usuario->created_at->format('d/m/Y')
        : '—' }}
                                    </div>
                                    <div class="usuario-metrica-detalle">
                                        {{ $usuario->created_at
        ? $usuario->created_at->format('h:i:s A')
        : 'Fecha no disponible' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- INFORMACIÓN DE LA CUENTA --}}
                    <section class="usuario-seccion mb-4">

                        <div class="usuario-seccion-header">
                            <div class="usuario-seccion-icono">
                                <i class="bi bi-person-vcard"></i>
                            </div>

                            <div>
                                <h5>INFORMACIÓN DE LA CUENTA</h5>
                                <p>Datos de identificación y configuración del usuario.</p>
                            </div>
                        </div>

                        <div class="row g-3">

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-person me-1"></i>
                                        NOMBRE COMPLETO
                                    </div>
                                    <div class="usuario-dato-valor">
                                        {{ $usuario->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-envelope me-1"></i>
                                        CORREO ELECTRÓNICO
                                    </div>
                                    <div class="usuario-dato-valor usuario-texto-largo">
                                        {{ $usuario->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        ROL ASIGNADO
                                    </div>
                                    <div class="usuario-dato-valor">
                                        <span class="usuario-rol-badge {{ match ($usuario->rol) {
        \App\Models\User::ROL_ADMINISTRADOR => 'rol-admin',
        \App\Models\User::ROL_REGISTRADOR => 'rol-registrador',
        default => 'rol-consulta',
    } }}">
                                            {{ $usuario->etiquetaRol() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-person-check me-1"></i>
                                        ESTADO DE LA CUENTA
                                    </div>
                                    <div class="usuario-dato-valor">
                                        {{ $usuario->activo ? 'Cuenta habilitada' : 'Cuenta deshabilitada' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-key me-1"></i>
                                        CAMBIO DE CONTRASEÑA
                                    </div>
                                    <div class="usuario-dato-valor">
                                        {{ $usuario->debe_cambiar_password
        ? 'Pendiente al ingresar'
        : 'No requerido' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="usuario-dato">
                                    <div class="usuario-dato-etiqueta">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        ÚLTIMA ACTUALIZACIÓN DE LA CUENTA
                                    </div>
                                    <div class="usuario-dato-valor">
                                        {{ $usuario->updated_at
        ? $usuario->updated_at->format('d/m/Y h:i:s A')
        : '—' }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    {{-- HISTORIAL DE AUDITORÍA --}}
                    <section class="usuario-seccion usuario-auditoria-seccion">

                        <div class="usuario-seccion-header usuario-auditoria-header">
                            <div class="usuario-seccion-icono">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <h5>HISTORIAL DE AUDITORÍA</h5>
                                <p>
                                    Operaciones registradas que fueron realizadas por esta cuenta.
                                </p>
                            </div>

                            <span class="usuario-auditoria-contador">
                                {{ number_format($totalAuditorias) }} eventos
                            </span>
                        </div>

                        @if ($auditorias->count() > 0)

                        <div class="usuario-timeline">

                            @foreach ($auditorias as $auditoria)
                            @php
                            $estilosAccion = match ($auditoria->accion) {
                            'CREAR' => ['bi-plus-circle', 'accion-crear'],
                            'ACTUALIZAR' => ['bi-pencil-square', 'accion-actualizar'],
                            'ELIMINAR' => ['bi-trash3', 'accion-eliminar'],
                            'ACTIVAR' => ['bi-person-check', 'accion-activar'],
                            'DESACTIVAR' => ['bi-person-x', 'accion-desactivar'],
                            'RESTABLECER_PASSWORD' => ['bi-key', 'accion-seguridad'],
                            default => ['bi-activity', 'accion-general'],
                            };
                            @endphp

                            <article class="usuario-evento">

                                <div class="usuario-evento-marcador {{ $estilosAccion[1] }}">
                                    <i class="bi {{ $estilosAccion[0] }}"></i>
                                </div>

                                <div class="usuario-evento-contenido">

                                    <div class="usuario-evento-cabecera">
                                        <div class="usuario-evento-titulo">
                                            <span class="usuario-accion-badge {{ $estilosAccion[1] }}">
                                                {{ str_replace('_', ' ', $auditoria->accion) }}
                                            </span>

                                            <span class="usuario-modulo-badge">
                                                {{ $auditoria->modulo }}
                                            </span>
                                        </div>

                                        <div class="usuario-evento-fecha">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $auditoria->created_at->format('d/m/Y h:i:s A') }}
                                        </div>
                                    </div>

                                    <p class="usuario-evento-descripcion">
                                        {{ $auditoria->descripcion }}
                                    </p>

                                    <div class="usuario-evento-metadatos">

                                        <span>
                                            <i class="bi bi-person me-1"></i>
                                            Actor: {{ $auditoria->usuario_nombre }}
                                        </span>

                                        @if ($auditoria->registro_tipo)
                                        <span>
                                            <i class="bi bi-database me-1"></i>
                                            Registro: {{ $auditoria->registro_tipo }}
                                            @if ($auditoria->registro_id)
                                            #{{ $auditoria->registro_id }}
                                            @endif
                                        </span>
                                        @endif

                                        @if ($auditoria->ip)
                                        <span>
                                            <i class="bi bi-pc-display me-1"></i>
                                            IP: {{ $auditoria->ip }}
                                        </span>
                                        @endif

                                    </div>


                                    @if (is_array($auditoria->cambios) && count($auditoria->cambios))

                                    @php
                                    $nombresCampos = [
                                    'nuevo' => 'DATOS NUEVOS',
                                    'anterior' => 'DATOS ANTERIORES',
                                    'eliminado' => 'DATOS DEL REGISTRO ELIMINADO',
                                    'prestamo' => 'DATOS DEL PRÉSTAMO',
                                    'prestamos' => 'PRÉSTAMOS INCLUIDOS',
                                    'equipos' => 'EQUIPOS INCLUIDOS',
                                    'accesorios' => 'ACCESORIOS',
                                    'solicitante' => 'Solicitante',
                                    'cargo' => 'Cargo',
                                    'fecha' => 'Fecha',
                                    'hora_inicio' => 'Hora de inicio',
                                    'hora_fin' => 'Hora de finalización',
                                    'estado' => 'Estado',
                                    'id' => 'ID',
                                    'tipo' => 'Tipo',
                                    'tipo_equipo' => 'Tipo de equipo',
                                    'tipo_equipo_id' => 'Tipo de equipo',
                                    'codigo_inventario' => 'Código de inventario',
                                    'marca' => 'Marca',
                                    'modelo' => 'Modelo',
                                    'num_serie' => 'Número de serie',
                                    'observacion' => 'Observación',
                                    'docente_id' => 'Docente',
                                    'equipo_id' => 'Equipo',
                                    'accesorio_id' => 'Accesorio',
                                    'estado_anterior' => 'Estado anterior',
                                    'estado_nuevo' => 'Estado nuevo',
                                    'formato' => 'Formato de exportación',
                                    'cantidad' => 'Cantidad de registros',
                                    'archivo' => 'Archivo generado',
                                    'accion' => 'Acción',
                                    ];

                                    $mostrarValorAuditoria = function ($valor) {
                                    if ($valor === null || $valor === '') {
                                    return 'No especificado';
                                    }

                                    if (is_bool($valor)) {
                                    return $valor ? 'Sí' : 'No';
                                    }

                                    if (is_scalar($valor)) {
                                    return (string) $valor;
                                    }

                                    return 'Detalle disponible';
                                    };

                                    /*
                                    * Genera una presentación recursiva de los datos.
                                    * Permite mostrar préstamos, equipos y accesorios
                                    * sin convertir las estructuras completas en JSON.
                                    */
                                    $renderAuditoria = function ($datos, $nivel = 0) use (
                                    &$renderAuditoria,
                                    $nombresCampos,
                                    $mostrarValorAuditoria
                                    ) {
                                    if (!is_array($datos)) {
                                    return '<span class="valor-nuevo">'
                                        . e($mostrarValorAuditoria($datos))
                                        . '</span>';
                                    }

                                    if (empty($datos)) {
                                    return '<span class="text-muted">Sin datos disponibles.</span>';
                                    }

                                    $esLista = array_is_list($datos);



                                    if ($esLista) {
                                    $totalRegistros = count($datos);
                                    $idLista = 'auditoria-lista-' . uniqid();

                                    $html = '<div class="auditoria-lista-anidada"'
        . ' data-auditoria-lista="' . e($idLista) . '">';

                                        foreach ($datos as $indice => $elemento) {
                                        $oculto = $indice >= 5;

                                        $html .= '<div class="auditoria-registro-anidado'
            . ($oculto ? ' auditoria-registro-oculto' : '') . '"'
            . ' data-lista-registro="' . e($idLista) . '"'
            . ($oculto ? ' hidden' : '' ) . '>' ;

                                            if (is_array($elemento)) {
                                            $identificador=$elemento['id']
                                            ?? $elemento['codigo_inventario']
                                            ?? null;

                                            $html .='<div class="auditoria-registro-titulo">'
                                            . e($identificador !==null
                                            ? 'REGISTRO #' . $identificador
                                            : 'ELEMENTO ' . ($indice + 1))
                                            . '</div>' ;

                                            $html .=$renderAuditoria($elemento, $nivel + 1);
                                            } else {
                                            $html .='<span class="valor-nuevo">'
                                            . e($mostrarValorAuditoria($elemento))
                                            . '</span>' ;
                                            }

                                            $html .='</div>' ;
                                            }

                                            if ($totalRegistros> 5) {
                                            $html .= '<button type="button"'
            . ' class="btn btn-sm btn-outline-secondary mt-2 btn-auditoria-lista"'
            . ' data-target-lista="' . e($idLista) . '"'
            . ' data-total-ocultos="' . ($totalRegistros - 5) . '"'
            . ' aria-expanded="false">'
                                                . 'VER MÁS (' . ($totalRegistros - 5) . ')'
                                                . '</button>';
                                            }

                                            $html .= '</div>';

                                        return $html;
                                        }



                                        $html = '<div class="auditoria-datos-anidados">';

                                            foreach ($datos as $campo => $valor) {
                                            $nombreCampo = $nombresCampos[$campo]
                                            ?? ucfirst(str_replace('_', ' ', $campo));

                                            /*
                                            * Los bloques anterior, nuevo y eliminado
                                            * se presentan como secciones diferenciadas.
                                            */
                                            if (is_array($valor)) {
                                            $claseSeccion = match ($campo) {
                                            'anterior', 'eliminado' => 'auditoria-seccion-anterior',
                                            'nuevo' => 'auditoria-seccion-nuevo',
                                            default => 'auditoria-seccion-anidada',
                                            };

                                            $html .= '<div class="auditoria-bloque-anidado '
                        . $claseSeccion . '">';

                                                $html .= '<div class="auditoria-bloque-titulo">'
                                                    . e($nombreCampo)
                                                    . '</div>';

                                                $html .= $renderAuditoria($valor, $nivel + 1);
                                                $html .= '</div>';

                                            continue;
                                            }

                                            $html .= '<div class="usuario-cambio-fila">';

                                                $html .= '<div class="usuario-cambio-campo">'
                                                    . e($nombreCampo)
                                                    . '</div>';

                                                $html .= '<div class="usuario-cambio-valor">'
                                                    . '<span class="valor-nuevo">'
                                                        . e($mostrarValorAuditoria($valor))
                                                        . '</span>'
                                                    . '</div>';

                                                $html .= '</div>';
                                            }

                                            $html .= '</div>';

                                        return $html;
                                        };
                                        @endphp

                                        <details class="usuario-evento-detalles">
                                            <summary>
                                                <i class="bi bi-list-ul me-1"></i>

                                                @if ($auditoria->modulo === 'PRESTAMOS')
                                                Ver detalle del préstamo y sus operaciones
                                                @else
                                                Ver detalle de los cambios
                                                @endif
                                            </summary>

                                            <div class="usuario-cambios-tabla">

                                                @if ($auditoria->modulo === 'PRESTAMOS')

                                                @if (in_array($auditoria->accion, ['EXPORTAR_PDF', 'EXPORTAR_EXCEL']))
                                                @php
                                                $esMasiva = isset($auditoria->cambios['prestamos'])
                                                && is_array($auditoria->cambios['prestamos']);

                                                $esIndividual = isset($auditoria->cambios['prestamo'])
                                                && is_array($auditoria->cambios['prestamo']);
                                                @endphp

                                                <div class="auditoria-tipo-operacion">
                                                    <i class="bi bi-file-earmark-arrow-down"></i>

                                                    <div>
                                                        <strong>
                                                            {{ $esMasiva
                                    ? 'EXPORTACIÓN DE VARIOS PRÉSTAMOS'
                                    : ($esIndividual
                                        ? 'EXPORTACIÓN DE ACTA INDIVIDUAL'
                                        : 'EXPORTACIÓN DE ARCHIVO') }}
                                                        </strong>

                                                        <div>
                                                            Formato:
                                                            {{ strtoupper(
                                    $auditoria->cambios['formato']
                                    ?? str_replace('EXPORTAR_', '', $auditoria->accion)
                                ) }}
                                                        </div>

                                                        @if (isset($auditoria->cambios['cantidad']))
                                                        <div>
                                                            Cantidad de registros:
                                                            {{ $auditoria->cambios['cantidad'] }}
                                                        </div>
                                                        @endif

                                                        @if (isset($auditoria->cambios['archivo']))
                                                        <div class="text-break">
                                                            Archivo:
                                                            {{ $auditoria->cambios['archivo'] }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @elseif ($auditoria->accion === 'IMPRIMIR_FICHA')
                                                <div class="auditoria-tipo-operacion">
                                                    <i class="bi bi-printer"></i>

                                                    <div>
                                                        <strong>IMPRESIÓN DE FICHA DE PRÉSTAMO</strong>
                                                        <div>
                                                            Se registró la solicitud de impresión de la ficha.
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                {!! $renderAuditoria($auditoria->cambios) !!}

                                                @else

                                                {{-- Se conserva el tratamiento existente para Equipos y otros módulos. --}}
                                                @foreach ($auditoria->cambios as $campo => $valores)

                                                @php
                                                $nombresCamposEquipos = [
                                                'tipo_equipo_id' => 'Tipo de equipo',
                                                'marca' => 'Marca',
                                                'modelo' => 'Modelo',
                                                'num_serie' => 'Número de serie',
                                                'codigo_inventario' => 'Código de inventario',
                                                'estado' => 'Estado',
                                                'ubicacion_id' => 'Ubicación',
                                                'fecha_registro' => 'Fecha de registro',
                                                'observacion' => 'Observación',
                                                'equipo_id' => 'Equipo',
                                                'docente_id' => 'Docente',
                                                ];

                                                $esModificacion = is_array($valores)
                                                && array_key_exists('anterior', $valores)
                                                && array_key_exists('nuevo', $valores);
                                                @endphp

                                                @if ($campo === 'equipos' && is_array($valores))

                                                @php
                                                $idListaEquipos = 'auditoria-equipos-' . $auditoria->id;
                                                $totalEquiposLista = count($valores);
                                                @endphp

                                                <div class="usuario-cambios-equipos">
                                                    <div class="usuario-cambio-campo mb-2">
                                                        EQUIPOS INCLUIDOS ({{ $totalEquiposLista }})
                                                    </div>

                                                    @foreach ($valores as $indiceEquipo => $equipoExportado)
                                                    <div
                                                        class="usuario-cambio-fila {{ $indiceEquipo >= 10 ? 'auditoria-equipo-oculto' : '' }}"
                                                        data-lista-equipos="{{ $idListaEquipos }}"
                                                        @if ($indiceEquipo>= 10) hidden @endif>

                                                        <div class="usuario-cambio-campo">
                                                            {{ $equipoExportado['num_serie'] ?? 'SIN SERIE' }}
                                                        </div>

                                                        <div class="usuario-cambio-valor">
                                                            <span class="valor-nuevo">
                                                                {{ $equipoExportado['marca'] ?? 'SIN MARCA' }}
                                                                {{ $equipoExportado['modelo'] ?? '' }}
                                                            </span>

                                                            <span class="text-muted">
                                                                · Tipo:
                                                                {{ $equipoExportado['tipo_equipo'] ?? 'SIN TIPO' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                    @if ($totalEquiposLista > 10)
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-secondary mt-2 btn-auditoria-ver-mas"
                                                        data-target-lista="{{ $idListaEquipos }}"
                                                        aria-expanded="false">
                                                        VER MÁS ({{ $totalEquiposLista - 10 }})
                                                    </button>
                                                    @endif
                                                </div>

                                                @elseif ($esModificacion)

                                                <div class="usuario-cambio-fila">
                                                    <div class="usuario-cambio-campo">
                                                        {{ $nombresCamposEquipos[$campo] ?? ucfirst(str_replace('_', ' ', $campo)) }}
                                                    </div>

                                                    <div class="usuario-cambio-valor">
                                                        <span class="valor-anterior">
                                                            {{ $mostrarValorAuditoria($valores['anterior']) }}
                                                        </span>

                                                        <i class="bi bi-arrow-right"></i>

                                                        <span class="valor-nuevo">
                                                            {{ $mostrarValorAuditoria($valores['nuevo']) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @elseif ($campo === 'eliminado' && is_array($valores))

                                                @foreach ($valores as $campoEliminado => $valorEliminado)
                                                <div class="usuario-cambio-fila">
                                                    <div class="usuario-cambio-campo">
                                                        {{ $nombresCamposEquipos[$campoEliminado] ?? ucfirst(str_replace('_', ' ', $campoEliminado)) }}
                                                    </div>

                                                    <div class="usuario-cambio-valor">
                                                        <span class="valor-anterior">
                                                            {{ $mostrarValorAuditoria($valorEliminado) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @endforeach

                                                @else

                                                <div class="usuario-cambio-fila">
                                                    <div class="usuario-cambio-campo">
                                                        {{ $nombresCamposEquipos[$campo] ?? ucfirst(str_replace('_', ' ', $campo)) }}
                                                    </div>

                                                    <div class="usuario-cambio-valor">
                                                        <span class="valor-nuevo">
                                                            @if (is_array($valores))
                                                            {{ json_encode($valores, JSON_UNESCAPED_UNICODE) }}
                                                            @else
                                                            {{ $mostrarValorAuditoria($valores) }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                @endif
                                                @endforeach

                                                @endif
                                            </div>
                                        </details>

                                        @endif


                                    </div>
                            </article>
                            @endforeach

                        </div>

                        <div class="usuario-paginacion">
                            <div class="usuario-paginacion-info">
                                Mostrando {{ $auditorias->firstItem() }}
                                a {{ $auditorias->lastItem() }}
                                de {{ $auditorias->total() }} eventos
                            </div>

                            {{ $auditorias->links() }}
                        </div>

                        @else

                        <div class="usuario-auditoria-vacia">
                            <div class="usuario-vacio-icono">
                                <i class="bi bi-clipboard2-data"></i>
                            </div>

                            <h6>No hay actividad registrada</h6>

                            <p>
                                Todavía no existen operaciones de auditoría asociadas a esta cuenta.
                                Los eventos aparecerán aquí a medida que el sistema los registre.
                            </p>
                        </div>

                        @endif

                    </section>

                    {{-- ACCIONES INFERIORES --}}
                    <div class="usuario-show-footer">

                        <div class="usuario-footer-texto">
                            <strong>Administración de la cuenta</strong>
                            <span>Consulta los datos o vuelve al listado de usuarios.</span>
                        </div>

                        <div class="usuario-footer-botones">
                            <a href="{{ route('usuarios.index') }}"
                                class="btn btn-outline-secondary usuario-btn-footer">
                                <i class="fa-solid fa-arrow-left me-1"></i>
                                VOLVER
                            </a>

                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                class="btn btn-success usuario-btn-footer">
                                <i class="fa-solid fa-pen-to-square me-1"></i>
                                EDITAR USUARIO
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<script>
    document.addEventListener('click', function(event) {
        const boton = event.target.closest('.btn-auditoria-ver-mas');

        if (!boton) {
            return;
        }

        const idLista = boton.dataset.targetLista;

        const elementos = document.querySelectorAll(
            '[data-lista-equipos="' + idLista + '"]'
        );

        const mostrarTodos = boton.getAttribute('aria-expanded') !== 'true';

        elementos.forEach(function(elemento) {
            if (elemento.classList.contains('auditoria-equipo-oculto')) {
                elemento.hidden = !mostrarTodos;
            }
        });

        boton.setAttribute('aria-expanded', String(mostrarTodos));

        if (mostrarTodos) {
            boton.textContent = 'VER MENOS';
        } else {
            const totalOcultos = Array.from(elementos).filter(function(elemento) {
                return elemento.classList.contains('auditoria-equipo-oculto');
            }).length;

            boton.textContent = 'VER MÁS (' + totalOcultos + ')';
        }
    });


    document.addEventListener('click', function(event) {
        const boton = event.target.closest('.btn-auditoria-lista');

        if (!boton) {
            return;
        }

        const idLista = boton.dataset.targetLista;

        const elementos = document.querySelectorAll(
            '[data-lista-registro="' + idLista + '"]'
        );

        const mostrarTodos = boton.getAttribute('aria-expanded') !== 'true';

        elementos.forEach(function(elemento, indice) {
            if (elemento.classList.contains('auditoria-registro-oculto')) {
                elemento.hidden = !mostrarTodos;
            }
        });

        boton.setAttribute('aria-expanded', String(mostrarTodos));

        if (mostrarTodos) {
            boton.textContent = 'VER MENOS';
        } else {
            boton.textContent =
                'VER MÁS (' + boton.dataset.totalOcultos + ')';
        }
    });
</script>


@endsection

<style>
    /* =========================================
       TARJETA PRINCIPAL
    ========================================= */

    .usuario-show-container {
        padding-bottom: 20px;
    }

    .usuario-show-card {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .usuario-show-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 16px 20px;
    }

    .usuario-show-titulo>div {
        gap: 10px !important;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .2px;
    }

    .usuario-show-titulo small {
        display: block;
        margin-top: 5px;
        margin-left: 2px;
        color: #6c757d;
        font-size: .84rem;
        font-weight: 400;
        letter-spacing: 0;
    }

    .usuario-show-icono {
        color: #198754;
        font-size: 1.3rem;
    }

    .usuario-show-body {
        padding: 20px;
    }

    /* =========================================
       ESTADO Y ROLES
    ========================================= */

    .usuario-estado-badge,
    .usuario-rol-badge {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 5px;
        font-size: .74rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .usuario-estado-punto {
        width: 7px;
        height: 7px;
        background: currentColor;
        border-radius: 50%;
    }

    .estado-activo {
        color: #146c43;
        background: #d1e7dd;
    }

    .estado-inactivo {
        color: #b02a37;
        background: #f8d7da;
    }

    .rol-admin {
        color: #ffffff;
        background: #343a40;
    }

    .rol-registrador {
        color: #ffffff;
        background: #0d6efd;
    }

    .rol-consulta {
        color: #ffffff;
        background: #6c757d;
    }

    /* =========================================
       TARJETAS DE RESUMEN
    ========================================= */

    .usuario-metrica {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        height: 100%;
        min-height: 112px;
        padding: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
    }

    .usuario-metrica-icono {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        border-radius: 9px;
        font-size: 1.2rem;
    }

    .metrica-verde {
        background: #e2f3e8;
        color: #198754;
    }

    .metrica-azul {
        background: #e2edff;
        color: #0d6efd;
    }

    .metrica-morado {
        background: #eee7ff;
        color: #6941c6;
    }

    .usuario-metrica-etiqueta {
        color: #64748b;
        font-size: .71rem;
        font-weight: 700;
        letter-spacing: .25px;
    }

    .usuario-metrica-valor {
        margin-top: 3px;
        color: #1e293b;
        font-size: 1.4rem;
        font-weight: 700;
        line-height: 1.35;
    }

    .usuario-metrica-fecha {
        font-size: 1.05rem;
    }

    .usuario-metrica-detalle {
        margin-top: 3px;
        color: #64748b;
        font-size: .77rem;
    }

    /* =========================================
       SECCIONES Y DATOS
    ========================================= */

    .usuario-seccion {
        padding: 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }

    .usuario-seccion-header {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 18px;
    }

    .usuario-seccion-icono {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        background: #e9f7e9;
        color: #198754;
        border-radius: 8px;
        font-size: 1.1rem;
    }

    .usuario-seccion-header h5 {
        margin: 0;
        color: #245c38;
        font-size: .92rem;
        font-weight: 700;
    }

    .usuario-seccion-header p {
        margin: 3px 0 0;
        color: #6c757d;
        font-size: .81rem;
    }

    .usuario-dato {
        height: 100%;
        min-height: 88px;
        padding: 13px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .usuario-dato-etiqueta {
        margin-bottom: 7px;
        color: #64748b;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .2px;
    }

    .usuario-dato-valor {
        color: #1e293b;
        font-size: .91rem;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    /* =========================================
       HISTORIAL Y CRONOLOGÍA
    ========================================= */

    .usuario-auditoria-seccion {
        padding-bottom: 8px;
    }

    .usuario-auditoria-header {
        flex-wrap: wrap;
    }

    .usuario-auditoria-contador {
        margin-left: auto;
        padding: 6px 10px;
        border: 1px solid #c8e6c9;
        border-radius: 6px;
        background: #e9f7e9;
        color: #146c43;
        font-size: .76rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .usuario-timeline {
        position: relative;
        padding-left: 8px;
    }

    .usuario-evento {
        position: relative;
        display: flex;
        gap: 14px;
        padding-bottom: 22px;
    }

    .usuario-evento:not(:last-child)::before {
        position: absolute;
        top: 35px;
        bottom: -1px;
        left: 16px;
        width: 2px;
        background: #e2e8f0;
        content: "";
    }

    .usuario-evento-marcador {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 50%;
        font-size: .92rem;
    }

    .usuario-evento-contenido {
        min-width: 0;
        flex: 1;
        padding: 14px 15px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
    }

    .usuario-evento-cabecera {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 9px;
    }

    .usuario-evento-titulo {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .usuario-accion-badge,
    .usuario-modulo-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 5px;
        font-size: .71rem;
        font-weight: 700;
        letter-spacing: .15px;
    }

    .usuario-modulo-badge {
        background: #eef2f7;
        color: #475569;
    }

    .accion-crear,
    .accion-activar {
        background: #d1e7dd;
        color: #146c43;
    }

    .accion-actualizar {
        background: #cfe2ff;
        color: #084298;
    }

    .accion-eliminar,
    .accion-desactivar {
        background: #f8d7da;
        color: #b02a37;
    }

    .accion-seguridad {
        background: #fff3cd;
        color: #856404;
    }

    .accion-general {
        background: #e2e3e5;
        color: #41464b;
    }

    .usuario-evento-fecha {
        color: #64748b;
        font-size: .77rem;
        white-space: nowrap;
    }

    .usuario-evento-descripcion {
        margin: 0 0 12px;
        color: #334155;
        font-size: .89rem;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .usuario-evento-metadatos {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        padding-top: 10px;
        border-top: 1px solid #edf0f4;
        color: #64748b;
        font-size: .76rem;
    }

    .usuario-evento-metadatos span {
        overflow-wrap: anywhere;
    }

    .usuario-evento-detalles {
        margin-top: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
    }

    .usuario-evento-detalles summary {
        color: #334155;
        cursor: pointer;
        font-size: .81rem;
        font-weight: 600;
    }

    .usuario-cambios-tabla {
        margin-top: 12px;
    }

    .usuario-cambio-fila {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 9px 0;
        border-bottom: 1px solid #e2e8f0;
        font-size: .81rem;
    }

    .usuario-cambio-fila:last-child {
        border-bottom: 0;
    }

    .usuario-cambio-campo {
        min-width: 120px;
        color: #475569;
        font-weight: 700;
        text-transform: capitalize;
    }

    .usuario-cambio-valor {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        color: #64748b;
    }

    .valor-anterior {
        color: #b02a37;
    }

    .valor-nuevo {
        color: #146c43;
        font-weight: 600;
    }

    /* =========================================
       SIN ACTIVIDAD
    ========================================= */

    .usuario-auditoria-vacia {
        padding: 38px 20px;
        text-align: center;
    }

    .usuario-vacio-icono {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        margin-bottom: 12px;
        background: #f1f5f9;
        border-radius: 50%;
        color: #64748b;
        font-size: 1.6rem;
    }

    .usuario-auditoria-vacia h6 {
        color: #334155;
        font-size: .95rem;
        font-weight: 700;
    }

    .usuario-auditoria-vacia p {
        max-width: 480px;
        margin: 6px auto 0;
        color: #64748b;
        font-size: .84rem;
        line-height: 1.6;
    }

    /* =========================================
       PAGINACIÓN
    ========================================= */

    .usuario-paginacion {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 15px 0 8px;
        border-top: 1px solid #e9ecef;
    }

    .usuario-paginacion-info {
        color: #64748b;
        font-size: .81rem;
    }

    .usuario-paginacion nav p {
        margin-bottom: 0;
    }

    .usuario-paginacion nav svg {
        width: 18px;
        height: 18px;
    }

    /* =========================================
       ACCIONES INFERIORES
    ========================================= */

    .usuario-show-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 20px;
        padding-top: 17px;
        border-top: 1px solid #e9ecef;
    }

    .usuario-footer-texto strong {
        display: block;
        color: #334155;
        font-size: .9rem;
    }

    .usuario-footer-texto span {
        display: block;
        margin-top: 3px;
        color: #6c757d;
        font-size: .82rem;
    }

    .usuario-footer-botones {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .usuario-btn-footer {
        padding: 9px 13px;
        border-radius: 6px;
        font-size: .82rem;
        font-weight: 600;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 768px) {
        .usuario-show-header {
            padding: 14px;
        }

        .usuario-show-body {
            padding: 12px;
        }

        .usuario-seccion {
            padding: 13px;
        }

        .usuario-evento {
            gap: 9px;
        }

        .usuario-evento-contenido {
            padding: 11px;
        }

        .usuario-evento-cabecera {
            flex-direction: column;
        }

        .usuario-evento-fecha {
            white-space: normal;
        }

        .usuario-paginacion {
            flex-direction: column;
            align-items: flex-start;
        }

        .usuario-show-footer {
            align-items: stretch;
        }

        .usuario-footer-botones {
            width: 100%;
        }

        .usuario-btn-footer {
            flex: 1;
        }
    }

    /* =========================================
       TEMA OSCURO
    ========================================= */

    [data-bs-theme="dark"] .usuario-show-card,
    [data-bs-theme="dark"] .usuario-seccion,
    [data-bs-theme="dark"] .usuario-metrica,
    [data-bs-theme="dark"] .usuario-evento-contenido {
        background: #1e293b;
        border-color: #334155;
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-show-header {
        background: #1b382d;
        border-color: #315442;
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-show-titulo small,
    [data-bs-theme="dark"] .usuario-seccion-header p,
    [data-bs-theme="dark"] .usuario-metrica-etiqueta,
    [data-bs-theme="dark"] .usuario-metrica-detalle,
    [data-bs-theme="dark"] .usuario-evento-fecha,
    [data-bs-theme="dark"] .usuario-evento-metadatos,
    [data-bs-theme="dark"] .usuario-paginacion-info {
        color: #b0becb;
    }

    [data-bs-theme="dark"] .usuario-seccion-header h5,
    [data-bs-theme="dark"] .usuario-metrica-valor,
    [data-bs-theme="dark"] .usuario-dato-valor,
    [data-bs-theme="dark"] .usuario-evento-descripcion,
    [data-bs-theme="dark"] .usuario-footer-texto strong {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-dato,
    [data-bs-theme="dark"] .usuario-evento-detalles {
        background: #273449;
        border-color: #3b4a60;
    }

    [data-bs-theme="dark"] .usuario-dato-etiqueta,
    [data-bs-theme="dark"] .usuario-evento-detalles summary,
    [data-bs-theme="dark"] .usuario-cambio-campo {
        color: #cbd5e1;
    }

    [data-bs-theme="dark"] .usuario-modulo-badge {
        background: #334155;
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-evento:not(:last-child)::before,
    [data-bs-theme="dark"] .usuario-evento-metadatos,
    [data-bs-theme="dark"] .usuario-cambio-fila,
    [data-bs-theme="dark"] .usuario-show-footer,
    [data-bs-theme="dark"] .usuario-paginacion {
        border-color: #334155;
    }

    [data-bs-theme="dark"] .usuario-vacio-icono {
        background: #273449;
        color: #cbd5e1;
    }

    [data-bs-theme="dark"] .usuario-auditoria-vacia h6 {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-auditoria-vacia p,
    [data-bs-theme="dark"] .usuario-footer-texto span {
        color: #b0becb;
    }

    /* =========================================
   AUDITORÍA DETALLADA DE PRÉSTAMOS
========================================= */

    .auditoria-tipo-operacion {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        padding: 13px;
        background: #e9f7e9;
        border: 1px solid #c8e6c9;
        border-radius: 8px;
        color: #245c38;
        font-size: .82rem;
        overflow-wrap: anywhere;
    }

    .auditoria-tipo-operacion>i {
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .auditoria-tipo-operacion strong {
        display: block;
        margin-bottom: 4px;
        font-size: .79rem;
    }

    .auditoria-tipo-operacion div div {
        margin-top: 3px;
    }

    .auditoria-lista-anidada {
        display: grid;
        gap: 10px;
        margin-top: 8px;
    }

    .auditoria-registro-anidado {
        min-width: 0;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }

    .auditoria-registro-titulo {
        margin-bottom: 8px;
        color: #245c38;
        font-size: .76rem;
        font-weight: 800;
        letter-spacing: .25px;
    }

    .auditoria-datos-anidados {
        display: grid;
        gap: 3px;
    }

    .auditoria-bloque-anidado {
        margin: 8px 0;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 7px;
    }

    .auditoria-bloque-titulo {
        margin-bottom: 7px;
        color: #475569;
        font-size: .75rem;
        font-weight: 800;
        letter-spacing: .2px;
    }

    .auditoria-seccion-anterior {
        background: #fff5f5;
        border-color: #f1c6ca;
    }

    .auditoria-seccion-nuevo {
        background: #f0faf4;
        border-color: #c8e6c9;
    }

    .auditoria-seccion-anidada {
        background: #f8fafc;
    }

    [data-bs-theme="dark"] .auditoria-tipo-operacion {
        background: #1b382d;
        border-color: #315442;
        color: #d8f3df;
    }

    [data-bs-theme="dark"] .auditoria-registro-anidado,
    [data-bs-theme="dark"] .auditoria-seccion-anidada {
        background: #1e293b;
        border-color: #475569;
    }

    [data-bs-theme="dark"] .auditoria-registro-titulo,
    [data-bs-theme="dark"] .auditoria-bloque-titulo {
        color: #d8e5f2;
    }

    [data-bs-theme="dark"] .auditoria-seccion-anterior {
        background: #3b252c;
        border-color: #75404a;
    }

    [data-bs-theme="dark"] .auditoria-seccion-nuevo {
        background: #1b382d;
        border-color: #315442;
    }

    @media (max-width: 768px) {
        .auditoria-registro-anidado {
            padding: 9px;
        }

        .auditoria-bloque-anidado {
            padding: 8px;
        }
    }

    .auditoria-registro-oculto[hidden] {
        display: none !important;
    }

    .btn-auditoria-lista {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .2px;
    }
</style>