<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pain Solutions - Revolutionizing Pain Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }
        .gradient-bg {
            /* Deeper, more vibrant gradient */
            background: linear-gradient(135deg, #4c51bf 0%, #6b46c1 100%); /* Indigo to Deep Purple */
        }
        .card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); /* Slightly stronger shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-7px); /* More pronounced lift */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background-color: #4f46e5; /* Primary indigo */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }
        .btn-primary:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        }
        .btn-secondary {
            border: 2px solid #4f46e5;
            color: #4f46e5;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.1);
        }
        .btn-secondary:hover {
            background-color: #4f46e5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.2);
        }
        /* Keyframe animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Apply animations */
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        .animate-slide-in-up {
            animation: slideInUp 0.8s ease-out forwards;
        }
        .icon-pulse {
            animation: pulse 2s infinite ease-in-out;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="antialiased">

<nav class="bg-white shadow-md py-4">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-indigo-700">Pain Solutions</a>
        <div class="hidden md:flex space-x-8">
            <a href="#about" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-300">About Us</a>
            <a href="#solutions" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-300">Solutions</a>
            <a href="#why-us" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-300">Why Choose Us</a>
            <a href="#testimonials" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-300">Testimonials</a>
            <a href="#contact" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-300">Contact</a>
        </div>
        <button class="md:hidden text-gray-600 hover:text-indigo-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>
</nav>

<header class="relative overflow-hidden py-24 lg:py-40 text-white gradient-bg rounded-b-3xl shadow-xl">
    <div class="absolute inset-0 z-0 opacity-15">
        <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
            <defs>
                <pattern id="grid-hero" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 L 0 10" fill="none" stroke="white" stroke-width="0.1"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-hero)"></rect>
        </svg>
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900 to-indigo-900 opacity-60"></div>
    </div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight mb-6 animate-slide-in-up">
            Revolutionizing Pain Management <span class="block lg:inline-block text-yellow-300">with Advanced Solutions</span>
        </h1>
        <p class="text-lg lg:text-2xl mb-12 max-w-4xl mx-auto opacity-90 animate-fade-in delay-200">
            Leveraging Cutting-Edge Technology for Personalized, Effective Pain Treatment and Automated Care.
        </p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 animate-fade-in delay-300">
            <a href="#solutions" class="btn-primary text-white font-semibold py-3 px-10 rounded-full shadow-lg hover:shadow-xl transition duration-300 text-lg">
                Explore Our Solutions
            </a>
            <a href="#contact" class="btn-secondary bg-white font-semibold py-3 px-10 rounded-full shadow-lg hover:shadow-xl transition duration-300 text-lg">
                Get a Free Consultation
            </a>
        </div>
    </div>
</header>

<section id="about" class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl lg:text-5xl font-bold mb-8 text-gray-800">About Our Company</h2>
        <p class="text-xl text-gray-600 max-w-5xl mx-auto leading-relaxed">
            At Pain Solutions, we are a dedicated team of specialists and medical professionals committed to transforming pain management. Our mission is to harness the power of advanced technology to deliver precise, personalized, and proactive pain treatment, improving the quality of life for millions. We believe in a future where chronic pain is effectively managed through smart, automated solutions.
        </p>
    </div>
</section>

<section id="solutions" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl lg:text-5xl font-bold text-center mb-16 text-gray-800">Our Key Solutions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">🧠</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Advanced Diagnostics & Prognosis</h3>
                <p class="text-gray-600 leading-relaxed">Utilize advanced algorithms for accurate diagnosis and prediction of pain progression, enabling early intervention.</p>
            </div>
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">✨</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Personalized Treatment Pathways</h3>
                <p class="text-gray-600 leading-relaxed">Tailored treatment plans generated by intelligent systems, optimizing therapies based on individual patient profiles and responses.</p>
            </div>
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">⏱️</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Automated Pain Monitoring & Alerts</h3>
                <p class="text-gray-600 leading-relaxed">Continuous, non-invasive monitoring of pain levels with automated alerts for clinicians and patients.</p>
            </div>
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">🔮</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Predictive Analytics for Relapse</h3>
                <p class="text-gray-600 leading-relaxed">Identify potential relapse risks and proactively adjust treatment strategies to prevent chronic pain recurrence.</p>
            </div>
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">🧘</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Virtual Pain Therapy & Coaching</h3>
                <p class="text-gray-600 leading-relaxed">Technology-guided virtual therapy sessions and personalized coaching to empower patients in their pain journey.</p>
            </div>
            <div class="card bg-white p-8 rounded-2xl text-center border border-gray-200 flex flex-col items-center">
                <div class="text-6xl text-indigo-600 mb-6 icon-pulse">🔬</div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Drug Discovery & Optimization</h3>
                <p class="text-gray-600 leading-relaxed">Accelerate the discovery of new analgesics and optimize existing drug formulations with advanced computational methods.</p>
            </div>
        </div>
    </div>
</section>

<section id="why-us" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl lg:text-5xl font-bold text-center mb-16 text-gray-800">Why Choose Pain Solutions?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-indigo-600 text-4xl mr-5">🚀</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">Cutting-Edge Technology</h3>
                        <p class="text-gray-600 leading-relaxed">We leverage the latest advancements in data science and machine learning to deliver superior pain management solutions.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-indigo-600 text-4xl mr-5">💖</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">Patient-Centric Approach</h3>
                        <p class="text-gray-600 leading-relaxed">Our solutions are designed with the patient at the forefront, focusing on comfort, efficacy, and ease of use.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-indigo-600 text-4xl mr-5">✅</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">Clinically Validated & Effective</h3>
                        <p class="text-gray-600 leading-relaxed">Our technologies undergo rigorous clinical validation to ensure safety and measurable positive outcomes.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-indigo-600 text-4xl mr-5">👩‍⚕️</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">Expert Medical & Tech Team</h3>
                        <p class="text-gray-600 leading-relaxed">A multidisciplinary team of top data scientists and medical experts drives our innovation and development.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-center p-4">
                <img src="https://placehold.co/600x400/764ba2/ffffff?text=Healthcare+Solutions" alt="Healthcare Solutions" class="rounded-xl shadow-2xl max-w-full h-auto">
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl lg:text-5xl font-bold text-center mb-16 text-gray-800">What Our Patients & Partners Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 flex flex-col justify-between">
                <p class="text-gray-700 italic text-lg mb-8 leading-relaxed">"Pain Solutions transformed how we approach chronic pain. The personalized treatment plans have significantly improved patient outcomes."</p>
                <div class="flex items-center">
                    <img src="https://placehold.co/60x60/indigo/white?text=JD" alt="Client Avatar" class="w-16 h-16 rounded-full mr-4 object-cover">
                    <div>
                        <p class="font-semibold text-gray-800 text-xl">Dr. Jane Doe</p>
                        <p class="text-md text-gray-500">Head of Pain Clinic, City Hospital</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 flex flex-col justify-between">
                <p class="text-gray-700 italic text-lg mb-8 leading-relaxed">"The automated monitoring system is a game-changer. It allows us to intervene faster and provide more consistent care."</p>
                <div class="flex items-center">
                    <img src="https://placehold.co/60x60/indigo/white?text=AS" alt="Client Avatar" class="w-16 h-16 rounded-full mr-4 object-cover">
                    <div>
                        <p class="font-semibold text-gray-800 text-xl">Mr. Alex Smith</p>
                        <p class="text-md text-gray-500">Patient Advocate</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 flex flex-col justify-between">
                <p class="text-gray-700 italic text-lg mb-8 leading-relaxed">"Their predictive analytics helped us reduce readmissions for pain-related issues by 25%. Truly revolutionary technology."</p>
                <div class="flex items-center">
                    <img src="https://placehold.co/60x60/indigo/white?text=RL" alt="Client Avatar" class="w-16 h-16 rounded-full mr-4 object-cover">
                    <div>
                        <p class="font-semibold text-gray-800 text-xl">Dr. Rachel Lee</p>
                        <p class="text-md text-gray-500">Chief Medical Officer, Health Innovations</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl lg:text-5xl font-bold mb-8 text-gray-800">Ready to Transform Pain Management?</h2>
        <p class="text-xl text-gray-600 max-w-4xl mx-auto mb-12">
            Contact us today to discuss how our solutions can revolutionize your approach to pain treatment and patient care.
        </p>
        <form class="max-w-xl mx-auto bg-gray-50 p-10 rounded-2xl shadow-2xl border border-gray-200">
            <div class="mb-6">
                <input type="text" placeholder="Your Name" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg" required>
            </div>
            <div class="mb-6">
                <input type="email" placeholder="Your Email" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg" required>
            </div>
            <div class="mb-6">
                <textarea placeholder="Your Message" rows="6" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg" required></textarea>
            </div>
            <button type="submit" class="btn-primary text-white font-semibold py-4 px-12 rounded-full shadow-lg hover:shadow-xl transition duration-300 w-full text-xl">
                Send Message
            </button>
        </form>
    </div>
</section>

<footer class="gradient-bg text-white py-12 rounded-t-3xl shadow-xl">
    <div class="container mx-auto px-6 text-center">
        <p class="mb-6 text-lg">&copy; 2025 Pain Solutions. All rights reserved.</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-8 text-md">
            <a href="#" class="hover:text-yellow-300 transition duration-300">Privacy Policy</a>
            <a href="#" class="hover:text-yellow-300 transition duration-300">Terms of Service</a>
        </div>
    </div>
</footer>

</body>
</html>
