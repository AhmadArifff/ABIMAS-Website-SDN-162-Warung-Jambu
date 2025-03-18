@extends('layouts.user')

@section('header')
    <style>
        .full-img {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 180px;
        }
        #hero{
            background: url('{{asset('user/images/hero-bg.jpg')}}') top center;
        }
        .image-center{
          display: block;
          margin-left: 6.5px;
          margin-right: 6.5px;
          width: 100%;
        } 
    </style>    
@endsection

@section('hero')
    <h1>INFORMASI</h1>
    
@endsection


@section('content')

      <!--========================== About Us Section ============================-->
      <section id="about" class="py-5">
      <div class="container wow fadeIn">
          <div class="section-header">
            <h3 class="section-title">Informasi Bantuan Dana</h3>
            <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
          </div>
          <div class="row justify-content-center">
    @foreach ($beasiswas->sortByDesc('created_at')->take(3) as $beasiswa)
        <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
            <a href="{{ route('beasiswa.show', $beasiswa->slug) }}" class="text-decoration-none w-100">
                <div class="card shadow-lg border-0 h-100 rounded-lg overflow-hidden">
                    <div class="position-relative" style="height: 220px; border: 3px solid #ddd; border-radius: 12px; overflow: hidden;">
                        <img src="{{ asset('beasiswas_image/' . $beasiswa->image) }}" 
                             alt="{{ $beasiswa->title }}" 
                             class="img-fluid w-100 h-100" 
                             style="object-fit: cover;">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                        <h4 class="text-dark font-weight-bold mb-3">{{ $beasiswa->title }}</h4>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
        <!-- Tombol Selengkapnya -->
<div class="row">
    <div class="col text-center mt-4">
        <a href="{{url('beasiswa')}}">klik untuk informasi Beasiswa Selengkapnya >></a>
            
        </a>
    </div>
</div>
  </div>
</section>


  
      <!--========================== Services Section ============================-->
      <section id="services">
        <div class="container wow fadeIn">
          <div class="section-header">
            <h3 class="section-title">Mengapa Memilih Kami?</h3>
            <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
          </div>
          <div class="row">
        @foreach($gurus ->take(4) as $guru)
        <div class="col-md-6 mb-4">
            <div class="d-flex justify-content-between align-items-center p-4 border rounded shadow-lg bg-white position-relative" style="box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;">
                <div class="text-center w-100">
                    <h5 class="mb-1 text-primary">{{ $guru->nama }}</h5>
                    <p class="mb-1 text-secondary">{{ $guru->jabatan }}</p>
                    <p class="mb-0 text-dark"><strong>{{ $guru->gelar }}</strong></p>
                </div>
                @if($guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" class="rounded-circle border border-primary p-1" width="70" height="70" alt="{{ $guru->nama }}">
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
    <div class="col text-center mt-4">
        <a href="{{url('daftar-guru')}}">klik untuk informasi Tendik dan Petendik Selengkapnya >></a>
            
        </a>
    </div>
</div>
        </div>
      </section><!-- #services -->
  
      <!--========================== Call To Action Section ============================-->
      <section id="call-to-action">
      <div class="section-header">
            <h3 class="section-title">INFORMASI PENDAFTARAN</h3>
            <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
          </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- About Section -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card shadow p-3">
                    <p>{!! $pendaftarans[0]->caption !!}</p>
                </div>
            </div>

            <!-- Form Pendaftaran -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow p-3 form-container">
                    <h4 class="text-center mb-3">Form Pendaftaran SD</h4>
                    <form id="registrationForm">
                        <div class="mb-2">
                            <label class="form-label">👦 Nama Anak</label>
                            <input type="text" id="nama_anak" class="form-control form-control-sm" placeholder="Nama lengkap" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">📅 Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">🏡 Alamat</label>
                            <textarea id="alamat" class="form-control form-control-sm" placeholder="Alamat lengkap" rows="2" required></textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">📞 No. HP Orangtua</label>
                            <input type="tel" id="nomor_hp" class="form-control form-control-sm" placeholder="Nomor WhatsApp" required>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-success btn-sm" onclick="kirimWhatsApp()">
                                <i class="fab fa-whatsapp"></i> Daftar via WhatsApp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function kirimWhatsApp() {
        var nama_anak = document.getElementById("nama_anak").value;
        var tanggal_lahir = document.getElementById("tanggal_lahir").value;
        var alamat = document.getElementById("alamat").value;
        var nomor_hp = document.getElementById("nomor_hp").value;

        if (nama_anak === "" || tanggal_lahir === "" || alamat === "" || nomor_hp === "") {
            alert("Harap lengkapi semua data sebelum mengirim.");
            return;
        }

        var nomorAdmin = "+6285723034244"; // Ganti dengan nomor WhatsApp admin sekolah
        var pesan = "Halo, saya ingin mendaftarkan anak saya ke SD. Berikut data anak saya:%0A%0A" +
                    "👦 Nama Anak: " + nama_anak + "%0A" +
                    "📅 Tanggal Lahir: " + tanggal_lahir + "%0A" +
                    "🏡 Alamat: " + alamat + "%0A" +
                    "📞 Nomor HP Orangtua: " + nomor_hp + "%0A%0A" +
                    "Mohon informasi lebih lanjut. Terima kasih.";

        var url = "https://wa.me/" + nomorAdmin + "?text=" + pesan;
        window.open(url, "_blank");
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

  
      <!--========================== category Section ============================-->
    
@endsection