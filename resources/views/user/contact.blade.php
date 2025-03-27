@extends('layouts.user')

@section('header')
<style>
  #hero {
    background: #000;
    width: 100%;
    position: relative;
    overflow: hidden;
  }

  .hero-slide {
    position: absolute;
    top: 0;
    left: 100%;
    width: 100%;
    height: 100%;
    transition: left 1s ease-in-out, opacity 1s ease-in-out;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    opacity: 0;
  }

  .hero-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .hero-slide h1 {
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    margin: 0;
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2rem;
  }

  .hero-slide h2 {
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    margin: 0;
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.2rem;
  }

  .hero-slide.active {
    left: 0;
    opacity: 1;
  }

  .hero-slide.previous {
    left: -100%;
    opacity: 0;
  }

  .form-control:focus {
    box-shadow: none;
  }

  .form-control::placeholder {
    font-size: 0.95rem;
    color: #aaa;
    font-style: italic;
  }

  .article {
    line-height: 1.6;
    font-size: 15px;
  }

  @media (max-width: 576px) {
    .hero-slide h1 {
      font-size: 1.5rem;
    }

    .hero-slide h2 {
      font-size: 1rem;
    }
  }

  .custom-button {
    background-color: rgb(34, 22, 194) !important;
    /* Warna ungu */
    color: white !important;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: 0.3s;
  }

  .custom-button:hover {
    background-color: rgb(34, 22, 194) !important;
  }
</style>
@endsection

@section('hero')
<div class="hero-slide active">
  <img src="{{ asset('sample_image/SDN-162.png') }}" alt="Slide 1">
  <h1>Contact <br>SDN 162 Warung Jambu </h1>
</div>

@endsection

@section('content')
<section id="contact">
  <div class="container wow fadeInUp">
    <div class="section-header">
      <h3 class="section-title">Contact </h3>
    </div>
    <div class="row ">
      <div class="col-lg-9">
        <div class="row justify-content-center">
          <!-- Bagian Info -->
          <div class="col-lg-6 col-md-6">
            <div class="info">
              <div>
                <i class="fa fa-map-marker" style="font-size:40px;color:red"></i>
                <p>
                  <a href="https://www.google.com/maps?ll=-6.929517,107.645742&z=16&t=m&hl=en&gl=ID&mapclient=embed&cid=8957196680549333916"
                    target="_blank" style="text-decoration: none; color: inherit;">
                    SDN 162 Warung Jambu, Kiaracondong
                  </a>
                </p>
              </div>

              <div>
                <i class="fa fa-envelope" style="font-size:24px;color:red"></i>
                <p>
                  <a href="mailto:SDN162@gmail.com" target="_blank" style="text-decoration: none; color: inherit;">
                    SDN162@gmail.com
                  </a>
                </p>
              </div>
            </div>

            <!-- Bagian Sosial Media -->
            <div class="social-media">
              <a href="https://www.facebook.com/profile.php?id=100089628607635" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #3b5998;">
                <i class="fa fa-facebook"></i>
              </a>
              <a href="https://twitter.com/sdndua_jambu" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #1da1f2;">
                <i class="fa fa-twitter"></i>
              </a>
              <a href="https://www.instagram.com/sdn2jambu_muarateweh/" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #e1306c;">
                <i class="fa fa-instagram"></i>
              </a>
              <a href="https://www.youtube.com/channel/UCK6kMH030GyI0VjVSj9HMRA" class="social-icon" style="font-size: 24px; margin-right: 10px; color: #ff0000;">
                <i class="fa fa-youtube"></i>
              </a>
            </div>
          </div>

          <!-- Bagian Form -->
          <div class="col-lg-6 col-md-6">
            <div class="form">
              <div id="sendmessage">Your message has been sent. Thank you!</div>
              <div id="errormessage"></div>
              <form onsubmit="SendMessage()">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                    data-rule="minlen:4" data-msg="Please enter at least 4 chars" required />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="message" rows="5" data-rule="required"
                    data-msg="Please write something for us" placeholder="Message" required></textarea>
                  <div class="validation"></div>
                </div>
                <div class="text-center">
                  <button type="submit" class="custom-button">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        document.querySelectorAll('.page-link').forEach(link => {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = document.querySelector('.page-link.active') ? parseInt(document.querySelector('.page-link.active').getAttribute('data-page')) : 1;
            let page = this.getAttribute('data-page');
            if (page === 'prev') {
              page = currentPage > 1 ? currentPage - 1 : 1;
            } else if (page === 'next') {
              page = currentPage < 2 ? currentPage + 1 : 2;
            } else {
              page = parseInt(page);
            }
            document.querySelectorAll('.activity-card').forEach(card => {
              card.style.opacity = 0;
              setTimeout(() => {
                card.style.display = card.getAttribute('data-page') == page ? 'block' : 'none';
                card.style.opacity = 1;
              }, 300);
            });
            document.querySelectorAll('.page-link').forEach(link => {
              link.classList.remove('active');
            });
            document.querySelector(`.page-link[data-page="${page}"]`).classList.add('active');
          });
        });

        document.querySelectorAll('.activity-card .card').forEach(card => {
          card.addEventListener('mouseover', () => {
            card.style.transform = 'scale(1.05)';
          });
          card.addEventListener('mouseout', () => {
            card.style.transform = 'scale(1)';
          });
        });
      </script>
      <style>
        @media (min-width: 992px) {
          .activity-card {
            margin-bottom: 30px;
          }
        }

        @media (max-width: 576px) {
          .activity-card {
            width: 100% !important;
            height: auto !important;
          }

          .activity-card img {
            height: auto !important;
          }
        }
      </style>
      <div class="col-md-3">
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
                  @foreach($berita->take(3) as $post)
                  <a href="{{ route('berita.detail', ['id' => $post->b_id]) }}" class="card mb-3" style="transition: transform 0.3s;" data-toggle="modal" data-target="#activityModal{{ $loop->index + 1 }}">
                    <img src="{{ asset('berita_image/'.$post->b_foto_berita) }}" class="card-img-top" alt="{{ $post->b_nama_berita }}" style="height: 150px; object-fit: cover; width: 100%; image-rendering: optimizeSpeed;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->b_nama_berita }}</h5>
                        <p class="card-text">{{ Str::limit($post->b_deskripsi_berita, 100) }}</p>
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
@endsection