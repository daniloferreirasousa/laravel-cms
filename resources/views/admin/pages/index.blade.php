@extends('adminlte::page')

@section('title', 'Páginas')

@section('content')
<h1>
    Minhas páginas
</h1>

<div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3" style="align-self:center;"> 
            Páginas criadas: <b>{{$total_pages}}</b>
        </h3>
        <ul class="nav nav-pills ml-auto p-3 ">
            <li class="nav-item">
                <a class="btn btn-success" href="{{route('pages.create')}}">Nova Página</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Título</th>
                    <th width="200">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{$page->id}}</td>
                        <td>{{$page->title}}</td>
                        <td>
                            <a href="" target="_blank" class="btn btn-sm btn-success">Ver</a>
                            <a href="{{route('pages.edit', ['page' => $page->id])}}" class="btn btn-sm btn-info">Editar</a>
                            <form method="POST" class="d-inline" action="{{route('pages.destroy', ['page' => $page->id])}}" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>    
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
{{ $pages->links() }}
@endsection