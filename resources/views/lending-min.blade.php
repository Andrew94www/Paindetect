<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAPID PAIN - An Innovative Solution for Pain Relief</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .cta-button {
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .creator-card {
            background: #f8fafc; /* bg-slate-50 */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 2rem; /* p-8 */
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold text-gray-900">
            <span class="text-blue-600">RAPID</span> PAIN
        </div>
        <div class="flex space-x-8">
            <a href="#solution" class="text-gray-600 hover:text-blue-600">The Solution</a>
            <a href="#creator" class="text-gray-600 hover:text-blue-600">The Creators</a>
        </div>
    </nav>
</header>

<!-- Hero Section -->
<section class="hero-gradient py-20 md:py-32">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4 leading-tight">Reclaim Your Life Without Pain</h1>
        <p class="text-lg md:text-xl text-gray-700 mb-8 max-w-3xl mx-auto">"RAPID PAIN" is the result of years of collaborative research, aimed at the effective and safe elimination of chronic pain.</p>
        <a href="#creator" class="bg-blue-600 text-white px-10 py-4 rounded-full font-bold text-lg cta-button inline-block">Meet the Creators</a>
    </div>
</section>

<!-- Solution Section -->
<section id="solution" class="py-20">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap items-center -mx-4">
            <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                <img src="https://placehold.co/600x400/3b82f6/ffffff?text=RAPID+PAIN" alt="RAPID PAIN Product Image" class="rounded-lg shadow-2xl">
            </div>
            <div class="w-full md:w-1/2 px-4">
                <span class="text-blue-600 font-semibold">A SCIENTIFIC APPROACH</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">"RAPID PAIN": Targeted Action on the Source of Pain</h2>
                <p class="text-gray-600 mb-6">"RAPID PAIN" is an innovative cream-gel designed for deep penetration and direct action on nerve endings and inflamed tissues. Its formula is based on a synergy of natural components and modern biotechnology.</p>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 bg-green-500 text-white rounded-full flex items-center justify-center mr-4">✓</div>
                        <p class="text-gray-700">Eliminates inflammation and swelling.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 bg-green-500 text-white rounded-full flex items-center justify-center mr-4">✓</div>
                        <p class="text-gray-700">Blocks the transmission of pain signals.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 bg-green-500 text-white rounded-full flex items-center justify-center mr-4">✓</div>
                        <p class="text-gray-700">Stimulates the regeneration of damaged tissues.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Creator Section -->
<section id="creator" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">About the Creators</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">The minds behind the revolutionary "RAPID PAIN" formula.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Creator 1 -->
            <div class="creator-card">
                <img src="https://placehold.co/300x300/e2e8f0/334155?text=Professor" alt="Photo of Professor Dmitry Dmitriev" class="rounded-full w-40 h-40 mb-6 shadow-lg">
                <h3 class="text-2xl font-semibold text-blue-600 mb-2">Dmitry Dmitriev</h3>
                <p class="text-gray-600">Professor, Doctor of Medical Sciences, Head of the Department of Nervous Diseases at the Vinnytsia National Pirogov Memorial Medical University. Author of over 250 scientific papers on neurology and the treatment of pain syndromes.</p>
            </div>
            <!-- Creator 2 (Placeholder) -->
            <div class="creator-card">
                <img src="https://placehold.co/300x300/e2e8f0/334155?text=Scientist" alt="Photo of the second creator" class="rounded-full w-40 h-40 mb-6 shadow-lg">
                <h3 class="text-2xl font-semibold text-blue-600 mb-2">Dr. Andrii Popelnukha</h3>
                <p class="text-gray-600">Leading biochemist specializing in transdermal delivery systems. Dr. Chen's expertise was crucial in developing a formula that penetrates deep into the tissue for maximum effectiveness. (Please edit this text).</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; 2024 RAPID PAIN. All rights reserved.</p>
        <p class="text-sm text-gray-400 mt-2">This product is not a medicinal drug. Consult a specialist before use.</p>
    </div>
</footer>

</body>
</html>
