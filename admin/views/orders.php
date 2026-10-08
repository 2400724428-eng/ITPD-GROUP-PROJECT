


<!-- SCREEN: ORDERS -->
<div id="screen-orders" class="screen-fade hidden max-w-5xl">
  <h1 class="text-xl font-bold text-slate-900 mb-6">Customer Orders</h1>

  <!-- Orders Table Card -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Order ID</th>
            <th class="py-3.5 px-4">Customer & Items</th>
            <th class="py-3.5 px-4">Payment</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <!-- Row 1: Pay After Delivery -->
          <tr class="hover:bg-slate-50/80 transition-colors">
            <td class="py-3.5 px-4 font-medium text-slate-900">#QC-8093</td>
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">David Mukasa</div>
              <div class="text-xs text-slate-500">1x Smart Watch • Total: $99.99</div>
            </td>
            <td class="py-3.5 px-4 text-slate-600 text-xs">Pay After Delivery</td>
            <td class="py-3.5 px-4 text-amber-600 text-xs font-medium">Delivered (Pending Cash)</td>
            <td class="py-3.5 px-4 text-right">
              <button onclick="alert('Payment collected and order #QC-8093 approved!')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                Approve
              </button>
            </td>
          </tr>

          <!-- Row 2: Pre-paid order -->
          <tr class="hover:bg-slate-50/80 transition-colors">
            <td class="py-3.5 px-4 font-medium text-slate-900">#QC-8092</td>
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">John Okello</div>
              <div class="text-xs text-slate-500">1x Wireless Bluetooth Earbuds • Total: $59.99</div>
            </td>
            <td class="py-3.5 px-4 text-slate-600 text-xs">Paid (Prepaid)</td>
            <td class="py-3.5 px-4 text-amber-600 text-xs font-medium">Out for Delivery</td>
            <td class="py-3.5 px-4 text-right">
              <button onclick="alert('Order #QC-8092 successfully approved!')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                Approve
              </button>
            </td>
          </tr>

          <!-- Row 3: Completed pre-paid order -->
          <tr class="hover:bg-slate-50/80 transition-colors">
            <td class="py-3.5 px-4 font-medium text-slate-900">#QC-8091</td>
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">Sarah Namubiru</div>
              <div class="text-xs text-slate-500">1x Active Noise Cancelling Headphones • Total: $129.99[cite: 5]</div>
            </td>
            <td class="py-3.5 px-4 text-slate-600 text-xs">Paid (Prepaid)</td>
            <td class="py-3.5 px-4 text-emerald-600 text-xs font-medium">Completed[cite: 5]</td>
            <td class="py-3.5 px-4 text-right">
              <span class="text-xs text-slate-400 italic">Done</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>