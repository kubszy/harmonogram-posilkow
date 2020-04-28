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
</style>

<?php $newLocale = setlocale(LC_TIME, 'pl_PL.UTF-8'); ?>
<h3 style="padding-bottom: 10px;">Szczegóły harmonogramu <br><span class="badge badge-secondary"> {{ $harmonogram[0]->nr_tygodnia }} @if ($harmonogram[0]->nazwa_harmonogramu != "") / {{ $harmonogram[0]->nazwa_harmonogramu }} @else @endif</span> {{ \Carbon\Carbon::parse($harmonogram[0]->start_dzien)->format('d-m-Y') }} / {{ \Carbon\Carbon::parse($harmonogram[0]->koniec_dzien)->format('d-m-Y') }}</h3>
@if ($harmonogram[0]->data_wizyty != "") <h5 style="padding-bottom: 10px;"> Data wizyty: <span class="badge badge-secondary">{{ \Carbon\Carbon::parse($harmonogram[0]->data_wizyty)->format('d-m-Y') }}</span></h5>@else @endif
<div class="row">
  <div class="col-md-auto">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      @foreach ($daty as $key => $value)
        <a class="nav-link
        {{-- {{ session('dzien') == $key ? 'active' : '' }} --}}
        {{ session('dzien') == $key ? 'active' : '' }} {{ !session('dzien') && $key == 1 ? 'active' : '' }}" id="v-pills-{{ $key }}-tab"
        data-toggle="pill" href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}" >Dzień {{ $key }} {{ \Carbon\Carbon::parse($value)->formatLocalized('%A') }} <br>
        @if ($opis_dnia != null)
        @foreach ($opis_dnia as $klucz => $dzien)
          @if (\Carbon\Carbon::parse($value)->formatLocalized('%A') == $klucz)
            {{ $dzien }}
          @endif
        @endforeach
        @endif
      </a>
      @endforeach
    </div>
    {{-- {{dd(Session::get('dzien'))}} --}}
  </div>
  <div class="col">
    <div class="tab-content" id="v-pills-tabContent">
      @foreach ($daty as $k => $v)
        <div class="tab-pane fade {{ session('dzien') == $k ? 'show active' : '' }} {{ !session('dzien') && $k == 1 ? 'show active' : '' }}" id="v-pills-{{ $k }}" role="tabpanel" aria-labelledby="v-pills-{{ $k }}-tab">
          <h5>Data: {{ \Carbon\Carbon::parse($v)->format('d-m-Y') }}</h5><div class="hr-line-dashed"><hr></div>
          <form action="{{ route('dodajPosilek') }}" id="{{ $k }}" method="post">
            @csrf
            @foreach ($typ_posilku as $klucz => $posilek)
            <div class="form-group row">
              <label for="" class="col-sm-2 col-form-label">@if ($posilek[0] == 'Woda') <i class="fas fa-tint fa-2x"></i> @else <i class="fas fa-utensils fa-2x"></i>@endif &nbsp; {{ $posilek[0] }}</label>
              <div class="col-sm-4">
                <input name="dzien" type="hidden" value="{{ $k }}">
                <input name="harmonogram_id" type="hidden" value="{{ $harmonogram[0]->id }}">
                <input name="{{ $posilek[1] }}_id" type="hidden" value="{{ $klucz }}">
                @if ($posilki->has($k))
                  <textarea class="form-control" rows="6" name="{{ $posilek[1] }}"  @if ($posilki[$k]->has($klucz)) disabled @endif>  @if ($posilki[$k]->has($klucz)) {{ $posilki[$k][$klucz]->opis }} @endif </textarea>
                  @if ($posilki[$k]->has($klucz) && $posilki[$k][$klucz]->uwagi != null)
                    <div class="alert alert-warning" style="margin-top: 10px" >
                      {{ $posilki[$k][$klucz]->uwagi }}
                    </div>
                  @endif
                @else
                  <textarea class="form-control" rows="6" name="{{ $posilek[1] }}"> </textarea>
                @endif
              </div>
              @if ($posilek[1] == 'woda')
              @elseif ($posilek[1] == 'przekaska')
              @else
              <div class="col-sm-1 input-group clockpicker">
                <div class="input-group clockpicker">
                  <label for="" class="col-sm-2 col-form-label"><i class="far fa-clock fa-2x"></i></label>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="input-group clockpicker" data-autoclose="true">
                  @if ($posilki->has($k))
                    <input type="text" autocomplete="off" name="{{ $posilek[1] }}_godzina" class="form-control" @if ($posilki[$k]->has($klucz)) disabled @endif @if ($posilki[$k]->has($klucz)) value="{{\Carbon\Carbon::parse($posilki[$k][$klucz]->data_godzina)->format('H:i') }}" @endif>
                  @else
                    <input type="text" autocomplete="off" name="{{ $posilek[1] }}_godzina" class="form-control" value="">
                  @endif
                </div>
              </div>
              @endif
              @role('admin')
              <div class="col-sm-2">
                @if ($posilki->has($k) && $posilki[$k]->has($klucz) && $posilki[$k][$klucz]->uwagi != null)
                @else
                @if ($posilki->has($k))  @if ($posilki[$k]->has($klucz)) <a href="" class="btn btn-warning btn-sm" data-dzien="{{ $k }}"
                  data-harmonogram_id="{{ $harmonogram[0]->id }}" data-nazwa="{{ $posilek[0] }}" data-user="{{ $harmonogram[0]->user_id }}"
                  data-id="{{ $posilki[$k][$klucz]->id }}" data-toggle="modal" data-target="#exampleModal">Uwagi !</a> @endif @endif
                @endif
              </div>
              @endrole
            </div>
            <div class="hr-line-dashed"><hr></div>
            @endforeach
          <div class="form-group col-sm-6">
            <a class="btn btn-secondary btn-sm" href="{{ route('index') }}">Powrót</a>
            @role('user')
            <button class="btn btn-primary btn-sm has-error" @if ($posilki->has($k) && $posilki[$k]->count() == 7) disabled @endif>Zapisz</button>
            @endrole
          </div>
          </form>
        </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Uwagi do </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action=""  method="post">
          <div class="form-group">
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
    var idPosilku = $(this).data('id');
    var nazwaPosilku = $(this).data('nazwa');
    var idHarmonogram = $(this).data('harmonogram_id');
    var dzien = $(this).data('dzien');
    var userId = $(this).data('user');
    $('#exampleModalLabel').html('Uwagi do: ' + nazwaPosilku);
    e.preventDefault();
    $('#zapisz').on('click', function(e) {
      var trescUwagi = $.trim($("#message-text").val());
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

<script>
  $('.clockpicker').clockpicker();
</script>
@endsection
