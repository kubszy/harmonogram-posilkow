@extends('layouts.app')

@section('title', 'Szczeóły harmonogramu - Harmonogram posiłków')

@section('content')
<style>
   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #17a2b8;
  }
  hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }
  .hid {
    display: none;
  }
</style>
<?php $newLocale = setlocale(LC_TIME, 'pl_PL.UTF-8'); ?>
<h3 style="padding-bottom: 10px;">Szczegóły harmonogramu <br><span class="badge badge-secondary"> {{ $harmonogram[0]->nr_tygodnia }} @if ($harmonogram[0]->nazwa_harmonogramu != "") / {{ $harmonogram[0]->nazwa_harmonogramu }} @else @endif</span> {{ \Carbon\Carbon::parse($harmonogram[0]->start_dzien)->format('d-m-Y') }} / {{ \Carbon\Carbon::parse($harmonogram[0]->koniec_dzien)->format('d-m-Y') }}</h3>
@if ($harmonogram[0]->data_wizyty != "") <h5 style="padding-bottom: 10px;"> Data wizyty: <span class="badge badge-secondary">{{ \Carbon\Carbon::parse($harmonogram[0]->data_wizyty)->format('d-m-Y') }}</span></h5>@else @endif
{{-- <div class="table-responsive"> --}}
<div class="row">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><i class="fas fa-calendar-day"></i></th>
        @foreach ($typ_posilku as $klucz => $posilek)
          <th>@if ($posilek[0] == 'Woda') <i class="fas fa-tint"></i> @else <i class="fas fa-utensils"></i>@endif {{ $posilek[0] }}</th>
        @endforeach
        @role('admin')<th><i class="far fa-comments"></i></th>@endrole
      </tr>
    </thead>
    <tbody>
      @foreach ($daty as $key => $value)
      <tr>
      <th >
        {{ \Carbon\Carbon::parse($value)->format('d-m-Y') }}<br>
        {{ \Carbon\Carbon::parse($value)->formatLocalized('%A') }}
        @if ($opis_dnia != null)
        @foreach ($opis_dnia as $klucz => $dzien)
          @if (\Carbon\Carbon::parse($value)->formatLocalized('%A') == $klucz)
            <br>{{ $dzien }}
          @endif
        @endforeach
        @endif
      </th>
        @foreach ($typ_posilku as $klucz => $posilek)
          @if ($posilki->has($key))
            <td> @if ($posilki[$key]->has($klucz)) @if ($posilek[0] != 'Woda' AND $posilek[0] != 'Przekąska')
              <p class="font-weight-bold">{{ \Carbon\Carbon::parse($posilki[$key][$klucz]->data_godzina)->format('H:i') }}</p>@endif {{ $posilki[$key][$klucz]->opis }} @endif   @if ($posilki[$key]->has($klucz) && $posilki[$key][$klucz]->uwagi != null)
                  <div class="alert alert-warning" style="margin-top: 10px" >
                    {{ $posilki[$key][$klucz]->uwagi }}
                  </div>
                @endif </td>
          @endif
        @endforeach
        @role('admin')
        <td>
          @if ($posilki->has($key))
            @if ($posilki[$key]->has($klucz))
              <a href="" class="btn btn-warning btn-sm" data-dzien="{{ $key }}"
              data-harmonogram_id="{{ $harmonogram[0]->id }}" data-nazwa="{{ $posilek[0] }}" data-user="{{ $harmonogram[0]->user_id }}"
              @php ($posilkiId = [])
              @foreach ($typ_posilku as $klucz => $posilek)
                @php ($posilkiId[$posilek[0]] = $posilki[$key][$klucz]->id . '-' . $posilek[0] )
              @endforeach
              data-id="{{ implode(',', $posilkiId) }}" data-toggle="modal" data-target="#exampleModal">Uwagi</a>
            @endif
          @endif


          {{-- <a href="" class="btn btn-warning btn-sm" data-dzien=""
          data-harmonogram_id="{{ $harmonogram[0]->id }}" data-nazwa="{{ $posilek[0] }}" data-user="{{ $harmonogram[0]->user_id }}"
          data-id="" data-toggle="modal" data-target="#exampleModal">Uwagi</a> --}}
        </td>
        @endrole
      </tr>
      @endforeach
    </tbody>
    </table>
  {{-- </div> --}}
</div>

{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Uwagi do posiłków</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action=""  method="post" id="uwagi">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Rodzaj posiłku:</label>
            <select class="form-control" id="posilekId" class="posilekId" required>
            </select>
            <div style="margin-top:10px" id="p" class="alert alert-danger hid" role="alert">
              Wybierz rodzja posiłku!
            </div>
            <label for="message-text" class="col-form-label">Treść uwagi:</label>
            <textarea class="form-control" rows="4" id="message-text" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Anuluj</button>
        <button type="button" class="btn btn-primary btn-sm" id="zapisz">Zapisz</button>
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
<script>
  $('.btn-warning').on('click', function(e) {
    $('#posilekId').empty().append('<option>-- Wybierz --</option>');
    var posilkiId = $(this).data('id').split(',');
    var r = new Array();
    $.each(posilkiId, function (i, item) {
      r[i] = item.split('-');
    });
    $.each(r, function (key, val) {
      $('#posilekId').append($('<option>', {
          value: val[0],
          text : val[1]
      }));
    });
    var idPosilku;
    $('#posilekId').change(function(){
      idPosilku = $(this).val();
    });
    var nazwaPosilku = $(this).data('nazwa');
    var idHarmonogram = $(this).data('harmonogram_id');
    var dzien = $(this).data('dzien');
    var userId = $(this).data('user');
    // $('#exampleModalLabel').html('Uwagi do: ' + nazwaPosilku);
    e.preventDefault();
    $('#zapisz').on('click', function(e) {
      var trescUwagi = $.trim($("#message-text").val());
      if(idPosilku == '-- Wybierz --') {
        $('#p').removeClass("hid");
      }
      $.ajax({
          url: '{!! route('dodajUwagi', ['', '', '']) !!}' + '/' + idPosilku + '/' + trescUwagi + '/' + dzien,
          type:"POST",
          dataType:"json",
          data: {
            _token: '{!! csrf_token() !!}',
          },
          success:function(data) {
            console.log('zapisano, OK');
            window.location.replace('/dieta/szczegoly-harmonogramu/' + idHarmonogram + '/' + userId);
          },
      });
    });
  });
</script>
@endsection
