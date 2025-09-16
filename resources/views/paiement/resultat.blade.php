@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-{{ $type === 'success' ? 'success' : 'danger' }} text-white">
                    <h4 class="mb-0">{{ $message }}</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($type === 'success')
                            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                        @else
                            <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                        @endif
                    </div>

                    <div class="transaction-details mb-4">
                        <h5 class="text-center mb-4">Détails de la transaction</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Référence</th>
                                    <td>{{ $transaction->reference }}</td>
                                </tr>
                                <tr>
                                    <th>Montant</th>
                                    <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                <tr>
                                    <th>Statut</th>
                                    <td>
                                        @if($transaction->status === 'success')
                                            <span class="badge bg-success">Réussi</span>
                                        @elseif($transaction->status === 'en_attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @else
                                            <span class="badge bg-danger">Échoué</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $transaction->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($transaction->operator_reference)
                                <tr>
                                    <th>Référence opérateur</th>
                                    <td>{{ $transaction->operator_reference }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($transaction->status === 'success')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Votre paiement a été traité avec succès. Un email de confirmation vous a été envoyé.
                        </div>
                    @elseif($transaction->status === 'en_attente')
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Votre paiement est en cours de traitement. Cette page se mettra à jour automatiquement.
                        </div>
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Votre paiement n'a pas pu être traité. Veuillez réessayer ou contacter le support.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('route_accueil') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i> Retour à l'accueil
                        </a>
                        @if($transaction->status !== 'success')
                        <a href="{{ route('paiement.form') }}" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i> Réessayer
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($transaction->status === 'en_attente')
@push('scripts')
<script>
// Vérification périodique du statut du paiement
function checkPaymentStatus() {
    fetch(`/api/pvit/verifier/{{ $transaction->reference }}`)
        .then(response => response.json())
        .then(data => {
            if (data.data.status !== 'en_attente') {
                // Recharger la page pour afficher le statut mis à jour
                window.location.reload();
            }
        })
        .catch(error => console.error('Erreur:', error));
}

// Vérifier toutes les 5 secondes
const intervalId = setInterval(checkPaymentStatus, 5000);

// Arrêter la vérification après 30 minutes
setTimeout(() => {
    clearInterval(intervalId);
}, 30 * 60 * 1000);
</script>
@endpush
@endif

@endsection
