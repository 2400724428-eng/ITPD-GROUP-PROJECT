
const $=id=>document.getElementById(id);
const addDays=(d,n)=>{const x=new Date(d);x.setDate(x.getDate()+n);return x};
const short=d=>d.toLocaleDateString('en-GB',{weekday:'short',day:'numeric',month:'short'});
const today=new Date();today.setHours(0,0,0,0);
let toastT;
function toast(m){const t=$('toast');t.textContent=m;t.style.opacity=1;clearTimeout(toastT);toastT=setTimeout(()=>t.style.opacity=0,2400)}
const clock=()=>new Date().toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'});
const esc=s=>s.replace(/</g,'&lt;');

/* ---- Data (Grace Nakato and Coach Brian come from the member portal; other clients are samples) ---- */
const CLIENTS=[
 {id:'APX-0231',n:'Grace Nakato',goal:'Lose weight',prog:72,left:2,status:'ok',wt:'82.0 to 78.6 kg',note:'Mild knee strain, avoid heavy jumping.',phone:'256772000000',pbs:'Bench 70 kg · Squat 100 kg · Deadlift 120 kg'},
 {id:'APX-0187',n:'David Okello',goal:'Build muscle',prog:55,left:6,status:'ok',wt:'74.5 to 76.2 kg',note:'No known issues.',phone:'256700000001',pbs:'Bench 85 kg · Squat 120 kg'},
 {id:'APX-0244',n:'Ruth Namukasa',goal:'Improve fitness',prog:38,left:1,status:'end',wt:'68.0 to 66.9 kg',note:'Asthma, keep an inhaler nearby.',phone:'256700000002',pbs:'5 km run 31:10'},
 {id:'APX-0199',n:'Samuel Mugisha',goal:'Get stronger',prog:81,left:4,status:'ok',wt:'88.0 to 87.1 kg',note:'Lower back stiffness after deadlifts.',phone:'256700000003',pbs:'Deadlift 150 kg · Squat 130 kg'},
 {id:'APX-0256',n:'Esther Achieng',goal:'Lose weight',prog:20,left:8,status:'warn',wt:'79.0 to 78.8 kg',note:'Missed the last 2 sessions.',phone:'256700000004',pbs:'Plank 2:10'},
 {id:'APX-0212',n:'Moses Kato',goal:'Build muscle',prog:46,left:3,status:'warn',wt:'70.2 to 70.9 kg',note:'No check-in for 9 days.',phone:'256700000005',pbs:'Bench 60 kg'}
];
const LABEL={ok:'On track',warn:'Needs check-in',end:'Plan ending'};
const SESS={ // by weekday; c = client index or null for a group class
 1:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',1],['11:00 AM','Personal Training',3]],
 2:[['2:00 PM','Personal Training',2],['5:00 PM','Personal Training',5],['7:00 PM','Boxing Cardio',null]],
 3:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',4],['11:00 AM','Personal Training',1]],
 4:[['2:00 PM','Personal Training',3],['5:00 PM','Personal Training',0],['7:00 PM','Boxing Cardio',null]],
 5:[['6:30 AM','Morning HIIT',null],['9:00 AM','Personal Training',2],['11:00 AM','Personal Training',5]],
 6:[['8:00 AM','Personal Training',0],['10:00 AM','Personal Training',4]],
 0:[]
};
const done=new Set();
const sessFor=d=>SESS[d.getDay()];

