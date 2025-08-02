@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Débitos por Atraso</h1>

    @php
        $hasDebits = false;
    @endphp

    <table class="table">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data de Devolução</th>
                <th>Multa (R$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowings as $borrowing)
                @if($borrowing->fine > 0)
                    @php $hasDebits = true; @endphp
                    <tr>
                        <td>{{ $borrowing->user->name }}</td>
                        <td>{{ $borrowing->book->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</td>
                        <td>{{ number_format($borrowing->fine, 2, ',', '.') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @if(!$hasDebits)
        <p>Não há débitos no momento.</p>
    @endif
</div>
@endsection
