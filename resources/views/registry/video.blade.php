<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaProduct | Minimal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#0a0a0a',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0a0a0a; }
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body class="text-white font-sans antialiased">

    <main class="min-h-screen flex flex-col items-center justify-center p-6 md:p-12">
        
        <header class="text-center mb-16 mt-10">
            <h1 class="text-5xl md:text-7xl font-light tracking-tighter mb-4">PAINDETECT</h1>
            <p class="text-gray-500 uppercase tracking-widest text-sm">Іновації в медецині</p>
        </header>

        <section class="w-full max-w-6xl">
            <div class="relative w-full rounded-2xl overflow-hidden glass aspect-video shadow-2xl group">
                <video 
                    id="productVideo" 
                    class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity duration-700"
                    preload="metadata">
                     <source src="{{ asset('img/video_pain.mp4') }}" type="video/mp4">
                </video>
                
                <button id="playBtn" class="absolute inset-0 flex items-center justify-center transition-all duration-500">
                    <div class="w-20 h-20 border border-white/20 rounded-full flex items-center justify-center hover:scale-110 transition-transform bg-white/5 backdrop-blur-sm">
                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </button>
            </div>
        </section>

        <footer class="mt-20 flex gap-8">
           
        </footer>
    </main>

    <script>
        const video = document.getElementById('productVideo');
        const btn = document.getElementById('playBtn');

        btn.addEventListener('click', () => {
            if(video.paused) {
                video.play();
                video.controls = true;
                btn.classList.add('opacity-0');
            }
        });

        video.addEventListener('pause', () => {
            btn.classList.remove('opacity-0');
            video.controls = false;
        });
    </script>
</body>
</html>