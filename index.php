<?php
/* ---------- 1. LOAD DATA ---------- */
$products   = json_decode(file_get_contents('data/products.json'),   true) ?: [];
$banner     = json_decode(file_get_contents('data/banner.json'),     true) ?: ['text'=>'','bg'=>'#ffe4e1'];
$carousel   = json_decode(file_get_contents('data/carousel.json'),   true) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>ZenVesture | Luxury Abayas & Shawls</title>
    <meta name="description" content="Discover premium modest fashion with ZenVesture's elegant abayas and shawls collection. Quality craftsmanship meets modern design.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<!-- Favicon -->
<link rel="icon" href="assets/top.png" type="image/png">
    
    <style>


        :root {
            --primary-bg: #FFFFFF;
            --primary-text: #333333;
            --accent-bg: #FFFFF0;
            --accent-secondary: #FFFDD0;
            --accent-tertiary: #F5F5DC;
            --accent-dark: oklch(28.6% 0.066 53.813);
            --accent-taupe: #D2B1A3;
            --accent-rose: #DCAE96;
            --brand-primary: oklch(28.6% 0.066 53.813);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-bg);
            color: var(--primary-text);
            overflow-x: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
        
        h1, h2, h3, h4 {
            font-family: 'Cormorant', serif;
            font-weight: 600;
        }
        
        .hero-section {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        #three-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .opacity-100 {
  opacity: 1 !important;
}

        
        .hero-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .horizontal-scroll-container {
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        
        .horizontal-scroll-content {
            position: absolute;
            height: 100%;
            white-space: nowrap;
            will-change: transform;
        }
        
        .horizontal-scroll-panel {
            display: inline-flex;
            height: 100%;
            width: 100vw;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .product-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .product-card:hover .product-3d-container {
            transform: scale(1.05);
        }
        
        .product-3d-container {
            transition: transform 0.3s ease;
        }
        
        .size-guide:hover .size-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        .size-tooltip {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .accordion.active .accordion-content {
            max-height: 500px;
        }
        
        .accordion-toggle {
            transition: all 0.3s ease;
        }
        
        .accordion.active .accordion-toggle {
            transform: rotate(90deg);
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        /* Scroll animations */
        [data-aos] {
            transition: all 0.5s ease;
        }
        
        .aos-fade {
            opacity: 0;
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .aos-fade-up {
            transform: translateY(20px);
        }
        
        .aos-fade-down {
            transform: translateY(-20px);
        }
        
        .aos-fade-left {
            transform: translateX(20px);
        }
        
        .aos-fade-right {
            transform: translateX(-20px);
        }
        
        .aos-animate {
            opacity: 1;
            transform: translate(0);
        }

        /* Hover effects */
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.03);
        }
        
        .whatsapp-btn {
            transition: all 0.3s ease;
        }
        
        .whatsapp-btn:hover {
            background-color: #25D366;
            color: white;
        }
        
        .nav-link::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: var(--accent-taupe);
            transition: width 0.3s;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        .loader {
            border-top-color: var(--accent-navy);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .floating-wrapper {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  overflow: hidden;
}

.floating-dot,
.floating-shape {
  position: absolute;
  opacity: 0.2;
  animation: floatAround 18s ease-in-out infinite;
}

.floating-dot {
  width: 20px;
  height: 20px;
  background-color: #7d614f;
  border-radius: 50%;
}

.floating-shape {
  width: 35px;
  height: 35px;
  background-color: #c7b9a3;
  border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
}

@keyframes floatAround {
  0%   { transform: translate(0, 0) scale(1); }
  25%  { transform: translate(-20px, -30px) scale(1.05); }
  50%  { transform: translate(30px, 10px) scale(0.95); }
  75%  { transform: translate(-10px, 20px) scale(1.1); }
  100% { transform: translate(0, 0) scale(1); }
}
.floating-element {
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
/* Smooth infinite marquee animation */
  @keyframes marquee {
    0% {
      transform: translateX(0%);
    }
    100% {
      transform: translateX(-50%);
    }
  }

  .animate-marquee {
    display: inline-flex;
    animation: marquee 15s linear infinite;
  }
  .product-card {
  transform-origin: center center;
  will-change: transform, opacity;
}

.product-card:hover {
  scale: 1.05;
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
@media (max-width: 768px) {
  .logo-stroke {
    max-width: 120px;
    max-height: 60px;
  }
}
.logo-stroke {
  /* Remove stroke */
  filter: none;

  /* Responsive size */
  width: auto;
  height: auto;
  max-width: 220px;
  max-height: 100px;
  object-fit: contain;
}

/* Optional: Adjust for smaller screens */
@media (max-width: 768px) {
  .logo-stroke {
    max-width: 160px;
    max-height: 80px;
  }
}




.nav-link.active {
  text-decoration: underline;
  text-underline-offset: 4px;
  text-decoration-thickness: 2px;
  color: #000000; /* Optional: make active link darker */
}
.animated-section {
  overflow: hidden;
}

.animated-item {
  opacity: 0;
  transform: translateX(-30px); /* Starts slightly left */
  transition: all 0.6s ease-out;
}

.animated-item.animate {
  opacity: 1;
  transform: translateX(0); /* Slides to normal position */
}

/* Optional: Staggered animation delays */
.animated-item:nth-child(1) { transition-delay: 0.1s; }
.animated-item:nth-child(2) { transition-delay: 0.3s; }
.animated-item:nth-child(3) { transition-delay: 0.5s; }


    /* Animation styles */
    #collections {
        opacity: 0;
        transition: opacity 0.5s ease, transform 0.8s ease;
    }
    
    #collections.animate-in {
        opacity: 1;
        transform: translateX(0);
    }
    
    #collections.animate-in.scroll-down {
        transform: translateX(0);
        animation: slideInFromLeft 0.8s ease forwards;
    }
    
    #collections.animate-in.scroll-up {
        transform: translateX(0);
        animation: slideInFromRight 0.8s ease forwards;
    }
    
    @keyframes slideInFromLeft {
        0% {
            transform: translateX(-100px);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideInFromRight {
        0% {
            transform: translateX(100px);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

.group:hover .group-hover\:opacity-100 {
  pointer-events: auto;
  transition: all 0.5s ease;
}

/* Make every carousel item exactly viewport height and cover */
#carouselHero img {
  height: 100vh;
  width: 100%;
  object-fit: cover;
  max-width: 100%;
}
/* ---------- WhatsApp Bubble ---------- */
.wa-float{
  position:fixed;
  bottom:25px;
  right:25px;
  z-index:999;
  width:55px;
  height:55px;
  background:#25D366;
  color:#fff;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:26px;
  box-shadow:0 4px 10px rgba(37,211,102,.5);
  transition:transform .3s, box-shadow .3s;
}
.wa-float:hover{
  transform:translateY(-4px);
  box-shadow:0 6px 16px rgba(37,211,102,.7);
}
/* gentle pulse */
@keyframes pulse{
  0%  {box-shadow:0 0 0 0 rgba(37,211,102,.4);}
  70% {box-shadow:0 0 0 8px rgba(37,211,102,0);}
  100%{box-shadow:0 0 0 0 rgba(37,211,102,0);}
}
.wa-float{animation:pulse 2s infinite;}

/* ---------- Scroll-to-Top Button ---------- */
.scroll-top{
  position:fixed;
  bottom:25px;
  left:25px;
  z-index:999;
  width:45px;
  height:45px;
  background:#8B4513;
  color:#fff;
  border:none;
  border-radius:50%;
  cursor:pointer;
  opacity:0;
  visibility:hidden;
  transition:opacity .4s, visibility .4s, transform .4s;
  transform:translateY(15px);
}
.scroll-top.show{
  opacity:1;
  visibility:visible;
  transform:translateY(0);
}
.scroll-top:hover{
  background:#a05a2c;
}

/*  Left → Right reveal  */
.slide-in-left {
  opacity: 0;
  transform: translateX(-80px);
  transition: opacity .8s ease, transform .8s ease;
}
.slide-in-left.show {
  opacity: 1;
  transform: translateX(0);
}
    </style>
</head>
<body class="antialiased bg-white relative overflow-x-hidden">

  <!-- Global Floating Decorative Elements -->
  <div class="floating-wrapper pointer-events-none">
    <div class="floating-dot" style="top:10%; left:5%; animation-delay: 0s;"></div>
    <div class="floating-dot" style="top:25%; right:10%; animation-delay: 3s;"></div>
    <div class="floating-shape" style="top:40%; left:15%; animation-delay: 6s;"></div>
    <div class="floating-dot" style="top:60%; right:20%; animation-delay: 1s;"></div>
    <div class="floating-shape" style="top:75%; left:10%; animation-delay: 5s;"></div>
    <div class="floating-dot" style="top:90%; right:5%; animation-delay: 2s;"></div>
  </div>



  <!-- Navigation -->
  <!-- Navigation -->
<header class="fixed w-full bg-white bg-opacity-90 shadow-sm z-50 transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-5 py-4 flex justify-between items-center">
    
    <!-- Logo -->
<a href="#" class="flex items-center">
  <img src="assets/logo.png" alt="ZenVesture Logo" class="logo-stroke">
</a>


    <!-- Desktop Menu -->
    <nav class="hidden md:flex items-center space-x-8 text-base font-medium">
  <a href="#home" class="nav-link">Home</a>
  <a href="#about" class="nav-link">About</a>
  <a href="#shop" class="nav-link">Shop</a>
  <a href="#collections" class="nav-link">Collections</a>
  <a href="#contact" class="nav-link">Contact</a>
</nav>


    <!-- Icons & Mobile Toggle -->
    <div class="flex items-center space-x-4 md:hidden">
      <a href="#" class="text-gray-700 hover:text-gray-900"><i class="fas fa-shopping-bag"></i></a>
      <button id="mobile-menu-button" class="text-gray-700">
        <i class="fas fa-bars text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden fixed inset-0 z-50 p-8 md:hidden bg-gradient-to-b from-[#f7f1e3] to-[#eaddcf] text-gray-900">
 <div id="mobile-menu" class="mobile-menu fixed inset-0 bg-white dark:bg-gray-900 z-50 p-8 md:hidden">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <label class="toggle-switch">
                        <input type="checkbox" id="mobile-dark-mode-toggle">
                        <span class="slider"></span>
                    </label>
                    <span class="ml-2 text-gray-700 dark:text-gray-300">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:inline"></i>
                    </span>
                </div>
                <button id="close-menu-button" class="text-gray-700 dark:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-6 text-center">
                <a href="#" class="text-xl text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Home</a>
                <a href="#our-products" class="text-xl text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Shop</a>
                <a href="#size-guide" class="text-xl text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Size Guide</a>
                <a href="#care" class="text-xl text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Customer Care</a>
            </nav>
        </div>


    <div class="flex justify-between items-center mb-6">
      <a href="#">
        <img src="assets/logo.png" alt="ZenVesture Logo" class="h-10">
      </a>
      <button id="close-menu-button" class="text-gray-700">
        <i class="fas fa-times text-2xl"></i>
      </button>
    </div>
    <nav class="flex flex-col space-y-6 text-lg">
      <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
      <a href="#about" class="text-gray-700 hover:text-gray-900">About</a>
      <a href="#collections" class="text-gray-700 hover:text-gray-900">Collections</a>
      <a href="#shop" class="text-gray-700 hover:text-gray-900">Shop</a>
      <a href="#contact" class="text-gray-700 hover:text-gray-900">Contact</a>
    </nav>
  </div>
</header>


    <!-- Mobile menu -->
    <div class="hidden md:hidden bg-white w-full absolute left-0 py-2 shadow-lg" id="mobile-menu">
      <div class="flex flex-col space-y-3 px-6 py-4 text-base font-medium">
        <a href="#" class="text-gray-700 hover:text-gray-900">Home</a>
        <a href="#about" class="text-gray-700 hover:text-gray-900">About</a>
        <a href="#collections" class="text-gray-700 hover:text-gray-900">Collections</a>
        <a href="#shop" class="text-gray-700 hover:text-gray-900">Shop</a>
        <a href="#contact" class="text-gray-700 hover:text-gray-900">Contact</a>
      </div>
    </div>
  </nav>

  
<!-- ========= HERO CAROUSEL ========= -->
<section class="hero-section relative overflow-hidden">
  <div id="carouselHero" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($carousel as $k=>$img): ?>
        <div class="carousel-item <?= $k===0 ? 'active' : '' ?>">
          <img src="<?= $img ?>" class="d-block w-100" style="height:100vh;object-fit:cover;">
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($carousel) > 1): ?>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselHero" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselHero" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    <?php endif; ?>
  </div>

  <!-- 3D Animation Overlay -->
<div id="three-container"
     class="absolute inset-0 z-10 opacity-0 pointer-events-none transition-opacity duration-1000">
</div>


  <!-- Hero Content Overlay -->
  <div class="absolute inset-0 z-20 flex items-center justify-center px-6 md:px-16">
    <div class="text-center max-w-4xl mx-auto space-y-6">

      <!-- Headline -->
      <div class="inline-block bg-black/50 backdrop-blur-sm rounded-lg px-6 py-4">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white">
          Discover the <span class="text-rose-400">new you</span>
        </h1>
      </div>

      <!-- Subheading -->
      <div class="inline-block bg-black/40 backdrop-blur-sm rounded-lg px-4 py-2">
        <p class="text-lg md:text-xl text-white">
          Timeless elegance. Modern modesty. The finest abayas and shawls crafted with care.
        </p>
      </div>

      <!-- CTA Buttons -->
      <div class="inline-block bg-black/40 backdrop-blur-sm rounded-lg px-6 py-4">
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#shop" 
             class="px-8 py-3 rounded-md text-white font-medium transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg"
             style="background-color: oklch(28.6% 0.066 53.813);">
            Shop Abayas
          </a>
          <a href="#collections" 
             class="px-8 py-3 rounded-md text-white font-medium transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg"
             style="background-color: oklch(28.6% 0.066 53.813);">
            Explore Collection
          </a>
        </div>
      </div>

    </div>
  </div>

  <!-- Down Icon -->
  <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center">
    <a href="#about" class="text-white hover:text-gray-200 animate-bounce">
      <i class="fas fa-chevron-down text-xl"></i>
    </a>
  </div>
</section>


  </div>
</div>

</section>



    <!-- About Section -->
<section id="about" class="py-20 bg-[#FFFFF0]">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

    <!-- Left Column: Content (fade from left) -->
    <div class="space-y-6" data-aos="fade-right">
      <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">
        Welcome to ZenVesture
      </h2>
      <p class="text-gray-700 text-lg leading-relaxed">
        Where modest fashion meets modern elegance. We craft abayas and shawls with care, offering quality, simplicity, and timeless design.
      </p>
      <p class="text-gray-700 text-lg leading-relaxed">
        Our brand reflects confidence, grace, and individuality — one elegant piece at a time. Each garment is designed to empower while honoring tradition.
      </p>
      <div class="flex gap-6">
        <div class="group bg-white p-6 shadow-lg rounded-md transition-transform transform hover:-translate-y-1 hover:shadow-xl">
          <h4 class="font-semibold mb-2" style="color: oklch(28.6% 0.066 53.813);">Ethically Made</h4>
          <p class="text-gray-600 text-sm">Handcrafted with sustainable materials</p>
        </div>
        <div class="group bg-white p-6 shadow-lg rounded-md transition-transform transform hover:-translate-y-1 hover:shadow-xl">
          <h4 class="font-semibold mb-2" style="color: oklch(28.6% 0.066 53.813);">Global Shipping</h4>
          <p class="text-gray-600 text-sm">Delivered worldwide with care</p>
        </div>
      </div>
    </div>

    <!-- Right Column: Image -->
    <div class="relative" data-aos="fade-left">
      <img src="assets/bg3.png" alt="ZenVesture Abaya" class="w-full h-auto rounded-md shadow-xl transform hover:scale-105 transition duration-500 ease-in-out">
      <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-rose-100 opacity-50 rounded-full z-0 animate-pulse"></div>
    </div>

  </div>
</section>

            
            <div class="horizontal-scroll-panel bg-stone-100">
  <div class="max-w-4xl mx-auto px-6 md:px-16 flex flex-col md:flex-row items-center gap-12">

    <!-- Image with fade-left animation -->
    <div class="w-full md:w-1/2 relative floating-element order-2 md:order-1">
      <img src="assets/hab1.jpg" 
     alt="ZenVesture craftsmanship" 
     class="w-full h-auto rounded-sm shadow-lg md:scale-200 transition-transform duration-500 ease-in-out">

      <div class="absolute -top-6 -left-6 w-32 h-32 bg-amber-100 opacity-50 -z-10"></div>
    </div>

    <!-- Text content with fade-right animation -->
    <div class="w-full md:w-1/2 order-1 md:order-2">
      <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Our Craftsmanship</h2>
      <p class="text-gray-600 mb-6 text-lg leading-relaxed">
        Each ZenVesture piece is carefully handcrafted by skilled artisans who have perfected their craft over generations.
      </p>
      <ul class="space-y-3 mb-8">
        <li class="flex items-start">
          <span class="bg-rose-100 text-rose-800 p-1 rounded-full mr-3">
            <i class="fas fa-check text-xs"></i>
          </span>
          <span class="text-gray-600">100% premium fabrics</span>
        </li>
        <li class="flex items-start">
          <span class="bg-rose-100 text-rose-800 p-1 rounded-full mr-3">
            <i class="fas fa-check text-xs"></i>
          </span>
          <span class="text-gray-600">Hand-finished details</span>
        </li>
        <li class="flex items-start">
          <span class="bg-rose-100 text-rose-800 p-1 rounded-full mr-3">
            <i class="fas fa-check text-xs"></i>
          </span>
          <span class="text-gray-600">Ethically sourced materials</span>
        </li>
        <li class="flex items-start">
          <span class="bg-rose-100 text-rose-800 p-1 rounded-full mr-3">
            <i class="fas fa-check text-xs"></i>
          </span>
          <span class="text-gray-600">Fair trade certified</span>
        </li>
      </ul>
      <a href="#shop" class="inline-block px-6 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
        Discover Our Abayas
      </a>
    </div>

  </div>
</div>

<br>
<br>
   

<!-- ========= SEAMLESS DOUBLE MARQUEE ========= -->
<div class="overflow-hidden w-full whitespace-nowrap"
     style="background-color: <?= htmlspecialchars($banner['bg']) ?>; border-top:1px solid #fecdd3; border-bottom:1px solid #fecdd3;">
  <div class="marquee-continuous inline-flex">
    <!-- two copies of the sentence -->
    <span class="flex-none px-6 text-2xl md:text-4xl font-extrabold italic tracking-wide drop-shadow-md" style="color:#8B4513;">
      <?= htmlspecialchars($banner['text']) ?>
    </span>
    <span class="flex-none px-6 text-2xl md:text-4xl font-extrabold italic tracking-wide drop-shadow-md" style="color:#8B4513;">
      <?= htmlspecialchars($banner['text']) ?>
    </span>
  </div>
</div>

<style>
.marquee-continuous {
  animation: scroll 15s linear infinite;
}
@keyframes scroll {
  0%   { transform: translateX(0%); }
  100% { transform: translateX(-50%); } /* exactly half the duplicated width */
}
</style>

    <!-- Shop Section -->
 <!-- ========= OUR COLLECTION ========= -->
<section id="shop" class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Our Collection</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Designed for comfort, crafted for beauty. Our timeless pieces are made to last.
      </p>
    </div>

    <!-- ===== CATEGORY BUTTONS ===== -->
<div class="flex justify-center mb-12 flex-wrap gap-3">
  <button class="category-btn px-4 py-2 bg-gray-800 text-white rounded-sm" data-category="all">All</button>
  <button class="category-btn px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-sm hover:bg-gray-100" data-category="abayas">Abayas</button>
  <button class="category-btn px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-sm hover:bg-gray-100" data-category="shawls">Shawls</button>
  <button class="category-btn px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-sm hover:bg-gray-100" data-category="new">New Arrivals</button>
  <button class="category-btn px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-sm hover:bg-gray-100" data-category="best">Best Sellers</button>
</div>

<!-- ===== PRODUCTS GRID ===== -->
<div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
  <?php foreach ($products as $p): ?>
    <div class="product-card" data-category="<?= htmlspecialchars($p['category']) ?>">
      <img src="<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-72 object-cover rounded-md">
      <h3 class="mt-4 text-lg font-semibold"><?= htmlspecialchars($p['title']) ?></h3>
      <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars(substr($p['content'], 0, 100)) ?>…</p>
    </div>
  <?php endforeach; ?>
</div>

<!-- ===== FILTER SCRIPT (after cards exist) ===== -->
<script>
(() => {
  const buttons = document.querySelectorAll('.category-btn');
  const cards   = document.querySelectorAll('.product-card');

  // Map button -> JSON value
  const mapBtnToJson = {
    all:   'all',
    abayas:'Abayas',
    shawls:'Shawls',
    new:   'New Arrivals',
    best:  'Best Sellers'
  };

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = mapBtnToJson[btn.dataset.category];
      cards.forEach(card => {
        const show = filter === 'all' || card.dataset.category === filter;
        card.style.display = show ? 'block' : 'none';
      });
    });
  });
})();
</script>
</section>

    <div class="text-center mt-12">
      <a href="#" class="inline-block px-8 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
        View All Products
      </a>
    </div>
  </div>
