@section('content')
    @extends('layouts.slidebar')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div class="row justify-content">

        <div class="card-header text-dark fw-bold mt-4 rounded">Categorias</div>
        <div class="card-body">

            @foreach ($category as $data)
                <ol class="list-group rounded-top mb-2 " data-name="{{ $data->name }}"
                    data-route-edit="{{ route('categories.update', [$data->id]) }}"
                    data-route-destroy="{{ route('categories.destroy', [$data->id]) }}">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div value="{{ $data->id }}" class="fw-bold">{{ $data->id }}. {{ $data->name }}</div>
                        </div>
                        <button class=" btn btn-dark rounded btn-edit-category">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </li>
                </ol>
            @endforeach
        </div>

    </div>
    </div>

    {{-- modal edita categoria --}}
    <div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST" role="ajax">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">


                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input value="" type="text" name="name" class="form-control" id="name">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class=" w-100 btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>
                                Editar</button>
                        </div>
                    </form>
                    <hr>
                    <button type="button" class=" w-100 btn btn-danger btn-remove" route="" role="ajax"
                        csrf="{!! csrf_token() !!}"><i class="fa-solid fa-trash"></i>
                        Excluir</button>


                </div>
            </div>
        </div>
    </div>
@endsection
