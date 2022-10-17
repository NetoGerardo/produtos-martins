@extends('layouts.user')

@section('content')

<div style="text-align: center;">
    <h2>Categorias</h2>
</div>

<div>
    <nova-categoria />
</div>

<div>
    <listas-categorias :categorias="{{ json_encode($categorias) }}" />
</div>

@endsection