@extends('adminlte::page')

@section('title', 'Criar Página')

@section('content')
<h1>
    Criar Página
</h1>

<div class="card">
    <div class="card-body">
        <form action="{{route('pages.store')}}" method="POST" class="form-horizontal">
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
                <label class="col-sm-2 col-form-label">Título</label>
                <div class="col-sm-10">
                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Corpo da página</label>
                <div class="col-sm-10">
                    <textarea name="body" class="form-control bodyfield">{{old('body')}}</textarea>
                </div>
             </div>
             <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <input type="submit" value="Criar" class="btn btn-success">
                </div>
             </div>
        </form>
    </div>
</div>


<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector:'textarea.bodyfield',
        height:300,
        menubar:false,
        plugins:['link', 'table', 'image', 'autoresize', 'lists', 'code'],
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image code | bullist numlist',
        content_css:[
            '{{asset('assets/css/content.css')}}'
        ],
        image_upload_url:'{{route('imageupload')}}',
        image_upload_credentials:true,
        convert_urls:false
    });
</script>

@endsection