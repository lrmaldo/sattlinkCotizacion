@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    
    <div class="card-body">
        <a href="{{ route('cotizador.create') }}" class="btn btn-success btn-xs"> <i class="fas fa-file"
            aria-hidden="true"></i> Crear nueva cotización </a>
    <div style="margin: 10px"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Forma</th>
                        <th>Vendedor</th>
                        <th>Total</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Folio</th>
                        <th>Forma</th>
                        <th>Vendedor</th>
                        <th>Total</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($cotizaciones as $item)
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
</div> 




@endsection

{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}