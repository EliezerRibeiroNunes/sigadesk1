@extends('layouts.slidebar')
@section('content')
    <main>


        <style>

            td {
                max-width: 10ch;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;

            }

        </style>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Chamados</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total</div>
                        <a href="?"
                            id="flip"class="card-footer d-flex align-items-center justify-content-between text-light text-decoration-none">
                            <h4>{{ $order->count() }}</h4>
                            <div class="small )text-white"><i class="fas fa-angle-right"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Prioridade Baixa</div>
                        <div
                            class="card-footer d-flex align-items-center justify-content-between text-light text-decoration-none">
                            <h4>{{ $lowPriority->count() }}</h4>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Prioridade Média</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h4>{{ $middlePriority->count() }}</h4>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Prioridade Alta</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h4>{{ $highPriority->count() }}</h4>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="breadcrumb mb-4">


                {{-- tabela --}}
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabela de chamados
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            data-bs-whatever="@getbootstrap">Criar Chamado</button>
                    </div>

                    <table id="datatablesSimple">

                        <thead>
                            <tr>
                                <th>Titulo </th>
                                {{-- <th>Descrição</th> --}}
                                <th>Prioridade</th>
                                <th>Categoria</th>
                                <th>Data e Hora</th>
                                {{-- <th>#</th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $priority = [
                                    1 => 'Baixa',
                                    2 => 'Media',
                                    3 => 'Alta',
                                ];
                            @endphp


                            @foreach ($order as $item)
                                <tr>

                                    <td>{{ $item->title }}</td>

                                    {{-- <td>{{ $item->description }}</td> --}}

                                    <td>{{ $priority[$item->priority] }}</td>

                                    <td>{{ $item->category }} </td>

                                    <td>{{ $item->created_at }}</td>

                                    <td><a class=" btn" href="{{ route('orders.edit', [$item->id]) }}"> <i
                                                class="fa-solid fa-pen-to-square"></i></a></td>

                                    <td><a target="_blank" class=" btn btn-info"
                                            href="{{ route('orders.show', [$item->id]) }}"><i
                                                class="fa-solid fa-arrow-up-right-from-square"></i></a></td>

                                </tr>
                            @endforeach


                        <tfoot>
                            <tr>
                                <th>Titulo</th>
                                {{-- <th>Descrição</th> --}}
                                <th>Prioridade</th>
                                <th>Categoria</th>
                                <th>Data e Hora</th>


                            </tr>
                        </tfoot>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('create.store') }}" name="makeorder" role="ajax">
                        {{-- <input type="hidden" name="_token"  value="{! csrf_token() !!}"> --}}
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" name="title" class="form-control" id="title">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea type="text" class="form-control" name="description" id="description" cols="30" rows=""></textarea>
                        </div>

                        <div class="mb-3">
                            <div for="order_category_id" class="input-group mb-3 mt-4">
                                <label class="input-group-text">Categoria</label>
                                <select id="order_category_id" name="order_category_id" class="form-select">
                                    <option selected>Escolha...</option>
                                    @foreach ($category as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class=" mb-2 mt-3">Prioridade</label>

                            <div class="d-grid gap-2 col-6 mx-auto" role="group"2
                                aria-label="Basic radio toggle button group">

                                <input type="radio" class="btn-check" id="priority1" name="priority" value="1"
                                    checked>
                                <label class="btn btn-outline-success" for="priority1">Baixa</label>

                                <input type="radio" class="btn-check" id="priority2" name="priority" value="2">
                                <label class="btn btn-outline-warning" for="priority2">Media</label>

                                <input type="radio" class="btn-check" id="priority3" name="priority" value="3">
                                <label class="btn btn-outline-danger" for="priority3">Alta</label>
                            </div>


                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection
