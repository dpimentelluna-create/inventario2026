<?php

namespace App\Http\Controllers;

use App\Models\Ubicacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UbicacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UbicacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ubicaciones = Ubicacione::paginate();

        return view('ubicacione.index', compact('ubicaciones'))
            ->with('i', ($request->input('page', 1) - 1) * $ubicaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ubicacione = new Ubicacione();

        return view('ubicacione.create', compact('ubicacione'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UbicacioneRequest $request): RedirectResponse
    {
        Ubicacione::create($request->validated());

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicacione created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $ubicacione = Ubicacione::find($id);

        return view('ubicacione.show', compact('ubicacione'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ubicacione = Ubicacione::find($id);

        return view('ubicacione.edit', compact('ubicacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UbicacioneRequest $request, Ubicacione $ubicacione): RedirectResponse
    {
        $ubicacione->update($request->validated());

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicacione updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Ubicacione::find($id)->delete();

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicacione deleted successfully');
    }
}
