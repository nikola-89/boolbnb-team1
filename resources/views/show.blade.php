@extends('layouts.app')

@section('content')


<div class="container">

    <div>
        <a class="btn btn-secondary mb-3" href="{{route("home")}}">Indietro</a>
    </div>
    <div class="card m-2">
        <div class="card-body">
            <img class="card-img-top " src="{{asset('storage/' . $apartment->cover_img)}}" alt="{{$apartment->title}}">
            <div class="d-flex justify-content-between">
                <h2 class="card-title mt-3"> {{$apartment->title}}</h2>
                <h2 class="card-title mt-3 text-primary"> {{$apartment->price}} Euro</h2>
            </div>
            <p class="card-text"> {{$apartment->description}}</p>
        </div>
    </div>

    <div class="d-flex flex-row ">
        <div class="card m-2 col-md-2">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center"> Numero stanze</h4>
                <p class="card-text text-center"> {{$apartment->n_rooms}}</p>
            </div>
        </div>
        <div class="card m-2 col-md-2">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center"> Numero Bagni</h4>
                <p class="card-text text-center"> {{$apartment->n_baths}}</p>
            </div>
        </div>
        <div class="card m-2 col-md-2">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center"> Metri quadri</h4>
                <p class="card-text text-center"> {{$apartment->sq_meters}}</p>
            </div>
        </div>
        <div class=" m-2 col-md-5">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center"> Indirizzo</h4>
                <p class="card-text text-center"> {{$apartment->address}}</p>
            </div>
        </div>
    </div>
    <div class="btn-toolbar col-md-12  ">
        <h3 class="card-text"> Servizi Aggiuntivi:</h3>
        @forelse ($apartment->services as $service)
          <h3 class="badge badge-primary m-2">{{$service->title}}</h3>
        @empty
          <p>Nessun servizio aggiuntivo</p>
        @endforelse
    </div>
</div>


@endsection
