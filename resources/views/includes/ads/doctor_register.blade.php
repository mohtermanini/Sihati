@if(!Auth::check() 
    || Auth::user()->type_id == Config::get("type_normal_id")
)
<div class="card mb-3">
    <div class="card-body text-center">
        <h4 class="card-title mb-3">هل أنت طبيب؟</h4>
        <small>شارك في كتابة المقالات والإجابة عن الاستفسارات</small>
        <a href="{{ route('signup', ['type_id'=>Config::get('type_doctor_id')]) }}"
            class="btn btn-outline-info d-block mt-3">سجل كطبيب الآن</a>
    </div>
</div>
@endif
