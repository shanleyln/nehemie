@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 50vh;">
        <!-- Image de fond -->
        <img src="{{ asset('images/notre-histoire.jpg') }}" alt="Donnez-leur vous-mêmes à manger"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">

        <!-- Filtre sombre sur toute l’image -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 2;"></div>

        <!-- Titre centré -->
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 3;">
            <h1 class="display-5 fw-bold text-center text-white">Donnez-leur vous-mêmes à manger</h1>
        </div>
    </section>



    <!-- Section Plaquette Interprétative Améliorée -->
    <section class="py-5 bg-light">
        <div class="container">

            <!-- Titre de section -->
            <div class="section-heading text-center" data-aos="fade-up">
                <div class="heading-line center"></div>
                <h2 class="fw-bold mb-2">Notre Plaquette de Présentation</h2>
                <p class="section-subtitle">
                    Explorez nos valeurs, nos actions et notre vision à travers une lecture claire et interactive.
                </p>
            </div>

            <!-- Bouton de téléchargement PDF -->
            <div class="text-center mb-5">
                <a href="{{ asset('pdf/Plaquette.pdf') }}" class="btn btn-primary btn-lg shadow-sm" download>
                    <i class="fas fa-file-pdf me-2"></i> Télécharger le PDF complet
                </a>

            </div>

            <!-- Double page interactive avec zoom visuel -->
            <div class="card border-0 shadow-sm p-3 bg-white">
                <div class="row g-4 align-items-center">
                    @foreach ([1, 2] as $num)
                        <div class="col-12 col-md-6">
                            <figure class="text-center position-relative group overflow-hidden">
                                <a href="{{ asset("images/plaquette{$num}.jpg") }}" data-lightbox="plaquette"
                                    data-title="Page {{ $num }}">
                                    <div class="zoom-container position-relative">
                                        <img src="{{ asset("images/plaquette{$num}.jpg") }}"
                                            class="img-fluid rounded shadow-sm zoom-image"
                                            alt="Plaquette – Page {{ $num }}">
                                        <div class="zoom-icon position-absolute top-50 start-50 translate-middle">
                                            <i
                                                class="fas fa-search-plus fa-2x text-white bg-dark bg-opacity-50 rounded-circle p-2"></i>
                                        </div>
                                    </div>
                                </a>
                                <figcaption class="mt-3 text-muted">
                                    <strong>Page {{ $num }} :</strong>
                                    @if ($num === 1)
                                        Une introduction à notre mission, nos engagements et les fondations de notre action.
                                    @else
                                        Aperçu de nos projets phares, de notre vision future et de nos axes stratégiques.
                                    @endif
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <style>
        .zoom-container {
            overflow: hidden;
            position: relative;
        }

        .zoom-image {
            transition: transform 0.3s ease;
        }

        .zoom-container:hover .zoom-image {
            transform: scale(1.05);
        }

        .zoom-icon {
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .zoom-container:hover .zoom-icon {
            opacity: 1;
        }
    </style>
@endsection
