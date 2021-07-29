

@extends('layouts.app')

@section('content')

<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <p class="mb-0" style="direction: ltr;">
			This is a demo website, play with it as you like.
			<br>
			This box won't be displayed when site is alive (to login as admin enter username: admin, 
			password: 123)
	</p>
		<button type="button" class="btn-close" style="right:0;" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- Login form -->
<section class="d-flex flex-grow-1 justify-content-center align-items-center my-5">
	<div class="card w-50">
		<div class="card-header">
			<h3 class="text-center">تسجيل الدخول</h3>
		</div>
		<div class="card-body">
			<form action="{{ route('login.check') }}" method="post">
                @csrf
				<input type="text" class="form-control text-start box-shadow-none mt-5"
						 name="emailOrUserName" placeholder="اسم المستخدم أو البريد الالكتروني" 
                         value="{{old('emailOrUserName')}}" required autofocus>
				<input type="password" class="form-control mt-3 box-shadow-none" name="password"
						 placeholder="كلمة المرور" required>
				<div class="form-group text-center">
				<button type="submit" class="btn btn-outline-success mt-3">تسجيل الدخول</button>
				</div>
			</form>
		
			<div  class="mt-5 text-center">
			<small class="text-muted">
			ليس لديك حساب؟
			<a href="{{ route('signup') }}" class="text-decoration-none text-info">سجل الآن</a>
			</small>
			</div>
		</div>
	</div>
</section>
<!-- Login form -->

@stop

        
     

           

