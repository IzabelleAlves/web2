@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Débitos</h1>

        <!-- Exemplo simples: -->
        <p>Aqui você pode listar os débitos dos usuários...</p>

        {{-- Você pode usar dados passados pelo controller aqui --}}
        @if(isset($debits) && count($debits) > 0)
            <ul>
                @foreach($debits as $debit)
                    <li>{{ $debit->user->name }} - R$ {{ number_format($debit->amount, 2, ',', '.') }}</li>
                @endforeach
            </ul>
        @else
            <p>Não há débitos para exibir.</p>
        @endif
    </div>
@endsection