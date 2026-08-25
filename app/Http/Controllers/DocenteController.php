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
        $docentes = Docente::paginate();

        return view('docente.index', compact('docentes'))
            ->with('i', ($request->input('page', 1) - 1) * $docentes->perPage());
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

        return Redirect::route('docentes.index')
            ->with('success', 'Docente created successfully.');
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

        return Redirect::route('docentes.index')
            ->with('success', 'Docente updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Docente::find($id)->delete();

        return Redirect::route('docentes.index')
            ->with('success', 'Docente deleted successfully');
    }
}
