<section class="subscribe_section">
    <div class="container-fuild">
       <div class="box">
          @if (session()->has('msg'))
                <div class="alert alert-success">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                   {{ session()->get('msg') }}
                </div>
          @endif
          <div class="row">
             <div class="col-md-6 offset-md-3">
                <div class="subscribe_form ">
                   <div class="heading_container heading_center">
                      <h3>Subscribe To Get Discount Offers</h3>
                   </div>
                   {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p> --}}
                   <form action="{{ route('subscribe') }}" method="POST">
                     @csrf
                      <input type="email" placeholder="Enter your email" name="email">
                      {{-- <input type="submit" value="Subscribe"> --}}
                      <button type="submit">Subscribe</button>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>