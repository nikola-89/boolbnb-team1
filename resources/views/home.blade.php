@extends('layouts.app')
@section('content')
<div class="container">

    @foreach ($apartments as $apartment)
    <div class="card mb-3" style="max-width: 100%;">
        <div class="row no-gutters">
            <div class="col-md-2">
                <img src="{{asset('storage/' . $apartment->cover_img)}}" class="card-img" alt="">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{$apartment->title}}</h5>
                    <p class="card-text"><small class="text-muted">{{$apartment->address}}</small></p>
                    <p class="card-text">{{$apartment->description}}</p>
                </div>
                <div class="card-body text-secondary">
                    <span class="card-title pr-2">Numero di stanze: {{$apartment->n_rooms}}</span>
                    <span class="card-title pr-2">Numero di bagni: {{$apartment->n_baths}}</span>
                    <span class="card-title pr-2">Metri quadri: {{$apartment->sq_meters}}</span>
                </div>

            </div>
            <div class="col-md-2">
                <div class="btn-group p-2 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{route("apartment.show", $apartment)}}">Visualizza</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @endsection
