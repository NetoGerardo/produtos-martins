@extends('layouts.user')

@section('content')

<div style="text-align: center;">
    <h2>Produtos</h2>
</div>

<div>
    <novo-produto :categorias="{{ json_encode($categorias) }}" :projetos="{{ json_encode($projetos) }}"/>
</div>

<div>
    <listar-produtos :produtos="{{ json_encode($produtos) }}" />
</div>

@endsection