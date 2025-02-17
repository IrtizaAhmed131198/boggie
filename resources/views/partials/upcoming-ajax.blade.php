@foreach ($courses as $val)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="traning-info">
            <a href="{{ route('upcoming-details', ['id' => $val->id]) }}">
                <div class="traning-info-img">
                    <img src="{{ asset($val->image) }}" class="img-fluid" alt="">
                </div>
                <div class="circle-logo">
                    <p>{{ $val->product_title }}</p>
                </div>
                @if (!empty($val->package) && count($val->package) != 0)
                    <div class="cost_course">
                        <nav class="navbar navbar-expand-lg m-0 p-0">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="main-cost_course">
                                    <li class="nav-item dropdown active">
                                        <a class="nav-link cost_course-menu dropdown-toggle p-0" href="#"
                                            id="navbarDropdown" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">{{ $val->package[0]->name }}</a>
                                        <div class="dropdown-menu cost_course-dropdown-menu"
                                            aria-labelledby="navbarDropdown">
                                            @foreach ($val->package as $item)
                                                @if (!$loop->first)
                                                    <a class="dropdown-item packages"
                                                        href="{{ route('upcoming-details', ['id' => $val->id, 'price_id' => $item->id]) }}"
                                                        data-id="{{ $item->id }}"
                                                        data-price="{{ $item->price }}">{{ $item->name }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                @else
                    <div class="cost_course">
                        <h6>${{ $val->price }}</h6>
                    </div>
                @endif
            </a>
        </div>
    </div>
@endforeach
