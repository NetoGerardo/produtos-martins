@extends('layouts.admin')

@section('content')

<div>
    <admin-list-users :usuarios="{{ json_encode($usuarios) }}" />
</div>
@endsection