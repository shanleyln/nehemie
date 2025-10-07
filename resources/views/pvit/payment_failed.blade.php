@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="error-circle">
                            <div class="error-mark">!</div>
                        </div>
                    </div>
                    <h2 class="mb-3">Paiement Échoué</h2>
                    <p class="text-muted mb-4">
                        Une erreur est survenue lors du traitement de votre paiement.
                        @if(!empty($message))
                            <div class="alert alert-warning mt-3">{{ $message }}</div>
                        @endif
                    </p>
                    
                    <div class="d-grid gap-3 d-md-flex justify-content-center mt-4">
                        <a href="{{ route('route_donnez_leur_vous_memes') }}" class="btn btn-primary px-4">
                            <i class="fas fa-credit-card me-2"></i>Réessayer le paiement
                        </a>
                        <a href="{{ route('route_accueil') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-home me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                    
                    @if(!empty($reference))
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-muted small mb-2">Référence : {{ $reference }}</p>
                        <p class="text-muted small">
                            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter notre support 
                            <a href="{{ route('contact') }}" class="text-primary">en cliquant ici</a>.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: block;
    border: 4px solid #dc3545;
    margin: 0 auto 20px;
    position: relative;
    animation: pulse 2s infinite;
}

.error-mark {
    position: absolute;
    color: #dc3545;
    font-size: 50px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes pulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}
</style>
@endsection