/* ---- Navigation ---- */
function show(v){
  document.querySelectorAll('.view').forEach(s=>s.classList.toggle('hidden',s.id!=='v-'+v));
  document.querySelectorAll('.pnav[data-view]').forEach(b=>b.classList.toggle('active',b.dataset.view===v));
  const s=$('v-'+v);s.style.animation='none';void s.offsetWidth;s.style.animation='';
  if(v==='overview')renderOverview();
  if(v==='clients')renderClients();
  if(v==='schedule')renderDays();
  if(v==='messages')renderThreads();
  if(innerWidth<1024)$('pnav').querySelector('.active')?.scrollIntoView({inline:'center',block:'nearest',behavior:'smooth'});
  else scrollTo({top:0});
  history.replaceState(null,'','#'+v);
}
document.querySelectorAll('.pnav[data-view]').forEach(b=>b.onclick=()=>show(b.dataset.view));
document.addEventListener('click',e=>{const g=e.target.closest('[data-go]');if(g)show(g.dataset.go)});

/* ---- Overview ---- */
function renderOverview(){
  const h=new Date().getHours();
  $('greet').textContent=(h<12?'Good morning':h<17?'Good afternoon':'Good evening')+', Coach Brian';
  $('stClients').textContent=CLIENTS.length;
  const list=sessFor(today);
  $('stToday').textContent=list.length;
  $('stUnread').textContent=unread();
  $('todayList').innerHTML=list.length?'':'<li class="py-6 text-sm text-slate-500 text-center">No sessions today. Enjoy the rest day.</li>';
  list.forEach((s,i)=>{
    const k=today.toDateString()+i,c=s[2]!==null?CLIENTS[s[2]]:null;
    const li=document.createElement('li');li.className='py-3 flex items-center justify-between gap-3';
    li.innerHTML='<div class="flex items-center gap-3 min-w-0"><span class="w-10 h-10 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center"><i class="fa-solid '+(c?'fa-dumbbell':'fa-people-group')+'"></i></span><div class="min-w-0"><p class="text-sm font-bold text-slate-900 truncate '+(done.has(k)?'line-through opacity-50':'')+'">'+s[1]+(c?' with '+c.n:'')+'</p><p class="text-xs text-slate-500">'+s[0]+(c?'':' · Group class')+'</p></div></div>';
    const b=document.createElement('button');b.type='button';
    b.className='shrink-0 text-xs font-semibold '+(done.has(k)?'text-green-600':'text-blue-600 hover:underline');
    b.textContent=done.has(k)?'Done ✓':'Mark done';
    b.onclick=()=>{done.has(k)?done.delete(k):done.add(k);renderOverview()};
    li.appendChild(b);$('todayList').appendChild(li);
  });
  const attn=CLIENTS.map((c,i)=>({c,i})).filter(x=>x.c.status!=='ok');
  $('attnList').innerHTML=attn.map(x=>'<li class="flex items-start justify-between gap-2"><div class="min-w-0"><p class="font-bold text-slate-900">'+x.c.n+'</p><p class="text-xs text-slate-500">'+x.c.note+'</p></div><button data-c="'+x.i+'" class="open pill '+x.c.status+'" type="button">'+LABEL[x.c.status]+'</button></li>').join('');
  const counts=[1,2,3,4,5,6,0].map(dow=>(SESS[dow]||[]).length),max=Math.max(...counts);
  const names=['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  $('weekChart').innerHTML=counts.map((n,i)=>'<div class="flex-1 flex flex-col items-center justify-end h-full gap-1.5"><span class="text-[11px] font-bold text-slate-700">'+n+'</span><div class="w-full rounded-t-lg bg-gradient-to-t from-blue-600 to-sky-400" style="height:'+(n/max*100)+'%;min-height:4px"></div><span class="text-[10px] text-slate-400">'+names[i]+'</span></div>').join('');
}

/* ---- Clients ---- */
let filter='all';
function renderClients(){
  const q=$('clientSearch').value.trim().toLowerCase();
  const rows=CLIENTS.map((c,i)=>({c,i})).filter(x=>(filter==='all'||x.c.status===filter)&&x.c.n.toLowerCase().includes(q));
  $('clientList').innerHTML=rows.length?'':'<div class="card text-center text-sm text-slate-500 py-8">No clients match your search.</div>';
  rows.forEach(x=>{
    const c=x.c,d=document.createElement('button');d.type='button';d.className='row w-full text-left';
    d.innerHTML='<div class="flex items-center gap-3 min-w-0 flex-1"><span class="w-11 h-11 shrink-0 rounded-full bg-sky-100 text-sky-700 font-extrabold flex items-center justify-center">'+c.n.split(' ').map(w=>w[0]).join('')+'</span><div class="min-w-0 flex-1"><p class="font-bold text-slate-900 truncate">'+c.n+'</p><p class="text-xs text-slate-500">'+c.goal+' · '+c.left+' sessions left</p><div class="dbar mt-2 max-w-[220px]"><i style="width:'+c.prog+'%"></i></div></div></div><span class="pill '+c.status+'">'+LABEL[c.status]+'</span>';
    d.onclick=()=>openClient(x.i);$('clientList').appendChild(d);
  });
}
$('clientSearch').oninput=renderClients;
$('clientFilters').onclick=e=>{const b=e.target.closest('.fchip');if(!b)return;filter=b.dataset.f;document.querySelectorAll('.fchip').forEach(x=>x.classList.toggle('on',x===b));renderClients()};
document.addEventListener('click',e=>{const o=e.target.closest('.open');if(o)openClient(+o.dataset.c)});

let current=0;
function openClient(i){
  current=i;const c=CLIENTS[i];
  $('mName').textContent=c.n;$('mId').textContent='ID: '+c.id;
  $('mBody').innerHTML=
   '<div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Goal</span><b>'+c.goal+'</b></div>'+
   '<div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Weight</span><b>'+c.wt+'</b></div>'+
   '<div class="flex justify-between bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">PT sessions left</span><b>'+c.left+'</b></div>'+
   '<div class="bg-slate-50 rounded-xl px-3.5 py-2.5"><span class="text-slate-500">Personal bests</span><p class="font-semibold mt-0.5">'+c.pbs+'</p></div>'+
   '<div class="bg-amber-50 rounded-xl px-3.5 py-2.5"><span class="text-amber-700 font-bold text-xs">HEALTH NOTES</span><p class="mt-0.5">'+c.note+'</p></div>'+
   '<div><div class="flex justify-between text-xs font-semibold text-slate-500 mb-1.5"><span>Plan progress</span><span>'+c.prog+'%</span></div><div class="dbar"><i style="width:'+c.prog+'%"></i></div></div>';
  $('modal').classList.replace('hidden','flex');
}
const closeModal=()=>$('modal').classList.replace('flex','hidden');
$('mClose').onclick=closeModal;
$('modal').onclick=e=>{if(e.target===$('modal'))closeModal()};
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal()});
$('mPlan').onclick=()=>toast('Plan editor opens here once connected to your backend.');
$('mMsg').onclick=()=>{closeModal();activeThread=current;show('messages')};

