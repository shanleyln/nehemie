@extends('layout.app')
@php
    $respRest = session('pvit_rest_response');
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

        <h4 class="mb-3">PVit — Transactions</h4>

        {{-- ==== REST PAYMENT / GIVE_CHANGE ==== --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">REST API (Payment / Give Change)</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.rest.init') }}" class="row gy-3">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label">Transaction type *</label>
                        <select name="transaction_type" class="form-select" required>
                            <option value="PAYMENT">PAYMENT</option>
                            <option value="GIVE_CHANGE">GIVE_CHANGE</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Amount (XAF) *</label>
                        <input name="amount" type="number" min="150" step="1" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Reference (<=15) *</label>
                                <input name="reference" maxlength="15" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Customer account *</label>
                        <input name="customer_account_number" maxlength="20" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Owner charge *</label>
                        <select name="owner_charge" class="form-select" required>
                            <option value="CUSTOMER">CUSTOMER</option>
                            <option value="MERCHANT">MERCHANT</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Operator owner charge</label>
                        <select name="operator_owner_charge" class="form-select">
                            <option value="">(défaut: MERCHANT)</option>
                            <option value="MERCHANT">MERCHANT</option>
                            <option value="CUSTOMER">CUSTOMER</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Agent</label>
                        <input name="agent" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Product</label>
                        <input name="product" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Free info</label>
                        <input name="free_info" class="form-control">
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">Initier REST</button>
                        <a class="btn btn-outline-secondary" href="{{ route('pvit.settings') }}">Paramètres</a>
                    </div>
                </form>

                @if ($respRest)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respRest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                @endif
            </div>
        </div>

        {{-- ==== LINK (WEB / VISA_MASTERCARD / RESTLINK) ==== --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">LINK API (générer un lien / prompt USSD)</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.link.init') }}" class="row gy-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Service *</label>
                        <select name="service" class="form-select" required>
                            <option value="WEB">WEB</option>
                            <option value="VISA_MASTERCARD">VISA_MASTERCARD</option>
                            <option value="RESTLINK">RESTLINK</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Amount (XAF) *</label>
                        <input name="amount" type="number" min="150" step="1" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Reference (<=15) *</label>
                                <input name="reference" maxlength="15" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Customer account</label>
                        <input name="customer_account_number" maxlength="20" class="form-control"
                            placeholder="Requis pour VISA/RESTLINK">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Owner charge *</label>
                        <select name="owner_charge" class="form-select" required>
                            <option value="CUSTOMER">CUSTOMER</option>
                            <option value="MERCHANT">MERCHANT</option>
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
                        <button class="btn btn-primary">Générer le lien</button>
                        <a class="btn btn-outline-secondary" href="{{ route('pvit.settings') }}">Paramètres</a>
                    </div>
                </form>

                @if ($respLink)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respLink, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
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
                        ({{ $s->operation_account_code ?? 'ACC_...' }})</button>
                </form>

                @if ($respBal)
                    <pre class="mt-3 bg-light p-3 border rounded small">{{ json_encode($respBal, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                @endif
            </div>
        </div>

    </div>
@endsection
