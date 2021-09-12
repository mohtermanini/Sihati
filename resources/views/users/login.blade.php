

@extends('layouts.app')

@section('styles')
<style>
	input{
		margin-top: 0.5rem;
		box-shadow: none !important;
	}
	@media only screen and (max-width: 400px) {
		input::placeholder{
			color:#fff !important;
		}
		input{
			border-radius: 0 !important;
			border-width: 0 0 1px 0 !important;
			padding-right: 0 !important;
		}
		.col-10{
			width: 90% !important;
		}
	}
	.form-group{
			margin-top: 1rem;
	}
</style>

@stop
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
	<div class="container-fluid">
	<div class="row justify-content-center">
	<div class="col-10 col-sm-7 col-md-6 col-lg-4">
	<div class="card">
		<div class="card-header">
			<h3 class="text-center">تسجيل الدخول</h3>
		</div>
		<div class="card-body">
			<form action="{{ route('login.check') }}" method="post">
                @csrf
				<div class="from-group">
					<label for="emailOrUserName" class="form-label">اسم المستخدم أو البريد الالكتروني</label>
				<input type="text" class="form-control text-start box-shadow-none 
						{{Session::has('emailOrUserName')?'is-invalid':''}}"
						 name="emailOrUserName" id="emailOrUserName" placeholder="اسم المستخدم أو البريد الالكتروني" 
                         value="{{session()->get('emailOrUserName')}}" required autofocus>
						@if(Session::has('emailOrUserName'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ Session::get('failed') }}</strong>
							</span>
						@endif
				</div>
				<div class="form-group">
					<label for="password">كلمة المرور</label>
					<input type="password" class="form-control box-shadow-none" name="password"
						id="password" placeholder="كلمة المرور" required>
				</div>
				<div class="form-group text-center recapatcha-container">
					<div class="g-recaptcha d-inline-block"
					data-size	="normal"
					data-sitekey="6LebfmAcAAAAABu4maMwoPvtd4NN7uCzTbmEFaF9"></div>
				</div>
				<div class="form-group text-center">
				<button type="submit" class="btn btn-outline-success">تسجيل الدخول</button>
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
	</div>
</div></div>
</section>
<!-- Login form -->

@stop


@section('scripts')
		<script>
			$(document).ready(function(){
				let d = 1360;
				let recapatchaResize = ()=>{
				let width = document.documentElement.clientWidth;
				let resizeScreenSizeBreakpoint = 450;
				/*
				if(width <= resizeScreenSizeBreakpoint){
					$(".g-recaptcha").attr("data-size","compact");
				}else{
					$(".g-recaptcha").attr("data-size","normal");
				}
				*/
				let x = width/d;
				$(".g-recaptcha").css("transform","scale("+x+ ")");
			}
			recapatchaResize();
			window.onresize = recapatchaResize;
			});
		</script>
		<script src="https://www.google.com/recaptcha/api.js?hl=ar" async defer></script>

@endsection
        
     

           

