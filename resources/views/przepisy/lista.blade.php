@extends('layouts.app')

@section('title', 'Przepisy - Lista przepisów')


@section('content')
<div class="container">
  <div class="row">
      <div class="col-sm">
      <div class="card" style="width: 12rem;">
        <img class="card-img-top" src="{{ URL('/images/sniadanie.jpg') }}" alt="Śniadanie">
        <div class="card-body">
          <h5 class="card-title">Śniadanie</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#" class="card-link">Owsianka herbaciana z musem jabłkowym</a></li>
            <li class="list-group-item"><a href="#" class="card-link">2</a></li>
            <li class="list-group-item"><a href="#" class="card-link">3</a></li>
          </ul>
        </div>
      </div>
      </div>

      <div class="col-sm">
      <div class="card" style="width: 12rem;">
        <img class="card-img-top" src="{{ URL('/images/2sniadanie.jpg') }}" alt="Drugie śniadanie">
        <div class="card-body">
          <h5 class="card-title">2 śniadanie</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#" class="card-link">Serek wiejski pomidor</a></li>
            <li class="list-group-item"><a href="#" class="card-link">2</a></li>
            <li class="list-group-item"><a href="#" class="card-link">3</a></li>
          </ul>
        </div>
      </div>
      </div>

      <div class="col-sm">
      <div class="card" style="width: 12rem;">
        <img class="card-img-top" src="{{ URL('/images/obiad.jpg') }}" alt="Obiad">
        <div class="card-body">
          <h5 class="card-title">Obiad</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#" class="card-link">Dorsz ze szpinakiem</a></li>
            <li class="list-group-item"><a href="#" class="card-link">2</a></li>
            <li class="list-group-item"><a href="#" class="card-link">3</a></li>
          </ul>
        </div>
      </div>
      </div>

      <div class="col-sm">
      <div class="card" style="width: 12rem;">
        <img class="card-img-top" src="{{ URL('/images/podwieczorek.jpg') }}" alt="Podwieczorek">
        <div class="card-body">
          <h5 class="card-title">Podwieczorek</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#" class="card-link">Cytrusowy koktajl</a></li>
            <li class="list-group-item"><a href="#" class="card-link">2</a></li>
            <li class="list-group-item"><a href="#" class="card-link">3</a></li>
          </ul>
        </div>
      </div>
      </div>

      <div class="col-sm">
      <div class="card" style="width: 12rem;">
        <img class="card-img-top" src="{{ URL('/images/kolacja.jpg') }}" alt="Kolacja">
        <div class="card-body">
          <h5 class="card-title">Kolacja</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#" class="card-link">Omlet z pomidorem i ziołami</a></li>
            <li class="list-group-item"><a href="#" class="card-link">2</a></li>
            <li class="list-group-item"><a href="#" class="card-link">3</a></li>
          </ul>
        </div>
      </div>
      </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection
