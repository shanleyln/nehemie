@extends('layouts.app')

@push('styles')
    <style>
        .error-modal .modal-header {
            background-color: #dc3545;
            color: white;
        }

        .error-modal .modal-title {
            font-weight: 600;
        }

        .error-modal .modal-body {
            padding: 2rem;
            text-align: center;
        }

        .error-modal .modal-body i {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')

    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 50vh;">
        <img src="{{ asset('images/notre-histoire.jpg') }}" alt="Actualités & Événements"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 2;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 3;">
            <h1 class="display-5 fw-bold text-center text-white">Actualités & Événements</h1>
        </div>
    </section>

    {{-- À la une --}}
    @if (isset($featured) && $featured)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="{{ $featured['fichier_cover'] }}" alt="{{ $featured['texte_publication'] }}"
                            class="img-fluid rounded shadow" style="max-height: 400px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-primary me-2">Nouveau</span>
                                <span class="text-muted">{{ $featured['date_formatted'] }}</span>
                            </div>
                            <h3 class="h2 mb-4">
                                {{ \Illuminate\Support\Str::limit($featured['texte_publication'], 100, '...') }}</h3>
                            <p class="lead">
                                {{ \Illuminate\Support\Str::limit($featured['texte_publication'], 250, '...') }}</p>
                            <a href="#" class="btn btn-outline-primary mt-auto align-self-start read-more">
                                Lire la suite <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Toutes les actualités --}}
    <section id="actualites" class="py-5">
        <div class="container">
            <div class="section-heading text-center mb-5" data-aos="fade-up">
                <div class="heading-line center"></div>
                <h2 class="section-title">Toutes les actualités</h2>
                <p class="section-subtitle">Restez informé de nos dernières actions et des événements à venir</p>
            </div>

            <div class="row g-4" data-aos="fade-up">
                @php $publications = $publications ?? []; @endphp

                @if (count($publications) > 0)
                    @foreach ($publications as $publication)
                        @php
                            $date = \Carbon\Carbon::parse($publication['date_publication']);
                            $formattedDate = $date->format('d M Y');
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ $publication['fichier_cover'] }}" class="card-img-top"
                                        alt="{{ $publication['texte_publication'] }}"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 text-white p-2"
                                        style="background-color: #C78A44;">
                                        {{ $formattedDate }}
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="card-text flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($publication['texte_publication'], 150, '...') }}
                                    </p>
                                    <a href="#" class="btn btn-outline-primary mt-auto align-self-start read-more">
                                        Lire la suite <i class="fas fa-arrow-right ms-1"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune actualité disponible pour le moment.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>




    {{-- Modale d’erreur --}}
    <div class="modal fade error-modal" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Erreur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>



@endsection
