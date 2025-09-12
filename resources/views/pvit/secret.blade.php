<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Clé secrète MyPVit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
                        <button class="btn btn-outline-secondary" type="button" onclick="toggle()">Afficher</button>
                        <button class="btn btn-outline-secondary" type="button" onclick="copy()">Copier</button>
                    </div>
                    <div class="form-text mt-2">
                        @if ($meta && isset($meta['received_at']))
                            Reçue le <strong>{{ $meta['received_at'] }}</strong>
                            @if (isset($meta['expires_in']))
                                — expire dans ~ {{ $meta['expires_in'] }} s
                            @endif
                        @endif
                    </div>
                @else
                    <div class="text-muted">Aucune clé enregistrée pour le moment.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Générer une nouvelle clé</h6>
                <form method="post" action="{{ route('pvit.renew') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Mot de passe marchand</label>
                        <input name="password" type="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary">Générer et envoyer</button>
                    <button class="btn btn-link" type="button" onclick="location.reload()">Actualiser la page</button>
                </form>
                <div class="form-text mt-2">Après génération, MyPVit envoie la nouvelle clé à
                    <code>/api/pvit/receive-secret</code>.
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggle() {
            const f = document.getElementById('secretField');
            f.type = (f.type === 'password') ? 'text' : 'password';
        }

        function copy() {
            const f = document.getElementById('secretField');
            f.type = 'text';
            f.select();
            document.execCommand('copy');
            f.type = 'password';
        }
    </script>
</body>

</html>
