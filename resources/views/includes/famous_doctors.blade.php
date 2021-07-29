 <!-- Most famous doctors -->
 @if($famousWriters->count() > 0)
 <section id="famousDoctors">
 <div class="card mb-3">
   <div class="card-header">
     <h4 class="card-title text-center">
       {{ $famous_title }}
     </h4>
   </div>
   <div class="card-body p-0">
     <?php $j=0; ?>
 @foreach($famousWriters as $famousWriter)
   <!-- Doctors -->
   <a href="{{ route('users.show',['user'=>$famousWriter->id]) }}"
      class="d-flex align-items-center p-3 grey-hover">
<img src="{{ asset($famousWriter->profile->avatar) }}" height="50" width="50" 
     class="rounded-circle me-2" alt="">   
    <div>
      <p class="mb-0 text-dark">
       {{ $famousWriter->profile->titleFromGender() }} 
       {{ $famousWriter->profile->first_name }}
       {{ $famousWriter->profile->last_name }}
       </p>
     <?php $i=0; ?>
     @foreach($famousWriter->profile->jobs as $job)
        <small class="text-muted">{{ $i++==0?'':' - '}}{{ $job->title }}</small>
     @endforeach
    </div>
</a>
  <!-- Doctors -->
  {!! ++$j < $famousWriters->count()? '<hr class="m-0">' : ''!!}
  @endforeach
<!-- 
    <div class="p-3">
      <a href="" class="btn btn-outline-info d-block">عرض كافة الأطباء</a>
    </div>
     -->
   </div>
 </div>
 </section>
 @endif
 <!-- Most famous doctors -->