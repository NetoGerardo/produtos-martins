@extends('layouts.user')

@section('content')

<div style="text-align: center;">
    <h2>Transações Recorrentes</h2>
</div>

<div>
    <nova-transacao-recorrente :projetos="{{ json_encode($projetos) }}"/>
</div>

<div>
    <listar-transacoes-recorrente :transacoes_recorrentes="{{ json_encode($transacoes_recorrentes) }}" />
</div>

@endsection