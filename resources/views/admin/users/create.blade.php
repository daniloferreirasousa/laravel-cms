@extends('adminlte::page')

@section('title', 'Criar Usuário')

@section('content')
<h1>
    Criar Usuário
</h1>

<div class="card">
    <div class="card-body">
        <form action="{{route('users.store')}}" method="POST" class="form-horizontal">
            @csrf
        
        
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5>
                        <i class="icon fas fa-ban"></i> Atenção!
                    </h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            
        
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nome Completo</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror">
                </div>
             </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label">Senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                </div>
             </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label">Confirmação de senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
             </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
             </div>
        </form>
    </div>
</div>

@endsection