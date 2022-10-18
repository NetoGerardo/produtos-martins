@extends('layouts.user')

@section('page-name')
<li class="breadcrumb-item"><a href="/user/relatorio" class="text-muted">Relatório</a></li>
@endsection

@section('content')
<div>
    <user-relatorio :transacoes="{{ json_encode($transacoes) }}" :soma_transacoes="{{ json_encode($soma_transacoes) }}" />
</div>
@endsection