@extends('layouts.app')

@section('title', 'PatuhID')
@section('body-class', 'index-page')

@section('content')
  @include('section.slider')
  @include('section.layanan')
  @include('section.berita')
@endsection
