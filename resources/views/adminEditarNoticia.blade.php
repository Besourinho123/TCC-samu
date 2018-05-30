@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
@section('content')
<br>
<br><br>
<div class="container">
<nav class="breadcrumb">
<a class="breadcrumb-item" href="/">Home</a>
<a class="breadcrumb-item" href="/admin">Administrar</a>
<span class="breadcrumb-item active">Editar Notícia</span>
</nav>
    
    @foreach ($dados as $v)
    
        {{ $v->titulo_noticia }} 

    <div class="align-right">
      <a href="/editarNoticia/{{$v->id}}" class="btn btn-primary fa fa-wrench" method="post"></a>
      <form method="post" style="display: inline;" action="/deleteNoticia/{{$v->id}}">
        {{csrf_field()}}
        <button class="btn btn-danger fa fa-trash" onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;"></button>
    </form>
    <br>
    @endforeach
    </div> 
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
