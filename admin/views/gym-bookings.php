<div id="screen-gym-bookings" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Class Bookings & Schedule</h1>
      <p class="text-sm text-slate-500 mt-0.5">Monitor upcoming classes, trainer timetables, and participant limits.</p>
    </div>
    <button onclick="alert('Schedule New Class')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
      + Schedule Class
    </button>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Class Name</th>
            <th class="py-3.5 px-4">Trainer</th>
            <th class="py-3.5 px-4">Time Schedule</th>
            <th class="py-3.5 px-4">Capacity</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">High-Intensity Interval Training (HIIT)</td>
            <td class="py-3.5 px-4 text-slate-700">Coach Marcus</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">Today, 06:00 PM - 07:00 PM</td>
            <td class="py-3.5 px-4 text-slate-700">18 / 20 Booked</td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('View class attendees')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Attendees</button>
              <button onclick="alert('Cancel class session')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Cancel</button>
            </td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900">Strength & Conditioning</td>
            <td class="py-3.5 px-4 text-slate-700">Coach Sandra</td>
            <td class="py-3.5 px-4 text-xs text-slate-500">Tomorrow, 07:00 AM - 08:00 AM</td>
            <td class="py-3.5 px-4 text-slate-700">12 / 15 Booked</td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="alert('View class attendees')" class="text-xs font-medium text-blue-600 hover:text-blue-800">Attendees</button>
              <button onclick="alert('Cancel class session')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Cancel</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>