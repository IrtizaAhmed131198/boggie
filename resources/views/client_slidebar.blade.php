@php
$reviews = App\Models\Review::with('user')->where('rating', '>=', 4)
    ->orderBy('id', 'DESC')
    ->limit(3)
    ->get();
@endphp
<section class="happy-client">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-stragety">
                    <h2>Happy Customers</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="custom-review" data-aos="zoom-in" data-aos-duration="2000">
                    <div class="client-review owl-carousel owl-theme">
                        @foreach ($reviews as $item)
                            @php
                             $data = App\Profile::where('user_id', $item->user_id)->first();
                            @endphp
                            <div class="item">
                                <div class="client-info">
                                     <div class="client-img">
                                          <figure>
                                               <img src="{{ asset($data->image_link) }}" class="img-fluid" alt="">
                                          </figure>
                                     </div>
                                     <div class="discription-review">
                                          <h5>{{ $item->user->name }}</h5>
                                          <p>“ {{ $item->comment }} ”
                                          </p>
                                     </div>
                                     <div class="star-rating">
                                          @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @endif
                                          @endfor
                                     </div>
                                </div>
                           </div>
                        @endforeach

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
