@extends('layouts.app_admin')
@php
    $respLink = session('pvit_link_response');
    $respStat = session('pvit_status_response');
    $respBal = session('pvit_balance_response');
@endphp

@section('content')
    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h4 class="mb-3">PVit — Paiements (LINK), Statut & Solde</h4>

        {{-- ==== LINK (WEB / VISA_MASTERCARD / RESTLINK) ==== --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">LINK API (générer un lien ou un prompt USSD)</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.link.init') }}" class="row gy-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Service *</label>
                        <select name="service" class="form-select" required>
                            <option value="WEB">WEB (page PVit)</option>
                            <option value="VISA_MASTERCARD">VISA_MASTERCARD</option>
                            <option value="RESTLINK">RESTLINK (prompt USSD direct)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Amount (XAF) *</label>
                        <input name="amount" type="number" min="150" step="1" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Reference (≤15)</label>
                        <input name="reference" maxlength="15" class="form-control" placeholder="Laisse vide pour auto">
                        <div class="form-text">Laisse vide : on génère une référence unique.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Customer account</label>
                        <input name="customer_account_number" maxlength="20" class="form-control"
                            placeholder="Requis pour VISA/RESTLINK">
                        <div class="form-text">Tu peux vérifier via KYC avant de générer.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Owner charge *</label>
                        <select name="owner_charge" class="form-select" required>
                            <option value="CUSTOMER">CUSTOMER (client paie frais PVit)</option>
                            <option value="MERCHANT">MERCHANT (marchand paie frais PVit)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Operator owner charge</label>
                        <select name="operator_owner_charge" class="form-select">
                            <option value="">(défaut: MERCHANT)</option>
                            <option value="MERCHANT">MERCHANT</option>
                            <option value="CUSTOMER">CUSTOMER</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Agent</label>
                        <input name="agent" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Product</label>
                        <input name="product" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Free info</label>
                        <input name="free_info" class="form-control">
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">Générer</button>
                        <button type="submit" formaction="{{ route('pvit.kyc.check') }}" formmethod="POST"
                            class="btn btn-primary">
                            Vérifier KYC
                        </button>
                    </div>
                </form>

                @if ($respLink)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respLink, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                    @if (!empty($respLink['_merchant_reference']))
                        <div class="alert alert-info mt-2">
                            <strong>Référence marchande utilisée :</strong>
                            <code>{{ $respLink['_merchant_reference'] }}</code>
                            <div class="small text-muted">Utilise-la dans "GET STATUS" (champ transactionId).</div>
                        </div>
                    @endif

                    @if (!empty($respLink['url']))
                        <div class="mt-2">
                            <a class="btn btn-success" target="_blank" href="{{ $respLink['url'] }}">Ouvrir la page de
                                paiement</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- ==== STATUS ==== --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">GET STATUS</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.status.check') }}" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">transactionId (ta référence) *</label>
                        <input name="transactionId" class="form-control" placeholder="ex: REF13090141" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">transactionOperation *</label>
                        <select name="transactionOperation" class="form-select" required>
                            <option value="PAYMENT">PAYMENT</option>
                            <option value="GIVE_CHANGE">GIVE_CHANGE</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Vérifier</button>
                    </div>
                </form>

                @if ($respStat)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respStat, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                @endif
            </div>
        </div>

        {{-- ==== BALANCE ==== --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">BALANCE</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.balance.check') }}">
                    @csrf
                    <button class="btn btn-primary">Consulter le solde
                        ({{ $s->merchant_operation_account_code ?? 'ACC_...' }})</button>
                </form>

                @if ($respBal)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respBal, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                @endif
            </div>
        </div>

    </div>
@endsection
