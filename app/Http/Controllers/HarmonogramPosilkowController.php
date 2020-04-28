<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Harmonogram;

use App\Posilek;

use Carbon\Carbon;

use DateTime;

use Auth;

use App\User;

class HarmonogramPosilkowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index (Request $request)
    {
      $user = Auth::user();
      if ($user->hasRole('admin') OR $user->hasRole('podglad')) {
        $harmonogramy = Harmonogram::all()->groupBy('user_id');
        $ile = $harmonogramy->count();
        foreach ($harmonogramy as $key => $value) {
          $ile_harmonogramow[] = $value->count();
          $data_ostatniej_wizyty[] = $value->last()->data_wizyty;
          $ostatnia_waga[] = $value->last()->masa_ciala;
        }

        $klienci = User::where('name', '!=' , 'dietetyk')->get(['name', 'id']);

        return view('harmonogramPosilkow.indexAdmin', compact('klienci', 'ile', 'ile_harmonogramow', 'data_ostatniej_wizyty', 'ostatnia_waga'));
      } else {
        $harmonogramy = Harmonogram::where('user_id', Auth::User()->id)->get(); //->orderBy('start_dzien', 'DESC')
        $ile = $harmonogramy->count();

        $ileUwag = Posilek::where('uzytkownik_id', Auth::User()->id)->where('uwagi', '!=' , '')->get()->groupBy('harmonogram_id');
        foreach ($ileUwag as $key => $value) {
          $ileUwag[$key] = $value->count();
        }

        if ($ile >= 2) {
          $masa_start = $harmonogramy->first();
          $masa_ostatnia = $harmonogramy->last();
          $straconeKg = (float)$masa_start->masa_ciala - (float)$masa_ostatnia->masa_ciala;
        }else{
          $straconeKg = 0;
        }
        $uzytkownik = $user->name;
        $request->session()->forget('dzien');
        $request->session()->forget('posilek');
        return view('harmonogramPosilkow.index', compact('harmonogramy', 'ile', 'straconeKg', 'uzytkownik', 'ileUwag'));
      }
    }

    public function dodaj ()
    {
        return view('harmonogramPosilkow.dodaj');
    }

    public  function dodajPost (Request $request)
    {
        $request->validate([
        'ilosc_dni' => 'required|numeric',
        'masa_ciala' => 'required|numeric',
        'start_dzien' => 'required',
        'data_wizyty' => 'required',
        // 'nazwa_tygodnia' => 'string'
        ],
        [
          'ilosc_dni.required' => 'Pole nie może być puste.',
          'ilosc_dni.numeric' => 'Pole musi być liczbą.',
          'masa_ciala.required' => 'Pole nie może być puste.',
          'masa_ciala.numeric' => 'Pole musi być liczbą.',
          'data_wizyty.required' => 'Pole nie może być puste.',
          'start_dzien.required' => 'Pole nie może być puste.',
          // 'nazwa_tygodnia.string' => 'Pole musi być ciągiem znaków.'
        ]);

        $start_dzien = new Carbon($request->start_dzien);
        $koniec_dzien = $start_dzien->copy()->addDay($request->ilosc_dni - 1);
        $nr_tygodnia = Harmonogram::latest('created_at')->where('user_id', Auth::User()->id)->pluck('nr_tygodnia')->first();
        if ($nr_tygodnia == null) {
            $nr_tygodnia = 1;
        } elseif ($nr_tygodnia >= 1) {
            $nr_tygodnia++;
        }

        $opis_dnia = ['poniedziałek' => $request->poniedzialek, 'wtorek' => $request->wtorek, 'środa' => $request->sroda, 'czwartek' => $request->czwartek, 'piątek' => $request->piatek,
        'sobota' => $request->sobota, 'niedziela' => $request->niedziela];
        $opis_dnia = json_encode($opis_dnia);

        $data_wizyty = new Carbon($request->data_wizyty);
        $tydzien = new Harmonogram();
        $tydzien->nr_tygodnia = $nr_tygodnia;
        $tydzien->ilosc_dni = $request->ilosc_dni;
        $tydzien->nazwa_harmonogramu = $request->nazwa_harmonogramu;
        $tydzien->start_dzien = $start_dzien;
        $tydzien->koniec_dzien = $koniec_dzien;
        $tydzien->data_wizyty = $data_wizyty;
        $tydzien->masa_ciala = $request->masa_ciala;
        $tydzien->bmi = $request->bmi;
        $tydzien->talia = $request->talia;
        $tydzien->pass = $request->pass;
        $tydzien->biodra = $request->biodra;
        $tydzien->opis_dnia = $opis_dnia;
        $tydzien->user_id = $uzytkownik_id = Auth::User()->id;
        $tydzien->save();

        $request->session()->forget('dzien');
        $request->session()->forget('posilek');
        return redirect()->route('index');
    }

    public function usun ($id)
    {
        $tygodnie = Harmonogram::where('id', $id)->delete();
        $posilki = Posilek::where('harmonogram_id', $id)->delete();

        return json_encode($tygodnie);
    }

    public function szczegoly (Request $request, $id, $userId = null)
    {
        if ($userId != null) {
          $user = $userId;
        } else {
          $user = Auth::User()->id;
        }
        $harmonogram = Harmonogram::where('user_id', $user)->where('id', $id)->get();
        $start_dzien = new Carbon($harmonogram[0]->start_dzien);
        $koniec_dzien = new Carbon($harmonogram[0]->koniec_dzien);

        $opis_dnia = json_decode($harmonogram[0]->opis_dnia);

        $daty = array();
        $y = 0;
        for ($i = $start_dzien; $i <= $koniec_dzien; $i->addDay()){
            $y ++;
            $daty[$y] = $start_dzien->toDateString();
        }
        $typ_posilku = array('0' => ['Śniadanie', 'sniadanie'], 1 => ['II śniadanie','II_sniadanie'], 2 => ['Obiad', 'obiad'], 3 => ['Podwieczorek', 'podwieczorek'], 4 => ['Kolacja', 'kolacja'], 5 => ['Woda', 'woda'], 6 => ['Przekąska', 'przekaska'] );

        foreach ($daty as $key => $value) {
          if  ($value == \Carbon\Carbon::now()->format('Y-m-d'))
            if ($request->session()->get('posilek') != 'tak') {
              $request->session()->put('dzien', $key);
            }
        }

        $posilki = Harmonogram::findOrFail($id)->posilek->groupBy('dzien');

        // dd($posilki);

        foreach ($posilki as $key => $value) {
            $posilki[$key] = collect($posilki[$key]->keyBy('posilek_id'));
        }

         $user = Auth::user();
         if ($user->hasRole('admin')  OR $user->hasRole('podglad')) {
           return view('harmonogramPosilkow.szczegoly_v2', compact('harmonogram', 'typ_posilku', 'daty', 'posilki', 'opis_dnia'));
         } else {
           return view('harmonogramPosilkow.szczegoly', compact('harmonogram', 'typ_posilku', 'daty', 'posilki', 'opis_dnia'));
         }
    }

    public function dodajPosilekPost (Request $request)
    {
        // dd($request->input());
        foreach ($request->input() as $key => $value) {
            if ($key == 'dzien') continue;
            if ($key == 'harmonogram_id') continue;
            if ($key == '_token') continue;
            if (strpos($key, '_godzina') !== false) {
                continue;
            }
            if (strpos($key, '_id') !== false) {
                continue;
            }

            if ($value == null) {
                continue;
            } else {
                $request->session()->put('posilek', 'tak');
                $request->session()->put('dzien', $request->get('dzien'));
                $posilek = new Posilek();
                $posilek->harmonogram_id = $request->get('harmonogram_id');
                $posilek->dzien = $request->get('dzien');
                $posilek->posilek_id = $request->get($key . '_id');
                $posilek->typ_posilku = $key;
                $posilek->opis = $value;
                $posilek->data_godzina = \Carbon\Carbon::now()->format('Y-m-d') . ' ' . $request->get($key . '_godzina');
                $posilek->uzytkownik_id = Auth::User()->id;
                $posilek->save();
            }
        }

        return redirect()->route('szczegoly', [$request->get('harmonogram_id'), Auth::User()->id]);
    }

    public function dodajUwagiPost (Request $request, $idPosilku, $trescUwagi, $dzien)
    {
      $request->session()->put('dzien', $dzien);
      $posilek = Posilek::where('id', $idPosilku)->update(['uwagi' => $trescUwagi]);

      return json_encode($posilek);
    }

    public function listaHarmonogramow (Request $request, $id)
    {
      $user = Auth::user();
      if ($user->hasRole('admin') OR $user->hasRole('podglad')) {
        $harmonogramy = Harmonogram::where('user_id', $id)->get();
        
        $ileUwag = Posilek::where('uzytkownik_id', $id)->where('uwagi', '!=' , '')->get()->groupBy('harmonogram_id');
        foreach ($ileUwag as $key => $value) {
          $ileUwag[$key] = $value->count();
        }
        // dd($harmonogramy);
        $ile = $harmonogramy->count();
        if ($ile >= 2) {
          $masa_start = $harmonogramy->first();
          $masa_ostatnia = $harmonogramy->last();
          $straconeKg = (float)$masa_start->masa_ciala - (float)$masa_ostatnia->masa_ciala;
        }else{
          $straconeKg = 0;
        }
        $uzytkownik = User::where('id', $id)->get();
        $uzytkownik = $uzytkownik[0]->name;
        $request->session()->forget('dzien');
        return view('harmonogramPosilkow.listaHarmonogramow', compact('harmonogramy', 'ile', 'straconeKg', 'uzytkownik', 'ileUwag'));
      }
    }


}
