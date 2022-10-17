@extends('layouts.user')

@section('page-name')
<li class="breadcrumb-item"><a href="/user" class="text-muted">Dashboard</a></li>
@endsection

@section('content')

<div>
    <user-index :ultimas_transacoes="{{ json_encode($ultimas_transacoes )}}" :transacoes_hoje="{{ json_encode($transacoes_hoje )}}" :transacoes="{{ json_encode($transacoes )}}" />
</div>

<div>
    <ultimas-transacoes :transacoes="{{ json_encode($ultimas_transacoes )}}" />
</div>

@endsection