/* ---- Schedule ---- */
let selDay=today;
function renderDays(){
  $('days').innerHTML='';
  for(let i=0;i<7;i++){
    const d=addDays(today,i),on=d.toDateString()===selDay.toDateString(),b=document.createElement('button');b.type='button';
    b.className='shrink-0 px-4 py-2.5 rounded-2xl border text-center transition-all '+(on?'text-white scale-105 shadow-md':'bg-white border-slate-200 text-slate-700 hover:border-blue-300');
    if(on)b.style.cssText='background:var(--accent);border-color:var(--accent)';
    b.innerHTML='<span class="block text-[11px] font-semibold '+(on?'text-blue-100':'text-slate-400')+'">'+d.toLocaleDateString('en-GB',{weekday:'short'})+'</span><span class="block text-base font-extrabold">'+d.getDate()+'</span>';
    b.onclick=()=>{selDay=d;renderDays()};$('days').appendChild(b);
  }
  const list=sessFor(selDay);
  $('dayList').innerHTML=list.length?'':'<div class="card text-center text-slate-500 text-sm py-10"><i class="fa-regular fa-moon text-3xl text-slate-300"></i><p class="mt-3 font-semibold text-slate-700">Rest day</p><p>No sessions on Sundays.</p></div>';
  list.forEach(s=>{
    const c=s[2]!==null?CLIENTS[s[2]]:null,r=document.createElement('div');r.className='card flex items-center justify-between gap-4 !p-4';
    r.innerHTML='<div class="flex items-center gap-4 min-w-0"><div class="w-20 shrink-0 text-center"><p class="text-sm font-extrabold text-slate-900">'+s[0]+'</p><p class="text-[11px] text-slate-400">60 min</p></div><div class="min-w-0"><p class="font-bold text-slate-900">'+s[1]+'</p><p class="text-xs text-slate-500">'+(c?c.n+' · '+c.goal:'Group class · open booking')+'</p></div></div>';
    if(c){const b=document.createElement('button');b.type='button';b.className='shrink-0 text-xs font-semibold text-blue-600 hover:underline';b.textContent='View client';b.onclick=()=>openClient(s[2]);r.appendChild(b)}
    $('dayList').appendChild(r);
  });
}

