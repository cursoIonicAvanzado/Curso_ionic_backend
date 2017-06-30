<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();
        $jsonResponse = response()->json($usuarios);
        $jsonResponse->setStatusCode(200);

        return $jsonResponse;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jsonResponse = response()->json([
            'error_message' => 'Ruta inexistente'
        ]);

        $jsonResponse->setStatusCode(400);

        return $jsonResponse;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request['nombre'];
        $usuario->ap_paterno = $request['ap_paterno'];
        $usuario->ap_materno = $request['ap_materno'];
        $usuario->edad = $request['edad'];
        $usuario->estado = $request['estado'];
        $usuario->municipio = $request['municipio'];
        $usuario->telefono = $request['telefono'];
        $usuario->email = $request['email'];
        $usuario->password = sha1($request['password']);

        try {
            $usuario->save();

            $jsonResponse = response()->json([
                'ok_message' => 'Usuario creado correctamente'
            ]);

            $jsonResponse->setStatusCode(200);
        } catch (\Exception $e) {
            $jsonResponse = response()->json([
                'error_message' => $e->getMessage()
            ]);

            $jsonResponse->setStatusCode(400);
        }

        return $jsonResponse;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);
        $jsonResponse = response()->json($usuario);
        $jsonResponse->setStatusCode(200);

        return $jsonResponse;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jsonResponse = response()->json([
            'error_message' => 'Ruta inexistente'
        ]);

        $jsonResponse->setStatusCode(400);

        return $jsonResponse;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            $jsonResponse = response()->json([
                'error_message' => 'Usuario con id ' . $id . ' no existe'
            ]);

            $jsonResponse->setStatusCode(400);

            return $jsonResponse;
        }

        if ($request['nombre']) {
            $usuario->nombre = $request['nombre'];
        }

        if ($request['ap_paterno']) {
            $usuario->ap_paterno = $request['ap_paterno'];
        }

        if ($request['ap_materno']) {
            $usuario->ap_materno = $request['ap_materno'];
        }

        if ($request['telefono']) {
            $usuario->telefono = $request['telefono'];
        }

        if ($request['email']) {
            $usuario->email = $request['email'];
        }

        if ($request['password']) {
            $usuario->password = sha1($request['password']);
        }

        if ($request['edad']) {
            $usuario->edad = $request['edad'];
        }

        if ($request['estado']) {
            $usuario->estado = $request['estado'];
        }

        if ($request['municipio']) {
            $usuario->municipio = $request['municipio'];
        }

        try {
            $usuario->save();

            $jsonResponse = response()->json([
                'ok_message' => 'Usuario actualizado correctamente'
            ]);

            $jsonResponse->setStatusCode(200);
        } catch (\Exception $e) {
            $jsonResponse = response()->json([
                'error_message' => $e->getMessage()
            ]);

            $jsonResponse->setStatusCode(400);
        }

        return $jsonResponse;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            $jsonResponse = response()->json([
                'error_message' => 'Usuario con id ' . $id . ' no existe'
            ]);

            $jsonResponse->setStatusCode(400);

            return $jsonResponse;
        }

        try {
            $usuario->delete();

            $jsonResponse = response()->json([
                'ok_message' => 'Usuario eliminado correctamente'
            ]);

            $jsonResponse->setStatusCode(200);
        } catch (\Exception $e) {
            $jsonResponse = response()->json([
                'error_message' => $e->getMessage()
            ]);

            $jsonResponse->setStatusCode(400);
        }

        return $jsonResponse;
    }

    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (!$email || !$password) {
            $jsonResponse = response()->json([
                'error_message' => 'Parámetros incompletos [email, password]'
            ]);

            $jsonResponse->setStatusCode(400);
        } else {
            $usuario = DB::table('usuario')
                ->where('email', '=', $email)
                ->where('password', '=', sha1($password))
                ->first();

            $jsonResponse = response()->json([
                'ok' => $usuario != null
            ]);

            $jsonResponse->setStatusCode(200);
        }

        return $jsonResponse;
    }
}
