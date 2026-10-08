<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Trainer Portal | PURE GAIN</title>
<link href="../src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
<style>
:root{--accent:#2563eb}
body{font-family:'Plus Jakarta Sans',sans-serif;-webkit-font-smoothing:antialiased}
.no-scrollbar::-webkit-scrollbar{display:none}.no-scrollbar{scrollbar-width:none}
.shell{display:flex;flex-direction:column}
@media(min-width:1024px){.shell{flex-direction:row}}
.pnav{position:relative;display:flex;align-items:center;flex-shrink:0;background:#f1f1f1;font-size:12.5px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#4b5563;border-right:1px solid #e2e2e2;white-space:nowrap;transition:background .25s}
.pnav .ic{width:46px;height:50px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#374151;transition:background .3s,color .3s}
.pnav .lbl{padding:0 14px 0 2px}
.pnav:hover{background:#e8e8e8}
.pnav.active{background:#fff;color:#111}
.pnav.active .ic{background:var(--accent);color:#fff}
.pnav.out,.pnav.out .ic{color:#dc2626}
.badge{display:none;margin-left:auto;margin-right:12px;min-width:20px;height:20px;padding:0 6px;border-radius:999px;background:#dc2626;color:#fff;font-size:11px;align-items:center;justify-content:center}
@media(min-width:1024px){.pnav{width:100%;border-right:0;border-bottom:1px solid #e2e2e2}.pnav .ic{width:52px;height:52px;font-size:20px}
.pnav.active::after{content:'';position:absolute;right:0;top:50%;margin-top:-9px;border:9px solid transparent;border-right-color:#fff}}
.ptitle{font-size:24px;font-weight:800;letter-spacing:-.01em;color:#1e4fa3}
.card{background:#fff;border:1px solid #eef0f3;border-radius:22px;padding:20px;box-shadow:0 1px 2px rgba(0,0,0,.04)}
.stat{background:#f8fafc;border:1px solid #eef0f3;border-radius:18px;padding:14px 16px;transition:transform .25s,box-shadow .25s}
.stat:hover{transform:translateY(-3px);box-shadow:0 12px 24px -12px rgba(0,0,0,.18)}
.stat p{font-size:11px;color:#64748b;font-weight:600}
.stat b{display:block;font-size:26px;font-weight:800;color:#0f172a;margin-top:2px}
.chip{font-size:11px;font-weight:700;color:#0369a1;background:#e0f2fe;border-radius:999px;padding:4px 10px}
.pill{font-size:11px;font-weight:800;border-radius:999px;padding:3px 10px;white-space:nowrap}
.ok{background:#dcfce7;color:#15803d}.warn{background:#ffedd5;color:#c2410c}.end{background:#fee2e2;color:#b91c1c}
.dbar{height:6px;background:#e5e7eb;border-radius:99px;overflow:hidden}
.dbar i{display:block;height:100%;border-radius:99px;background:var(--accent);transition:width 1s cubic-bezier(.2,.8,.2,1)}
.inp{width:100%;background:#f8fafc;border:1px solid #cbd5e1;border-radius:12px;padding:10px 14px;font-size:14px}
.inp:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 1px var(--accent);background:#fff}
.hero{color:#fff;border-radius:26px;padding:26px;background:linear-gradient(135deg,#1d4ed8,#0f172a);position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;width:260px;height:260px;right:-70px;top:-90px;border-radius:50%;background:rgba(255,255,255,.07)}
.avatar{width:84px;height:84px;border-radius:50%;background:linear-gradient(135deg,#38bdf8,#2563eb);border:3px solid rgba(255,255,255,.7);font-size:28px;font-weight:800;display:flex;align-items:center;justify-content:center}
.row{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:12px 14px;background:#fff;border:1px solid #eef0f3;border-radius:16px;transition:transform .2s,box-shadow .2s}
.row:hover{transform:translateX(3px);box-shadow:0 8px 18px -10px rgba(0,0,0,.2)}
.chatbox{height:340px;overflow-y:auto;background:#f8fafc;border-radius:18px;padding:14px;display:flex;flex-direction:column;gap:8px}
.bub{max-width:80%;padding:9px 14px;border-radius:18px;font-size:14px;line-height:1.4}
.bub span{display:block;font-size:10px;opacity:.6;margin-top:3px}
.bub.me{align-self:flex-end;background:var(--accent);color:#fff;border-bottom-right-radius:5px}
.bub.them{align-self:flex-start;background:#fff;border:1px solid #e2e8f0;border-bottom-left-radius:5px}
.view{animation:rise .5s cubic-bezier(.2,.8,.2,1) both}
@keyframes rise{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.fchip{padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;color:#475569;background:#f1f5f9;transition:all .2s}
.fchip.on{background:var(--accent);color:#fff}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition-duration:.01ms!important}}
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

<header class="w-full border-b border-slate-200 bg-white sticky top-0 z-50">
  <div class="max-w-[1100px] mx-auto px-4 h-16 flex items-center justify-between">
    <a href="index.php" class="flex items-center gap-3"><img src="../assets/images/logos.png" alt="PURE GAIN" style="width:150px;height:auto;object-fit:contain"><span class="hidden sm:inline chip">Trainer Portal</span></a>
    <div class="flex items-center gap-3 text-sm font-semibold text-slate-700">
      <span class="hidden sm:inline">Coach Brian</span>
      <span class="w-9 h-9 rounded-full text-white font-extrabold text-xs flex items-center justify-center" style="background:var(--accent)">BS</span>
    </div>
  </div>
</header>

<main class="flex-grow py-6 px-4 sm:px-6">
<div class="max-w-[1100px] mx-auto">
<div class="shell bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

  <aside class="lg:w-[240px] shrink-0 bg-[#f1f1f1]">
    <div class="hidden lg:flex items-center gap-3 px-4 py-5 border-b border-[#e2e2e2] bg-white">
      <span class="w-11 h-11 rounded-full text-white font-extrabold flex items-center justify-center" style="background:var(--accent)">BS</span>
      <div class="min-w-0"><p class="font-bold text-slate-900 leading-tight truncate">Brian Ssebunya</p><p class="text-xs text-slate-500">Strength &amp; Conditioning</p></div>
    </div>
    <nav id="pnav" class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar">
      <button data-view="overview" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-gauge-high"></i></span><span class="lbl">Overview</span></button>
      <button data-view="clients" class="pnav" type="button"><span class="ic"><i class="fa-solid fa-users"></i></span><span class="lbl">My Clients</span></button>
      <button data-view="schedule" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-calendar-check"></i></span><span class="lbl">Schedule</span></button>
      <button data-view="messages" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-message"></i></span><span class="lbl">Messages</span><span id="mBadge" class="badge"></span></button>
      <button data-view="profile" class="pnav" type="button"><span class="ic"><i class="fa-regular fa-user"></i></span><span class="lbl">My Profile</span></button>
      <button id="logoutBtn" class="pnav out" type="button"><span class="ic"><i class="fa-solid fa-arrow-right-from-bracket"></i></span><span class="lbl">Log out</span></button>
    </nav>
  </aside>

  <div class="flex-1 min-w-0 p-5 sm:p-8 bg-white">

    <?php include 'views/overview.php'; ?>

    <!-- CLIENTS -->
  <?php include 'views/clients.php'; ?>

    <!-- SCHEDULE -->
  <?php include 'views/schedule.php'; ?>

    <!-- MESSAGES -->

<?php include 'views/messages.php'; ?>
    <!-- PROFILE -->
  
<?php include 'views/profile.php'; ?>
 
  </div>
</div>
</div>
</main>


<?php include 'views/clientmodel.php'; ?>













<script>

const $=id=>document.getElementById(id);
const addDays=(d,n)=>{const x=new Date(d);x.setDate(x.getDate()+n);return x};
const today=new Date();today.setHours(0,0,0,0);
let toastT;

function toast(m){
  const t=$('toast');
  if(!t)return;
  t.textContent=m;
  t.style.opacity=1;
  clearTimeout(toastT);
  toastT=setTimeout(()=>t.style.opacity=0,2400);
}

const clock=()=>new Date().toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'});
const esc=s=>s?s.replace(/</g,'&lt;'):'';

/* ---- Data ---- */
const CLIENTS=[
 {id:'APX-0231',n:'Grace Nakato',goal:'Lose weight',prog:72,left:2,status:'ok',wt:'82.0 to 78.6 kg',note:'Mild knee strain, avoid heavy jumping.',phone:'256772000000',pbs:'Bench 70 kg · Squat 100 kg · Deadlift 120 kg'},
 {id:'APX-0187',n:'David Okello',goal:'Build muscle',prog:55,left:6,status:'ok',wt:'74.5 to 76.2 kg',note:'No known issues.',phone:'256700000001',pbs:'Bench 85 kg · Squat 120 kg'},
 {id:'APX-0244',n:'Ruth Namukasa',goal:'Improve fitness',prog:38,left:1,status:'end',wt:'68.0 to 66.9 kg',note:'Asthma, keep an inhaler nearby.',phone:'256700000002',pbs:'5 km run 31:10'},
 {id:'APX-0199',n:'Samuel Mugisha',goal:'Get stronger',prog:81,left:4,status:'ok',wt:'88.0 to 87.1 kg',note:'Lower back stiffness after deadlifts.',phone:'256700000003',pbs:'Deadlift 150 kg · Squat 130 kg'},
 {id:'APX-0256',n:'Esther Achieng',goal:'Lose weight',prog:20,left:8,status:'warn',wt:'79.0 to 78.8 kg',note:'Missed the last 2 sessions.',phone:'256700000004',pbs:'Plank 2:10'},
 {id:'APX-0212',n:'Moses Kato',goal:'Build muscle',prog:46,left:3,status:'warn',wt:'70.2 to 70.9 kg',note:'No check-in for 9 days.',phone:'256700000005',pbs:'Bench 60 kg'}
];

const LABEL={ok:'On track',warn:'Needs check-in',end:'Plan ending'};
const SESS={
 1:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',1],['11:00 AM','Personal Training',3]],
 2:[['2:00 PM','Personal Training',2],['5:00 PM','Personal Training',5],['7:00 PM','Boxing Cardio',null]],
 3:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',4],['11:00 AM','Personal Training',1]],
 4:[['2:00 PM','Personal Training',3],['5:00 PM','Personal Training',0],['7:00 PM','Boxing Cardio',null]],
 5:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',2],['11:00 AM','Personal Training',5]],
 6:[['8:00 AM','Personal Training',0],['10:00 AM','Personal Training',4]],
 0:[]
};
const done=new Set();
const sessFor=d=>SESS[d.getDay()] || [];

/* ---- Navigation Handler ---- */
function show(v){
  document.querySelectorAll('.view').forEach(s=>s.classList.toggle('hidden',s.id!=='v-'+v));
  document.querySelectorAll('.pnav[data-view]').forEach(b=>b.classList.toggle('active',b.dataset.view===v));
  
  const activeView=$('v-'+v);
  if(activeView){
    activeView.style.animation='none';
    void activeView.offsetWidth;
    activeView.style.animation='';
  }

  if(v==='overview')renderOverview();
  if(v==='clients')renderClients();
  if(v==='schedule')renderDays();
  if(v==='messages')renderThreads();

  const navContainer = $('pnav');
  if(innerWidth<1024 && navContainer){
    navContainer.querySelector('.active')?.scrollIntoView({inline:'center',block:'nearest',behavior:'smooth'});
  } else {
    scrollTo({top:0});
  }
  
  try { history.replaceState(null,'','#'+v); } catch(e){}
}

// Global Event Listeners for Navigation
document.addEventListener('click', e => {
  const navBtn = e.target.closest('.pnav[data-view]');
  if (navBtn) {
    show(navBtn.dataset.view);
    return;
  }
  const goBtn = e.target.closest('[data-go]');
  if (goBtn) {
    show(goBtn.dataset.go);
    return;
  }
});

/* ---- Overview Logic ---- */
function renderOverview(){
  const greetEl = $('greet');
  if(greetEl){
    const h=new Date().getHours();
    greetEl.textContent=(h<12?'Good morning':h<17?'Good afternoon':'Good evening')+', Coach Brian';
  }
  
  if($('stClients'))$('stClients').textContent=CLIENTS.length;
  const list=sessFor(today);
  if($('stToday'))$('stToday').textContent=list.length;
  if($('stUnread'))$('stUnread').textContent=unread();
  
  const todayList = $('todayList');
  if(todayList){
    todayList.innerHTML=list.length?'':'<li class="py-6 text-sm text-slate-500 text-center">No sessions today. Enjoy the rest day.</li>';
    list.forEach((s,i)=>{
      const k=today.toDateString()+i,c=s[2]!==null?CLIENTS[s[2]]:null;
      const li=document.createElement('li');li.className='py-3 flex items-center justify-between gap-3';
      li.innerHTML=`<div class="flex items-center gap-3 min-w-0"><span class="w-10 h-10 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid ${c?'fa-dumbbell':'fa-people-group'}"></i></span><div class="min-w-0"><p class="text-sm font-bold text-slate-900 truncate ${done.has(k)?'line-through opacity-50':''}">${s[1]}${c?' with '+c.n:''}</p><p class="text-xs text-slate-500">${s[0]}${c?'':' · Group class'}</p></div></div>`;
      const b=document.createElement('button');b.type='button';
      b.className='shrink-0 text-xs font-semibold '+(done.has(k)?'text-green-600':'text-blue-600 hover:underline');
      b.textContent=done.has(k)?'Done ✓':'Mark done';
      b.onclick=()=>{done.has(k)?done.delete(k):done.add(k);renderOverview()};
      li.appendChild(b);todayList.appendChild(li);
    });
  }

  const attnList = $('attnList');
  if(attnList){
    const attn=CLIENTS.map((c,i)=>({c,i})).filter(x=>x.c.status!=='ok');
    attnList.innerHTML=attn.map(x=>`<li class="flex items-start justify-between gap-2"><div class="min-w-0"><p class="font-bold text-slate-900">${x.c.n}</p><p class="text-xs text-slate-500">${x.c.note}</p></div><button data-c="${x.i}" class="open pill ${x.c.status}" type="button">${LABEL[x.c.status]}</button></li>`).join('');
  }

  const weekChart = $('weekChart');
  if(weekChart){
    const counts=[1,2,3,4,5,6,0].map(dow=>(SESS[dow]||[]).length),max=Math.max(...counts, 1);
    const names=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    weekChart.innerHTML=counts.map((n,i)=>`<div class="flex-1 flex flex-col items-center justify-end h-full gap-1.5"><span class="text-[11px] font-bold text-slate-700">${n}</span><div class="w-full rounded-t-lg bg-gradient-to-t from-blue-600 to-sky-400" style="height:${(n/max*100)}%;min-height:4px"></div><span class="text-[10px] text-slate-400">${names[i]}</span></div>`).join('');
  }
}

/* ---- Clients Logic ---- */
let filter='all';
function renderClients(){
  const searchInput = $('clientSearch');
  const q = searchInput ? searchInput.value.trim().toLowerCase() : '';
  const rows = CLIENTS.map((c,i)=>({c,i})).filter(x=>(filter==='all'||x.c.status===filter)&&x.c.n.toLowerCase().includes(q));
  
  const clientList = $('clientList');
  if(clientList){
    clientList.innerHTML=rows.length?'':'<div class="card text-center text-sm text-slate-500 py-8">No clients match your search.</div>';
    rows.forEach(x=>{
      const c=x.c,d=document.createElement('button');d.type='button';d.className='row w-full text-left';
      d.innerHTML=`<div class="flex items-center gap-3 min-w-0 flex-1"><span class="w-11 h-11 shrink-0 rounded-full bg-sky-100 text-sky-700 font-extrabold flex items-center justify-center">${c.n.split(' ').map(w=>w[0]).join('')}</span><div class="min-w-0 flex-1"><p class="font-bold text-slate-900 truncate">${c.n}</p><p class="text-xs text-slate-500">${c.goal} · ${c.left} sessions left</p><div class="dbar mt-2 max-w-[220px]"><i style="width:${c.prog}%"></i></div></div></div><span class="pill ${c.status}">${LABEL[c.status]}</span>`;
      d.onclick=()=>openClient(x.i);
      clientList.appendChild(d);
    });
  }
}

const clientSearchInput = $('clientSearch');
if(clientSearchInput) clientSearchInput.oninput=renderClients;

const clientFiltersContainer = $('clientFilters');
if(clientFiltersContainer){
  clientFiltersContainer.onclick=e=>{
    const b=e.target.closest('.fchip');if(!b)return;
    filter=b.dataset.f;
    document.querySelectorAll('.fchip').forEach(x=>x.classList.toggle('on',x===b));
    renderClients();
  };
}

document.addEventListener('click',e=>{
  const o=e.target.closest('.open');
  if(o) openClient(+o.dataset.c);
});

let current=0;
function openClient(i){
  current=i;const c=CLIENTS[i];
  if($('mName'))$('mName').textContent=c.n;
  if($('mId'))$('mId').textContent='ID: '+c.id;
  if($('mBody')){$('mBody').innerHTML=`
     <div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Goal</span><b>${c.goal}</b></div>
     <div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Weight</span><b>${c.wt}</b></div>
     <div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">PT sessions left</span><b>${c.left}</b></div>
     <div class="bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Personal bests</span><p class="font-semibold mt-0.5">${c.pbs}</p></div>
     <div class="bg-amber-50 rounded-xl px-3.5 py-2.5"><span class="text-amber-700 font-bold text-xs">HEALTH NOTES</span><p class="mt-0.5">${c.note}</p></div>
     <div><div class="flex justify-between text-xs font-semibold text-slate-500 mb-1.5"><span>Plan progress</span><span>${c.prog}%</span></div><div class="dbar"><i style="width:${c.prog}%"></i></div></div>`;
  }
  const modal = $('modal');
  if(modal) modal.classList.replace('hidden','flex');
}

const closeModal=()=>{
  const modal = $('modal');
  if(modal) modal.classList.replace('flex','hidden');
};

const mCloseBtn = $('mClose');
if(mCloseBtn) mCloseBtn.onclick=closeModal;

const modalEl = $('modal');
if(modalEl){
  modalEl.onclick=e=>{if(e.target===modalEl)closeModal()};
}

document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal()});

const mPlanBtn = $('mPlan');
if(mPlanBtn) mPlanBtn.onclick=()=>toast('Plan editor opens here once connected to your backend.');

const mMsgBtn = $('mMsg');
if(mMsgBtn) mMsgBtn.onclick=()=>{closeModal();activeThread=current;show('messages')};

/* ---- Schedule Logic ---- */
let selDay=today;
function renderDays(){
  const daysContainer = $('days');
  if(daysContainer){
    daysContainer.innerHTML='';
    for(let i=0;i<7;i++){
      const d=addDays(today,i),on=d.toDateString()===selDay.toDateString(),b=document.createElement('button');b.type='button';
      b.className='shrink-0 px-4 py-2.5 rounded-2xl border text-center transition-all '+(on?'text-white scale-105 shadow-md':'bg-white border-slate-200 text-slate-700 hover:border-blue-300');
      if(on)b.style.cssText='background:var(--accent);border-color:var(--accent)';
      b.innerHTML=`<span class="block text-[11px] font-semibold ${on?'text-blue-100':'text-slate-400'}">${d.toLocaleDateString('en-GB',{weekday:'short'})}</span><span class="block text-base font-extrabold">${d.getDate()}</span>`;
      b.onclick=()=>{selDay=d;renderDays()};
      daysContainer.appendChild(b);
    }
  }
  
  const dayList = $('dayList');
  if(dayList){
    const list=sessFor(selDay);
    dayList.innerHTML=list.length?'':'<div class="card text-center text-slate-500 text-sm py-10"><i class="fa-regular fa-moon text-3xl text-slate-300"></i><p class="mt-3 font-semibold text-slate-700">Rest day</p><p>No sessions on Sundays.</p></div>';
    list.forEach(s=>{
      const c=s[2]!==null?CLIENTS[s[2]]:null,r=document.createElement('div');r.className='card flex items-center justify-between gap-4 !p-4';
      r.innerHTML=`<div class="flex items-center gap-4 min-w-0"><div class="w-20 shrink-0 text-center"><p class="text-sm font-extrabold text-slate-900">${s[0]}</p><p class="text-[11px] text-slate-400">60 min</p></div><div class="min-w-0"><p class="font-bold text-slate-900">${s[1]}</p><p class="text-xs text-slate-500">${c?c.n+' · '+c.goal:'Group class · open booking'}</p></div></div>`;
      if(c){
        const b=document.createElement('button');b.type='button';b.className='shrink-0 text-xs font-semibold text-blue-600 hover:underline';b.textContent='View client';
        b.onclick=()=>openClient(s[2]);
        r.appendChild(b);
      }
      dayList.appendChild(r);
    });
  }
}

/* ---- Messages Logic ---- */
const CHATS=CLIENTS.map(()=>[]);
CHATS[0].push({me:false,t:'Thanks Coach! See you on Thursday for legs.',time:'09:12',unread:true});
CHATS[4].push({me:false,t:'Sorry I missed the sessions, work has been busy.',time:'08:40',unread:true});
CHATS[1].push({me:true,t:'Great session today, David. Keep protein high.',time:'Yesterday'});
let activeThread=0;

const unread=()=>CHATS.reduce((n,t)=>n+t.filter(m=>m.unread).length,0);

function badge(){
  const n=unread(),b=$('mBadge');
  if(b){
    b.textContent=n;
    b.style.display=n?'inline-flex':'none';
  }
}

function renderThreads(){
  CHATS[activeThread].forEach(m=>m.unread=false);
  badge();
  
  const threadList = $('threadList');
  if(threadList){
    threadList.innerHTML=CLIENTS.map((c,i)=>{
      const last=CHATS[i][CHATS[i].length-1],un=CHATS[i].some(m=>m.unread);
      return `<button data-t="${i}" class="thr row w-full text-left ${i===activeThread?'!border-blue-300 !bg-blue-50/50':''}" type="button"><div class="min-w-0"><p class="font-bold text-slate-900 text-sm truncate">${c.n}</p><p class="text-xs text-slate-500 truncate">${last?esc(last.t):'No messages yet'}</p></div>${un?'<span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span>':''}</button>`;
    }).join('');
  }

  const c=CLIENTS[activeThread];
  if($('chatName'))$('chatName').textContent=c.n;
  if($('chatWa'))$('chatWa').href='https://wa.me/'+c.phone;
  if($('chatCall'))$('chatCall').href='tel:+'+c.phone;
  
  const box=$('chatBox');
  if(box){
    box.innerHTML=CHATS[activeThread].length?'':'<p class="text-sm text-slate-400 text-center m-auto">Start the conversation.</p>';
    CHATS[activeThread].forEach(m=>{
      const d=document.createElement('div');
      d.className='bub '+(m.me?'me':'them');
      d.innerHTML=`${esc(m.t)}<span>${m.time}</span>`;
      box.appendChild(d);
    });
    box.scrollTop=box.scrollHeight;
  }
}

const threadListContainer = $('threadList');
if(threadListContainer){
  threadListContainer.onclick=e=>{
    const b=e.target.closest('.thr');
    if(b){activeThread=+b.dataset.t;renderThreads();}
  };
}

const chatForm = $('chatForm');
if(chatForm){
  chatForm.onsubmit=e=>{
    e.preventDefault();
    const inputEl = $('chatInput');
    const v=inputEl?inputEl.value.trim():'';
    if(!v)return;
    CHATS[activeThread].push({me:true,t:v,time:clock()});
    if(inputEl) inputEl.value='';
    renderThreads();
  };
}

/* ---- Profile & Init Misc ---- */
const availBtn = $('availBtn');
if(availBtn) availBtn.onclick=()=>toast('Request sent to the gym admin.');

const logoutBtn = $('logoutBtn');
if(logoutBtn) logoutBtn.onclick=()=>{if(confirm('Log out of the trainer portal?'))location.href='index.php'};

badge();

// Initialize initial view safely based on location hash or default to overview
const start = location.hash ? location.hash.replace('#','') : 'overview';
show(['overview','clients','schedule','messages','profile'].includes(start) ? start : 'overview');
</script>





</body>
</html>