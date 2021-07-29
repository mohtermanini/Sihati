
<!-- consultations -->
<section id="consultations" class="container mt-5">
  <header class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-center flex-wrap">
    <div class="invisible d-none d-lg-inline">
     <a href="#" class="btn btn-sm btn-outline-success mb-2 me-2">اسأل طبيب</a>
     <a href="#" class="btn btn-sm btn-outline-success-success mb-2">عرض كافة الأسئلة</a> 
     </div>
    <a href="{{ route('consultations.index') }}" class=" h2 mb-4 m-lg-2 text-dark">استشارات طبية</a>
    <div class="text-center">
     <a href="{{ route('consultations.create') }}" class="btn btn-sm btn-outline-success mb-2 me-2">اسأل طبيب</a>
     <a href="{{ route('consultations.index')}}" class="btn btn-sm btn-outline-success mb-2">عرض كافة الأسئلة</a>
      </div>
  </header>
  <article>
    <div class="row mt-5"> 
      <!-- Items -->
      @if($consultations->count() > 0)
      @foreach($consultations as $consultation)
      <div class="col-sm-6 col-lg-4 mb-3">
        <div class="card h-100 ">
          <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <p class="text-muted mb-1"> 
              {{ $consultation->personalInfo() }}
             </p>
            <a href="#" class="btn btn-sm btn-outline-orange mb-1">
              {{ $consultation->consultation_category->name  }}</a> </div>
          <div class="card-body">
             <a href="{{ route('consultations.show',
             ['id'=>$consultation->id,'slug'=>$consultation->slug] ) }}"
              class=" text-dark">
            {{ Str::limit($consultation->content,130) }}
          </a>
            <div class="border p-2 mt-3 rounded">
              <p class="text-muted mb-2" style="margin-top:-20px;"> 
                <span class="px-1" style="background-color: white;">أجاب عن السؤال</span> </p>
              <div class="d-flex flex-wrap flex-sm-nowrap">
                 <img src="{{ asset($consultation->comments[0]->user->profile->avatar) }}" 
                      height="75" width="75" class="rounded-circle me-2" alt="">
                <div>
                  @if($consultation->comments[0]->user->type_id == Config::get("type_normal_id"))
                  <span class="btn btn-info rounded-pill btn-sm text-white ">
                  <small>
                   {{ $consultation->comments[0]->user->profile->getFullName() }}
                  </small>
              </span>
                  <small class="ms-2 text-muted d-block">
                      مستخدم عام
                  </small>
                  @else
                  <a href="{{ route('users.show',['user'=>$consultation->comments[0]->user->id])}}" 
                    class="btn btn-info rounded-pill btn-sm text-white">
                    <small>
                      {{ $consultation->comments[0]->user->profile->titleFromGender() }}
                      {{ $consultation->comments[0]->user->profile->getFullName() }}
                    </small>
                  </a> 
                  <?php $i=0; ?>
                    <p class="mb-0">
                      @foreach($consultation->comments[0]->user->profile->jobs as $job)
                      <small class="{{$i==0?'ms-2':''}} text-muted">
                        {{ $i++==0?'':' - '}}{{ $job->title }}
                      </small>
                      @endforeach
                    </p>
                    @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-muted d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center"> <i class="bi bi-calendar3 me-2"></i>
              <p class="mb-1">17 أيار 2007</p>
            </div>
            <a href="{{ route('consultations.show',
            ['id'=>$consultation->id,'slug'=>$consultation->slug] ) }}"
             class="btn btn-sm btn-outline-info mb-1">شاهد الإجابة</a> </div>
        </div>
      </div>
      @endforeach
      @else
          <h2 class="text-center text-primary" style="font-size: 1.7rem;">لايوجد استشارات حالياً</h2>
      @endif
      <!-- Items --> 
    </div>
  </article>
</section>

<!-- consultations -->
