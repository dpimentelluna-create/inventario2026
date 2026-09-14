<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DocenteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $docentes = Docente::orderBy('apellidos')->get();

        return view('docente.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $docente = new Docente();

        return view('docente.create', compact('docente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocenteRequest $request): RedirectResponse
    {
        Docente::create($request->validated());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente registrado.')
            ->with('toast_tipo', 'exito');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $docente = Docente::find($id);

        return view('docente.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $docente = Docente::find($id);

        return view('docente.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocenteRequest $request, Docente $docente): RedirectResponse
    {
        $docente->update($request->validated());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado.')
            ->with('toast_tipo', 'aviso');
    }

    public function destroy($id): RedirectResponse
    {
        Docente::find($id)->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado.')
            ->with('toast_tipo', 'error');
    }
}
