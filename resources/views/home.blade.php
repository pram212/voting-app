@extends('layouts.main')

@section('header-content', 'HOME')
@section('title', 'HOME')

@section('content')
    <h1>Selamat Datang, {{ ucwords(auth()->user()->name) }}</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet adipisci tenetur atque beatae provident voluptate quia exercitationem illum harum dolorem iusto officiis, fuga excepturi accusamus alias enim? Ad, dolorem eligendi.</p>
@endsection
