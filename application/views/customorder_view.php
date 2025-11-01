<?php $this->load->view('header'); ?>

<section class="custom-section mt-5">
    <div class="container">
        <h2 class="text-center">Custom Baju Bodo</h2>
        <p class="text-center">Buatlah baju bodo versi kamu!</p>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4" style="background-color:rgba(252, 224, 224, 0.22);">
                        <form action="<?= site_url('CustomOrderController/store') ?>" method="post" enctype="multipart/form-data" >
                            <div class="mb-3">
                                <label for="jenis-kain" class="form-label">Jenis Kain</label>
                                <select id="jenis-kain" name="jenis_kain" class="form-select custom-input">
                                <option value="">Pilih Jenis Kain</option>
                                    <option value="Organza">Organza</option>
                                    <option value="Organdi">Organdi</option>
                                    <option value="Kain Labbu">Kain Labbu</option>
                                    <option value="Brokat">Brokat</option>
                                    <option value="Tile">Tile</option>
                                    <option value="Jaguar">Jaguar</option>
                                    <option value="Songket">Songket</option>

                                </select>
                            </div>

                            <!-- Preview Image -->
                            <div id="preview-container" class="mb-3 text-center" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-fluid" style="max-width: 100%;">
                            </div>

                            <div class="mb-3">
                                <label for="jenis-sarung" class="form-label">Jenis Sarung</label>
                                <select id="jenis-sarung" name="jenis_sarung" class="form-select custom-input">
                                    <option value="">Pilih Jenis Sarung</option>
                                    <option value="sarung">Sarung Sutra</option>
                                    <option value="sarung">Sarung Songket</option>
                                    <option value="sarung">Batik Lilit</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <select id="size" name="size" class="form-select custom-input">
                                    <option value="">Pilih Size</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="warna" class="form-label">Warna</label>
                                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Pink" style="background-color: #ffc0cb ; color: black;">Pink</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Dusty Blue" style="background-color: #b0c4de; color: black;">Dusty Blue</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Coffe" style="background-color: #6f4e37; color: white;">Coffe</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Milo" style="background-color: #c7a17a; color: black;">Milo</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Coconut" style="background-color: #fffdd0; color: black;">Coconut</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Grey" style="background-color: grey; color: white;">Grey</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Nude" style="background-color: #d2b48c; color: black;">Nude</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Navy" style="background-color: #000080; color: white;">Navy</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="White" style="background-color: white; color: black;">White</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Hijau" style="background-color:rgb(28, 232, 28); color: black;">Hijau</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Krem" style="background-color: #f5deb3; color: black;">Krem</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Merah" style="background-color: #FF0000; color: black;">Merah</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Lilac" style="background-color: #C8A2C8; color: black;">Lilac</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-color="Terracota" style="background-color: #c45824 ; color: white;">Terracota</button>
                                </div>
                                <!-- Hidden input field to store the selected color -->
                                <input type="hidden" id="selected-color" name="warna" value="">
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" class="form-control custom-input" value="1">
                            </div>
                            
                            <div class="mb-3">
                                <label for="custom" class="form-label">Upload Foto Baju</label>
                                <input type="file" id="custom" name="foto_baju" class="form-control custom-input" onchange="previewImage(event)">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Order Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Model Reference Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Referensi Model</h5>
                        <img id="preview-image" src="model.jpeg" alt="Model Baju Bodo" class="img-fluid">
                    </div>
                </div>
            </div>

<!-- Add JavaScript to preview the image -->


        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.btn-outline-secondary').forEach(button => {
    button.addEventListener('click', function() {
        var color = this.getAttribute('data-color'); // Ambil nilai warna dari atribut data-color
        document.getElementById('selected-color').value = color; // Set nilai input hidden
        alert('Warna yang dipilih: ' + color); // Opsional, untuk menampilkan warna yang dipilih
    });
});

    document.getElementById('custom').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var previewImage = document.getElementById('preview-image');
            previewImage.src = reader.result; // Set the source of the preview image
        };
        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]); // Read the selected image
        }
    });
</script>


<?php $this->load->view('footer'); ?>

<!-- Custom CSS -->
<style>
    .custom-section {
        padding: 30px 0;
    }

    .custom-input {
        background-color: #fff;
        border: 1px solid #d5a6d1;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .custom-input:focus {
        border-color: #e1a9c1;
        box-shadow: 0 0 5px rgba(225, 169, 193, 0.5);
    }

    .btn-outline-secondary {
        border-color: rgba(255, 255, 255, 0.5);
        color: #d5a6d1;
    }

    .btn-outline-secondary:hover {
        border-color: #000;
        background-color: transparent;
        color: white;
    }
</style>
