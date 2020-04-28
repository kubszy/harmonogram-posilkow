@extends('layouts.app')

@section('title', 'Start - Harmonogram posiłków')

@section('content')

<h3 style="padding-bottom: 20px;">Podstawowe informacje <span class="badge badge-secondary"> {{ $uzytkownik }}</span></h3>
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th>Data wizyty</th>
      <th>Masa ciała</th>
      <th>BMI</th>
      <th>Talia (cm)</th>
      <th>Pass (cm)</th>
      <th>Biodra (cm)</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($harmonogramy as $key => $value)
    <tr>
      <td>{{ \Carbon\Carbon::parse($value->data_wizyty)->format('d-m-Y') }}</td>
      <td>{{ $value->masa_ciala }} kg </td>
      <td>{{ $value->bmi }}</td>
      <td>{{ $value->talia }}</td>
      <td>{{ $value->pass }} cm </td>
      <td>{{ $value->biodra }}</tdc>
    </tr>
    @endforeach
  </tbody>
</table>
@if ($straconeKg != 0) <h3 style="padding-bottom: 20px;" class="alert alert-success">Twoja waga spadła o {{ $straconeKg }} kg</h3>@endif
<h3 style="padding-bottom: 20px;">Harmonogramy <span class="badge badge-secondary">{{ $ile }}</span></h3>
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th>Nr / nazwa</th>
      <th>Ilość dni</th>
      {{-- <th>Pierwszy dzień</th> --}}
      <th>Uwagi</th>
      <th>Akcja</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($harmonogramy as $key => $value)
    <tr>
      <td>{{ $value->nr_tygodnia }} @if ($value->nazwa_harmonogramu != "") / {{ $value->nazwa_harmonogramu }} @else @endif</td>
      <td>{{ $value->ilosc_dni }}</td>
      {{-- <td>{{ \Carbon\Carbon::parse($value->start_dzien)->format('d-m-Y') }}</td> --}}
      <td>
        @foreach ($ileUwag as $k => $v)
          @if ($value->id == $k)
            <p class="text-danger">{{ $v }}</p>
          @endif
        @endforeach
      </td>
      <td>
        <div class="row">
          <div>
            <a href="{{ route('szczegoly', [$value->id, $value->user_id]) }}" class="btn btn-info btn-sm" title="Szczegóły harmonogramu"><i class="fas fa-info-circle"></i></a>
            {{-- <a href="" class="btn btn-success btn-sm">Uzupełnij</a> --}}
            @role('user')
            <a href="" class="btn btn-danger btn-sm" data-id="{{ $value->id }}" title="Usuń harmonogram" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash-alt"></i></a>
            @endrole
          </div>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{-- @permission('dodaj.harmonogram') --}}
@role('user')
<div class="form-group">
    <a href="{{ route('dodaj') }}" class="btn btn-primary btn-sm" title="Dodaj nowy harmonogram"> Dodaj harmonogram </a>
</div>
@endrole
{{-- @endpermission --}}

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usuwanie harmonogramu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Czy na pewno usunąć harmonogram, jeśli wcześniej uzupełniłeś posiłki również zostaną usunięte ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Anuluj</button>
        <button type="submit" class="btn btn-danger btn-sm" id="usun">Usuń</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('.btn-danger').on('click', function(e) {
         //var $form = $(this).closest('form');
         var id = $(this).data("id");
         e.preventDefault();
         $('#usun').on('click', function(e) {
            // $form.trigger('submit');
            $.ajax({
                  url: '{!! route('usun', '') !!}' + '/' + id,
                  type:"POST",
                  dataType:"json",
                  data: {
                   _token: '{!! csrf_token() !!}',
                  },
                  success:function(data) {
                    console.log('usunięto, OK');
                    window.location.replace('{!! route('index', '') !!}');
                  },
              });
          });
      });
    });
  </script>
@endsection
