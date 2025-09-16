@extends('layout.app')

@section('content')
    <div class="py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header fw-bold">Paramètres PVit</div>
            <div class="card-body">
                <form method="post" action="{{ route('pvit.settings.save') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Merchant Slug</label>
                            <input name="merchant_slug" class="form-control"
                                value="{{ old('merchant_slug', $s->merchant_slug) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Operation Account Code *</label>
                            <input name="operation_account_code" class="form-control" required
                                value="{{ old('operation_account_code', $s->operation_account_code) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Renew Password *</label>
                            <input name="renew_password" class="form-control" required
                                value="{{ old('renew_password', $s->renew_password) }}">
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CodeURL Renew *</label>
                            <input name="codeurl_renew" class="form-control" required
                                value="{{ old('codeurl_renew', $s->codeurl_renew) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CodeURL REST</label>
                            <input name="codeurl_rest" class="form-control"
                                value="{{ old('codeurl_rest', $s->codeurl_rest) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CodeURL LINK</label>
                            <input name="codeurl_link" class="form-control"
                                value="{{ old('codeurl_link', $s->codeurl_link) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CodeURL Balance</label>
                            <input name="codeurl_balance" class="form-control"
                                value="{{ old('codeurl_balance', $s->codeurl_balance) }}">
                        </div>
                        <div class="col-md-3 mt-3">
                            <label class="form-label">CodeURL Status</label>
                            <input name="codeurl_status" class="form-control"
                                value="{{ old('codeurl_status', $s->codeurl_status) }}">
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Callback URL Code</label>
                            <input name="callback_url_code" class="form-control"
                                value="{{ old('callback_url_code', $s->callback_url_code) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Success Redirect Code</label>
                            <input name="success_redirect_code" class="form-control"
                                value="{{ old('success_redirect_code', $s->success_redirect_code) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Failed Redirect Code</label>
                            <input name="failed_redirect_code" class="form-control"
                                value="{{ old('failed_redirect_code', $s->failed_redirect_code) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Secret Reception Code *</label>
                            <input name="secret_reception_code" class="form-control" required
                                value="{{ old('secret_reception_code', $s->secret_reception_code) }}">
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary">Enregistrer</button>
                        <form method="post" action="{{ route('pvit.renewSecret') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-dark" formaction="{{ route('pvit.renewSecret') }}">Renouveler la
                                clé maintenant</button>
                        </form>
                        <a class="btn btn-outline-secondary" href="{{ route('pvit.secretsLog') }}">Journal des clés
                            reçues</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header fw-bold">Clé actuelle</div>
            <div class="card-body">
                <div>Secret actuel:
                    <code>{{ $s->current_secret ? \Illuminate\Support\Str::limit($s->current_secret, 24) : '—' }}</code>
                </div>
                <div>Expire le:
                    <strong>{{ $s->secret_expires_at?->format('d/m/Y H:i') ?? '—' }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
