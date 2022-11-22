@extends("adminlte::page")

@section('title', 'Bancos de Dados')

@section('content')
    <h1>Bancos de Dados</h1>
    
    <div class="card">
        <div class="row my-4 mx-3">
            <div class="col-md-3">
                Fazer baackup do banco de dados
            </div>
            <div class="col-md-9">
                <a href="{{route('panel.database.backup')}}" class="btn btn-md btn-info">Backup</a>
            </div>
        </div>
    </div>
@endsection