<!--navbar-->
<div class="bg-black">

    <nav class="container-fluid navbar navbar-expand-lg navbar-light bg-black container-x nav-x">
        <a class="navbar-brand" href="{{ url("/") }}">
            <img src="https://cdn.arzdigital.com/uploads/2019/09/screenshot.png" alt="" width="43px" height="50px">
        </a>
        <ul class="navbar-toggle list-group list-group-horizontal mobile-just">
            <li class="list-none-x ml-1">
                <a href="{{ auth()->check() ? url('admin/index') : url('/login')}}" data-toggle="collapse"
                   aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                  <i class="fas fa-user"></i>
                </span>
                </a>
            </li>
            <li class="list-none-x ml-1">
                <a href="#search" type="button" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                      <i class="fas fa-search"></i>
                    </span>
                </a>
            </li>
            <li class="list-none-x ml-1">
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                      <i class="fas fa-bars"></i>
                    </span>
                </button>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @forelse(\App\Category::query()->limit(6)->get() as $menu)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{$menu->url}}">{{$menu->title}}</a>
                    </li>
                @empty
                @endforelse
            </ul>
            <ul class="form-inline mr-auto">

                <li class="hidden-lp">
                    <a class="nav-form text-white font-s-18" href="#search">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li class="hidden-lp">
                    @guest
                        {{--                        <a class="btn-warning nav-form btn  mr-sm-2" href="{{ route('login') }}">ورود/ثبت نام</a>--}}
                    @else
                        {{--                        <a class="btn-warning nav-form btn  mr-sm-2"--}}
                        {{--                           href="{{url('admin/index')}}">{{auth()->user()->name }}</a>--}}
                    @endguest
                </li>

            </ul>
        </div>
    </nav>
</div>

<!--end navbar-->
