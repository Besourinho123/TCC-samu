@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
@section('content')
<br>    

<div class="container">

    
    @foreach ($dados as $v)
    
        {{ $v->nome }} 

    <div class="align-right">
      <a href="/editarCurso/{{$v->id}}" class="btn btn-primary fa fa-wrench" method="post"></a>
      <form method="post" style="display: inline;" action="/deleteCurso/{{$v->id}}">
        {{csrf_field()}}
        <button class="btn btn-danger fa fa-trash" onclick="return confirm('Tem certeza que deseja deletar esse registro?'); return false;"></button>
    </form>
    <br>
    @endforeach
    </div>
    <br>
</div>
@endsection
  