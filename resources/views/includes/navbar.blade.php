
<nav id="topNavbar" class="navbar navbar-expand-md navbar-dark bg-dark pb-md-2 pb-0">
    <div class="container-md container-fluid p-0">
        <a id="link-skip-navigation" href="#main-content">تصفح المحتوى</a>
        <a href="{{ route('index') }}" class="navbar-brand ms-2 ms-md-0">
            <div class="d-flex align-items-center">
                <img src="{{ asset('files/logo.png') }}" width="50" height="50">
                <h5 style="color:#2BE0E0; font-size: 1.5rem;">صحتي</h5>
            </div>
        </a>
        <button class="navbar-toggler box-shadow-none me-2 me-md-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto">

                <!-- Nav item1 -->
                <li class="nav-item ">
                    <a href="{{ url()->current() == route('index')?'#siteSections':route('index',['#siteSections']) }}"
                        class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block">
                        <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">أقسام الموقع</p>
                            <i class="bi bi-journals pt-1"></i>
                        </span> </a>
                    <a href="{{ url()->current() == route('index')?'#siteSections':route('index',['#siteSections']) }}" class="nav-link d-md-none nav-link-grey-hover px-3">
                        <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">أقسام الموقع</p>
                            <i class="bi bi-journals pt-1"></i>
                        </span>
                    </a>
                </li>
                <!-- Nav item1-->

                <!-- Nav item2 -->
                <li class="nav-item">
                    <a  href="{{ route('consultations.index') }}"
                        class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block">
                        <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">الاستشارات الطبية</p>
                            <i class="bi bi-chat-dots pt-1"></i>
                        </span> </a>

                    <a href="{{ route('consultations.index') }}" class="nav-link d-md-none nav-link-grey-hover  px-3">
                        <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">الاستشارات الطبية</p>
                            <i class="bi bi-chat-dots pt-1"></i>
                        </span> </a>
                </li>
                <!-- Nav item2 -->

              

                <!-- Nav item3 -->
                @if(Auth::check())
                <li class="nav-item"> <a href="{{ route('profile') }}"
                        class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block"> <span
                            class="d-flex align-items-center">
                            <p class="mb-0 me-1">الصفحة الشخصية</p>
                            <i class="bi bi-layout-text-window pt-1"></i>
                        </span> </a>
                    <a href="{{ route('profile') }}" class="nav-link d-md-none nav-link-grey-hover px-3"> <span
                            class="d-flex align-items-center">
                            <p class="mb-0 me-1">الصفحة الشخصية</p>
                            <i class="bi bi-layout-text-window pt-1"></i>
                        </span> </a>
                </li>
                @endif
                <!-- Nav item3 -->

                  <!-- Nav item4 -->
                  @if(!Auth::check())
                  <li class="nav-item">
                      <a  href="{{ route('login')}}" 
                            class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block me-0">
                          <span class="d-flex align-items-center">
                              <p class="mb-0 me-1">تسجيل الدخول</p>
                              <i class="bi bi-person-circle pt-1"></i>
                          </span> </a>
                      <a href="{{ route('login')}}" class="nav-link d-md-none nav-link-grey-hover px-3">
                         <span class="d-flex align-items-center">
                              <p class="mb-0 me-1">تسجيل الدخول</p>
                              <i class="bi bi-person-circle pt-1"></i>
                          </span> </a>
                  </li>
                  @else
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout')}}" method="POST" class="d-none">
                    @csrf
                    <button type="submit"
                        class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block me-0">
                        <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">تسجيل الخروج</p>
                            <i class="bi bi-person-circle pt-1"></i>
                        </span> </button>
                    </form>
                    <li class="nav-item">
                        <a  role="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                              class="btn btn-sm btn-outline-light navbar-link d-none d-md-inline-block me-0">
                            <span class="d-flex align-items-center">
                                <p class="mb-0 me-1">تسجيل الخروج</p>
                                <i class="bi bi-person-circle pt-1"></i>
                            </span> </a>
                        <a role="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link d-md-none nav-link-grey-hover px-3">
                           <span class="d-flex align-items-center">
                                <p class="mb-0 me-1">تسجيل الخروج</p>
                                <i class="bi bi-person-circle pt-1"></i>
                            </span> </a>
                    </li>
                    <!-- 
                    <div class="nav-link-grey-hover px-3">
                    <button type="submit" class="nav-link d-md-none border-0"
                            style="background-color: rgba(0,0,0,0);">
                         <span class="d-flex align-items-center">
                            <p class="mb-0 me-1">تسجيل الخروج</p>
                            <i class="bi bi-person-circle pt-1"></i>
                        </span> </button>
                    </div>
                     -->
                </li>
            @endif
                <!-- Nav item4 -->

            </ul>
        </div>
    </div>
</nav>

