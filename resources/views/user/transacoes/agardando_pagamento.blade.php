@extends('layouts.user')

@section('page-name')
<li class="breadcrumb-item"><a href="/user" class="text-muted">Dashboard</a></li>
@endsection

@section('content')

<div style="text-align: center;">
    <h2>Transações Aguardando Pagamento</h2>
</div>

<div>
    <listar-transacoes-aguardando-pagamento :soma_transacoes="{{ json_encode($soma_transacoes )}}" :projetos="{{ json_encode($projetos )}}" :transacoes="{{ json_encode($transacoes )}}" />
</div>

@endsection