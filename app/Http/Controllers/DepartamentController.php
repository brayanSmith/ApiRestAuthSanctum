<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Se tomaran todos los dptos y se ponen en formato Json
        $departaments = Departament::all();
        return response()->json($departaments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //en esta funcion se creara una regla en la que si no marcha bien nos mandara el error 400
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        // en caso de que todo salga bien se guardara
        $departament = new Departament($request->input());
        $departament->save();
        return response()->json([
            'status' => true,
            'errors' => 'Departament crafted succefully'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        //Aqui me retornara todos los departamentos en formato Json
        return response()->json(['status' => true,'data' => $departament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        //
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        // en caso de que todo salga bien se Actualizara
        $departament->update($request->input());
        return response()->json([
            'status' => true,
            'errors' => 'Departament Updated succefully'
        ],200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        //
        $departament->delete();
        return response()->json([
            'status' => true,
            'errors' => 'Departament Deleted succefully'
        ],200);
    }
}
