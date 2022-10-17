@extends('layouts.user')

@section('content')

<div style="text-align: center;">
    <h2>Projetos</h2>
</div>

<div>
    <novo-projeto />
</div>

<div>
    <listar-projetos :projetos="{{ json_encode($projetos) }}" />
</div>

@endsection