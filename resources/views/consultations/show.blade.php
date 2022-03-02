@extends('layouts.app')

@section('content')

<main class="flex-grow-1 mt-5">
    @include('includes.breadcrumb',[
        'breadcrumbs' => [
            [ 'title' => 'الصفحة الرئيسية', 'url' => route('index')],
            [ 'title' => 'الاستشارات الطبية', 'url' => route('consultations.index') ],
            [ 'title' =>  'استشارة' ]
        ]
    ])
    <section class="container">
        <div class="row">
            <div class="col-lg-8  mb-3">
                <!-- Consultation -->
                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a href="{{ route('consultations.index',['tags[]'=>$consultation->consultation_category->id])}}" class="btn btn-outline-orange btn-sm">
                                {{ $consultation->consultation_category->name }}
                            </a>
                            <small class="text-muted">
                                {{ $consultation->personalInfo() }}
                            </small>
                        </div>
                        <h2 style="font-size:1.1rem;" class="mt-3">
                            {{ $consultation->title }}
                        </h2>
                        <p class="my-3">
                            {{ $consultation->content }}
                        </p>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between flex-wrap align-items-center">
                        <div class="d-flex align-items-center">
                            <small>
                                <i class="bi bi-calendar3 me-2"></i>
                                <span class="mb-1">
                                    {{ \App\Http\Controllers\GeneralController::toArabicDate($consultation->created_at) }}
                                </span>
                                |
                                <span class="mb-1">{{ $consultation->views }} مشاهدة</span>
                                |
                                <span class="mb-1">{{ count($consultation->comments) }} تعليقات</span>
                            </small>
                        </div>
                    </div>
                </div>
                <!-- Delete consultation -->
                @if(Auth::check() && Auth::user()->type_id == Config::get("type_admin_id"))
                <div class="text-center mt-3">
                  <form action="{{route('consultations.destroy',['consultation'=>$consultation->id])}}"
                        method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">حذف الاستشارة</button>
                     </form>
                </div>
                @endif
                <!-- Delete consultation -->
                <!-- Consultation -->

                <header class="mt-5">
                    <h4>جميع التعليقات</h4>
                    <small>يمكن فقط للأطباء أو صاحب السؤال ترك تعليق</small>
                </header>

                <!-- Comments -->
                <?php $i= 0; ?>
                @foreach($comments as $comment)
                    <div class="card {{$i++==0?'mt-5':'mt-3'}} ">
                        @if($best_exists)
                          @if($comment->best)
                          <div class="card-header d-flex justify-content-sm-end justify-content-start">
                            <button class="btn btn-success btn-sm">إجابة معتمدة</button>
                          </div>
                          @endif
                        @else
                          @if(Auth::check() && Auth::id() == $consultation->user_id)
                        <div class="card-header d-flex justify-content-sm-end justify-content-start">
                            <form action="{{ route('comments.setbest',['id'=>$comment->id] )}}"
                               method="POST">
                              @csrf
                              @method("PUT")
                              <button type="submit"
                              class="btn btn-warning btn-sm">اعتماد الإجابة</button>
                            </form>
                        </div>
                        @endif
                        @endif
                        <div class="card-body">
                            <!-- Writer -->
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                <img src="{{ asset($comment->user->profile->avatar) }}" height="50" width="50"
                                    class="rounded-circle me-2 mb-2" alt="">
                                <div>
                                    @if($comment->user->type_id == Config::get("type_normal_id"))
                                    <span class="btn btn-info rounded-pill btn-sm text-white ">
                                    <small>
                                     {{ $comment->user->profile->getFullName() }}
                                    </small>
                                </span>
                                    <small class="ms-2 text-muted d-block">
                                        مستخدم عام
                                    </small>
                                    @else
                                    <a href="{{ route('users.show',['user'=>$comment->user->id])}}" 
                                        class="btn btn-info rounded-pill btn-sm text-white ">
                                        <small>
                                            {{ $comment->user->profile->titleFromGender() }}
                                            {{ $comment->user->profile->getFullName() }}
                                        </small>
                                    </a>
                                    <?php $i=0; ?>
                                    <p class="mb-0">
                                        @foreach($comment->user->profile->jobs as $job)
                                            <small
                                                class="{{ $i==0?'ms-2':'' }} text-muted">
                                                {{ $i++==0?'':' - ' }}{{ $job->title }}
                                            </small>
                                        @endforeach
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <!-- Writer -->
                            <p>
                                {{ $comment->content }}
                            </p>

                        </div>
                        <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
                            <small class="text-muted">
                                تاريخ التعليق :
                                <span>
                                    {{ \App\Http\Controllers\GeneralController::toArabicDate($comment->created_at) }}
                                </span>
                            </small>
                        </div>
                    </div>
                @endforeach
                <!-- Comments -->
                <hr class="mt-5">
                <!-- Write comment -->
                @if(Auth::check()
                        && (
                        Auth::id() == $consultation->user_id
                        || Auth::user()->type_id == Config::get('type_doctor_id')
                        || Auth::user()->type_id == Config::get('type_admin_id')
                        )
                    )
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="text-center">كتابة تعليق</h5>
                        <form action="{{ route('comments.store') }}" method="post">
                          @csrf
                          <input type="hidden" name="consultation_id" value="{{$consultation->id}}">
                            <div class="form-group mt-3">
                                <label for="" class="form-label">الاسم</label>
                                <input type="text" class="form-control"
                                     value="{{$consultation->commentWriterName()}}" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <textarea name="content" cols="30" rows="10" 
                                    class="form-control box-shadow-none"
                                    placeholder="نص التعليق..." required></textarea>
                            </div>
                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-outline-success">أرسل التعليق</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                <!-- Write comment -->
                <!-- Comments -->

                <!-- Related Posts -->
      @if($related_consultations->count() > 0)
      <section id="relatedConsultations" class="mt-5">
       <div class="card">
           <div class="card-header p-3">
                 <h4>أسئلة أخرى</h4>
           </div>
           <div class="card-body p-0">
         <?php $i=0; ?>
         @foreach($related_consultations as $consultation)
         @if($i++>0) <hr class="m-0"> @endif
               <a href="{{ route('consultations.show',['id'=>$consultation->id, 
                                'slug'=> $consultation->slug])}}"
                  class="d-flex justify-content-between align-items-center p-3 grey-hover">
                   <h6 style="color:blue; font-size:1.1rem;">{{$consultation->title}}</h6>
                   <i class="bi bi-arrow-left-circle ms-2 text-muted" style="font-size: 25px;"></i>
               </a>
         @endforeach
           </div>
       </div>
   </section>
   @endif
       <!-- Related Posts -->

            </div>
            <div class="col-lg-4  mb-3">
                <aside> </aside>
            </div>
        </div>
    </section>

</main>


@stop
