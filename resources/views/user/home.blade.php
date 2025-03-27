@extends('layouts.user')

@section('header')
  <style>
    .full-img {
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      height: 180px;
    }
    #hero {
      background: url('{{ asset('sample_image/sekolah.jpg') }}') top center no-repeat;
      background-size: cover;
    }
    .image-center {
      display: block;
      margin: 0 auto;
      width: 100%;
    }
  </style>    
@endsection

@section('hero')
    <h1>Welcome to SDN 162 Warung Jambu</h1>
    {{-- <h2>Kami adalah agen travel terpercaya dan jaminan layanan perencanaan wisata yang mudah dan murah</h2>
    <a href="#about" class="btn-get-started">Get Started</a> --}}
@endsection


@section('content')
<!--========================== sejarah,visi-misi dan recent berita Section ============================-->
<section id="about">
  <div class="container wow fadeIn">
    <div class="row">
      <div class="col-lg-9">
        <div class="section-header">
          <h3 class="section-title">Sejarah Dan Visi Misi<br>SDN 162 Warung Jambu Kiaracondong<br></h3>
        </div>
        <div class="article">
          <div class="row" id="activity-cards" style="margin-top: 50px">
            @foreach($aboutsejarah as $sejarah)
            @if($loop->first)
            <div class="col-12 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center">Sejarah</h5>
                  <p class="card-text text-justify">{{ Str::limit($sejarah->as_sejarah, 1000) }}</p>
                </div>
              </div>
            </div>
            @endif
            @endforeach
            <div class="col-md-6 col-12">
              <h3 class="text-center">Visi</h3>
              <div class="mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                <div class="card" style="transition: transform 0.3s;">
                  <div class="card-body">
                    @foreach($about as $activity)
                    <p class="card-text text-justify">{{ $activity->a_visi }}</p>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <h3 class="text-center">Misi</h3>
              <div class="mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
                <div class="card" style="transition: transform 0.3s;">
                  <div class="card-body">
                    @foreach($about as $activity)
                    <p class="card-text text-justify">{{ $activity->a_misi }}</p>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <!-- Search Element -->
        <div class="mb-4">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari...">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Calendar Element -->
        <div class="card mb-4" style="user-select: none;">
          <div class="card-header">
            <h5 class="card-title">Kalender</h5>
          </div>
          <div class="card-body text-center">
            <h6>{{ \Carbon\Carbon::now()->format('l') }}</h6> <!-- Day of the week -->
            <h3>{{ \Carbon\Carbon::now()->format('d') }}</h3> <!-- Day -->
            <h6>{{ \Carbon\Carbon::now()->format('F Y') }}</h6> <!-- Month and Year -->
          </div>
        </div>
        <!-- Recent Posts -->
        <div class="widget">
          <div class="widget_title">Berita Terbaru</div>
          <div class="widget_body">
            <div class="recent-content">
              @foreach($berita->take(2) as $post)
              <a href="{{ route('berita.detail', ['id' => $post->b_id]) }}" class="card mb-3" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $loop->index + 1 }}">
                <img src="{{ asset('berita_image/'.$post->b_foto_berita) }}" class="card-img-top" alt="{{ $post->b_nama_berita }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                <div class="card-body">
                  <h7 class="card-title">{{ $post->b_nama_berita }}</h7>
                  <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($post->b_create_at)->format('d-m-Y') }}</small></p>
                </div>
              </a>
              @endforeach
            </div>
          </div>
        </div>
        <script>
          document.querySelectorAll('.recent-content-item').forEach(item => {
            item.addEventListener('mouseover', () => {
              item.style.transform = 'scale(1.05)';
            });
            item.addEventListener('mouseout', () => {
              item.style.transform = 'scale(1)';
            });
          });
        </script>
      </div>
    </div>
  </div>
</section>



