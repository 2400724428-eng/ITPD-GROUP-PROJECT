<div id="screen-gym-trainers" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Trainer Management & Allocations</h1>
      <p class="text-sm text-slate-500 mt-0.5">Oversee fitness instructors, assign personal trainers to members, and manage staff schedules.</p>
    </div>
    <div class="flex items-center gap-2">
      <button onclick="document.getElementById('allocate-modal').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs rounded shadow-sm transition">
        + Allocate Trainer
      </button>
      <button onclick="alert('Add New Trainer Modal')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
        + Add Trainer
      </button>
    </div>
  </div>

  <!-- Trainers Table -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden mb-8">
    <div class="px-5 py-4 border-b border-slate-200 font-semibold text-sm text-slate-800">Active Instructors & Staff</div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Trainer Name</th>
            <th class="py-3.5 px-4">Specialization</th>
            <th class="py-3.5 px-4">Contact</th>
            <th class="py-3.5 px-4">Assigned Members</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Marcus Byaruhanga</td>
            <td class="py-3.5 px-4 text-slate-700">HIIT & Strength</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">+256 782 555444</td>
            <td class="py-3.5 px-4 text-slate-700">Ronald Kigozi, Brian Mugisha</td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('Viewing roster for Marcus')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Roster</button>
              <button onclick="alert('Removing trainer')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Remove</button>
            </td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Sandra Namubiru</td>
            <td class="py-3.5 px-4 text-slate-700">Nutrition & Yoga</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">+256 704 333222</td>
            <td class="py-3.5 px-4 text-slate-700">Doreen Nagawa</td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('Viewing roster for Sandra')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Roster</button>
              <button onclick="alert('Removing trainer')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ALLOCATE TRAINER MODAL (Hidden by default) -->
  <div id="allocate-modal" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-sm shadow-lg max-w-md w-full p-6 border border-slate-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-slate-900">Assign Trainer to Member</h3>
        <button onclick="document.getElementById('allocate-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-sm font-bold">✕</button>
      </div>
      <form onsubmit="event.preventDefault(); alert('Trainer successfully allocated!'); document.getElementById('allocate-modal').classList.add('hidden');" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Select Gym Member</label>
          <select class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
            <option>Ronald Kigozi (Pro Plan)</option>
            <option>Doreen Nagawa (Nutrition Coaching)</option>
            <option>John Okello (Standard Plan)</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Select Trainer / Instructor</label>
          <select class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
            <option>Marcus Byaruhanga (HIIT & Strength)</option>
            <option>Sandra Namubiru (Nutrition & Yoga)</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Allocation Package / Sessions</label>
          <input type="text" placeholder="e.g., 4 Personal Training Sessions" class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" required />
        </div>
        <div class="flex justify-end space-x-2 pt-2">
          <button type="button" onclick="document.getElementById('allocate-modal').classList.add('hidden')" class="px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded shadow-sm">Confirm Allocation</button>
        </div>
      </form>
    </div>
  </div>
</div>