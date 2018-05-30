@extends('layouts.app')

@section('content')
<br><br><br>
    
    <div class="container">
    <nav class="breadcrumb">
    <a class="breadcrumb-item" href="/">Home</a>
    <a class="breadcrumb-item" href="/admin">Administrar</a>
    <span class="breadcrumb-item active">Ouvidoria</span>
    </nav>
    <h1>Feedback da Comunidade</h1>
    <br>

    <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone para Contato</th>
                    <th>Email para Contato</th>
                    <th>Texto</th>
                    
                
                </tr>
            </thead>
            <tbody>
            @foreach($dados as $value)
                <tr>
                    <td>{{ $value->nome }}</td>
                    <td>{{ $value->telefone }}</td>
                    <td>{{ $value->email }}</td>
                    <td style="white-space: initial">{{ $value->texto }}</td>
                </tr>


            @endforeach
            </tbody>
            
        </table>
    </div>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection