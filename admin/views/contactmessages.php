<!-- SCREEN: CONTACT MESSAGES -->
<div id="screen-contact-messages" class="screen-fade max-w-5xl mt-10 hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Customer Messages</h1>
      <p class="text-sm text-slate-500 mt-0.5">Manage and respond to inquiries submitted via the Contact Us page.</p>
    </div>
    <div class="flex items-center gap-2">
      <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
        3 Unread Messages
      </span>
    </div>
  </div>

  <!-- Messages Table Card -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Sender</th>
            <th class="py-3.5 px-4">Subject</th>
            <th class="py-3.5 px-4">Message Preview</th>
            <th class="py-3.5 px-4">Date</th>
            <th class="py-3.5 px-4 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <!-- Row 1: Unread Message -->
          <tr class="hover:bg-slate-50/80 transition-colors bg-blue-50/30">
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">John Okello</div>
              <div class="text-xs text-slate-500">john.okello@example.com</div>
            </td>
            <td class="py-3.5 px-4 font-medium text-slate-800">Order Delivery Inquiry</td>
            <td class="py-3.5 px-4 text-slate-600 truncate max-w-xs">
              Hello, I would like to know if you ship packages to Nakawa, Kampala...
            </td>
            <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">Oct 6, 2026</td>
            <td class="py-3.5 px-4 text-right space-x-3 whitespace-nowrap">
              <button onclick="alert('Opening message details...')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                View
              </button>
              <button onclick="alert('Message deleted.')" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition">
                Delete
              </button>
            </td>
          </tr>

          <!-- Row 2: Read Message -->
          <tr class="hover:bg-slate-50/80 transition-colors">
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">Sarah Namubiru</div>
              <div class="text-xs text-slate-500">sarah.n@example.com</div>
            </td>
            <td class="py-3.5 px-4 font-medium text-slate-800">Product Return Policy</td>
            <td class="py-3.5 px-4 text-slate-600 truncate max-w-xs">
              Hi QuickCart team, what is the procedure if I want to return a defective...
            </td>
            <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">Oct 4, 2026</td>
            <td class="py-3.5 px-4 text-right space-x-3 whitespace-nowrap">
              <button onclick="alert('Opening message details...')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                View
              </button>
              <button onclick="alert('Message deleted.')" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition">
                Delete
              </button>
            </td>
          </tr>

          <!-- Row 3: Read Message -->
          <tr class="hover:bg-slate-50/80 transition-colors">
            <td class="py-3.5 px-4">
              <div class="font-medium text-slate-900">Brian Mugisha</div>
              <div class="text-xs text-slate-500">brian.m@example.com</div>
            </td>
            <td class="py-3.5 px-4 font-medium text-slate-800">Partnership Proposal</td>
            <td class="py-3.5 px-4 text-slate-600 truncate max-w-xs">
              We are an electronics supplier looking to list our items on your platform...
            </td>
            <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">Sep 29, 2026</td>
            <td class="py-3.5 px-4 text-right space-x-3 whitespace-nowrap">
              <button onclick="alert('Opening message details...')" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                View
              </button>
              <button onclick="alert('Message deleted.')" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    <div class="py-3 px-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
      <span>Showing <strong>3</strong> of <strong>3</strong> messages</span>
      <div class="flex items-center space-x-1">
        <button disabled class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">Previous</button>
        <button disabled class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">Next</button>
      </div>
    </div>
  </div>
</div>