</section>


    <!-- Size Guide Section -->
    <section class="py-16 bg-stone-50"  data-aos-duration="800">
  <div class="max-w-4xl mx-auto px-6">
    
    <!-- Title and Intro -->
    <div class="text-center mb-12" data-aos="fade-down" data-aos-duration="800">
      <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Size Guide</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        We recommend sizing based on length first, then checking bust and sleeve for comfort — especially for loose-fitting styles.
      </p>
    </div>
    
    <!-- Size Table -->
    <div class="overflow-x-auto" data-aos="fade-left" data-aos-duration="800">
      <table class="w-full bg-white shadow-sm">
        <thead>
          <tr class="bg-gray-800 text-white">
            <th class="py-3 px-4 text-left">Size</th>
            <th class="py-3 px-4 text-center">Bust (in)</th>
            <th class="py-3 px-4 text-center">Waist (in)</th>
            <th class="py-3 px-4 text-center">Length (in)</th>
            <th class="py-3 px-4 text-center">Sleeve (in)</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-gray-200">
            <td class="py-4 px-4">S</td>
            <td class="py-4 px-4 text-center">32-34</td>
            <td class="py-4 px-4 text-center">24-26</td>
            <td class="py-4 px-4 text-center">50</td>
            <td class="py-4 px-4 text-center">22</td>
          </tr>
          <tr class="border-b border-gray-200">
            <td class="py-4 px-4">M</td>
            <td class="py-4 px-4 text-center">36-38</td>
            <td class="py-4 px-4 text-center">28-30</td>
            <td class="py-4 px-4 text-center">52</td>
            <td class="py-4 px-4 text-center">23</td>
          </tr>
          <tr class="border-b border-gray-200">
            <td class="py-4 px-4">L</td>
            <td class="py-4 px-4 text-center">40-42</td>
            <td class="py-4 px-4 text-center">32-34</td>
            <td class="py-4 px-4 text-center">54</td>
            <td class="py-4 px-4 text-center">24</td>
          </tr>
          <tr class="border-b border-gray-200">
            <td class="py-4 px-4">XL</td>
            <td class="py-4 px-4 text-center">44-46</td>
            <td class="py-4 px-4 text-center">36-38</td>
            <td class="py-4 px-4 text-center">56</td>
            <td class="py-4 px-4 text-center">25</td>
          </tr>
          <tr>
            <td class="py-4 px-4">2XL</td>
            <td class="py-4 px-4 text-center">48-50</td>
            <td class="py-4 px-4 text-center">40-42</td>
            <td class="py-4 px-4 text-center">58</td>
            <td class="py-4 px-4 text-center">26</td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Measuring Guide -->
    <div class="mt-8 bg-white p-6 shadow-sm" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
      <h4 class="font-bold text-gray-800 mb-3">Measuring Guide</h4>
      <div class="flex flex-wrap -mx-3">
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
          <div class="size-guide relative px-3 py-2">
            <span class="text-rose-500 cursor-pointer"><i class="fas fa-ruler mr-2"></i>Bust</span>
            <div class="size-tooltip absolute left-0 mt-2 w-64 bg-white p-4 shadow-lg z-10">
              <p class="text-sm text-gray-700">Measure around the fullest part of your bust, keeping the tape measure parallel to the floor.</p>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
          <div class="size-guide relative px-3 py-2">
            <span class="text-rose-500 cursor-pointer"><i class="fas fa-ruler mr-2"></i>Waist</span>
            <div class="size-tooltip absolute left-0 mt-2 w-64 bg-white p-4 shadow-lg z-10">
              <p class="text-sm text-gray-700">Measure around the smallest part of your natural waistline, keeping the tape measure parallel to the floor.</p>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 px-3">
          <div class="size-guide relative px-3 py-2">
            <span class="text-rose-500 cursor-pointer"><i class="fas fa-ruler mr-2"></i>Sleeve</span>
            <div class="size-tooltip absolute left-0 mt-2 w-64 bg-white p-4 shadow-lg z-10">
              <p class="text-sm text-gray-700">Measure from the center back of the neck, over the shoulder, and down to the wrist.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Note Section -->
    <div class="mt-8 bg-white p-6 shadow-sm" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
      <h4 class="font-bold text-gray-800 mb-3">Note</h4>
      <p class="text-gray-600">
        All sales are final. No return, no exchange due to hygiene and product nature. Contact us before ordering if unsure.
      </p>
    </div>
    
  </div>
