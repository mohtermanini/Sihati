@extends('layouts.app')

@section('styles')
    <style>
        @media (min-width: 576px) {
            .w-sm-auto {
                width: auto;
            }
        }

        .floating-label {
            position: relative;
        }

        .floating-label label {
            position: absolute;
            top: 50%;
			right: 0.75rem;
            transform: translateY(-50%);
			cursor: text;
			transition: all 0.25s;
			color: rgba(0, 0, 0, 0.5);
        }

		.form-control:focus, .form-select:focus {
			box-shadow: none;
		}
		
		.floating-label input:focus + label  {
			color: #86b7fe;
		}

        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
			top: -12px;
			right: 0.5rem;
			background-color: #fff;
			padding: 0 0.25rem;
			transform: translateY(0);
			font-size: 0.75em;
		}

    </style>
@endsection
@section('content')
    <!-- Signup form -->
    <section class="container flex-grow-1 my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">إنشاء حساب جديد</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }} " method="post" enctype="multipart/form-data">
                            @csrf
                            <div
                                class="form-group d-flex align-items-center flex-wrap justify-content-center justify-content-sm-start mt-5">
                                <label for="" class="flex-shrink-0 me-2 mb-2">نوع الحساب</label>
                                <select name="type_id" id="userType" class="form-select form-select-sm w-auto mb-2" required>
                                    <option value="{{ Config::get('type_normal_id') }}" selected>مستخدم</option>
                                    <option value="{{ Config::get('type_doctor_id') }}">طبيب</option>
                                </select>
                            </div>
                            <p id="signup_type_header" class="fw-bold mt-3">تسجيل مستخدم جديد</p>
                            <div class="form-group row mt-3">
                                <div class="col-sm-6 mb-2">
                                    <div class="floating-label">
                                        <input type="text" class="form-control" name="fname" id="fname"
                                            value="{{ old('fname') }}" placeholder=" " autocomplete="off">
                                        <label for="fname">الاسم الأول</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2 mt-sm-0 mt-3">
									<div class="floating-label">
                                    <input type="text" class="form-control" name="lname"
										id="lname"
										value="{{ old('lname') }}"
                                        placeholder=" " autocomplete="off">
										<label for="lname">الاسم الأخير</label>
                                    </div>
                                </div>
                            </div>
							<div class="floating-label">
                            <input type="email" class="form-control text-start mt-3" name="email"
							id="email"
                                value="{{ old('email') }}" placeholder=" " required>
								<label for="email">البريد الاكتروني</label>
							</div>
							<div class="floating-label">
                            <input type="text" class="form-control text-start mt-3" name="user_name"
								id="user_name"
                                value="{{ old('user_name') }}" placeholder=" " required>
								<label for="user_name">اسم المستخدم</label>
							</div>
							<div class="floating-label">
                            <input type="password" class="form-control mt-3" name="password" 
								id="password"
								placeholder=" "
                                required>
								<label for="password">كلمة المرور</label>
							</div>
                            <div class="form-group mt-3 d-flex flex-column flex-sm-row  flex-wrap">
                                <label for="birthday" class="col-form-label me-3">تاريخ الميلاد</label>
                                <input type="date" class="form-control w-auto flex-grow-1 text-start" id="birthday"
                                    name="birthday" value="{{ old('birthday') }}" placeholder="تاريخ الميلاد">
                            </div>
                            <div class="form-group d-flex flex-column mt-3">
                                <label for="" class="form-label">اختيار صورة</label>
                                <img id="ImagePreview" src="{{ asset('files/profiles/default.png') }}"
                                    class="align-self-center rounded-circle mt-2" width="100" height="100">
                                <input type="file" id="ImageSelector" name="img" class="form-control box-shadow-none mt-2">
                            </div>
                            <div class="form-group mt-3 ms-1">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="gender" value="0"
                                        {{ old('gender') == 0 ? 'checked' : '' }}>
                                    <label for="" class="form-check-label">ذكر</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="gender" value="1"
                                        {{ old('gender') == 1 ? 'checked' : '' }}>
                                    <label for="" class="form-check-label">أنثى</label>
                                </div>
                            </div>
                            <div id="specialisations" class="d-none">
                                <div id="specialisationsLists">
                                    <div id="specialisationChoose"
                                        class="form-group d-flex align-items-center flex-wrap justify-content-center justify-content-sm-start mt-3">
                                        <label for="" class="flex-shrink-0 me-2 mb-2">اختيار تخصص</label>
                                        <select name="specialisations[]" class="form-select form-select-sm w-sm-auto mb-2">
                                            @foreach ($jobs as $job)
                                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div
                                    class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center">
                                    <button id="addSpecialisation" type="button"
                                        class="btn btn-outline-success btn-sm rounded-pill mt-3 me-2">إضافة تخصص آخر
                                        +</button>
                                    <button id="removeSpecialisation" type="button"
                                        class="btn btn-outline-danger btn-sm rounded-pill mt-3 d-none">إزالة تخصص -</button>
                                </div>
                            </div>
                            <div id="sectionDescription" class="d-none">
                                <textarea id="taDescription" name="description" class="form-control mt-3 box-shadow-none"
                                    cols="30" rows="10" placeholder="اكتب وصف عنك...">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-outline-success mt-3">إنشاء حساب</button>
                            </div>
                        </form>
                        <div class="mt-5 text-center">
                            <small class="text-muted">
                                لديك حساب؟
                                <a href="{{ route('login') }}" class="text-decoration-none text-info">تسجيل الدخول</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup form -->
@endsection

@section('scripts')
    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            $("#userType").change(function() {
                var userType = $("#userType").val();
                if (userType == {{ Config::get('type_normal_id') }}) {
                    $("#signup_type_header").text("تسجيل مستخدم جديد");
                    $("#taDescription").val("");
                    $("#sectionDescription").addClass("d-none");
                    $("#specialisations").addClass("d-none");
                } else if (userType == {{ Config::get('type_doctor_id') }}) {
                    $("#signup_type_header").text("تسجيل طبيب جديد");
                    $("#sectionDescription").removeClass("d-none");
                    $("#specialisations").removeClass("d-none");
                }
            });
            let old_type = parseInt({{ old('type_id') }});
            if (!isNaN(old_type)) {
                $("#userType").val(old_type).change();
            }

            let chooseSpecialisationNum = 1;
            let specialisationsNum = {{ $jobs->count() }};
            $("#addSpecialisation").click(function() {
                ++chooseSpecialisationNum;
                let newSpecialisation = $("#specialisationChoose").clone();
                newSpecialisation.attr("id", "specialisationChoose" + chooseSpecialisationNum);
                newSpecialisation.appendTo($("#specialisationsLists"));
                $("#removeSpecialisation").removeClass("d-none");
                $("#removeSpecialisation").addClass("d-inline-block");
                if (chooseSpecialisationNum == specialisationsNum) {
                    $("#addSpecialisation").addClass("d-none");
                }
            });
            $("#removeSpecialisation").click(function() {
                $("#specialisationChoose" + chooseSpecialisationNum).remove();
                --chooseSpecialisationNum;
                if (chooseSpecialisationNum == 1) {
                    $("#removeSpecialisation").addClass("d-none");
                    $("#removeSpecialisation").removeClass("d-inline-block");
                }
                if (chooseSpecialisationNum < specialisationsNum) {
                    $("#addSpecialisation").removeClass("d-none");
                }
            });

        });
    </script>
    <!-- Scripts -->
    @include('includes.scripts.image_preview')
@endsection
