@extends('layouts.app')

@section('title', 'Lista klientów - Harmonogram posiłków')

@section('content')
<div class="form-group">
    <a href="{{ route('przepisy') }}" class="btn btn-primary btn-sm" title="Przepisy"> Przepisy </a>
</div>

<h3 style="padding-bottom: 20px;">Lista klientów <span class="badge badge-secondary"> {{ $ile }} </span></h3>
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th>Klient</th>
      <th>Harmonogramy</th>
      <th>Data ostatniej wizyty</th>
      <th>Ostatnia waga</th>
      <th>Akcja</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($klienci as $key => $value)
    <tr>
      <td>{{ $value->name }}</td>
      <td>{{ $ile_harmonogramow[$key] }}</td>
      <td>{{ \Carbon\Carbon::parse($data_ostatniej_wizyty[$key])->format('d-m-Y') }}</td>
      <td>{{ $ostatnia_waga[$key] }} kg</td>
      <td><a href="{{ route('listaHarmonogramow', $value->id) }}" class="btn btn-info btn-sm" title="Szczegóły"><i class="fas fa-info-circle"></i></a></td>
    </tr>
    @endforeach
  </tbody>
</table>


{{-- @permission('dodaj.harmonogram')
<div class="form-group">
    <a href="{{ route('dodaj') }}" class="btn btn-primary btn-sm" title="Dodaj nowy harmonogram"> Dodaj harmonogram </a>
</div>
@endpermission --}}

{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> --}}

@endsection

@section('scripts')

@endsection
