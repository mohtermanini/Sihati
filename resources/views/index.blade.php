
@extends('layouts.app')
@section('content')

<!-- Slides -->
@include('index_includes.slides')
<!-- Slides -->

<hr class="container bg-secondary mt-5" style="height: 2px;">

<!-- Site Sections --> 
@include('index_includes.sections')
<!-- Site Sections --> 

<!-- Most viewed posts -->
@include('index_includes.most_viewed_posts')
<!-- Most viewed posts -->

<!-- consultations --> 
@include('index_includes.consultations')
<!-- consultations --> 

@stop