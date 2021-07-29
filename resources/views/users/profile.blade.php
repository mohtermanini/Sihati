@extends('layouts.app')

@section('content')


<main class="flex-grow-1 mt-5">
    <section class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset($user->profile->avatar) }}" class="rounded-circle" width="75"
                                height="75" alt="">
                            <p class="mt-2 mb-0 fw-bold">
                                {{ $user->profile->first_name }}
                                {{ $user->profile->last_name }}
                            </p>
                            <p class="mb-0 fw-bold">
                                {{ $user->user_name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
				
            <div class="col-md-8">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item">
                        <button class="nav-link text-info btnTab active" data-bs-toggle="tab" 
												data-bs-target="#profile">الملف
                            الشخصي</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark btnTab" data-bs-toggle="tab"
                            data-bs-target="#consultations">الاستشارات الطبية</button>
                    </li>
                    @if($user->type_id != Config::get('type_normal_id'))
                        <li class="nav-item">
                            <button class="nav-link text-dark btnTab" data-bs-toggle="tab"
                                data-bs-target="#posts">المقالات</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="profile">
                        <div class="card">
                            <div class="card-body">
                                <form id="personalForm" action="{{ route('users.update') }}"
                                    method="post">
                                    @csrf
                                    @method("PUT")
                                    <div class="form-group">
                                        <label for="" class="form-label">الاسم الأول</label>
                                        <input type="text" class="form-control  box-shadow-none" name="fname"
                                            value="{{ $user->profile->first_name }}" placeholder="الاسم الأول"
                                            autocomplete="off" readonly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="" class="form-label">الاسم الأخير</label>
                                        <input type="text" class="form-control box-shadow-none" name="lname"
                                            value="{{ $user->profile->last_name }}" placeholder="الاسم الأخير"
                                            autocomplete="off" readonly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="" class="form-label">البريد الالكتروني</label>
                                        <input type="email" class="form-control text-start  box-shadow-none" name="email"
                                            value="{{ $user->email }}" placeholder="البريد الالكتروني" required
                                            readonly>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="" class="form-label">اسم المستخدم</label>
                                        <input type="text" class="form-control  box-shadow-none" name="user_name"
                                            value="{{ $user->user_name }}" placeholder="اسم المستخدم" required
                                            readonly>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="" class="form-label">تاريخ الميلاد</label>
                                        <input type="date" class="form-control text-start  box-shadow-none" name="birthday"
                                            value="{{ $user->profile->birthday }}" placeholder="تاريخ الميلاد"
                                            readonly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="" class="form-label">الجنس</label>
                                        <select name="gender" id="" class="form-select box-shadow-none" required disabled>
                                            <option value="0"
                                                {{ $user->profile->gender==0?'selected':'' }}>
                                                ذكر</option>
                                            <option value="1"
                                                {{ $user->profile->gender==1?'selected':'' }}>
                                                أنثى</option>
                                        </select>
                                    </div>
                                    @if($user->type_id != Config::get('type_normal_id'))
                                    <div class="form-group mt-3">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" class="form-control box-shadow-none" rows="7" placeholder="الوصف"
                                            readonly>{{$user->profile->description}}</textarea>
                                    </div>
                                    @endif
                                    @if($user->type_id == Config::get('type_doctor_id'))
                                    <div class="form-group mt-3">
                                        <label class="form-label">التخصصات</label>
                                        <ul class="mt-3 list-unstyled">
                                        @foreach($user->profile->jobs as $job)
                                        <li class="d-inline-block mb-3">
                                            <button class="btn btn-outline-info me-2 btn-sm rounded-pill">
                                            {{$job->title}}  
                                            </button>
                                        </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group text-center mt-3">
                                        <button type="button" id="btnSubmit" class="btn btn-primary">تعديل
                                            البيانات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="consultations">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                <p class="mb-0 fw-bold">لديك سؤال وتحتاج إلى استشارة؟</p>
                                <a href="{{ route('consultations.create') }}"
                                    class="btn btn-outline-success">اسأل طبيب</a>
                            </div>
                        </div>
                        <h4 class="text-center mt-4">جميع استشاراتك</h4>
                        <!-- Consultations -->
                        @if($consultations->count() == 0)
                        <div class="d-flex justify-content-center align-items-center h-100 mt-5">
                            <h5>لم تقم بأي استشارة</h5>
                        </div>
                        @else
                        @foreach($consultations as $consultation)
                            @include("includes.consultations.big_card",
                            ['margin_top' => 'mt-4' ])
                        @endforeach
                        <!-- Consultations -->
                        <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-5">
                        {{$consultations->links()}}
                    </div>
                <!-- Pagination -->
                @endif
                    </div>
                    @if($user->type_id != Config::get('type_normal_id'))
                        <div class="tab-pane fade show" id="posts">
                            <!-- Post Write -->
                            <div class="card">
                                <div class="card-body">
                                    <div
                                        class="d-block text-center d-sm-flex flex-sm-wrap justify-content-sm-between align-items-sm-center">
                                        <p class="mb-0 fw-bold">شارك في كتابة المقالات</p>
                                        <a href="{{ route('posts.create') }}"
                                            class="btn btn-outline-success">اكتب مقالة</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Write -->
                            <h4 class="mt-5 text-center">جميع المقالات التي قمت بكتابتها</h4>
                            @if(count($posts)==0)
                                <div class="d-flex justify-content-center align-items-center h-100 mt-5">
                                    <h5>لايوجد مقالات في هذا القسم بعد</h5>
                                </div>
                            @else
                                <!-- Posts -->
                                <?php $i=0; ?>
                                @foreach($posts as $post)
                                    <div
                                        class="card {{ $i++==0?'mt-5':'mt-3' }}">
                                        <div class="card-header">
                                            <h2 style="font-size:1.1rem;">
                                                <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug]) }}"
                                                    class="text-dark">
                                                    {{ $post->title }}
                                                </a></h2>
                                        </div>

                                        <div class="card-body p-0 row justify-content-between">
                                            <div class="col-12 col-md-8">
                                                <div class="p-3">
                                                    <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug]) }}"
                                                        class="text-dark">
                                                        <small>{{ Str::limit(strip_tags($post->content),130) }}</small>
                                                    </a>
                                                    <div
                                                        class="d-flex flex-wrap align-items-center justify-content-between">

                                                        <!-- Writers -->
                                                        <div class="dropdown my-3">
                                                            <button class="btn btn-info btn-sm dropdown-toggle"
                                                                data-bs-toggle="dropdown">الكاتبين</button>
                                                            <ul class="dropdown-menu">
                                                                @foreach($post->users as $writer)
                                                                    <li><a href="" class="dropdown-item">
                                                                            <div class="d-flex align-items-center">
                                                                                <img src="{{ asset($writer->profile->avatar) }}"
                                                                                    height="25" width="25"
                                                                                    class="rounded-circle me-1" alt="">
                                                                                <p class="mb-0">
                                                                                    {{ $writer->profile->titleFromGender() }}
                                                                                    {{ $writer->profile->first_name }}
                                                                                    {{ $writer->profile->last_name }}
                                                                                </p>
                                                                            </div>
                                                                        </a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <!-- Writers -->

                                                        <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug]) }}"
                                                            class="btn btn-outline-success btn-sm my-3">قراءة كامل
                                                            المقالة</a>
                                                    </div>

                                                    <div class="d-flex align-items-center text-muted ">
                                                        <i class="bi bi-calendar3 me-2"></i>
                                                        <small>{{ \App\Http\Controllers\GeneralController::toArabicDate($post->created_at) }}</small>
                                                        &nbsp;|&nbsp;
                                                        <a href="{{ route('posts.index', ['slug'=>$post->post_category->slug]) }}"
                                                            class="text-muted"><small>{{ $post->post_category->name }}</small></a>
                                                        &nbsp;|&nbsp;
                                                        <small>{{ $post->views }} مشاهدة</small>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none d-md-block"> <img
                                                    src="{{ asset($post->img) }}" class="w-100 " height="175" alt="">
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                                <!-- Posts -->
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-5">
                                    {{ $posts->links() }}
                                </div>
                                <!-- Pagination -->
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>


@endsection

@section('scripts')
<script>
    $(document).ready(function () {
			

        $("#btnSubmit").click(function () {
            $("#personalForm input,select, textarea").each(function (index, item) {
                item.removeAttribute("readonly");
                item.removeAttribute("disabled");
            });
            let new_btn = $("#btnSubmit").clone().insertAfter($("#btnSubmit"));
            new_btn.attr('type', 'submit').text('إرسال').removeClass('btn-primary').addClass(
                'btn-success');
            $("#btnSubmit").addClass('d-none');

        });
    });

</script>
@endsection
