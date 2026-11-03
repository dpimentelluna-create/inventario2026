@extends('layouts.app')

@section('template_title')
    Actualizar Accesorio
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Actualizar Accesorios Equipo</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('accesorios-equipo.update', $accesoriosEquipo->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('accesorios-equipo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('aviso-cambios')