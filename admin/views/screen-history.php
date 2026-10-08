<div id="screen-history" class="screen-fade max-w-4xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Activity History</h1>
      <p class="text-sm text-slate-500 mt-0.5">Audit trail of recent system actions, check-ins, and data modifications.</p>
    </div>
    <button onclick="alert('Exporting log history...')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded transition">
      Export Logs
    </button>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Action / Event</th>
            <th class="py-3.5 px-4">Module</th>
            <th class="py-3.5 px-4">Performed By</th>
            <th class="py-3.5 px-4 text-right">Timestamp</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Allocated Trainer Marcus to Ronald Kigozi</td>
            <td class="py-3.5 px-4 text-slate-700">Gym Management</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">Rwomushana Macarthy</td>
            <td class="py-3.5 px-4 text-right text-xs text-slate-500">Today, 03:42 PM</td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Added new product: Creatine Monohydrate</td>
            <td class="py-3.5 px-4 text-slate-700">QuickCart / Products</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">Rwomushana Macarthy</td>
            <td class="py-3.5 px-4 text-right text-xs text-slate-500">Yesterday, 11:15 AM</td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Updated gym subscription plans</td>
            <td class="py-3.5 px-4 text-slate-700">Gym Subscriptions</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">Rwomushana Macarthy</td>
            <td class="py-3.5 px-4 text-right text-xs text-slate-500">Oct 4, 2026, 09:30 AM</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>