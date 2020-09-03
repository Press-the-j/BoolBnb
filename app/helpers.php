<?php
 
use App\Flat;
 
function control_slug($slug)
{
    // !CONTROLLO CHE NON SI GENERINO 2 SLUG UGUALI
    //devo vedere se nel db c'e' gia uno slug uguale
    $findSlug =Flat::where('slug', $slug)->first();
    $originalSlug = $slug;
    $counter = 0;
    //se c'e' tramite un contatore aggiunto 1 allo slug corrente
    while ($findSlug) {
        $counter++;
        $slug = $originalSlug . '-' . $counter;
        //rifaccio il controllo fino a quando non lo trovo piu
        $findSlug =Flat::where('slug', $slug)->first();
    };
 
    return $slug;
}
 
function update_control_slug($slug, $flat)
{
    // !CONTROLLO CHE NON SI GENERINO 2 SLUG UGUALI
    //devo vedere se nel db c'e' gia uno slug uguale
    $findSlug =Flat::where('slug', $slug)->first();
   /*  dd($flat->id); */

    $originalSlug = $slug;
    $counter = 0;
    //se c'e' tramite un contatore aggiunto 1 allo slug corrente
    //!controllo anche che lo slug gia esistente non sia quello del Flat che sto editando
    while ($findSlug && $findSlug->id != $flat->id) {
        $counter++;
        $slug = $originalSlug . '-' . $counter;
        //rifaccio il controllo fino a quando non lo trovo piu
        $findSlug =Flat::where('slug', $slug)->first();
    };
 
    return $slug;
}