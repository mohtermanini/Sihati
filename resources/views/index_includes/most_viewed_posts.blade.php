<!-- Best Posts -->
<section class="mt-5">
  <div id="bestPosts" class="carousel slide carousel-fade" data-bs-ride="carousel" >
    <div class="carousel-inner" > 
      <!-- Items -->
      <?php $i = 0; ?>
      @foreach($most_viewed_posts as $post)
      <div class="carousel-item {{$i++ == 0?'active':''}}" >
        <div class="card border-0 p-3 px-5 rounded-0"  
             style="background-image: url({{asset('files/posts/background.jpg')}}); 
             background-size: cover; background-repeat: no-repeat;">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 mb-3 mb-md-0"> <img src="{{ asset($post->img) }}" class="w-100" height="250" alt=""> </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <header class="d-flex justify-content-between mb-3 align-items-center"> 
                  <a href="{{ route('posts.index',['slug'=> $post->post_category->slug]) }}" 
                        class="mb-0 text-white fw-bold">{{ $post->post_category->name}} </a>
                  <div class="d-none d-md-block">
                    <button class="btn rounded-circle bg-light me-2" data-bs-target="#bestPosts" data-bs-slide="next"> <i class="bi bi-arrow-right fw-bold" style="font-size:25px;"></i> </button>
                    <button class="btn rounded-circle bg-light" data-bs-target="#bestPosts" data-bs-slide="prev"> <i class="bi bi-arrow-left fw-bold" style="font-size:25px;"></i> </button>
                  </div>
                </header>
                <article  class="overflow-auto"  style="height:200px;">
                  <h2 style="font-size:1.8rem;">
                    <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                    class="text-dark">{{ $post->title }}</a>
                </h2>
                  <p class="text-dark mt-2">{!! $post->content !!}</p>
                </article>
                <hr height="2">
              </div>
            </div>
            <footer class="row">
              <div class="col-sm-6 d-md-none d-flex align-items-center justify-content-center order-sm-first order-last mb-3">
                <button class="btn rounded-circle bg-light me-2" data-bs-target="#bestPosts" data-bs-slide="next"> <i class="bi bi-arrow-right fw-bold" style="font-size:25px;"></i> </button>
                <button class="btn rounded-circle bg-light" data-bs-target="#bestPosts" data-bs-slide="prev"> <i class="bi bi-arrow-left fw-bold" style="font-size:25px;"></i> </button>
              </div>
              <div class="col-sm-6 col-md-12 d-flex  
                        justify-content-center justify-content-md-end align-items-center  mb-3">
                 <a href="{{ route('posts.show',['id'=>$post->id, 'slug'=> $post->slug])}}"
                         class="btn btn-light">اقرأ كامل المقالة...</a> </div>
            </footer>
          </div>
        </div>
      </div>
      @endforeach
      <!-- Items --> 
    </div>
  </div>
</section>

<!-- Best Posts -->