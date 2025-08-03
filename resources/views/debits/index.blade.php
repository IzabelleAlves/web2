@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Usuários com Débito</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($borrowings->isEmpty())
        <p>Nenhum usuário com débito.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Débito (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
<tbody>
    @foreach ($borrowings as $borrowing)
        @php
            $user = $borrowing->user;
        @endphp
        @if ($user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ number_format($user->debit, 2, ',', '.') }}</td>
                <td>
                    <!-- <form method="POST" action="{{ route('admin.debits.clear', $user) }}"> -->
                        <form method="POST" action="{{ route('debits.clear', $user) }}"></form>
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Confirmar quitação da dívida deste usuário?')">
                            Quitar multa
                        </button>
                    </form>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>

        </table>
    @endif
</div>
@endsection
