@php use Illuminate\Support\Str; @endphp


@extends('layout.app')

@section('content')
    <div class="py-4">
        <h4 class="mb-3">Journal des clés reçues</h4>

        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Clé (début)</th>
                        <th>Expires In</th>
                        <th>Operation Account</th>
                        <th>Reçu le</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $e)
                        <tr>
                            <td>{{ $e->id }}</td>
                            <td><code>{{ $e->secret_key ? Str::limit($e->secret_key, 24) : '—' }}</code></td>
                            <td>{{ $e->expires_in ? $e->expires_in . ' s' : '—' }}</td>
                            <td>{{ $e->operation_account_code ?? '—' }}</td>
                            <td>{{ $e->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucun événement pour l’instant.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $events->links() }}
    </div>
@endsection
