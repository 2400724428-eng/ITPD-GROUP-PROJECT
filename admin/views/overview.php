<div id="screen-gym-dashboard" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Dashboard Overview</h1>
      <p class="text-sm text-slate-500 mt-0.5">Key performance indicators, daily check-ins, and revenue overview.</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
      System Online & Active
    </span>
  </div>

  <!-- Metric Summary Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Members</div>
      <div class="text-2xl font-bold text-slate-900 mt-2">342</div>
      <div class="text-xs text-emerald-600 font-medium mt-1">+12% from last month</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Today's Check-ins</div>
      <div class="text-2xl font-bold text-slate-900 mt-2">68</div>
      <div class="text-xs text-blue-600 font-medium mt-1">Peak hour: 5:00 PM</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Classes Booked</div>
      <div class="text-2xl font-bold text-slate-900 mt-2">24</div>
      <div class="text-xs text-slate-500 font-medium mt-1">4 sessions running today</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-sm p-5 shadow-sm">
      <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Monthly Revenue</div>
      <div class="text-2xl font-bold text-slate-900 mt-2">UGX 14.2M</div>
      <div class="text-xs text-emerald-600 font-medium mt-1">Target: UGX 15M</div>
    </div>
  </div>

  <!-- Recent Activity Table -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-200 font-semibold text-sm text-slate-800">Recent Member Sign-ups</div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3 px-4">Member Name</th>
            <th class="py-3 px-4">Plan Selected</th>
            <th class="py-3 px-4">Amount Paid</th>
            <th class="py-3 px-4">Date</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3 px-4 font-medium text-slate-900">Ronald Kigozi</td>
            <td class="py-3 px-4 text-slate-700">Pro · 1 Month</td>
            <td class="py-3 px-4 text-slate-700">UGX 300,000</td>
            <td class="py-3 px-4 text-xs text-slate-500">Oct 6, 2026</td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3 px-4 font-medium text-slate-900">Doreen Nagawa</td>
            <td class="py-3 px-4 text-slate-700">Nutrition Coaching · 3 Months</td>
            <td class="py-3 px-4 text-slate-700">UGX 180,000</td>
            <td class="py-3 px-4 text-xs text-slate-500">Oct 5, 2026</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>