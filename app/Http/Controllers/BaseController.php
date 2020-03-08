<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $classe;
 
    public function index(Request $request)
    {
        /*
        $offset = ($request->page * 1) * $request->per_page;
        return $this->classe::query()
                ->offset($offset)
                ->limit($request->per_page)
                ->get();*/

        return $this->classe::paginate($request->per_page);
    }

    public function store(Request $request)
    {
        return response()->json($this->classe::create($request->all()), 201);
    }

    public function show(int $id)
    {
        $entidade = $this->classe::find($id);
        if (is_null($entidade)) {
            return response()->json("", 204);
        }
        return response()->json($entidade, 200);
    }

    public function update(int $id, Request $request)
    {
        $entidade = $this->classe::find($id);
        if (is_null($entidade)) {
            return response()->json([
                "mensagem" => "Recurso não encontrado"
            ], 404);
        }
        $entidade->fill($request->all());
        $entidade->save();
        return response()->json($entidade);
    }

    public function destroy(int $id)
    {
        $quantidadeRecursosRemovidos = $this->classe::destroy($id);
        if ($quantidadeRecursosRemovidos === 0) {
            return response()->json([
                "mensagem" => "Recurso não encontrado"
         ], 404);
        }
        return response()->json("", 204);
    }
}  