/* ---- Messages ---- */
const CHATS=CLIENTS.map(()=>[]);
CHATS[0].push({me:false,t:'Thanks Coach! See you on Thursday for legs.',time:'09:12',unread:true});
CHATS[4].push({me:false,t:'Sorry I missed the sessions, work has been busy.',time:'08:40',unread:true});
CHATS[1].push({me:true,t:'Great session today, David. Keep protein high.',time:'Yesterday'});
let activeThread=0;
const unread=()=>CHATS.reduce((n,t)=>n+t.filter(m=>m.unread).length,0);
function badge(){const n=unread(),b=$('mBadge');b.textContent=n;b.style.display=n?'inline-flex':'none'}
function renderThreads(){
  CHATS[activeThread].forEach(m=>m.unread=false);badge();
  $('threadList').innerHTML=CLIENTS.map((c,i)=>{
    const last=CHATS[i][CHATS[i].length-1],un=CHATS[i].some(m=>m.unread);
    return '<button data-t="'+i+'" class="thr row w-full text-left '+(i===activeThread?'!border-blue-300 !bg-blue-50/50':'')+'" type="button"><div class="min-w-0"><p class="font-bold text-slate-900 text-sm truncate">'+c.n+'</p><p class="text-xs text-slate-500 truncate">'+(last?esc(last.t):'No messages yet')+'</p></div>'+(un?'<span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span>':'')+'</button>';
  }).join('');
  const c=CLIENTS[activeThread];
  $('chatName').textContent=c.n;$('chatWa').href='https://wa.me/'+c.phone;$('chatCall').href='tel:+'+c.phone;
  const box=$('chatBox');box.innerHTML=CHATS[activeThread].length?'':'<p class="text-sm text-slate-400 text-center m-auto">Start the conversation.</p>';
  CHATS[activeThread].forEach(m=>{const d=document.createElement('div');d.className='bub '+(m.me?'me':'them');d.innerHTML=esc(m.t)+'<span>'+m.time+'</span>';box.appendChild(d)});
  box.scrollTop=box.scrollHeight;
}
$('threadList').onclick=e=>{const b=e.target.closest('.thr');if(b){activeThread=+b.dataset.t;renderThreads()}};
$('chatForm').onsubmit=e=>{
  e.preventDefault();const v=$('chatInput').value.trim();if(!v)return;
  CHATS[activeThread].push({me:true,t:v,time:clock()});$('chatInput').value='';renderThreads();
};

/* ---- Misc ---- */
$('availBtn').onclick=()=>toast('Request sent to the gym admin.');
$('logoutBtn').onclick=()=>{if(confirm('Log out of the trainer portal?'))location.href='index.php'};
badge();
const start=location.hash.replace('#','');
show(['overview','clients','schedule','messages','profile'].includes(start)?start:'overview');

