
<?php $this->load->view('header'); ?>
<section id="home-section" class="hero">
    <div class="home-slider js-fullheight owl-carousel">
        <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
                <div class="row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                    <div class="one-third order-md-last img js-fullheight" style="background-image:url(<?php echo base_url('assets/home/images/duo.jpg'); ?>);"></div>
                    <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                            <span class="subheading">HRSHOPKU</span>
                            <div class="horizontal">
                                <h3 class="vr" style="background-image: url(<?php echo base_url('assets/home/images/divider.jpg'); ?>);">Best eCommerce Online Shop</h3>
                                <h1 class="mb-4 mt-3">Temukan Dirimu <br><span>Tampilan & Gaya</span></h1>
                                <p><a href="<?php echo base_url('index.php/produk'); ?>" class="btn btn-primary px-5 py-3 mt-3">Temukan Sekarang</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
                <div class="row d-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                    <div class="one-third order-md-last img js-fullheight" style="background-image:url(<?php echo base_url('assets/home/images/ipad.png'); ?>);"></div>
                    <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                            <span class="subheading">HRSHOPKU</span>
                            <div class="horizontal">
                                <h3 class="vr" style="background-image: url(<?php echo base_url('assets/home/images/divider.jpg'); ?>);">Best eCommerce Online Shop</h3>
                                <h1 class="mb-4 mt-3">Benar-benar <span>Tradisional</span> yang modern</h1>
                                <p><a href="<?php echo base_url('produk'); ?>" class="btn btn-primary px-5 py-3 mt-3">Belanja Sekarang</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-5 img img-2 d-flex justify-content-center align-items-center">
                <img src="<?= base_url('assets/home/images/bg-home.jpeg') ?>" width="100%" style="border-radius: 10px">
            </div>
            <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                <div class="heading-section-bold mb-4 mt-md-5">
                    <div class="ml-md-0">
                        <h2 class="mb-4">Temukan Baju Bodo Terbaikmu</h2>
                    </div>
                </div>
                <div class="pb-md-5">
                    <p>Baju Bodo merupakan salah satu pakaian adat tertua di dunia yang berasal dari Sulawesi Selatan. 
                        Baju ini memiliki sejarah panjang yang diperkirakan telah ada sejak abad ke-9 masehi.
                        Baju adat suku Bugis ini terbuat dari kain tenun kapas yang memiliki transparansi unik dan sangat cocok digunakan di Indonesia, 
                        negara beriklim tropis.</p>
                    <div class="row ftco-services">
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-002-recommended"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Kebijakan Pengembalian Dana</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-001-box"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Kemasan Premium</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-003-medal"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Kualitas Unggul</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Produk</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php foreach ($produk as $perproduk): ?>
                <div class="col-sm col-md-6 col-lg ftco-animate">
                    <div class="product">
                        <a href="<?php echo site_url('produk/detail/'.$perproduk['idproduk']); ?>" class="img-prod">
                            <img class="img-fluid" src="<?php echo base_url('assets/foto/'.$perproduk['fotoproduk']); ?>" alt="">
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 px-3">
                            <h3><a href="<?php echo site_url('produk/detail/'.$perproduk['idproduk']); ?>"><?php echo $perproduk['namaproduk']; ?></a></h3>
                            <div class="d-flex">
                                <div class="pricing">
                                    <p class="price"><span>Rp <?php echo number_format($perproduk['hargaproduk']); ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php $this->load->view('footer'); ?>

