@extends('layouts.app')

@section('styles')
  <style>
    .form-group{
      margin-top: 1rem;
    }
    
  </style>
@endsection
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
                @if( $user->profile->description == null)
                  <p class="text-danger text-center pb-0">لم يقم الطبيب/ة بكتابة وصف بعد</p>
                @else
                  {{ $user->profile->description }}
                @endif
          </div>
          <hr>
          <div class="container-fluid">
            @if($user->profile->email_visible)
            <div class="form-group row ">
              <div class="col-sm-4 col-md-3 flex-center justify-content-start justify-content-sm-center">
                <label for="email" class="col-form-label">البريد الاكتروني</label>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <input type="text" class="form-control text-end" value="{{$user->email}}" readonly>
              </div>
            </div>
            @endif
            @if($user->profile->birthday_visible)
            <div class="form-group row">
              <div class="col-sm-4 col-md-3 flex-center justify-content-start justify-content-sm-center">
              <label for="birthday" class="col-form-label">تاريخ الميلاد</label>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <input type="date" class="form-control" value="{{$user->profile->birthday}}" readonly>
              </div>
            </div>
            @endif
            <div class="form-group">
              <label class="form-label fw-bold text-warning">التخصصات</label>
              <ul class="mt-2 list-unstyled">
              @foreach($user->profile->jobs as $job)
              <li class="d-inline-block mb-3">
                  <button type="button" class="btn btn-outline-info me-2 btn-sm rounded-pill">
                  {{$job->title}}  
                  </button>
              </li>
              @endforeach
              </ul>
          </div>

          </div>
        </div>
      </div>
               
           
        <div class="card">
         
        </div>
    </section>
</main>
@endsection
