@extends('users.layouts.index')
@section('title', 'profil-toko')
@section('content')
  <!-- Contact Section Begin -->
      <!-- Breadcrumb Begin -->
      <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Profil Toko</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
  <section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__content">
                    <div class="contact__address">
                        <h5>Contact info</h5>
                        <ul>
                            <li>
                                <h6><i class="fa fa-map-marker"></i>Alamat</h6>
                                <p>Jl. Otista No.102, Kuningan, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45511</p>
                            </li>
                            <li>
                                <h6><i class="fa fa-phone"></i>Nomor Telepon</h6>
                                <p><span>125-711-811</span><span>125-668-886</span></p>
                            </li>
                            <li>
                                <h6><i class="fa fa-headphones"></i>Email</h6>
                                <p>terasfactory@gmail.com</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__map">
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15840.866492869185!2d108.4747139!3d-6.9837431!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f142cd319b045%3A0x9568f0c8c08033fb!2sTeras%20Factory%20Outlet!5e0!3m2!1sen!2sid!4v1718079263510!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    height="780" style="border:0" allowfullscreen="">
                </iframe>
            </div>
        </div>
    </div>
</div>
</section>
<!-- Contact Section End -->
@endsection