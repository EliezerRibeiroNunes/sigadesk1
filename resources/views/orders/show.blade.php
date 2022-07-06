@extends('layouts.slidebar')

@section('content')

<div class="row justify-content-center">
    <div class="col-8">
        <div class="card mt-5">
            <div class="card-header bg-dark text-light fw-bold">Informações</div>
            <div class="card-body">

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <div class="mb-3">
                <h5><label for="title" class="form-label">Titulo</label></h5>

                    <p>{{ $order->title }}"</p>
                </div>
                <div class="mb-3">
                    <h5><label for="description" class="form-label">Descrição</label></h5>
                    <p>{{ $order->description }}</p>
                </div>


                <div class="mb-3">
                <h5><label for="description" class="form-label">Prioridade</label></h5>
                    <p>{{ $order->priority }}</p>

                </div>

                <div class="mb-3">
                <h5><label for="description" class="form-label">Categoria</label></h5>
                    <p>{{ $order->order_category_id }}</p>

                </div>

                <div class="mb-3">
                <h5><label for="description" class="form-label">Data e Hora</label></h5>
                    <p>{{ $order->created_at }}</p>

                </div>


            </div>
        </div>
    </div>
</div>
</div>
@endsection