</section>


    <!-- Collections Section -->
    <section id="collections" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Collections</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover our seasonal collections and limited edition pieces</p>
        </div>
        
        <div class="relative" id="collections-slider">
            <div class="relative h-96 md:h-[500px] overflow-hidden">
                <!-- Collection 1 -->
                <div class="absolute inset-0 transition-opacity duration-500 opacity-100 flex" data-slide>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('assets/hab3.webp')"></div>

                    <div class="w-1/2 bg-gray-50 p-12 flex flex-col justify-center">
                        <span class="text-rose-500 font-medium mb-3">NEW COLLECTION</span>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Spring Elegance</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Lightweight fabrics and delicate embroideries characterize our spring line. Inspired by the blooming season, featuring soft pastels and flowing silhouettes.
                        </p>
                        <a href="#" class="self-start px-6 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
                            Shop the Collection
                        </a>
                    </div>
                </div>
                
                <!-- Collection 2 -->
                <div class="absolute inset-0 transition-opacity duration-500 opacity-0 flex" data-slide>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('assets/hab4.webp')"></div>
                    <div class="w-1/2 bg-gray-50 p-12 flex flex-col justify-center">
                        <span class="text-rose-500 font-medium mb-3">BEST SELLER</span>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Timeless Classics</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Our signature collection featuring versatile pieces that transcend seasons. Designed for everyday elegance and comfort, with premium fabrics and timeless designs.
                        </p>
                        <a href="#" class="self-start px-6 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
                            Shop the Collection
                        </a>
                    </div>
                </div>
                
                <!-- Collection 3 -->
                <div class="absolute inset-0 transition-opacity duration-500 opacity-0 flex" data-slide>
                    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('assets/hab5.webp')"></div>
                    <div class="w-1/2 bg-gray-50 p-12 flex flex-col justify-center">
                        <span class="text-rose-500 font-medium mb-3">LIMITED EDITION</span>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Evening Luxe</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Special occasion abayas and shawls with intricate detailing, luxurious fabrics and sophisticated designs. Perfect for weddings, celebrations and formal events.
                        </p>
                        <a href="#" class="self-start px-6 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
                            Shop the Collection
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slider Controls -->
            <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                <i class="fas fa-chevron-left text-gray-800"></i>
            </button>
            <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                <i class="fas fa-chevron-right text-gray-800"></i>
            </button>
            
            <!-- Slider Indicators -->
            <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-2">
                <button class="w-3 h-3 rounded-full bg-gray-300 slide-indicator active"></button>
                <button class="w-3 h-3 rounded-full bg-gray-300 slide-indicator"></button>
                <button class="w-3 h-3 rounded-full bg-gray-300 slide-indicator"></button>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-stone-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Get In Touch</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">We'd love to hear from you. Contact us with any questions or inquiries.</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-12">
                <div class="w-full md:w-1/2">
                    <!-- Map -->
                    <!-- Map Section -->
