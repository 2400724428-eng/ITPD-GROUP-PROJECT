<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IronVault - Supplements & Gym Training</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Initial state for JS scroll animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Ripple effect styling */
        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple-effect 0.6s linear;
            pointer-events: none;
        }
        @keyframes ripple-effect {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

  
    <main>
        <!-- Gym Services & Membership Section -->
        <section class="max-w-7xl mx-auto px-4 py-12 border-t border-slate-200">
            
            <!-- Section Header -->
            <div class="text-center mb-12 animate-on-scroll">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Elite Training & Facilities</span>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 mt-1">Gym Services & Membership Plans</h2>
                <p class="text-slate-600 max-w-2xl mx-auto mt-2">Take your physique to the next level with state-of-the-art equipment, professional trainers, and specialized fitness schedules.</p>
            </div>

            <!-- Core Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <!-- Service Card 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm animate-on-scroll transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Strength & Conditioning</h3>
                    <p class="text-slate-600 text-sm">Full access to heavy-duty racks, Olympic weights, pin-loaded machines, and turf areas optimized for progressive overload.</p>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm animate-on-scroll transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="transition-delay: 100ms;">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Personal Training</h3>
                    <p class="text-slate-600 text-sm">One-on-one coaching tailored to your body type, incorporating customized workout splits, form correction, and body composition tracking.</p>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm animate-on-scroll transition-all duration-300 hover:-translate-y-1 hover:shadow-md" style="transition-delay: 200ms;">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Supplement & Diet Stacks</h3>
                    <p class="text-slate-600 text-sm">Integrated nutrition plans combining rigorous training with professional supplementation guidance for maximum lean mass gains.</p>
                </div>
            </div>

            <!-- Pricing Tiers Grid -->
            <div class="mb-16">
                <h3 class="text-2xl font-bold text-center text-slate-900 mb-8 animate-on-scroll">Membership & Training Pricing</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Tier 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm flex flex-col justify-between animate-on-scroll transition-all duration-300 hover:shadow-lg">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Standard Pass</span>
                            <h4 class="text-xl font-bold text-slate-900 mt-4">Daily / Monthly Access</h4>
                            <p class="text-slate-500 text-sm mt-1">Great for flexible gym schedules.</p>
                            <div class="mt-6 mb-6">
                                <span class="text-3xl font-extrabold text-slate-900">UGX 25,000</span>
                                <span class="text-slate-500 text-sm"> / day</span>
                                <div class="text-slate-600 text-sm font-medium mt-1">or UGX 180,000 / month</div>
                            </div>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-center gap-2">✓ Full floor equipment access</li>
                                <li class="flex items-center gap-2">✓ Locker room & shower access</li>
                                <li class="flex items-center gap-2">✓ Free fitness assessment</li>
                            </ul>
                        </div>
                        <button class="ripple-btn relative overflow-hidden mt-8 w-full py-3 px-4 rounded-lg bg-black text-white font-medium text-sm tracking-wide transform transition-all duration-300 ease-in-out hover:bg-slate-900 hover:scale-[1.02] hover:shadow-xl active:scale-[0.98]">Choose Plan</button>
                    </div>

                    <!-- Tier 2 (Highlighted) -->
                    <div class="bg-slate-900 text-white rounded-2xl p-8 shadow-lg flex flex-col justify-between relative ring-2 ring-blue-500 animate-on-scroll transition-all duration-300 hover:shadow-2xl" style="transition-delay: 100ms;">
                        <span class="absolute -top-3 right-6 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Most Popular</span>
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-blue-400 bg-blue-950 px-3 py-1 rounded-full">Pro All-Access</span>
                            <h4 class="text-xl font-bold mt-4">Monthly VIP Pass</h4>
                            <p class="text-slate-400 text-sm mt-1">Total package for dedicated athletes.</p>
                            <div class="mt-6 mb-6">
                                <span class="text-3xl font-extrabold">UGX 250,000</span>
                                <span class="text-slate-400 text-sm"> / month</span>
                            </div>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center gap-2">✓ 24/7 Unlimited Gym Access</li>
                                <li class="flex items-center gap-2">✓ 1 Free Personal Training Session / mo</li>
                                <li class="flex items-center gap-2">✓ 15% discount on all supplements</li>
                                <li class="flex items-center gap-2">✓ Free guest pass per month</li>
                            </ul>
                        </div>
                        <button class="ripple-btn relative overflow-hidden mt-8 w-full py-3 px-4 rounded-lg bg-black text-white font-medium text-sm tracking-wide border border-slate-800 transform transition-all duration-300 ease-in-out hover:bg-slate-900 hover:scale-[1.02] hover:shadow-xl hover:shadow-blue-500/10 active:scale-[0.98]">Join Pro Club</button>
                    </div>

                    <!-- Tier 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm flex flex-col justify-between animate-on-scroll transition-all duration-300 hover:shadow-lg" style="transition-delay: 200ms;">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Personal Coaching</span>
                            <h4 class="text-xl font-bold text-slate-900 mt-4">1-on-1 Trainer Package</h4>
                            <p class="text-slate-500 text-sm mt-1">Custom routines & direct coaching.</p>
                            <div class="mt-6 mb-6">
                                <span class="text-3xl font-extrabold text-slate-900">UGX 200,000</span>
                                <span class="text-slate-500 text-sm"> / 12 sessions</span>
                            </div>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-center gap-2">✓ Dedicated professional trainer</li>
                                <li class="flex items-center gap-2">✓ Custom diet and macro scheduling</li>
                                <li class="flex items-center gap-2">✓ Bi-weekly progress & body scans</li>
                            </ul>
                        </div>
                        <button class="ripple-btn relative overflow-hidden mt-8 w-full py-3 px-4 rounded-lg bg-black text-white font-medium text-sm tracking-wide transform transition-all duration-300 ease-in-out hover:bg-slate-900 hover:scale-[1.02] hover:shadow-xl active:scale-[0.98]">Book Coaching</button>
                    </div>

                </div>
            </div>

        
        </section>
    </main>



    <!-- Custom JavaScript for Animations -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // 1. Scroll Reveal Animation using Intersection Observer
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // 2. Navbar dynamic shadow on scroll
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md', 'bg-white/95');
                } else {
                    navbar.classList.remove('shadow-md', 'bg-white/95');
                }
            });

            // 3. Button Click Ripple Effect
            document.querySelectorAll('.ripple-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

</body>
</html>