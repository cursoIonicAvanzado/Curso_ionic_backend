<?php

namespace App\Http\Controllers;

use App\Places;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Places::all();
        $jsonResponse = response()->json($places);
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
        $place = new Places();
        $place->nombre = $request['nombre'];
        $place->latitud = $request['latitud'];
        $place->longitud = $request['longitud'];

        try {
            $place->save();

            $jsonResponse = response()->json([
                'ok_message' => 'Place creado correctamente'
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
        $place = Places::find($id);
        $jsonResponse = response()->json($place);
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
        $place = Places::find($id);

        if (!$place) {
            $jsonResponse = response()->json([
                'error_message' => 'Usuario con id ' . $id . ' no existe'
            ]);

            $jsonResponse->setStatusCode(400);

            return $jsonResponse;
        }

        if ($request['nombre']) {
            $place->nombre = $request['nombre'];
        }

        if ($request['nombre']) {
            $place->latitud = $request['latitud'];
        }

        if ($request['nombre']) {
            $place->longitud = $request['longitud'];
        }

        try {
            $place->save();

            $jsonResponse = response()->json([
                'ok_message' => 'Place actualizado correctamente'
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
        $place = Places::find($id);

        if (!$place) {
            $jsonResponse = response()->json([
                'error_message' => 'Usuario con id ' . $id . ' no existe'
            ]);

            $jsonResponse->setStatusCode(400);

            return $jsonResponse;
        }

        try {
            $place->delete();

            $jsonResponse = response()->json([
                'ok_message' => 'Place eliminado correctamente'
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
}
