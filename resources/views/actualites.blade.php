@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 50vh;">
        <!-- Image de fond -->
        <img src="{{ asset('images/notre-histoire.jpg') }}" alt="Actualités & Événements"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">

        <!-- Filtre sombre sur toute l’image -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 2;"></div>

        <!-- Titre centré -->
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 3;">
            <h1 class="display-5 fw-bold text-center text-white">Actualités & Événements</h1>
        </div>
    </section>

    <!-- Section Actualités -->
    <section id="actualites" class="news-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">

                <div class="heading-line center"></div>
                <p class="section-subtitle">Restez informé de nos dernières actions et des événements à venir</p>
            </div>

            <div class="news-grid" data-aos="fade-up">
                <div class="news-card">
                    <div class="news-image">
                        <img src="<?= asset('images/evenement/club-anglais.png') ?>" alt="Lancement du Club d'Anglais">
                        <div class="news-date">
                            <span class="day">15</span>
                            <span class="month">Mai</span>
                        </div>
                    </div>
                    <div class="news-content">
                        <h3>Lancement du Club d'Anglais pour les jeunes</h3>
                        <p>NÉHÉMIE International a inauguré son club d'anglais visant à renforcer les compétences
                            linguistiques des jeunes...</p>
                        <a href="#" class="news-link">Lire la suite <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        <img src="<?= asset('images/evenement/distribution-dorcas.png') ?>" alt="Distribution alimentaire">
                        <div class="news-date">
                            <span class="day">22</span>
                            <span class="month">Avr</span>
                        </div>
                    </div>
                    <div class="news-content">
                        <h3>Grande distribution alimentaire à Akébé</h3>
                        <p>Dans le cadre du programme DORCAS, une importante distribution de vivres a eu lieu dans
                            le
                            quartier Akébé...</p>
                        <a href="#" class="news-link">Lire la suite <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-image">
                        <img src="<?= asset('images/evenement/visite-terrain-nzeng-ayong.png') ?>" alt="Visite de terrain">
                        <div class="news-date">
                            <span class="day">10</span>
                            <span class="month">Fév</span>
                        </div>
                    </div>
                    <div class="news-content">
                        <h3>Visite de terrain et évaluation des besoins</h3>
                        <p>L'équipe de NÉHÉMIE s'est rendue à Nzeng-Ayong pour une évaluation des besoins des
                            familles
                            vulnérables...</p>
                        <a href="#" class="news-link">Lire la suite <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            {{-- <div class="news-events-wrapper" data-aos="fade-up">
                      <div class="upcoming-events">
                          <h3>Prochains Événements</h3>

                          <div class="event-item">
                              <div class="event-date">
                                  <span class="event-day">10</span>
                                  <span class="event-month">JUIN</span>
                              </div>
                              <div class="event-details">
                                  <h4>Lancement campagne "Donnez-leur..."</h4>
                                  <p><i class="fas fa-map-marker-alt"></i> Centre communautaire, Libreville</p>
                                  <p><i class="fas fa-clock"></i> 18h00</p>
                              </div>
                          </div>

                          <div class="event-item">
                              <div class="event-date">
                                  <span class="event-day">15</span>
                                  <span class="event-month">JUIN</span>
                              </div>
                              <div class="event-details">
                                  <h4>Atelier Formation Club d'Anglais</h4>
                                  <p><i class="fas fa-map-marker-alt"></i> Local NÉHÉMIE</p>
                                  <p><i class="fas fa-clock"></i> 14h00 - 16h00</p>
                              </div>
                          </div>
                      </div>

                       <div class="newsletter-signup">
                          <h3>Rejoignez notre newsletter</h3>
                          <p>Recevez nos actualités et restez informé de nos actions sur le terrain.</p>

                          <form class="newsletter-form">
                              <div class="form-group">
                                  <label for="name">Nom</label>
                                  <input type="text" id="name" placeholder="Votre nom">
                              </div>
                              <div class="form-group">
                                  <label for="email">Email</label>
                                  <input type="email" id="email" placeholder="Votre email">
                              </div>
                              <button type="submit" class="btn btn-primary">S'abonner</button>
                          </form>
                      </div> -
                  </div> --}}
        </div>
    </section>
@endsection
