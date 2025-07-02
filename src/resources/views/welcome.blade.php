@extends('layouts.app')

@section('title', 'PatuhID')
@section('body-class', 'index-page')

@section('content')
  @include('section.slider')
  @include('section.about')
  @include('section.peraturan')
@endsection
