<?php

namespace App\Http\Controllers;

use App\Models\CampanaEsterilizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaActividadNotification;

class CampanaEsterilizacionController extends Controller
{
    // Listar todas las campañas
    public function index()
    {
        $campanas = CampanaEsterilizacion::all();
        return view('campanas.index', compact('campanas'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $campana = null;
        return view('campanas.create', compact('campana'));
    }

    // Guardar nueva campaña
    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'descripcion'  => 'nullable|string',
            'criterios'    => 'nullable|string',
        ]);

        $campana = CampanaEsterilizacion::create([
            'user_id'      => Auth::id(),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'descripcion'  => $request->descripcion,
            'criterios'    => $request->criterios,
        ]);

        // 🔔 Notificar a todos los seguidores del usuario que creó la campaña
        $seguidores = Auth::user()->seguidores; // asegúrate de tener la relación 'seguidores'
        foreach ($seguidores as $seguidor) {
            $seguidor->notify(
                new NuevaActividadNotification(
                    'campana',
                    Auth::user()->name.' publicó una campaña de esterilización.',
                    Auth::user()
                )
            );
        }

        return redirect()->route('campanas.index')->with('success', 'Campaña creada correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $campana = CampanaEsterilizacion::findOrFail($id);
        return view('campanas.create', compact('campana'));
    }

    // Actualizar campaña
    public function update(Request $request, $id)
    {
        $campana = CampanaEsterilizacion::findOrFail($id);

        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'descripcion'  => 'nullable|string',
            'criterios'    => 'nullable|string',
        ]);

        $campana->update([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'descripcion'  => $request->descripcion,
            'criterios'    => $request->criterios,
        ]);

        return redirect()->route('campanas.index')->with('success', 'Campaña actualizada correctamente.');
    }

    // Eliminar campaña
    public function destroy($id)
    {
        $campana = CampanaEsterilizacion::findOrFail($id);
        $campana->delete();

        return redirect()->route('campanas.index')->with('success', 'Campaña eliminada correctamente.');
    }

    // Mostrar campañas tipo publicación
    public function publicacion()
    {
        $campanas = CampanaEsterilizacion::latest()->get();
        return view('campanas.publicacion', compact('campanas'));
    }

    // Mostrar detalles de una campaña
    public function show($id)
    {
        $campana = CampanaEsterilizacion::with('solicitudes')->findOrFail($id);
        return view('campanas.show', compact('campana'));
    }
}
