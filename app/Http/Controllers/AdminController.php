<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener datos con nombres de variables únicos
        $data = [
            'lista_juegos' => Juego::orderBy('nombre')->get(['id', 'nombre']),
            'lista_materias' => Materia::orderBy('nombre')->get(['id', 'nombre']),
            'lista_proyectos' => Proyecto::orderBy('nombre')->get(['id', 'nombre']),
            'usuarios' => User::with(['juegos', 'materias', 'proyectos'])->get()
        ];

        return view('admin.index', $data);
    }

    public function updateUserPermissions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->juegos_permissions = json_encode($request->input('juegos_permissions', []));
        $user->materias_permissions = json_encode($request->input('materias_permissions', []));
        $user->proyectos_permissions = json_encode($request->input('proyectos_permissions', []));

        $user->save();

        return redirect()->back()->with('success', 'Permisos actualizados correctamente.');
    }

    public function showAdminRegisterForm()
    {
        return view('admin.register');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|string|in:user,admin',
            'security_question_1' => 'required|string|max:255',
            'security_answer_1' => 'required|string|max:255',
            'security_question_2' => 'required|string|max:255',
            'security_answer_2' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'security_question_1' => $request->security_question_1,
            'security_answer_1' => $request->security_answer_1,
            'security_question_2' => $request->security_question_2,
            'security_answer_2' => $request->security_answer_2,
        ]);

        return redirect()->route('admin.index')->with('success', 'User registered successfully.');
    }

    public function deleteUser($userId)
    {
        $usuario = User::find($userId);

        if (!$usuario) {
            return redirect()->route('admin.index')->with('error', 'Usuario no encontrado');
        }

        // Verificar si el usuario es admin
        if ($usuario->role === 'admin') {
            return redirect()->route('admin.index')->with('error', 'No se puede eliminar a un administrador');
        }

        $usuario->delete();
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente');
    }
    public function createJuego()
    {
        return view('admin.juegos.create');
    }

    public function storeJuego(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id', // Validar que el usuario exista
        ]);

        // Crear el nuevo juego y asociar el usuario
        Juego::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->usuario_id, // Aquí se asigna el usuario
        ]);

        // Redirigir a la lista de juegos
        return redirect()->route('admin.index')->with('success', 'Juego creado con éxito');
    }


    public function createMateria()
    {
        $usuarios = User::all(); // Obtener usuarios para asignar a una materia
        return view('admin.materias.create', compact('usuarios'));
    }

    public function storeMateria(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id', // Validar que el usuario exista
        ]);

        // Crear la nueva materia y asociar el usuario
        Materia::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->usuario_id, // Aquí se asigna el usuario
        ]);

        // Redirigir a la lista de materias
        return redirect()->route('admin.index')->with('success', 'Materia creada con éxito');
    }
    public function createProyecto()
    {
        $usuarios = User::all(); // Obtener usuarios para asignar a una materia
        return view('admin.proyectos.create', compact('usuarios'));
    }

    public function storeProyecto(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id',
        ]);

        Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->usuario_id,
        ]);

        // Redirigir a la lista de materias
        return redirect()->route('admin.index')->with('success', 'Proyecto creada con éxito');
    }
      // ==================== JUEGOS ====================
      public function editJuego($id)
      {
          $juego = Juego::findOrFail($id);
          $usuarios = User::all();
          return view('admin.juegos.edit', compact('juego', 'usuarios'));
      }

      public function updateJuego(Request $request, $id)
      {
          $request->validate([
              'nombre' => 'required|string|max:255',
              'descripcion' => 'required|string',
              'usuario_id' => 'required|exists:users,id',
          ]);

          $juego = Juego::findOrFail($id);
          $juego->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'user_id' => $request->usuario_id,
          ]);

          return redirect()->route('admin.index')->with('success', 'Juego actualizado con éxito');
      }

      public function destroyJuego($id)
      {
          $juego = Juego::findOrFail($id);
          $juego->delete();
          return redirect()->route('admin.index')->with('success', 'Juego eliminado con éxito');
      }

      // ==================== MATERIAS ====================
      public function editMateria($id)
      {
          $materia = Materia::findOrFail($id);
          $usuarios = User::all();
          return view('admin.materias.edit', compact('materia', 'usuarios'));
      }

      public function updateMateria(Request $request, $id)
      {
          $request->validate([
              'nombre' => 'required|string|max:255',
              'descripcion' => 'required|string',
              'usuario_id' => 'required|exists:users,id',
          ]);

          $materia = Materia::findOrFail($id);
          $materia->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'user_id' => $request->usuario_id,
          ]);

          return redirect()->route('admin.index')->with('success', 'Materia actualizada con éxito');
      }

      public function destroyMateria($id)
      {
          $materia = Materia::findOrFail($id);
          $materia->delete();
          return redirect()->route('admin.index')->with('success', 'Materia eliminada con éxito');
      }

      // ==================== PROYECTOS ====================
      public function editProyecto($id)
      {
          $proyecto = Proyecto::findOrFail($id);
          $usuarios = User::all();
          return view('admin.proyectos.edit', compact('proyecto', 'usuarios'));
      }

      public function updateProyecto(Request $request, $id)
      {
          $request->validate([
              'nombre' => 'required|string|max:255',
              'descripcion' => 'required|string',
              'usuario_id' => 'required|exists:users,id',
          ]);

          $proyecto = Proyecto::findOrFail($id);
          $proyecto->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'user_id' => $request->usuario_id,
          ]);

          return redirect()->view('admin.index')->with('success', 'Proyecto actualizado con éxito');
      }

      public function destroyProyecto($id)
      {
          $proyecto = Proyecto::findOrFail($id);
          $proyecto->delete();
          return redirect()->route('admin.index')->with('success', 'Proyecto eliminado con éxito');
      }

      // ==================== VISTAS INDIVIDUALES ====================
      public function showJuego($id)
      {
          $juego = Juego::with('user')->findOrFail($id);
          return view('admin.juegos.show', compact('juego'));
      }

      public function showMateria($id)
      {
          $materia = Materia::with('user')->findOrFail($id);
          return view('admin.materias.show', compact('materia'));
      }

      public function showProyecto($id)
      {
          $proyecto = Proyecto::with('user')->findOrFail($id);
          return view('admin.proyectos.show', compact('proyecto'));
      }
}