<div class="h-96 bg-gray-200 mb-8 relative overflow-hidden rounded-lg shadow-lg">
  <!-- Embedded Google Map -->
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2826.0382526525536!2d79.88634307499672!3d6.9407934930592585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2s!5e1!3m2!1sen!2slk!4v1752343878423!5m2!1sen!2slk"
    width="100%" height="100%"
    style="border:0;" allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    class="absolute inset-0 w-full h-full"
  ></iframe>
</div>

                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-rose-100 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-rose-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Our Store</h4>
                                <p class="text-gray-600">31/91 Avissawella Road, Wellampitiya, Colombo , Sri Lanka</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-rose-100 p-3 rounded-full mr-4">
                                <i class="fas fa-phone-alt text-rose-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Call Us</h4>
                                <a href="tel:+94763572475" class="text-gray-600 hover:text-rose-600">+94 763 572 475</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-rose-100 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-rose-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Email Us</h4>
                                <a href="mailto:zenvesture.lk@gmail.com" class="text-gray-600 hover:text-rose-600">zenvesture.lk@gmail.com</a>
                            </div>
                        </div>
                        
                        <div>
                            <a href="https://wa.me/94763572475" class="whatsapp-btn inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-sm hover:shadow-lg">
                                <i class="fab fa-whatsapp text-xl mr-2"></i>
                                Chat on WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form Section -->
