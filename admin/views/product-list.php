<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>QuickCart - Seller Panel</title>
<!-- Tailwind CSS CDN with forms and container queries plugins -->
<link href="../src/output.css" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8'
            }
          }
        }
      }
    }
  </script>
<style>
    body {
      background-color: #ffffff;
      color: #334155;
    }
    input::placeholder, textarea::placeholder {
      color: #94a3b8;
    }
    /* Simple fade/slide animation for screen switching */
    .screen-fade {
      animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased text-slate-800 bg-white">


    <div id="screen-product-list" class="screen-fade hidden max-w-4xl">
      <h1 class="text-xl font-bold text-slate-900 mb-6">All Products</h1>
      <div class="border border-slate-200 rounded overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
              <th class="p-3.5 font-medium">Image</th>
              <th class="p-3.5 font-medium">Name</th>
              <th class="p-3.5 font-medium">Category</th>
              <th class="p-3.5 font-medium">Price</th>
              <th class="p-3.5 font-medium text-right">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-3.5"><div class="w-10 h-10 bg-slate-200 rounded flex items-center justify-center text-xs text-slate-500">Img</div></td>
              <td class="p-3.5 font-medium text-slate-900">Wireless Bluetooth Earbuds</td>
              <td class="p-3.5 text-slate-600">Earphone</td>
              <td class="p-3.5 text-slate-600">$59.99</td>
              <td class="p-3.5 text-right"><button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button></td>
            </tr>
            <tr class="hover:bg-slate-50 transition-colors">
              <td class="p-3.5"><div class="w-10 h-10 bg-slate-200 rounded flex items-center justify-center text-xs text-slate-500">Img</div></td>
              <td class="p-3.5 font-medium text-slate-900">Active Noise Cancelling Headphones</td>
              <td class="p-3.5 text-slate-600">Headphone</td>
              <td class="p-3.5 text-slate-600">$129.99</td>
              <td class="p-3.5 text-right"><button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

 


















    
</body>