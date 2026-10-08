<!-- OVERVIEW -->
<section id="v-overview" class="view hidden">
  <p id="greet" class="text-sm font-semibold text-slate-500"></p>
  <h2 class="ptitle">Trainer Overview</h2>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5">
    <div class="stat"><p>Active clients</p><b id="stClients">0</b></div>
    <div class="stat"><p>Sessions today</p><b id="stToday">0</b></div>
    <div class="stat"><p>Rating</p><b>4.9 <i class="fa-solid fa-star text-amber-400 text-base"></i></b></div>
    <div class="stat"><p>Unread messages</p><b id="stUnread">0</b></div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-6">
    <div class="md:col-span-3 card">
      <div class="flex items-center justify-between"><h3 class="font-extrabold text-slate-900">Today's sessions</h3><button data-go="schedule" class="text-sm font-semibold text-blue-600" type="button">Full schedule →</button></div>
      <ul id="todayList" class="mt-3 divide-y divide-slate-100"></ul>
    </div>
    <div class="md:col-span-2 card">
      <h3 class="font-extrabold text-slate-900">Needs attention</h3>
      <ul id="attnList" class="mt-3 space-y-3 text-sm"></ul>
    </div>
  </div>
  <div class="card mt-5">
    <div class="flex items-center justify-between"><h3 class="font-extrabold text-slate-900">Sessions this week</h3><span class="text-xs font-semibold text-slate-400">Group classes and personal training</span></div>
    <div id="weekChart" class="mt-5 flex items-end gap-3 h-40"></div>
  </div>
</section>