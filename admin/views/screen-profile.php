<div id="screen-profile" class="screen-fade max-w-4xl hidden">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Your Profile</h1>
    <p class="text-sm text-slate-500 mt-0.5">Manage your personal account details, credentials, and administrator role.</p>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-6 mb-6">
    <div class="flex items-center gap-4 pb-6 border-b border-slate-200">
      <div class="w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl flex items-center justify-center shadow-sm">
        RM
      </div>
      <div>
        <h2 class="text-base font-bold text-slate-900">Rwomushana Macarthy</h2>
        <p class="text-xs text-slate-500">Administrator · PURE GAIN Gym & QuickCart</p>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 mt-1.5">
          Active Account
        </span>
      </div>
    </div>

    <form onsubmit="event.preventDefault(); alert('Profile updated successfully!');" class="space-y-4 pt-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Full Name</label>
          <input type="text" value="Rwomushana Macarthy" class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Address</label>
          <input type="email" value="macarthy@puregain.com" class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Phone Number</label>
          <input type="text" value="+256 700 000000" class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Role / Designation</label>
          <input type="text" value="System Administrator" disabled class="w-full text-sm bg-slate-50 border border-slate-200 rounded-sm p-2 text-slate-500 cursor-not-allowed" />
        </div>
      </div>
      <div class="flex justify-end pt-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>