<div class="w-full md:w-1/2">
    <form id="contact-form" class="bg-white p-8 shadow-sm" onsubmit="sendWhatsAppMessage(event)">
        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent" required>
        </div>
        
        <div class="mb-6">
            <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
            <input type="text" id="location" class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent" required>
        </div>
        
        <div class="mb-6">
            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
            <select id="subject" class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                <option value="General Inquiry">General Inquiry</option>
                <option value="Order Question">Order Question</option>
                <option value="Returns">Returns</option>
                <option value="Feedback">Feedback</option>
            </select>
        </div>
        
        <div class="mb-6">
            <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
            <textarea id="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent" required></textarea>
        </div>
        
        <button type="submit" class="w-full bg-gray-800 text-white py-3 px-6 rounded-sm hover:bg-gray-900 transition duration-300 font-medium">
            Send Message
        </button>
        
        <div id="form-message" class="mt-4 hidden px-4 py-3 rounded-sm"></div>
    </form>
</div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-bold mb-6" style="color: #8B4513;">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Find answers to common questions about our products, ordering process, and shipping.
                </p>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="accordion bg-white border border-gray-200 rounded-sm overflow-hidden">
                    <button class="accordion-toggle w-full flex justify-between items-center p-6 text-left">
                        <span class="text-lg font-medium text-gray-800">How do I determine my size?</span>
                        <i class="fas fa-chevron-right transition-transform"></i>
                    </button>
                    <div class="accordion-content px-6">
                        <div class="pb-6 text-gray-600">
                            <p class="mb-4">Please refer to our detailed size guide above. We recommend measuring yourself following our guidelines and comparing to our size chart. If you're between sizes or unsure, we recommend sizing up for a more comfortable fit, especially for our looser styles.</p>
                            <p>Our customer service team is also happy to assist with size recommendations based on your measurements and preferred fit.</p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion bg-white border border-gray-200 rounded-sm overflow-hidden">
                    <button class="accordion-toggle w-full flex justify-between items-center p-6 text-left">
                        <span class="text-lg font-medium text-gray-800">What is your shipping policy?</span>
                        <i class="fas fa-chevron-right transition-transform"></i>
                    </button>
                    <div class="accordion-content px-6">
                        <div class="pb-6 text-gray-600">
                            <p class="mb-4">We offer worldwide shipping with the following options:</p>
                            <ul class="list-disc pl-5 space-y-2 mb-4">
                                <li><strong>Standard Shipping:</strong> 5-10 business days (free on orders over $100)</li>
                                <li><strong>Express Shipping:</strong> 2-5 business days (additional fee)</li>
                            </ul>
                            <p>Orders are processed within 1-2 business days. You will receive tracking information once your order has shipped.</p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion bg-white border border-gray-200 rounded-sm overflow-hidden">
                    <button class="accordion-toggle w-full flex justify-between items-center p-6 text-left">
                        <span class="text-lg font-medium text-gray-800">Do you offer returns or exchanges?</span>
                        <i class="fas fa-chevron-right transition-transform"></i>
                    </button>
                    <div class="accordion-content px-6">
                        <div class="pb-6 text-gray-600">
                            <p class="mb-4">Due to hygiene reasons, we cannot accept returns or exchanges unless the item received is defective or significantly not as described.</p>
                            <p>If you receive an item that is defective or incorrect, please contact us within 7 days of delivery with photos of the issue. We will work with you to resolve the situation.</p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="accordion bg-white border border-gray-200 rounded-sm overflow-hidden">
                    <button class="accordion-toggle w-full flex justify-between items-center p-6 text-left">
                        <span class="text-lg font-medium text-gray-800">What payment methods do you accept?</span>
                        <i class="fas fa-chevron-right transition-transform"></i>
                    </button>
                    <div class="accordion-content px-6">
                        <div class="pb-6 text-gray-600">
                            <p class="mb-4">We accept the following payment methods:</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Visa, Mastercard, American Express</li>
                                <li>PayPal</li>
                                <li>Bank transfers (for wholesale orders only)</li>
                                <li>Cash on delivery (available in selected regions)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="accordion bg-white border border-gray-200 rounded-sm overflow-hidden">
                    <button class="accordion-toggle w-full flex justify-between items-center p-6 text-left">
                        <span class="text-lg font-medium text-gray-800">How should I care for my ZenVesture garment?</span>
                        <i class="fas fa-chevron-right transition-transform"></i>
                    </button>
                    <div class="accordion-content px-6">
                        <div class="pb-6 text-gray-600">
                            <p class="mb-4">To ensure your garments maintain their beauty and longevity:</p>
                            <ul class="list-disc pl-5 space-y-2 mb-4">
                                <li>Machine wash cold on gentle cycle or hand wash in cool water</li>
                                <li>Use mild detergent</li>
                                <li>Hang to dry or lay flat - avoid direct sunlight</li>
                                <li>Iron low heat if needed (check fabric care label)</li>
                                <li>Store folded in a cool, dry place</li>
                            </ul>
                            <p>Specific care instructions are included with each garment.</p>
                        </div>
                    </div>
                </div>
            </div>
            
           <div class="mt-12 text-center">
  <p class="text-gray-600 mb-6">Still have questions? We're happy to help.</p>
  <a href="https://wa.me/94763572475?text=Hi%2C%20Zenvesture%2C%20I%20am%20interested%20in%20your%20collection%2C%20shall%20we%20discuss%3F"
     target="_blank" rel="noopener noreferrer"
     class="inline-block px-8 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition duration-300 font-medium">
    Contact Us
  </a>
