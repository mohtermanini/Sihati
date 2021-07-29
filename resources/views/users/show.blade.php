@extends('layouts.app')

@section('content')

<main class="flex-grow-1 mt-5">
    <section class="container">
       
      <div class="card">
        <div class="card-body">
            <div class="text-center me-4" style="float: right;">
              <img src="{{ asset($user->profile->avatar) }}" class="rounded-circle" width="75"
              height="75">
          </div>
          <div>
              <h2 style="font-size: 1.4rem;">
                {{$user->profile->titleFromGender()}}
                {{ $user->profile->getFullName() }}
              </h2>
              <hr>
              {{ $user->profile->description }}
          </div>
        </div>
      </div>
               
           
        <div class="card">
         
        </div>
    </section>
</main>
@endsection
