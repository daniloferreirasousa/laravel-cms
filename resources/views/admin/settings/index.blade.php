@extends("adminlte::page")

@section('title', 'Configurações')

@section('content')
    <h1>Configurações</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{route('panel.settings.save')}}" method="POST" class="form-horizontal">
                @method('PUT')
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
                
                @if (session('warning'))
                    <div class="alert alert-success">    
                        <h5>
                            <i class="icon fas fa-check"></i> Sucesso!
                        </h5>
                        {{session('warning')}}
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Título do site</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{$settings['title']}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Subtitulo do site</label>
                    <div class="col-sm-10">
                        <input type="text" name="subtitle" value="{{$settings['subtitle']}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">E-mail para contato</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{$settings['email']}}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cor de fundo</label>
                    <div class="col-sm-10">
                        <input type="color" name="bgcolor" value="{{$settings['bgcolor']}}" class="form-control" style="width:70px;">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cor da fonte</label>
                    <div class="col-sm-10">
                        <input type="color" name="fontcolor" value="{{$settings['fontcolor']}}" class="form-control" style="width:70px;">
                    </div>
                </div>
       
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Salvar" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection