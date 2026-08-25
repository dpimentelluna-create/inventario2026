<?php

namespace App\Http\Controllers;

use App\Models\TiposEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TiposEquipoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TiposEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tiposEquipos = TiposEquipo::paginate();

        return view('tipos-equipo.index', compact('tiposEquipos'))
            ->with('i', ($request->input('page', 1) - 1) * $tiposEquipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tiposEquipo = new TiposEquipo();

        return view('tipos-equipo.create', compact('tiposEquipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TiposEquipoRequest $request): RedirectResponse
    {
        TiposEquipo::create($request->validated());

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'TiposEquipo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tiposEquipo = TiposEquipo::find($id);

        return view('tipos-equipo.show', compact('tiposEquipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tiposEquipo = TiposEquipo::find($id);

        return view('tipos-equipo.edit', compact('tiposEquipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TiposEquipoRequest $request, TiposEquipo $tiposEquipo): RedirectResponse
    {
        $tiposEquipo->update($request->validated());

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'TiposEquipo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TiposEquipo::find($id)->delete();

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'TiposEquipo deleted successfully');
    }
}
