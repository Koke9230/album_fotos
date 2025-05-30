<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galería de la Boda</title>
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #fffdf8, #f9f3ed);
      margin: 0;
      padding: 0;
      color: #333;
      position: relative;
    }
    header {
      background: #8b6a33;
      color: white;
      padding: 20px;
      text-align: center;
    }
    h1 {
      margin: 0;
      font-size: 2em;
    }
    .swiper-container {
      width: 100%;
      padding: 40px 0;
      background: #fff9f0;
    }
    .swiper-slide {
      text-align: center;
    }
    .swiper-slide img {
      width: 90%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 15px;
      padding: 20px;
      max-width: 1200px;
      margin: auto;
    }
    .gallery img {
      width: 100%;
      border-radius: 10px;
      object-fit: cover;
      height: 200px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .ver-mas {
      text-align: center;
      margin: 30px;
    }
    .ver-mas button {
      background-color: #8b6a33;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    .corner-decoration {
      position: absolute;
      width: 50px;
      height: 50px;
      background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Ornament_corner_gold.svg/512px-Ornament_corner_gold.svg.png');
      background-size: contain;
      background-repeat: no-repeat;
      z-index: 10;
    }
    .corner-top-left { top: 0; left: 0; }
    .corner-top-right { top: 0; right: 0; transform: scaleX(-1); }
    .corner-bottom-left { bottom: 0; left: 0; transform: scaleY(-1); }
    .corner-bottom-right { bottom: 0; right: 0; transform: scaleX(-1) scaleY(-1); }

    @media (max-width: 768px) {
      h1 {
        font-size: 1.5em;
      }
      .swiper-slide img {
        max-height: 200px;
      }
      .gallery img {
        height: 150px;
      }
    }
  </style>
</head>
<body>
  <div class="corner-decoration corner-top-left"></div>
  <div class="corner-decoration corner-top-right"></div>
  <div class="corner-decoration corner-bottom-left"></div>
  <div class="corner-decoration corner-bottom-right"></div>

  <header>
    <h1>🎉 Galería de la Boda de Camila & Javier</h1>
  </header>

  <div class="swiper-container">
    <div class="swiper-wrapper">
      <?php
      $uploadDir = __DIR__ . '/uploads';
      $images = glob($uploadDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
      $highlighted = array_slice($images, 0, 5);
      foreach ($highlighted as $imagePath) {
        $url = 'uploads/' . basename($imagePath);
        echo "<div class='swiper-slide'><img src='$url' alt='foto destacada'></div>";
      }
      ?>
    </div>
  </div>

  <div class="gallery" id="gallery">
    <?php
    $maxVisible = 12;
    $count = 0;
    foreach ($images as $imagePath) {
      if ($count >= $maxVisible) break;
      $url = 'uploads/' . basename($imagePath);
      echo "<img src='$url' alt='foto boda'>";
      $count++;
    }
    ?>
  </div>

  <?php if (count($images) > $maxVisible): ?>
  <div class="ver-mas">
    <button onclick="loadMore()">Ver más fotos</button>
  </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    const swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        960: { slidesPerView: 3 }
      }
    });

    let visible = <?php echo $maxVisible; ?>;
    const allImages = <?php echo json_encode(array_map(fn($p) => 'uploads/' . basename($p), array_slice($images, $maxVisible))); ?>;

    function loadMore() {
      const gallery = document.getElementById('gallery');
      for (let i = 0; i < allImages.length; i++) {
        const img = document.createElement('img');
        img.src = allImages[i];
        img.alt = 'foto boda';
        gallery.appendChild(img);
      }
      document.querySelector('.ver-mas').style.display = 'none';
    }
  </script>
</body>
</html>