</div>

        </div>
    </section>


    <!-- Footer -->
   <footer class="bg-gray-900 text-gray-400">
  <div class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

      <!-- Brand Info -->
      <div data-aos="fade-up" data-aos-duration="800">
        <h3 class="text-white text-xl font-bold mb-6">ZenVesture</h3>
        <p class="mb-4">
          Luxury modest fashion designed for the modern woman. Elegant abayas and shawls crafted with care.
        </p>
        <div class="flex space-x-4">
          <a href="https://www.facebook.com/zenvesture" target="_blank" class="text-gray-400 hover:text-white" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://www.instagram.com/zenvesture" target="_blank" class="text-gray-400 hover:text-white" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.pinterest.com/zenvesture" target="_blank" class="text-gray-400 hover:text-white" aria-label="Pinterest">
            <i class="fab fa-pinterest"></i>
          </a>
          <a href="https://www.youtube.com/@zenvesture" target="_blank" class="text-gray-400 hover:text-white" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

      <!-- Shop Links -->
      <div data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
        <h4 class="text-white font-medium mb-6">Shop</h4>
        <ul class="space-y-3">
          <li><a href="#collections" class="hover:text-white">All Abayas</a></li>
          <li><a href="#collections" class="hover:text-white">Shawls & Wraps</a></li>
          <li><a href="#collections" class="hover:text-white">New Arrivals</a></li>
          <li><a href="#collections" class="hover:text-white">Best Sellers</a></li>
          <li><a href="#collections" class="hover:text-white">Gift Cards</a></li>
        </ul>
      </div>

      <!-- Customer Service -->
      <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
        <h4 class="text-white font-medium mb-6">Customer Service</h4>
        <ul class="space-y-3">
          <li><a href="#contact" class="hover:text-white">Contact Us</a></li>
          <li><a href="#contact" class="hover:text-white">FAQs</a></li>
          <li><a href="#contact" class="hover:text-white">Shipping Info</a></li>
          <li><a href="#contact" class="hover:text-white">Size Guide</a></li>
          <li><a href="#contact" class="hover:text-white">Terms & Conditions</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
        <h4 class="text-white font-medium mb-6">Contact Info</h4>
        <address class="not-italic">
          <p class="mb-3">
            31/91 Avissawella Road,<br>
            Wellampittiya,<br>
            Colombo<br>
            Sri Lanka
          </p>
          <p class="mb-3">
            <a href="tel:+94763572475" class="hover:text-white">+94 763 572 475</a>
          </p>
          <p>
            <a href="mailto:zenvesture.lk@gmail.com" class="hover:text-white">zenvesture.lk@gmail.com</a>
          </p>
        </address>
      </div>
      
    </div>
  </div>


            
            <!-- Footer Section -->
<footer class="border-t border-gray-800 pt-8">
  <div class="text-center text-gray-500 text-sm" data-aos="fade-up">
    <p>&copy; 2023 ZenVesture. All rights reserved.</p>
    
   <div class="flex justify-center space-x-6 mt-4 relative">
  <!-- Terms of Service -->
  <div class="group relative">
    <a href="#" class="hover:text-white transition-colors duration-300">Terms of Service</a>
    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 w-80 p-4 bg-white text-sm text-gray-700 shadow-lg rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-50">
      <strong>Terms & Conditions</strong><br />
      Welcome to ZenVesture. By accessing or using our website (www.zenvesture.lk), you agree to the following terms.<br /><br />
      <strong>1. General:</strong> We may update terms anytime. Continued use = acceptance.<br />
      <strong>2. Products:</strong> Items may slightly differ due to screen settings.<br />
      <strong>3. Orders:</strong> Full payment required.<br />
      <strong>4. Delivery:</strong> We dispatch within the mentioned time.<br />
      <strong>5. No Returns:</strong> No exchange or return once purchased.<br />
      <strong>6. IP:</strong> No copying content.<br />
    </div>
  </div>

  <!-- Privacy Policy -->
  <div class="group relative">
    <a href="#" class="hover:text-white transition-colors duration-300">Privacy Policy</a>
    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 w-80 p-4 bg-white text-sm text-gray-700 shadow-lg rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-50">
      <strong>Privacy Policy</strong><br />
      Your data is protected and used only for order processing, customer service, and communication.
    </div>
  </div>
</div>


    <p class="mt-6">Payment methods we accept:</p>
    <div class="flex justify-center space-x-4 mt-2 text-xl text-white">
      <i class="fab fa-cc-visa"></i>
      <i class="fab fa-cc-mastercard"></i>
      <i class="fab fa-cc-paypal"></i>
    </div>

    <p class="mt-9 text-xs">
      Developed by <strong><a href="www.facebook.com/mhm-humaidh">Cyber Bro IT Solution</a></strong> © 2025
    </p>
  </div>
</footer>

    
<script>
  window.addEventListener('load', () => {
    const container = document.getElementById('three-container');
    container.classList.remove('opacity-0');
    container.classList.add('opacity-100');
  });
