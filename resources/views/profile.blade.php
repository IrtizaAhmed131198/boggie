@extends('layouts.main')

@section('content')



<section class="inner-banner">
     <div class="container">
          <div class="row">
               <div class="col-lg-4">
                    <div class="banner-profile-img">
                         <figure>
                              <img src="{{ asset('images/proflel.png') }}" class="img-fluid" alt="">
                         </figure>
                    </div>
               </div>
               <div class="col-lg-4">
                    <div class="member-info">
                         <h4>{{ $users->name }}</h4>
                         <ul>
                              <li>
                                   <p>Age </p>
                                   <p> {{ $profile->age ?? '' }}</p>
                              </li>
                              <li>
                                   <p>Sex</p>
                                   <p> {{ $profile->gender ?? '' }}</p>
                              </li>
                              <li>
                                   <p>Email</p>
                                   <p> {{ $users->email ?? '' }}</p>
                              </li>
                              <li>
                                   <p>Location </p>
                                   <p> {{ $profile->address ?? '' }}</p>
                              </li>
                              <li>
                                   <p>Web </p>
                                   <p> {{ $profile->domain ?? '' }}</p>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>
     </div>
</section>


<section class="about-me">
     <div class="container">
          <div class="row">
               <div class="col-lg-12">
                    <div class="member-tabs">
                         <div class="tabs_click">
                              <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                   <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                        aria-selected="true">About Me</button>
                                   <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Gallery</button>
                                   <button class="nav-link" id="nav-fav-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-fav" type="button" role="tab" aria-controls="nav-fav"
                                        aria-selected="false">Favorite DJ’s</button>
                                   <button class="nav-link" id="nav-favart-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-favart" type="button" role="tab" aria-controls="nav-favart"
                                        aria-selected="false">Favorite Signed Artist</button>
                                   <button class="nav-link" id="nav-event-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-event" type="button" role="tab" aria-controls="nav-event"
                                        aria-selected="false">Events</button>
                              </div>
                         </div>
                         <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane fade active show" id="nav-home" role="tabpanel"
                                   aria-labelledby="nav-home-tab">
                                   <div class="Tabcondent">
                                        <p>{{$profile->bio}}</p>
                                   </div>
                              </div>
                              <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                   aria-labelledby="nav-profile-tab">
                                   <div class="Tabcondent">
                                        <div class="row">
                                        @foreach ($gallery as $val)
                                                  <div class="col-lg-3">
                                                       <div class="fancy_img">
                                                            <a href="{{ $val->image_link }}" data-fancybox="gallery1">
                                                                 <figure>
                                                                      <img src="{{ $val->image_link }}" class="img-fluid" alt="" style="height: 300px;">
                                                                 </figure>
                                                            </a>
                                                       </div>
                                                  </div>
                                             @endforeach
                                        </div>
                                   </div>
                              </div>
                              <div class="tab-pane fade" id="nav-fav" role="tabpanel" aria-labelledby="nav-fav-tab">
                                   <div class="col-lg-12">
                                        <div class="Tabcondent">
                                             <div class="main-featured">
                                                  {{-- <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ asset('images/client01.png') }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>Carter</h5>
                                                            <p>Lorem ipsum dolor sit amet, con- </p>
                                                       </div>
                                                  </div> --}}
                                                  @foreach ($favorite as $val)
                                                  @if($val->artist_type == 1)
                                                       <div class="client-profile">
                                                            <div class="client-img">
                                                                 <figure>
                                                                      <img src="{{ $val->dj_profile->image_link }}" class="img-fluid"
                                                                           alt="">
                                                                 </figure>
                                                            </div>
                                                            <div class="client-info">
                                                                 <h5>{{ $val->dj->name }}</h5>
                                                                 <p>@if(!empty($val->dj_profile->bio))
                                                                      {{ Illuminate\Support\Str::words($val->dj_profile->bio, 6) }}
                                                                  @endif</p>
                                                            </div>
                                                       </div>
                                                  @endif
                                                  @endforeach
                                             </div>
                                             {{-- <div class="main-featured">
                                                  <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ asset('images/client01.png') }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>Carter</h5>
                                                            <p>Lorem ipsum dolor sit amet, con- </p>
                                                       </div>
                                                  </div>
                                                  <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ asset('images/client02.png') }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>Grayson</h5>
                                                            <p>Lorem ipsum dolor sit amet, con- </p>
                                                       </div>
                                                  </div>
                                                  <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ asset('images/client03.png') }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>Mason</h5>
                                                            <p>Lorem ipsum dolor sit amet, con- </p>
                                                       </div>
                                                  </div>
                                                  <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ asset('images/client04.png') }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>Parker</h5>
                                                            <p>Lorem ipsum dolor sit amet, con- </p>
                                                       </div>
                                                  </div>
                                             </div> --}}
                                        </div>
                                   </div>
                              </div>
                              <div class="tab-pane fade" id="nav-favart" role="tabpanel"
                                   aria-labelledby="nav-favart-tab">
                                   <div class="col-lg-12">
                                        <div class="Tabcondent">
                                             <div class="main-featured">
                                                  @foreach ($favorite as $val)
                                                  @if($val->artist_type == 2)
                                                  <div class="client-profile">
                                                       <div class="client-img">
                                                            <figure>
                                                                 <img src="{{ $val->dj_profile->image_link }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="client-info">
                                                            <h5>{{ $val->dj->name }}</h5>
                                                            <p>@if(!empty($val->dj_profile->bio))
                                                                 {{ Illuminate\Support\Str::words($val->dj_profile->bio, 6) }}
                                                                 @endif</p>
                                                       </div>
                                                  </div>
                                                  @endif
                                                  @endforeach
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="tab-pane fade" id="nav-event" role="tabpanel" aria-labelledby="nav-event-tab">
                                   <div class="Tabcondent">
                                        <div class="event-date">
                                             @foreach ($events as $val)
                                                  <div class="coming-events">
                                                       <div class="event-img">
                                                            <figure>
                                                                 <img src="{{ $val->image_link ?? '' }}" class="img-fluid"
                                                                      alt="">
                                                            </figure>
                                                       </div>
                                                       <div class="events-info">
                                                            <div class="rap-discription">
                                                                 <h3>{{ $val->event_title }}</h3>
                                                                 <p>@if(!empty($val->description))
                                                                      {{ Illuminate\Support\Str::words($val->description, 10) }}
                                                                      @endif</p>
                                                                 <h6><span>{{ $val->format_date }}</span> By {{ $val->auth->name }} </h6>
                                                            </div>
                                                       </div>
                                                  </div>
                                             @endforeach

                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</section>


@include('newsletter')


@endsection

@section('css')
<style>

</style>
@endsection

@section('js')
<script type="text/javascript">



</script>
@endsection