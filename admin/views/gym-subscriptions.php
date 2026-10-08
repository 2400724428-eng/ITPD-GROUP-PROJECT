<div id="screen-gym-subscriptions" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Subscriptions</h1>
      <p class="text-sm text-slate-500 mt-0.5">Track monthly/weekly subscription payments and membership renewals.</p>
    </div>
    <button onclick="alert('Open New Subscription Form')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
      + New Subscription
    </button>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Service</th>
            <th class="py-3.5 px-4">Tier / Package</th>
            <th class="py-3.5 px-4">Amount Paid</th>
            <th class="py-3.5 px-4">Date</th>
            <th class="py-3.5 px-4">Days Left</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Gym Membership</td>
            <td class="py-3.5 px-4 text-slate-700">Pro · 1 month</td>
            <td class="py-3.5 px-4 text-slate-700 font-medium">UGX 300,000</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">28 Sept 2026</td>
            <td class="py-3.5 px-4 text-slate-700">22 Days</td>
            <td class="py-3.5 px-4 text-right">
              <button onclick="alert('Renewing subscription')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Renew</button>
            </td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Personal Training Pack</td>
            <td class="py-3.5 px-4 text-slate-700">4 sessions</td>
            <td class="py-3.5 px-4 text-slate-700 font-medium">UGX 240,000</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">16 Sept 2026</td>
            <td class="py-3.5 px-4 text-slate-700">40 Days</td>
            <td class="py-3.5 px-4 text-right">
              <button onclick="alert('Renewing subscription')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Renew</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>