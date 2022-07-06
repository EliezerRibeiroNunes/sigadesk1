<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return view('categories.index', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors=[];

        $vall = $this->vall($request);

        //Validando as informações ou apresentando mensagens de erro

        if (!empty($vall)) {
            $errors = Arr::collapse([$errors, $vall]);
        }

        if(empty($errors)){

            try{
                $category = Category::create ([
                    'name' => $request->name,
                    'status'=> 1
                    ]);

            }catch(Exception $e){
                $errors[] ='Erro ao criar uma nova categoria ';
            }
        }
        if(!empty($errors)){
            $return =[
                'status' => false,
                'errors' => $errors
            ];
        }else{
            $return =[
                'status' => true,
                'message' => 'Categoria criada com sucesso!',
                'redirect' => route('orders.index', [$category->id]),


            ];

        }


        return response()->json($return);
        //return redirect()->route('orders.show',[$order->id]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $errors = [];

        $vall = $this->vall($request);

        if (!empty($vall)) {
            $errors = Arr::collapse([$errors, $vall]);
        }

        if (empty($errors)) {
            try {
                Category::find($category->id)->update([
                    'name' => $request->name,
                    'status' => 1
                ]);
            } catch (Exception $e) {
                $errors[] = 'Erro ao editar categoria'.$e -> getMessage();
            }
        }

        if (!empty($errors)) {
            $return = [
                'status' => false,
                'errors' => $errors
            ];
        } else {
            $return = [
                'status' => true,
                'message' => 'Categoria alterada!',
                'redirect' => route('categories.index')
            ];
        }

        return response()->json($return);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $errors = [];

        try {
            Category::find($category->id)->delete();
        } catch (Exception $e) {
            $errors[] = 'Erro ao remover categoria';
        }

        if (!empty($errors)) {
            $return = [
                'status' => false,
                'errors' => $errors
            ];
        } else {
            $return = [
                'status' => true,
                'message' => 'Categoria removida!',
                'redirect' => route('categories.index')
            ];
        }

        return response()->json($return);
    }

    private function vall($request){


        //Configurando regras de incerção de dados
        $dataRules = [
            'name'=> 'required|min:3',
        ];

        //Configurando tratamento de erros dos dados
        $errorMsg = [
            'name.required' => 'Insira o nome da categoria!',
            'name.min' => 'O nome é muito curto!',

        ];

        $validator = Validator::make($request->all(), $dataRules, $errorMsg);



        if($validator -> fails()){
            return $validator->errors()->all();
        }else{
            return[];
        }
        // Arr: classe que contem utilitarios para Arrays da linguagem PHP

    }
}
