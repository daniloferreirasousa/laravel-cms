@extends('adminlte::page')

@section('title', 'Usuários')

@section('content')
<h1>
    Meus Usuários
</h1>

<div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="card-title p-3" style="align-self:center;"> 
            Páginas criadas: <b>{{$total_users}}</b>
        </h3>
        <ul class="nav nav-pills ml-auto p-3 ">
            <li class="nav-item">
                <a class="btn btn-success" href="{{route('users.create')}}">Novo Usuário</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width='50'>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th width='150'>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <a href="{{route('users.edit', ['user' => $user->id])}}" class="btn btn-sm btn-info">Editar</a>
                            @if($loggedId !== intval($user->id))
                            <form method="POST" class="d-inline" action="{{route('users.destroy', ['user' => $user->id])}}" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                            @endif
                        </td>
                    </tr>    
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
{{ $users->links() }}
@endsection