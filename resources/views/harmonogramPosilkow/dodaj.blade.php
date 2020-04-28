@extends('layouts.app')

@section('title', 'Dodawanie harmonogramu - Harmonogram posiłków')

@section('content')
<style>
  .has-error .form-control {
    border-color: #ed5565;
  }
  hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }
</style>

<div class="col">
<form action="{{ route('dodaj') }}" method="post">
@csrf
    <div class="form-group row {{ $errors->has('ilosc_dni') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Ilość dni</label>
        <div class="col-sm-4">
          <input type="text" name="ilosc_dni" class="form-control">
          @if ($errors->any())
            @foreach ($errors->get('ilosc_dni') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted">Ile dni ma obejmować harmonogram, np: 7, 14</small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('start_dzien') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Dzień start</label>
        <div class="col-sm-4">
          <input type="text" name="start_dzien" class="form-control datepicker" value="{{ date('d-m-Y') }}">
          @if ($errors->any())
            @foreach ($errors->get('start_dzien') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted">Data pierwszego dnia</small>
          @endif
        </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2" for="">Opis dnia</label>
        <div class="col-sm-4">
          <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="poniedzialek" class="form-control" value="" placeholder="poniedziałek">
          <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="wtorek" class="form-control" value="" placeholder="wtorek">
          <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="sroda" class="form-control" value="" placeholder="środa">
          <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="czwartek" class="form-control" value="" placeholder="czwartek">
          <input style="margin-bottom: 10px;" type="text" autocomplete="off" name="piatek" class="form-control" value="" placeholder="piątek">
          <input style="margin-bottom: 10px;"type="text" autocomplete="off" name="sobota" class="form-control" value="" placeholder="sobota">
          <input type="text" name="niedziela" class="form-control" value="" placeholder="niedziela">
          <small class="form-text text-muted">Jeżeli cyklicznie w danym dniu pojawiają się rzeczy typu trening, basen, wyjazd to podaj te informacje przy nazwie dnia tygodnia</small>
        </div>
    </div>
    <div class="form-group row {{ $errors->has('nazwa_harmonogramu') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Nazwa harmonogramu</label>
        <div class="col-sm-4">
          <input type="text" name="nazwa_harmonogramu" class="form-control">
          @if ($errors->any())
            @foreach ($errors->get('nazwa_harmonogramu') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted">Opcja</small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('data_wizyty') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Data wizyty</label>
        <div class="col-sm-4">
          <input type="text" name="data_wizyty" autocomplete="off" class="form-control datepicker" value="{{ date('d-m-Y') }}">
          @if ($errors->any())
            @foreach ($errors->get('data_wizyty') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted">Data wizyty</small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('masa_ciala') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Masa ciała (kg)</label>
        <div class="col-sm-4">
          <input type="text" name="masa_ciala" class="form-control" placeholder="Np. 70.5">
          @if ($errors->any())
            @foreach ($errors->get('masa_ciala') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted"></small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('bmi') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">BMI</label>
        <div class="col-sm-4">
          <input type="text" name="bmi" class="form-control" placeholder="Np. 27.5">
          @if ($errors->any())
            @foreach ($errors->get('bmi') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted"></small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('talia') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Talia (cm)</label>
        <div class="col-sm-4">
          <input type="text" name="talia" class="form-control" placeholder="Np. 70.5">
          @if ($errors->any())
            @foreach ($errors->get('talia') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted"></small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('pass') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Pass (cm)</label>
        <div class="col-sm-4">
          <input type="text" name="pass" class="form-control" placeholder="Np. 70.5">
          @if ($errors->any())
            @foreach ($errors->get('pass') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted"></small>
          @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('biodra') ? 'has-error' : '' }}">
      <label class="col-sm-2" for="">Biodra (cm)</label>
        <div class="col-sm-4">
          <input type="text" name="biodra" class="form-control" placeholder="Np. 70.5">
          @if ($errors->any())
            @foreach ($errors->get('biodra') as $error)
              <small class="form-text text-danger">{{ $error }}</small>
            @endforeach
          @else
              <small class="form-text text-muted"></small>
          @endif
        </div>
    </div>

    <div class="form-group col-sm-6">
      <a class="btn btn-secondary btn-sm" href="{{ route('index') }}">Powrót</a>
      <button class="btn btn-primary btn-sm has-error">Zapisz</button>
    </div>

</form>
</div>

@endsection

@section('scripts')
  <script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd-mm-yyyy",
        language: "pl",
        calendarWeeks: true,
    });
  });
  </script>
@endsection
