<div id="modal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/50">
  <div class="bg-white rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
    <div class="flex items-start justify-between gap-3">
      <div><h3 id="mName" class="text-xl font-extrabold text-slate-900"></h3><p id="mId" class="text-xs text-slate-400"></p></div>
      <button id="mClose" class="w-9 h-9 rounded-full hover:bg-slate-100 text-slate-500" type="button" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div id="mBody" class="mt-4 space-y-3 text-sm"></div>
    <div class="flex flex-wrap gap-3 mt-5">
      <button id="mMsg" class="px-5 py-2.5 rounded-full bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700" type="button"><i class="fa-regular fa-message mr-2"></i>Message</button>
      <button id="mPlan" class="px-5 py-2.5 rounded-full border border-slate-300 text-sm font-semibold hover:border-blue-400 hover:text-blue-600" type="button">Edit plan</button>
    </div>
  </div>
</div>

<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[70] bg-slate-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-lg opacity-0 pointer-events-none transition-opacity duration-300"></div>