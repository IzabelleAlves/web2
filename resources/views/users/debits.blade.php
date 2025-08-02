@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Usuários com Débito</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($usuariosComDebito->isEmpty())
        <p>Nenhum usuário com débito no momento.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Débito</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuariosComDebito as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>R$ {{ number_format($user->debit, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('admin.zerarDebito', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-danger">Zerar Débito</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
