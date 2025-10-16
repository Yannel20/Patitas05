<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Dueno;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    // Mostrar listado de mascotas
    public function index()
    {
        $mascotas = Mascota::all();
        return view('mascotas.index', compact('mascotas'));
    }

    // Formulario para crear nueva mascota
    public function create()
    {
        $mascota = null; // no hay mascota para crear
        $duenos = Dueno::all();
        return view('mascotas.create', compact('mascota', 'duenos'));
    }

    // Guardar mascota en BD
    public function store(Request $request)
    {
        $request->validate([
            'ID_dueno'  => 'nullable|exists:duenos,ID_dueno',
            'nombre_m'  => 'required|string|max:255',
            'especie'   => 'required|string|max:50',
            'raza'      => 'required|string|max:50',
            'sexo'      => 'required|string|max:10',
            'edad'      => 'required|integer|min:0',
        ]);

        Mascota::create([
            'ID_dueno'   => $request->ID_dueno,
            'n_registro' => uniqid(),
            'nombre_m'   => $request->nombre_m,
            'especie'    => $request->especie,
            'raza'       => $request->raza,
            'sexo'       => $request->sexo,
            'edad'       => $request->edad
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota registrada correctamente');
    }

    // Formulario para editar mascota
    public function edit(Mascota $mascota)
    {
        $duenos = Dueno::all();
        return view('mascotas.create', compact('mascota', 'duenos')); // reutilizamos la vista create
    }

    // Actualizar datos de mascota
    public function update(Request $request, Mascota $mascota)
    {
        $request->validate([
            'ID_dueno'  => 'nullable|exists:duenos,ID_dueno',
            'nombre_m'  => 'required|string|max:255',
            'especie'   => 'required|string|max:50',
            'raza'      => 'nullable|string|max:50',
            'sexo'      => 'required|string|max:1',
            'edad'      => 'required|integer|min:0',
        ]);

        $mascota->update([
            'ID_dueno' => $request->ID_dueno,
            'nombre_m' => $request->nombre_m,
            'especie'  => $request->especie,
            'raza'     => $request->raza,
            'sexo'     => $request->sexo,
            'edad'     => $request->edad
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada correctamente');
    }

    // Eliminar mascota
    public function destroy(Mascota $mascota)
    {
        $mascota->delete();
        return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada correctamente');
    }
}
