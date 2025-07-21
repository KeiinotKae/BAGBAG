<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brgy Bagbag Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary: #ffffff;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #203B6B 0%, #3b82f6 100%);
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg" style="background-color: #00216d;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" >
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="../images/Gaid.png" alt="Brgy Bagbag official seal - circular emblem with 'Barangay Bagbag' text surrounding a shield with mountains and sun motifs in blue and gold colors">
                        <span class="ml-3 text-2xl font-bold text-gray-900">Brgy Bagbag</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#" class="text-gray-900 hover:text-blue-700 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <a href="#services" class="text-gray-500 hover:text-blue-700 px-3 py-2 rounded-md text-sm font-medium">Services</a>
                        <a href="#about" class="text-gray-500 hover:text-blue-700 px-3 py-2 rounded-md text-sm font-medium">About</a>
                        <a href="#contact" class="text-gray-500 hover:text-blue-700 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                        <a href="../login-system/login.php" class="bg-blue-800 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-300">Brgy System</a>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                        <span class="block">Brgy Bagbag</span>
                        <span class="block text-blue-200">Management System</span>
                    </h1>
                    <p class="mt-3 text-xl text-blue-100 max-w-3xl">
                        Modern solutions for efficient barangay administration and community services. 
                        Streamlining processes for residents and officials alike.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="../login-system/login.php" class="btn-primary px-8 py-3 rounded-full text-white text-lg font-semibold shadow-lg hover:shadow-xl transition duration-300 flex items-center justify-center">
                            Access Brgy System <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/606c2316-e11b-4710-88fe-3abb30b9970a.png" alt="Modern barangay hall building with clean architecture, blue accent colors, with smiling officials and residents in front" class="rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Our Services</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Comprehensive services designed to meet all barangay administration needs
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Service 1 -->
                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden p-6 transition duration-300 hover:shadow-lg">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-id-card-alt text-blue-700 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Document Processing</h3>
                        <p class="mt-2 text-gray-500">
                            Efficient processing of barangay clearances, permits, and certifications with our digital system.
                        </p>
                    </div>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden p-6 transition duration-300 hover:shadow-lg">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-users text-blue-700 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Citizen Services</h3>
                        <p class="mt-2 text-gray-500">
                            Easy access to community services including health programs, senior citizen benefits, and more.
                        </p>
                    </div>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card bg-white rounded-xl shadow-md overflow-hidden p-6 transition duration-300 hover:shadow-lg">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-blue-700 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Reports & Analytics</h3>
                        <p class="mt-2 text-gray-500">
                            Comprehensive data analysis and reporting tools for effective barangay management.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-10 lg:mb-0">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/41d70421-d44f-4b68-9da1-c022d0c510b5.png" alt="Group photo of Brgy Bagbag officials in blue polo shirts engaged in meeting at modern conference room" class="rounded-lg shadow-xl">
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">About Brgy Bagbag</h2>
                    <p class="text-xl text-gray-500 mb-4">
                        Barangay Bagbag is committed to providing excellent public service through innovation and community engagement. 
                        Our management system is designed to enhance efficiency in barangay operations while maintaining transparency and accessibility.
                    </p>
                    <p class="text-xl text-gray-500 mb-4">
                        With our digital transformation initiative, we aim to simplify processes for both residents and barangay staff, 
                        reducing paperwork and wait times while improving service quality.
                    </p>
                    <div class="mt-8">
                        <a href="../login-system/login.php" class="btn-primary px-6 py-3 rounded-full text-white font-semibold shadow-lg hover:shadow-xl transition duration-300 inline-flex items-center">
                            Access Brgy System <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Contact Us</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Get in touch with Brgy Bagbag for inquiries and assistance
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-blue-700"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-500">Barangay Bagbag Hall, Main Road, Quezon City</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-phone-alt text-blue-700"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-500">(02) 8765 4321</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-envelope text-blue-700"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-500">info@brgybagbag.gov.ph</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-blue-700"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-500">Monday to Friday: 8:00 AM - 5:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Send Us a Message</h3>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            
                            <button type="submit" class="btn-primary px-6 py-3 rounded-md text-white font-medium hover:bg-blue-700 transition duration-300 w-full">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Brgy Bagbag</h3>
                    <p class="text-gray-400">
                        Committed to serving our community with excellence through innovative solutions and dedicated public service.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Clearances</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Permits</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Certifications</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Utilities</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <div class="mt-6">
                        <a href="/system" class="inline-block bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            Access Brgy System
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2023 Barangay Bagbag Management System. All rights reserved.
                </p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.createElement('div');
            mobileMenu.id = 'mobile-menu';
            mobileMenu.className = 'hidden md:hidden bg-white shadow-lg absolute w-full z-50';
            mobileMenu.innerHTML = `
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-700">Home</a>
                    <a href="#services" class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 hover:text-blue-700">Services</a>
                    <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 hover:text-blue-700">About</a>
                    <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 hover:text-blue-700">Contact</a>
                    <a href="/system" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-800 text-white">Brgy System</a>
                </div>
            `;
            document.body.appendChild(mobileMenu);

            let menuOpen = false;
            mobileMenuButton.addEventListener('click', function() {
                if (menuOpen) {
                    mobileMenu.classList.add('hidden');
                } else {
                    mobileMenu.classList.remove('hidden');
                }
                menuOpen = !menuOpen;
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                const targetId = anchor.getAttribute('href');
                if (targetId !== '#') {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.querySelector(targetId).scrollIntoView({
                            behavior: 'smooth'
                        });
                        mobileMenu.classList.add('hidden');
                        menuOpen = false;
                    });
                }
            });
        });
    </script>
</body>
</html>