</script>

    <!-- Include AOS -->
     <!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
  duration: 1000,
  once: false,  // Animate every time element scrolls into view
  mirror: true, // Also animate elements when scrolling back up
});
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true,
  });

  // Global variables
  let currentSlide = 0;
  let slides = [];
  let slideIndicators = [];

  document.addEventListener('DOMContentLoaded', function () {
    // AOS Elements observer
    const aosElements = document.querySelectorAll('[data-aos]');
    aosElements.forEach(el => {
      const animation = el.getAttribute('data-aos');
      el.classList.add('aos-fade', `aos-${animation}`);

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('aos-animate');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      observer.observe(el);
    });

    // Mobile menu toggle
    const menuButton = document.getElementById('mobile-menu-button');
    const closeButton = document.getElementById('close-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuButton && mobileMenu) {
      menuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
      });
    }

    if (closeButton && mobileMenu) {
      closeButton.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
      });
    }

    // Product filtering
    const categoryButtons = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.product-card');

    categoryButtons.forEach(button => {
      button.addEventListener('click', function () {
        const category = this.getAttribute('data-category');

        categoryButtons.forEach(btn => {
          btn.classList.toggle('bg-gray-800', btn === this);
          btn.classList.toggle('text-white', btn === this);
          btn.classList.toggle('bg-white', btn !== this);
          btn.classList.toggle('text-gray-800', btn !== this);
        });

        productCards.forEach(card => {
          const categories = card.getAttribute('data-categories').split(' ');
          card.style.display = category === 'all' || categories.includes(category) ? 'block' : 'none';
        });
      });
    });

    // Tooltip for size guide
    const sizeGuides = document.querySelectorAll('.size-guide');
    sizeGuides.forEach(guide => {
      guide.addEventListener('mouseenter', () => {
        guide.querySelector('.size-tooltip').style.opacity = '1';
        guide.querySelector('.size-tooltip').style.visibility = 'visible';
      });
      guide.addEventListener('mouseleave', () => {
        guide.querySelector('.size-tooltip').style.opacity = '0';
        guide.querySelector('.size-tooltip').style.visibility = 'hidden';
      });
    });

    // Accordion
    const accordionButtons = document.querySelectorAll('.accordion-toggle');
    accordionButtons.forEach(button => {
      button.addEventListener('click', function () {
        const accordion = this.parentElement;
        const content = accordion.querySelector('.accordion-content');
        accordion.classList.toggle('active');
        content.style.maxHeight = accordion.classList.contains('active') ? content.scrollHeight + 'px' : '0';
      });
    });

    // Collections slider
    slides = document.querySelectorAll('[data-slide]');
    slideIndicators = document.querySelectorAll('.slide-indicator');

    if (slides.length > 0) {
      showSlide(currentSlide);

      document.getElementById('next-slide')?.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      });

      document.getElementById('prev-slide')?.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
      });

      slideIndicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
          currentSlide = index;
          showSlide(currentSlide);
        });
      });

      setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }, 8000);
    }

    // Contact form
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
      contactForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formMessage = document.getElementById('form-message');
        formMessage.className = 'mt-4 px-4 py-3 rounded-sm bg-green-100 text-green-800';
        formMessage.textContent = 'Your message has been sent successfully!';
        formMessage.classList.remove('hidden');

        setTimeout(() => contactForm.reset(), 2000);
        setTimeout(() => formMessage.classList.add('hidden'), 5000);
      });
    }

    // Terms modal
    const termsBtn = document.getElementById('terms-btn');
    const termsModal = document.getElementById('terms-modal');
    const closeTerms = document.getElementById('close-terms');

    if (termsBtn && termsModal && closeTerms) {
      termsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        termsModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      });

      closeTerms.addEventListener('click', () => {
        termsModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
      });

      termsModal.addEventListener('click', (e) => {
        if (e.target === termsModal) {
          termsModal.classList.add('hidden');
          document.body.style.overflow = 'auto';
        }
      });
    }

    // Preloader
    setTimeout(() => {
      const preloader = document.getElementById('preloader');
      preloader.style.opacity = '0';
      preloader.style.pointerEvents = 'none';
      setTimeout(() => {
        preloader.style.display = 'none';
      }, 500);
    }, 1500);

    // GSAP Animations
    gsap.utils.toArray('.floating-element').forEach(element => {
      gsap.from(element, {
        y: 50,
        opacity: 0,
        duration: 1,
        scrollTrigger: {
          trigger: element,
          start: "top 80%",
          toggleActions: "play none none none"
        }
      });
    });

    gsap.utils.toArray('section').forEach(section => {
      gsap.from(section, {
        opacity: 0,
        y: 50,
        duration: 1,
        scrollTrigger: {
          trigger: section,
          start: "top 80%",
          toggleActions: "play none none none"
        }
      });
    });

    // Three.js
    initThreeJS();
  });

  // Show slide
  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.opacity = i === index ? '1' : '0';
    });
    slideIndicators.forEach((indicator, i) => {
      indicator.classList.toggle('active', i === index);
      indicator.classList.toggle('bg-gray-400', i !== index);
      indicator.classList.toggle('bg-gray-800', i === index);
    });
  }

  // Init Three.js
  function initThreeJS() {
    const container = document.getElementById('three-container');
    if (!container) return;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);

    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(1, 1, 1);

    scene.add(ambientLight, directionalLight);

    const cube = new THREE.Mesh(
      new THREE.BoxGeometry(2, 3, 1),
      new THREE.MeshPhongMaterial({ color: 0xdddddd, shininess: 100 })
    );
    scene.add(cube);

    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCnt = 2000;
    const posArray = new Float32Array(particlesCnt * 3);
    const colorArray = new Float32Array(particlesCnt * 3);

    for (let i = 0; i < particlesCnt * 3; i++) {
      posArray[i] = (Math.random() - 0.5) * 10;
      colorArray[i] = Math.random();
    }

    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    particlesGeometry.setAttribute('color', new THREE.BufferAttribute(colorArray, 3));

    const particlesMaterial = new THREE.PointsMaterial({
      size: 0.02,
      transparent: true,
      opacity: 0.8,
      vertexColors: true,
      blending: THREE.AdditiveBlending
    });

    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);

    function animate() {
      requestAnimationFrame(animate);
      cube.rotation.x += 0.005;
      cube.rotation.y += 0.01;
      particlesMesh.rotation.y -= 0.001;
      renderer.render(scene, camera);
    }

    animate();

    window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    });
  }
  // Category filter functionality
const buttons = document.querySelectorAll('.category-btn');
const productsGrid = document.getElementById('products-grid');
const products = productsGrid.querySelectorAll('.product-card');

buttons.forEach(button => {
  button.addEventListener('click', () => {
    const category = button.getAttribute('data-category');

    // Update active button styles
    buttons.forEach(btn => btn.classList.remove('bg-gray-800', 'text-white'));
    button.classList.add('bg-gray-800', 'text-white');

    // Filter products
    products.forEach(product => {
      const categories = product.getAttribute('data-categories').split(' ');
      if (category === 'all' || categories.includes(category)) {
        product.style.display = 'block';
      } else {
        product.style.display = 'none';
      }
    });

    // Animate visible products after filter change
    animateProducts();
  });
});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
  gsap.registerPlugin(ScrollTrigger);

  document.querySelectorAll("[data-slide]").forEach((slide) => {
    const img = slide.querySelector(".slide-left");
    const content = slide.querySelector(".slide-right");

    gsap.fromTo(
      img,
      { x: "-100%", opacity: 0 },
      {
        x: "0%",
        opacity: 1,
        duration: 1.2,
        ease: "power3.out",
        scrollTrigger: {
          trigger: slide,
          start: "top 80%",
          end: "bottom top",
          toggleActions: "play none none reset",
        },
      }
    );

    gsap.fromTo(
      content,
      { x: "100%", opacity: 0 },
      {
        x: "0%",
        opacity: 1,
        duration: 1.2,
        ease: "power3.out",
        scrollTrigger: {
          trigger: slide,
          start: "top 80%",
          end: "bottom top",
          toggleActions: "play none none reset",
        },
      }
    );
  });
</script>
<script>
function sendWhatsAppMessage(event) {
    event.preventDefault(); // Prevent form from submitting normally

    // Get input values
    const name = document.getElementById('name').value.trim();
    const location = document.getElementById('location').value.trim();
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value.trim();

    // Format WhatsApp message
    const whatsappMessage = `Hello,%0A%0A*Name:* ${name}%0A*Location:* ${location}%0A*Subject:* ${subject}%0A*Message:* ${message}`;

    // WhatsApp Number
    const phoneNumber = "94763572475";

    // Open WhatsApp in new tab
    const url = `https://wa.me/${phoneNumber}?text=${whatsappMessage}`;
    window.open(url, '_blank');
}
</script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"/>
<script>
  AOS.init();
  AOS.init({
  once: false, // ensures animation works every scroll
  duration: 800,
  easing: 'ease-in-out'
});
</script>