<!--========================== informasi guru Section ============================-->
<section id="services">
  <div class="container wow fadeIn">
    <div class="section-header">
      <h3 class="section-title">Informasi Guru <br>SDN 162 Warung Jambu Kiaracondong<br></h3>
    </div>
    <div class="row">
      @foreach($gurus ->take(4) as $guru)
      <div class="col-md-6 mb-4" style="margin-top: 50px">
        <div class="d-flex justify-content-between align-items-center p-4 border rounded shadow-lg bg-white position-relative" style="box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;">
          <div class="text-center w-100">
            <h5 class="mb-1 text-primary">{{ $guru->nama }}</h5>
            <p class="mb-1 text-secondary">{{ $guru->jabatan }}</p>
            <p class="mb-0 text-dark"><strong>{{ $guru->gelar }}</strong></p>
          </div>
          @if($guru->foto)
          <img src="{{ asset('guru_image/' . $guru->foto) }}" class="rounded-circle border border-primary p-1" width="70" height="70" alt="{{ $guru->nama }}">
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


<!--========================== Pembiasaan Section ============================-->
<section id="about">
  <div class="container wow fadeIn">
    <div class="section-header">
      <h3 class="section-title mb-4 " ,> Kegiatan Pembiasaan <br>SDN 162 Warung Jambu Kiaracondong<br></h3>
    </div>
    <div class="row">
      <div class="article">
        <div class="col-md-12">
          <div class="row" id="activity-cards" style="margin-top: 50px">
            @foreach($pembiasaan->take(4) as $index => $activity)
            <div class="col-md-6 col-lg-6 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
              <a href="{{ route('pembiasaan.detail', ['id' => $activity->p_id]) }}" class="card" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $index + 1 }}">
                <img src="{{ asset('kesiswaan_image/pembiasaan_image/'.$activity->p_foto) }}" class="card-img-top" alt="{{ $activity->p_nama_kegiatan }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                <div class="card-body">
                  <h5 class="card-title">{{ $activity->p_nama_kegiatan }}</h5>
                  <p class="card-text">{{ Str::limit($activity->p_deskripsi, 100) }}</p>
                  <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($activity->p_create_at)->format('d-m-Y') }}</small></p>
                </div>
              </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="activityModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel{{ $index + 1 }}" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel{{ $index }}">{{ $activity->p_nama_kegiatan }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <img src="{{ asset('kesiswaan_image/pembiasaan_image/'.$activity->p_foto) }}" class="img-fluid mb-3" alt="{{ $activity->p_nama_kegiatan }}">
                    <p>{{ $activity->p_deskripsi }}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
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

