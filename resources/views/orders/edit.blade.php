@extends('layouts.slidebar')

@section('content')

        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card mt-5">
                    <div class="card-header bg-dark text-light fw-bold">Editar Chamado</div>
                    <div class="card-body">
                        <form action="{{ route('orders.update', [$order->id]) }}" method="POST" role="ajax">
                            {{ method_field('PUT') }}
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $order->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea name="description" id="description" class="form-control" rows="5">{{ $order->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <div for="order_category_id" class="input-group mb-3 mt-4">
                                    <label class="input-group-text">Categoria</label>
                                    <select id="order_category_id" name="order_category_id" class="form-select">
                                        <option>Escolha...</option>

                                        @foreach ( $category as $data )

                                        <option value="{{$data->id}}" {{$order->order_category_id == $data->id ? 'selected' : ''}}>{{$data->name}}</option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class=" mb-2 mt-3">Prioridade</label>

                                <div class="d-grid gap-2 col-6 mx-auto" role="group"2
                                    aria-label="Basic radio toggle button group">

                                    <input {{$order->priority == 1 ? 'checked' : ''}} type="radio" class="btn-check" id="priority1" name="priority" value="1">
                                    <label class="btn btn-outline-success" for="priority1">Baixa</label>

                                    <input {{$order->priority == 2 ? 'checked' : ''}} type="radio" class="btn-check" id="priority2" name="priority" value="2">
                                    <label class="btn btn-outline-warning" for="priority2">Media</label>

                                    <input {{$order->priority == 3 ? 'checked' : ''}} type="radio" class="btn-check" id="priority3" name="priority" value="3">
                                    <label class="btn btn-outline-danger" for="priority3">Alta</label>
                                </div>


                            </div>


                            <button type="submit" class=" w-100 btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>
                                Editar</button>
                        </form>
                        <hr>
                        <button type="button" class=" w-100 btn btn-danger btn-remove"
                            route="{{ route('orders.destroy', [$order->id]) }}" role="ajax"
                            csrf="{!! csrf_token() !!}"><i class="fa-solid fa-trash"></i>
                            Excluir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
