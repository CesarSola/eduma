<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\DocumentosNec;
use App\Models\Estandares;
use App\Models\User;

class CursosController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::all();
        $documentosnec = DocumentosNec::all();
        $estandares = Estandares::all();
        $userId = $request->query('user_id');
        $usuario = $userId ? User::findOrFail($userId) : auth()->user();

        if ($request->is('cursosExpediente*')) {
            return view('expedientes.expedientesAdmin.cursos.index', compact('usuario', 'cursos', 'documentosnec'));
        } else {
            return view('lista_cursos.index', compact('usuario', 'cursos', 'estandares', 'documentosnec'));
        }
    }

    public function create()
    {
        $documentosnec = DocumentosNec::all();
        $estandares = Estandares::all();
        return view('lista_cursos.create', compact('documentosnec', 'estandares'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'id_estandar' => 'required',
            'instructor' => 'nullable|string',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'costo' => 'nullable|string',
            'certification' => 'nullable|string',
            'documentosnec_id' => 'array', // Validar que es un array
            'documentosnec_id.*' => 'exists:documentosnec,id', // Validar que cada ID existe en la tabla documentosnec
        ]);

        $curso = Curso::create([
            'name' => $request->name,
            'description' => $request->description,
            'id_estandar' => $request->id_estandar,
            'instructor' => $request->instructor,
            'duration' => $request->duration,
            'modalidad' => $request->modalidad,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_final' => $request->fecha_final,
            'costo' => $request->costo,
            'certification' => $request->certification,
        ]);

        if ($request->has('documentosnec_id')) {
            $curso->documentosnec()->attach($request->documentosnec_id);
        }

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }


    public function show(string $id)
    {
        $curso = Curso::findOrFail($id);
        $documentosnec = DocumentosNec::all();
        return view('lista_cursos.show', compact('curso', 'documentosnec'));
    }

    public function edit(string $id)
    {
        $curso = Curso::findOrFail($id);
        $documentosnec = DocumentosNec::all();
        $estandares = Estandares::all();
        return view('lista_cursos.edit', compact('curso', 'documentosnec', 'estandares'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'id_estandar' => 'required|exists:estandares,id',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'costo' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
            'documentosnec_id' => 'required|array',
            'documentosnec_id.*' => 'exists:documentosnec,id',
        ]);

        $curso = Curso::findOrFail($id);
        $curso->update($request->only([
            'name', 'description', 'id_estandar', 'instructor', 'duration', 'modalidad',
            'fecha_inicio', 'fecha_final', 'costo', 'certification'
        ]));

        $curso->documentosnec()->sync($request->input('documentosnec_id'));

        return back()->with('success', 'Curso actualizado exitosamente');
    }

    public function destroy(string $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return back()->with('success', 'Curso eliminado exitosamente');
    }

    public function storeDocumento(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DocumentosNec::create([
            'name' => $request->input('name'),
        ]);

        return back()->with('success', 'Documento creado exitosamente');
    }
}