<!--========================== penghargaan Section ============================-->
<section id="about">
  <div class="container wow fadeIn">
    <div class="section-header">
      <h3 class="section-title">Penghargaan<br>SDN 162 Warung Jambu Kiaracondong<br></h3>
    </div>
    <div class="row">
      <div class="article">
        <div class="col-md-12">
          <div class="row" id="activity-cards" style="margin-top: 50px">
            @foreach($penghargaan ->take (4) as $index => $activity)
            <div class="col-md-6 col-lg-6 mb-4 activity-card" data-page="1" style="transition: transform 0.3s, opacity 0.3s;">
              <a href="{{ route('penghargaan.detail', ['id' => $activity->ph_id]) }}" class="card" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $index + 1 }}">
                <img src="{{ asset('kesiswaan_image/penghargaan_image/'.$activity->ph_foto) }}" class="card-img-top" alt="{{ $activity->ph_nama_kegiatan }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                <div class="card-body">
                  <h5 class="card-title">{{ $activity->ph_nama_kegiatan }}</h5>
                  <p class="card-text">{{Str::limit( $activity->ph_deskripsi, 100) }}</p>
                  <p class="card-text text-right"><small class="text-muted">{{ \Carbon\Carbon::parse($activity->ph_create_at)->format('d-m-Y') }}</small></p>
                </div>
              </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="activityModal{{ $index + 1 }}" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel{{ $index + 1 }}" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel{{ $index }}">{{ $activity->ph_nama_kegiatan }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <img src="{{ asset('kesiswaan_image/pembiasaan_image/'.$activity->ph_foto) }}" class="img-fluid mb-3" alt="{{ $activity->ph_nama_kegiatan }}">
                    <p>{{ $activity->ph_deskripsi }}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
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

<!--========================== Ekstrakurukuler Section ============================-->
<section id="about">
  <div class="container wow fadeIn">
    <div class="section-header">
      <h3 class="section-title">Ekstrakurikuler</h3>
    </div>
    @if($ekstrakurikuler_all->count() > 0)
      <div class="row">
        <div class="article d-flex flex-wrap justify-content-center mx-auto" style="max-width: 1200px;">
          @foreach($ekstrakurikuler_all->take(3) as $ekstra)
          <div class="col-md-4 mb-4 d-flex flex-column align-items-center" style="padding: 15px; transition: transform 0.3s;">
            <a href="{{ url('ekstrakurikuler/' . $ekstra->e_nama_ekstrakurikuler) }}" class="text-decoration-none text-dark">
              <div style="width: 100%; height: 250px; overflow: hidden; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 15px;">
                <img src="{{ asset("kesiswaan_image/ekstrakurikuler_image/{$ekstra->e_foto}") }}" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <h5 class="text-center">{{ $ekstra->e_nama_ekstrakurikuler }}</h5>
              <p class="text-center">{{ Str::limit($ekstra->e_deskripsi, 100) }}</p>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="col-12">
        <h5 class="text-center">Data Ekstrakurikuler Belum Tersedia!</h5>
      </div>
    @endif
  </div>
</section>

<script>
  document.querySelectorAll('#about .col-md-4').forEach(item => {
    item.addEventListener('mouseover', () => {
      item.style.transform = 'scale(1.05)';
    });
    item.addEventListener('mouseout', () => {
      item.style.transform = 'scale(1)';
    });
  });
</script>

<!--========================== Informasi Pendaftaran Section ============================-->
<section id="about">
  <div class="section-header">
    <h3 class="section-title">INFORMASI PENDAFTARAN</h3>
  </div>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <!-- About Section -->
      @if(isset($pendaftarans) && count($pendaftarans) > 0)
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow p-3">
          <p>{!! $pendaftarans[0]->caption !!}</p>
        </div>
      </div>
      @else
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow p-3">
          <p>Data pendaftaran tidak tersedia.</p>
        </div>
      </div>
      @endif

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

            <div class="mb-3">
              <label for="nomor_hp" id="nomor-hp-label" class="font-weight-bold">📞 No. HP Orangtua</label>
              <div class="input-group">
              <input type="tel" id="nomor_hp" name="nomor_hp" placeholder="Nomor WhatsApp..." 
               class="form-control {{$errors->first('nomor_hp') ? 'is-invalid' : ''}}" 
               value="{{ old('nomor_hp') }}" maxlength="15" required>
              </div>
            </div>

            <script>
              document.addEventListener('DOMContentLoaded', function() {
              const nomorHpInput = document.getElementById('nomor_hp');
              if (nomorHpInput) {
              nomorHpInput.oninput = function() {
              // Remove non-numeric characters except the leading '+'
              this.value = this.value.replace(/[^\d+]/g, '');

              // Ensure the input starts with '+62' only once
              if (!this.value.startsWith('+62')) {
              this.value = '+62' + this.value.replace(/^(\+62|0)+/, '');
              }

              // Remove leading '00' if present
              if (this.value.startsWith('+6200')) {
              this.value = '+62' + this.value.slice(4);
              }

              // Limit the input to a maximum of 15 characters
              if (this.value.length > 15) {
              this.value = this.value.slice(0, 15);
              }
              };
              }
              });
            </script>

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

      var nomorAdmin = "{{ $media->where('ms_nama_media', 'whatsApp')->first()->ms_url ?? '' }}"; // Ambil nomor WhatsApp dari database
      if (!nomorAdmin) {
          alert("Nomor WhatsApp admin tidak tersedia.");
          return;
      }

      var pesan = "Halo, saya ingin mendaftarkan anak saya ke SD. Berikut data anak saya:%0A%0A" +
                  "👦 Nama Anak: " + nama_anak + "%0A" +
                  "📅 Tanggal Lahir: " + tanggal_lahir + "%0A" +
                  "🏡 Alamat: " + alamat + "%0A" +
                  "📞 Nomor HP Orangtua: +" + nomor_hp + "%0A%0A" +
                  "Mohon informasi lebih lanjut. Terima kasih.";

      var url = "https://wa.me/" + nomorAdmin + "?text=" + pesan;
      window.open(url, "_blank");
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
@endsection