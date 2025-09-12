<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Clé secrète MyPVit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 24px;
            background: #f8fafc
        }
    </style>
</head>

<body>
    <div class="container" style="max-width: 800px">
        <h3 class="mb-3">Gestion de la clé secrète MyPVit</h3>

        <div class="card mb-4">
            <div class="card-body">
                <h6 class="text-muted">Paramètres</h6>
                <div class="small">
                    Endpoint renew:&nbsp;<code>{{ $info['endpoint'] }}</code><br>
                    Compte d’opération:&nbsp;<code>{{ $info['account'] }}</code><br>
                    Code URL réception:&nbsp;<code>{{ $info['reception'] }}</code>
                </div>
            </div>
        </div>

        @if (session('renew_resp'))
            <div class="alert {{ $renew_ok ? 'alert-success' : 'alert-danger' }}">
                <strong>Renew-secret :</strong>
                <pre class="m-0">{{ json_encode($renew_resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                <div class="small mt-1">La nouvelle clé est envoyée par MyPVit à l’URL de réception. Actualise pour la
                    voir.</div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h6 class="mb-2">Clé actuelle (stockée côté serveur)</h6>
                @if ($secret)
                    <div class="input-group">
                        <input id="secretField" type="password" class="form-control" value="{{ $secret }}"
                            readonly>
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="toggleSecret(this)">Afficher</button>
                        <button class="btn btn-outline-secondary" type="button" onclick="copySecret()">Copier</button>
                    </div>
                    @if ($meta)
                        <div class="form-text mt-2">
                            Reçue le <b>{{ $meta['received_at'] ?? '' }}</b>
                            @if (isset($meta['expires_in']))
                                — expire dans ~ {{ $meta['expires_in'] }} s
                            @endif
                        </div>
                    @endif
                @else
                    <div class="text-muted">Aucune clé enregistrée pour le moment.</div>
                @endif

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Générer une nouvelle clé</h6>
                <form id="renewForm" method="post" action="{{ route('pvit.renew') }}"
                    onsubmit="return renewAjax(event)">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Mot de passe marchand</label>
                        <div class="input-group">
                            <input name="password" id="pvpass" type="password" class="form-control" required
                                autocomplete="current-password">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePw(this)">Afficher</button>
                        </div>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary">Générer et envoyer</button>
                    <button class="btn btn-link" type="button" onclick="location.reload()">Actualiser</button>
                </form>

                <div id="renewResult" class="mt-3"></div>

                <div class="form-text mt-2">Après génération, MyPVit envoie la nouvelle clé à
                    <code>/api/pvit/receive-secret</code>.
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePw(btn) {
            const f = document.getElementById('pvpass');
            f.type = (f.type === 'password') ? 'text' : 'password';
            btn.textContent = (f.type === 'password') ? 'Afficher' : 'Masquer';
        }

        function toggleSecret(btn) {
            const f = document.getElementById('secretField');
            f.type = (f.type === 'password') ? 'text' : 'password';
            btn.textContent = (f.type === 'password') ? 'Afficher' : 'Masquer';
        }

        function copySecret() {
            const f = document.getElementById('secretField');
            const prev = f.type;
            f.type = 'text';
            f.select();
            try {
                document.execCommand('copy');
            } catch (e) {}
            f.type = prev;
        }

        async function renewAjax(e) {
            e.preventDefault();
            const form = e.target;
            const target = document.getElementById('renewResult');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const pwd = form.querySelector('input[name="password"]').value;

            target.innerHTML = '<div class="alert alert-info">Envoi en cours…</div>';

            try {
                const body = new URLSearchParams({
                    password: pwd
                });
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body
                });

                const data = await res.json().catch(() => ({}));

                if (res.ok && data.ok) {
                    target.innerHTML =
                        '<div class="alert alert-success"><b>Renew-secret OK.</b><br>' +
                        '<small>La nouvelle clé a été envoyée à /api/pvit/receive-secret. Cliquez sur "Actualiser" pour l’afficher.</small>' +
                        (data.response ? '<pre class="mt-2 mb-0 small">' + escapeHtml(JSON.stringify(data.response,
                            null, 2)) + '</pre>' : '') +
                        '</div>';
                } else {
                    let msg = (data && data.message) ? data.message : ('Erreur HTTP ' + res.status);
                    target.innerHTML =
                        '<div class="alert alert-danger"><b>Échec du renouvellement.</b><br>' + escapeHtml(msg) +
                        (data && data.response ? '<pre class="mt-2 mb-0 small">' + escapeHtml(JSON.stringify(data
                            .response, null, 2)) + '</pre>' : '') +
                        '</div>';
                }
            } catch (err) {
                target.innerHTML = '<div class="alert alert-danger">Erreur réseau : ' + escapeHtml(err.message) +
                    '</div>';
            }

            return false; // pas de rechargement
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [m]));
        }
    </script>


</body>

</html>
