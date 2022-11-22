@extends("adminlte::page")

@section('plugins.Chartjs', true)

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class='container-fluid'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <form method="GET">
                    <select onchange="this.form.submit()" name="interval" class="float-md-right">
                        <option {{$data['interval']==30?'selected="selected"':''}} value="30">Ultimos 30 dias</option>
                        <option {{$data['interval']==60?'selected="selected"':''}} value="60">Últimos 2 meses</option>
                        <option {{$data['interval']==90?'selected="selected"':''}} value="90">Últimos 3 meses</option>
                        <option {{$data['interval']==120?'selected="selected"':''}} value="120">Últimos 4 meses</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$data['visitsCount']}}</h3>
                    <p>Visitas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$data['onlineCount']}}</h3>
                    <p>Usuários Online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$data['pageCount']}}</h3>
                    <p>Páginas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$data['userCount']}}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sobre o sistema</h3>
                </div>
                <div class="card-body">
                    ...
                </div>
            </div>
        </div>
    </div>

<script>
    window.onload = function(){
        let ctx = document.getElementById('pagePie').getContext('2d');

        window.pagePie = new Chart(ctx, {
            type:'pie',
            data:{
                datasets:[{
                    data:{{$data['pageValues']}},
                    backgroundColor:'#0000ff'
                }],
                labels:{!! $data['pageLabels'] !!}
            },
            options:{
                responsive:true,
                legend:{
                    display:false,
                }
            }
        });
    }
</script>
@endsection