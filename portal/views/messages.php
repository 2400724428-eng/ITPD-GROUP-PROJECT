<!-- MESSAGES -->
<section id="v-messages" class="view hidden">
  <h2 class="ptitle">Client Messages</h2>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
    <div id="threadList" class="card lg:col-span-1 space-y-2 max-h-[440px] overflow-y-auto"></div>
    <div class="card lg:col-span-2 flex flex-col justify-between">
      <div class="flex items-center justify-between pb-3 border-b border-slate-100">
        <div><h3 id="chatName" class="font-extrabold text-slate-900"></h3><p class="text-[11px] text-green-600 font-bold">Active now</p></div>
        <div class="flex items-center gap-2">
          <a id="chatWa" class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 transition" target="_blank" title="Open WhatsApp"><i class="fa-brands fa-whatsapp text-lg"></i></a>
          <a id="chatCall" class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center hover:bg-sky-100 transition" title="Call Client"><i class="fa-solid fa-phone text-sm"></i></a>
        </div>
      </div>
      <div id="chatBox" class="chatbox my-3"></div>
      <form id="chatForm" class="flex gap-2 pt-2 border-t border-slate-100">
        <input id="chatInput" class="inp" placeholder="Type a message to client..." autocomplete="off">
        <button class="px-5 py-2.5 rounded-xl text-white font-bold text-sm shrink-0 shadow" style="background:var(--accent)" type="submit">Send</button>
      </form>
    </div>
  </div>
</section>

