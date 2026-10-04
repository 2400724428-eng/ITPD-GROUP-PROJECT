<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PeakForm Gym — Train. Transform. Triumph.</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',
            500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a'
          }
        },
        fontFamily: {
          display: ['"Sora"','sans-serif'],
          body: ['"Inter"','sans-serif']
        }
      }
    }
  }
</script>


<body>
    




<?php
include '../includes/top.php'; 
?>






<!-- ══════════ SUBSCRIPTIONS ══════════ -->
<section id="subscriptions" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <p class="text-brand-600 font-semibold text-sm uppercase tracking-widest">Membership</p>
      <h2 class="mt-2 text-4xl font-bold text-brand-900">Gym Subscriptions</h2>
      <p class="mt-3 text-slate-600 max-w-xl mx-auto">Flexible monthly plans. Cancel anytime, no hidden fees.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="card-hover rounded-3xl border border-brand-200 p-8 bg-white">
        <h3 class="font-bold text-lg text-brand-900">Basic</h3>
        <p class="text-4xl font-extrabold text-brand-900 mt-4">$29<span class="text-base font-medium text-slate-500">/mo</span></p>
        <ul class="mt-6 space-y-3 text-sm text-slate-600">
          <li>✓ Full gym floor access</li>
          <li>✓ 4 group classes / month</li>
          <li>✓ Locker & showers</li>
          <li class="text-slate-300">✗ Personal training</li>
        </ul>
        <a href="#booking" class="mt-8 block text-center px-5 py-3 rounded-xl border border-brand-300 text-brand-700 font-semibold hover:bg-brand-50 transition">Choose Basic</a>
      </div>
      <div class="card-hover relative rounded-3xl bg-gradient-to-b from-brand-700 to-brand-900 p-8 text-white shadow-2xl shadow-brand-900/30">
        <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow">BEST VALUE</span>
        <h3 class="font-bold text-lg">Pro</h3>
        <p class="text-4xl font-extrabold mt-4">$59<span class="text-base font-medium text-brand-200">/mo</span></p>
        <ul class="mt-6 space-y-3 text-sm text-brand-50">
          <li>✓ Unlimited gym access</li>
          <li>✓ Unlimited group classes</li>
          <li>✓ 1 personal session / month</li>
          <li>✓ Guest pass every month</li>
        </ul>
        <a href="#booking" class="mt-8 block text-center px-5 py-3 rounded-xl bg-white text-brand-800 font-bold hover:bg-brand-50 transition">Choose Pro</a>
      </div>
      <div class="card-hover rounded-3xl border border-brand-200 p-8 bg-white">
        <h3 class="font-bold text-lg text-brand-900">All-Access</h3>
        <p class="text-4xl font-extrabold text-brand-900 mt-4">$99<span class="text-base font-medium text-slate-500">/mo</span></p>
        <ul class="mt-6 space-y-3 text-sm text-slate-600">
          <li>✓ Everything in Pro</li>
          <li>✓ 4 personal sessions / month</li>
          <li>✓ Nutrition coaching plan</li>
          <li>✓ Sauna & recovery zone</li>
        </ul>
        <a href="#booking" class="mt-8 block text-center px-5 py-3 rounded-xl border border-brand-300 text-brand-700 font-semibold hover:bg-brand-50 transition">Choose All-Access</a>
      </div>
    </div>
  </div>
</section>

</body>