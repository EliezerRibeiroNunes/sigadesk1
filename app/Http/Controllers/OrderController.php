<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::addSelect(['category' => Category::select('name')->whereColumn('orders.order_category_id', 'id')->limit(1)])->get();
        $lowPriority = Order::where('priority', 1)->get();
        $middlePriority = Order::where('priority', 2)->get();
        $highPriority = Order::where('priority', 3)->get();
        $category = Category::where('status', 1)->get();


        return view('orders.index', [
            'order' => $order,
            'lowPriority' => $lowPriority,
            'middlePriority' => $middlePriority,
            'highPriority' => $highPriority,
            'category' => $category
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.index');


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
                $order = Order::create ([
                'title' => $request->title,
                'description' => $request->description,
                'order_category_id' => $request->order_category_id,
                'priority' => $request->priority,
                'status' => 1
                ]);
            }catch(Exception $e){
                $errors[] ='Erro ao criar um novo chamado';
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
                'message' => 'Chamado criado com sucesso!',
                'redirect' => route('orders.index', [$order->id]),


            ];

        }


        return response()->json($return);
        //return redirect()->route('orders.show',[$order->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $category = Category::where('status', 1)->get();

        return view('orders.edit', [

            'order' => $order,
            'category' => $category

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $errors = [];

        $vall = $this->vall($request);

        if (!empty($vall)) {
            $errors = Arr::collapse([$errors, $vall]);
        }

        if (empty($errors)) {
            try {
                Order::find($order->id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'order_category_id' => $request->order_category_id,
                    'priority' => $request->priority,
                    'status' => 1
                ]);
            } catch (Exception $e) {
                $errors[] = 'Erro ao editar chamado';
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
                'message' => 'Chamado alterado com exito!',
                'redirect' => route('orders.index', [$order->id])
            ];
        }

        return response()->json($return);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $errors = [];

        try {
            Order::find($order->id)->delete();
        } catch (Exception $e) {
            $errors[] = 'Erro ao remover produto no banco de dados';
        }

        if (!empty($errors)) {
            $return = [
                'status' => false,
                'errors' => $errors
            ];
        } else {
            $return = [
                'status' => true,
                'message' => 'Produto excluído com sucesso!',
                'redirect' => route('orders.index')
            ];
        }

        return response()->json($return);
    }


    //Criando função de validação

    private function vall($request){


        //Configurando regras de incerção de dados
        $dataRules = [
            'title'=> 'required|min:3',
            'description' =>'required',
            'order_category_id' => 'required',
            'priority'=> 'required'
        ];

        //Configurando tratamento de erros dos dados
        $errorMsg = [
            'title.required' => 'Insira o titulo do seu problema!',
            'title.min' => 'O titulo é muito curto!',
            'description.required' => 'Descreva o seu problema!',
            'order_category_id.required' => 'Categoria não selecionada!',
            'priority.required' => 'Prioridade não selecionada!'
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
