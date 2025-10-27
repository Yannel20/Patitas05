<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Publicacion;
use App\Models\CampanaEsterilizacion;
use App\Models\BusquedaGuardada;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $filtros = $request->input('filtros', []); // array o null
        $resultados = collect();

        // Si no hay filtros -> búsqueda global cuando hay $query; si tampoco hay $query, mostrar todos usuarios.
        if (empty($filtros)) {
            if ($query !== '') {
                // Buscar en usuarios
                $usuarios = User::where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%")
                      ->orWhere('tipo_usuario', 'LIKE', "%{$query}%");
                })->get();

                // Buscar en publicaciones
                $publicaciones = Publicacion::where(function ($q) use ($query) {
                    $q->where('titulo', 'LIKE', "%{$query}%")
                      ->orWhere('descripcion', 'LIKE', "%{$query}%");
                })->with('user')->get();

                // Buscar en campañas
                $campanas = CampanaEsterilizacion::where(function ($q) use ($query) {
                    $q->where('descripcion', 'LIKE', "%{$query}%")
                      ->orWhere('criterios', 'LIKE', "%{$query}%");
                })->with('user')->get();

                $resultados = $usuarios->merge($publicaciones)->merge($campanas);
            } else {
                // Sin filtros y sin query -> mostrar todos los usuarios (puedes cambiar esto)
                $resultados = User::all();
            }
        } else {
            // Hay filtros -> procesarlos uno por uno y agregar resultados
            // 1) Usuarios (marca "usuario" significa TODOS los usuarios; si hay query, filtrar por query)
            if (in_array('usuario', $filtros)) {
                if ($query !== '') {
                    $usuarios = User::where(function ($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('email', 'LIKE', "%{$query}%");
                    })->get();
                } else {
                    $usuarios = User::all();
                }
                $resultados = $resultados->merge($usuarios);
            }

            // 2) Refugios (tipo_usuario = 'refugio')
            if (in_array('refugio', $filtros)) {
                if ($query !== '') {
                    $refugios = User::where('tipo_usuario', 'refugio')
                        ->where(function ($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })->get();
                } else {
                    $refugios = User::where('tipo_usuario', 'refugio')->get();
                }
                $resultados = $resultados->merge($refugios);
            }

            // 3) Veterinarias (tipo_usuario = 'veterinaria')
            if (in_array('veterinaria', $filtros)) {
                if ($query !== '') {
                    $veterinarias = User::where('tipo_usuario', 'veterinaria')
                        ->where(function ($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })->get();
                } else {
                    $veterinarias = User::where('tipo_usuario', 'veterinaria')->get();
                }
                $resultados = $resultados->merge($veterinarias);
            }

            // 4) Publicaciones
            if (in_array('publicacion', $filtros)) {
                if ($query !== '') {
                    $publicaciones = Publicacion::where(function ($q) use ($query) {
                        $q->where('titulo', 'LIKE', "%{$query}%")
                          ->orWhere('descripcion', 'LIKE', "%{$query}%");
                    })->with('user')->get();
                } else {
                    $publicaciones = Publicacion::with('user')->get();
                }
                $resultados = $resultados->merge($publicaciones);
            }

            // 5) Campañas
            if (in_array('campana', $filtros)) {
                if ($query !== '') {
                    $campanas = CampanaEsterilizacion::where(function ($q) use ($query) {
                        $q->where('descripcion', 'LIKE', "%{$query}%")
                          ->orWhere('criterios', 'LIKE', "%{$query}%");
                    })->with('user')->get();
                } else {
                    $campanas = CampanaEsterilizacion::with('user')->get();
                }
                $resultados = $resultados->merge($campanas);
            }
        }

        // Cargar búsquedas guardadas del usuario
        $busquedasGuardadas = Auth::check()
            ? BusquedaGuardada::where('user_id', Auth::id())->latest()->get()
            : collect();

        // Eliminar duplicados entre diferentes colecciones (comparando clase + id)
        $resultados = $resultados->unique(function ($item) {
            // si no tiene id (caso extraño), usar hash del objeto
            $id = $item->id ?? spl_object_hash($item);
            return get_class($item) . ':' . $id;
        })->values();

        return view('busqueda.index', compact('resultados', 'query', 'filtros', 'busquedasGuardadas'));
    }

    /**
     * Guardar búsqueda.
     */
    public function guardar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'q' => 'nullable|string|max:255',
            'filtros' => 'nullable|array',
        ]);

        BusquedaGuardada::create([
            'user_id' => Auth::id(),
            'termino' => $request->input('q'),
            'filtros' => json_encode($request->input('filtros', [])),
        ]);

        return redirect()->back()->with('success', 'Búsqueda guardada correctamente ✅');
    }

    /**
     * Mostrar búsquedas guardadas.
     */
    public function misBusquedas()
    {
        if (!Auth::check()) return redirect()->route('login');

        $busquedas = BusquedaGuardada::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('busqueda.guardadas', compact('busquedas'));
    }

    /**
     * Eliminar una búsqueda guardada.
     */
    public function eliminar($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $busqueda = BusquedaGuardada::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $busqueda->delete();

        return back()->with('success', 'Búsqueda eliminada correctamente 🗑️');
    }
}
