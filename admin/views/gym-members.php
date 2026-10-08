<div id="screen-gym-members" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Members</h1>
      <p class="text-sm text-slate-500 mt-0.5">Manage registered members, active profiles, and membership statuses.</p>
    </div>
    <button onclick="alert('Open Add Member Modal')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
      + Add New Member
    </button>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Member</th>
            <th class="py-3.5 px-4">Contact</th>
            <th class="py-3.5 px-4">Active Plan</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Ronald Kigozi</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">+256 772 123456</td>
            <td class="py-3.5 px-4 text-slate-700">Gym Membership (Pro)</td>
            <td class="py-3.5 px-4"><span class="px-2 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">Active</span></td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('Viewing member profile')" class="text-xs font-medium text-blue-600 hover:text-blue-800">View</button>
              <button onclick="alert('Deactivating member')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Deactivate</button>
            </td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Doreen Nagawa</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">+256 701 987654</td>
            <td class="py-3.5 px-4 text-slate-700">Nutrition Coaching</td>
            <td class="py-3.5 px-4"><span class="px-2 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">Active</span></td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('Viewing member profile')" class="text-xs font-medium text-blue-600 hover:text-blue-800">View</button>
              <button onclick="alert('Deactivating member')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Deactivate</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>