<script>
  const sections = document.querySelectorAll('section');
  const navLinks = document.querySelectorAll('.nav-link');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 80;
      const sectionHeight = section.clientHeight;
      if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
        current = section.getAttribute('id');
      }
    });

    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === `#${current}`) {
        link.classList.add('active');
      }
    });
  });
    // Initialize AOS (Animate On Scroll) library
  AOS.init();
  
  // Alternative scroll animation without AOS
  document.addEventListener('DOMContentLoaded', function() {
    const animatedItems = document.querySelectorAll('.animated-item');
    
    function checkScroll() {
      animatedItems.forEach((item, index) => {
        const itemTop = item.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (itemTop < windowHeight - 100) {
          setTimeout(() => {
            item.classList.add('animate');
          }, index * 100);
        }
      });
    }
    
    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Check on load
  });
  
    // Scroll animation
    document.addEventListener('DOMContentLoaded', function() {
        const collectionsSection = document.getElementById('collections');
        let lastScrollPosition = window.scrollY;
        
        // Function to check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom >= 0
            );
        }
        
        // Function to handle scroll animation
        function handleScrollAnimation() {
            const currentScrollPosition = window.scrollY;
            const scrollDirection = currentScrollPosition > lastScrollPosition ? 'down' : 'up';
            lastScrollPosition = currentScrollPosition;
            
            if (isInViewport(collectionsSection)) {
                collectionsSection.classList.add('animate-in');
                collectionsSection.classList.add(scrollDirection === 'down' ? 'scroll-down' : 'scroll-up');
            }
        }
        
        // Initial check on load
        if (isInViewport(collectionsSection)) {
            collectionsSection.classList.add('animate-in', 'scroll-down');
        }
        
        // Listen for scroll events
        window.addEventListener('scroll', handleScrollAnimation);
        
        // Slider functionality
        const slides = document.querySelectorAll('[data-slide]');
        const indicators = document.querySelectorAll('.slide-indicator');
        const prevButton = document.getElementById('prev-slide');
        const nextButton = document.getElementById('next-slide');
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === index);
                slide.classList.toggle('opacity-0', i !== index);
            });
            
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
                indicator.classList.toggle('bg-gray-300', i !== index);
                indicator.classList.toggle('bg-rose-500', i === index);
            });
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }
        
        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        
        // Auto slide if desired
        // setInterval(nextSlide, 5000);
    });

</script>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.10.0/firebase-app.js";
  import { getFirestore, collection, getDocs } from "https://www.gstatic.com/firebasejs/11.10.0/firebase-firestore.js";

  const firebaseConfig = {
    // your firebase config
  };
  const app = initializeApp(firebaseConfig);
  const db = getFirestore(app);

  async function loadProducts() {
    const productsCol = collection(db, "products");
    const snapshot = await getDocs(productsCol);
    const products = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
    renderProducts(products);
  }

  function renderProducts(products) {
    const grid = document.getElementById('products-grid');
    grid.innerHTML = ''; // clear any content

    products.forEach(product => {
      const categories = product.category ? product.category.toLowerCase().split(' ') : [];
      grid.innerHTML += `
        <div class="product-card group bg-white shadow-sm hover:shadow-lg transition duration-300" data-categories="${categories.join(' ')}" data-aos="fade-up">
          <div class="product-3d-container relative overflow-hidden h-80">
            <img src="${product.imageUrl}" alt="${product.title}" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
              <div class="p-4 translate-y-5 group-hover:translate-y-0 transition duration-300">
                <button class="w-full bg-white text-gray-800 py-2 px-4 font-medium hover:bg-gray-100 transition duration-200">Quick View</button>
              </div>
            </div>
          </div>
          <div class="p-4">
            <h3 class="text-lg font-medium text-gray-800 mb-1">${product.title}</h3>
            <div class="flex items-center mb-2">
              <div class="flex text-amber-400 text-sm">
                ${renderStars(product.rating)}
              </div>
              <span class="text-gray-600 text-sm ml-2">(${product.reviewsCount || 0})</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-800 font-medium">$${product.price.toFixed(2)}</span>
              <button class="text-rose-500 hover:text-rose-700"><i class="fas fa-heart"></i></button>
            </div>
          </div>
        </div>`;
    });
  }

  // Helper function to render star icons based on rating
  function renderStars(rating = 0) {
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5 ? 1 : 0;
    const emptyStars = 5 - fullStars - halfStar;
    return '★'.repeat(fullStars) + (halfStar ? '½' : '') + '☆'.repeat(emptyStars); 
    // For actual icons, you'd replace with <i> elements similarly
  }

  loadProducts();
</script>
<!-- ========= BOOTSTRAP 5 (for carousel) ========= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ========= FRONT-END CATEGORY FILTER (unchanged) ========= -->
<script>
const buttons = document.querySelectorAll('.category-btn');
const cards   = document.querySelectorAll('.product-card');
buttons.forEach(btn=>btn.addEventListener('click', ()=>{
  const cat = btn.dataset.category;
  cards.forEach(c=>{
    const show = cat==='all' || c.dataset.category===cat;
    c.style.display = show ? 'block' : 'none';
  });
}));
</script>
<!-- place this right before </body> -->
<script defer>
/* ---------- CATEGORY FILTER ---------- */
const buttons = document.querySelectorAll('.category-btn');
const cards   = document.querySelectorAll('.product-card');
const mapBtnToJson = {
  all   : 'all',
  abayas: 'Abayas',
  shawls: 'Shawls',
  new   : 'New Arrivals',
  best  : 'Best Sellers'
};
buttons.forEach(btn => btn.addEventListener('click', () => {
  const filter = mapBtnToJson[btn.dataset.category];
  cards.forEach(card => {
    card.style.display = (filter === 'all' || card.dataset.category === filter) ? 'block' : 'none';
  });
}));
</script>
<!-- ===== WHATSAPP FLOATING BUTTON ===== -->
<a  href="https://wa.me/+94763572475?text=Hi%2C%20Zenvesture%2C%20I%20am%20interested%20in%20your%20collection%2C%20shall%20we%20discuss%3F"
    class="wa-float"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Chat on WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<!-- ===== SCROLL-TO-TOP BUTTON ===== -->
<button id="scrollTop" class="scroll-top" aria-label="Scroll to top">
  <i class="fas fa-chevron-up"></i>
</button>

<!-- Font Awesome (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script>
/* Show / hide scroll-to-top */
const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  if (window.scrollY > 300) {
    scrollBtn.classList.add('show');
  } else {
    scrollBtn.classList.remove('show');
  }
});
/* Scroll to top on click */
scrollBtn.addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
<script>
/*  Re-trigger left-slide on every scroll-into-view  */
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    } else {
      /* remove class when it leaves so it can animate again */
      entry.target.classList.remove('show');
    }
  });
}, { threshold: 0.2 });

/*  Apply to the whole section  */
const shopSection = document.getElementById('shop');
shopSection.classList.add('slide-in-left');
observer.observe(shopSection);
</script>
</body>
</html>