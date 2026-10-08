<div id="screen-settings" class="screen-fade max-w-4xl hidden">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">System Settings</h1>
    <p class="text-sm text-slate-500 mt-0.5">Configure system preferences, notification toggles, and application defaults.</p>
  </div>

  <div class="space-y-6">
    <!-- General Settings Card -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-6">
      <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">General Preferences</h2>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm font-medium text-slate-800">Email Notifications</div>
            <div class="text-xs text-slate-500">Receive alerts for new orders and gym sign-ups.</div>
          </div>
          <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500" />
        </div>
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm font-medium text-slate-800">Automatic Check-in Logs</div>
            <div class="text-xs text-slate-500">Record daily member gym check-ins automatically.</div>
          </div>
          <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500" />
        </div>
      </div>
    </div>

    <!-- Security Settings Card -->
    <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-6">
      <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Security & Password</h2>
      <form onsubmit="event.preventDefault(); alert('Password updated successfully!');" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Current Password</label>
          <input type="password" placeholder="••••••••" class="w-full sm:w-1/2 text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">New Password</label>
          <input type="password" placeholder="••••••••" class="w-full sm:w-1/2 text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
          Update Password
        </button>
      </form>
    </div>
  </div>
</div>