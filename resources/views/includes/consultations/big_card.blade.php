
    <div class="card {{ $margin_top }}">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-5">
                <a class="btn btn-outline-orange btn-sm">
                    {{ $consultation->consultation_category->name }}
                </a>
                <small class="text-muted">
                    {{ $consultation->personalInfo() }}
                </small>
            </div>
            <h2 class="mt-3 fz-default">
                <a href="{{ route('consultations.show',
                ['id'=>$consultation->id,'slug'=>$consultation->slug] ) }}"
                class="text-dark">
                {{ $consultation->title }}
                </a>
            </h2>
            <p class="  my-3">
                <a href="{{ route('consultations.show',
                ['id'=>$consultation->id,'slug'=>$consultation->slug] ) }}"
                class="text-dark">
                {{ Str::limit($consultation->content,200) }}
            </a>
            </p>

        </div>
        <div class="card-footer text-muted d-block d-sm-flex
                             justify-content-between flex-wrap align-items-center">
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
            <div class="mt-3 mt-sm-0 text-center text-sm-start">
                <a href="{{ route('consultations.show',
                        ['id'=>$consultation->id,'slug'=>$consultation->slug] ) }}"
                    class="btn btn-outline-info btn-sm mb-1">شاهد التعليقات</a>
            </div>
        </div>
    </div>

