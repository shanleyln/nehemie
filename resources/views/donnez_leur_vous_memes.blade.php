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

    <!-- PDF Viewer Section -->
    <section class="py-3 bg-white">
        <div class="container">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="position-relative" style="padding-top: 56.25%;"> <!-- Ratio 16:9 -->
                    <iframe src="{{ asset('pdf/donnez-leur-vous-mêmes-a-manger.pdf') }}#toolbar=0&navpanes=0&scrollbar=0"
                        title="Donnez-leur vous-mêmes à manger" class="position-absolute top-0 start-0 w-100 h-100"
                        style="border: none;">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
