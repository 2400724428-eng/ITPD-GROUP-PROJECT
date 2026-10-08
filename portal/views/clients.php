<!-- CLIENTS -->
<section id="v-clients" class="view hidden">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div><h2 class="ptitle">My Clients</h2><p class="text-sm text-slate-500 mt-0.5">Manage goals, progress, and performance history</p></div>
    <div class="flex items-center gap-2"><input id="clientSearch" class="inp sm:w-64" placeholder="Search client..." type="text"></div>
  </div>
  <div id="clientFilters" class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1">
    <button class="fchip on" data-f="all" type="button">All clients</button>
    <button class="fchip" data-f="ok" type="button">On track</button>
    <button class="fchip" data-f="warn" type="button">Needs check-in</button>
    <button class="fchip" data-f="end" type="button">Plan ending</button>
  </div>
  <div id="clientList" class="mt-5 space-y-3"></div>
</section>