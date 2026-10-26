<?php
// auth.php — Member & Trainer Authentication with Database Integration
session_start();

$dbCandidates = [
    __DIR__ . '/../includes/db_connect.php',
    __DIR__ . '/includes/db_connect.php',
    __DIR__ . '/../../includes/db_connect.php',
];
$dbFound = false;
foreach ($dbCandidates as $p) {
    if (file_exists($p)) {
        require_once $p;
        $dbFound = true;
        break;
    }
}

$error_message = '';
$active_tab = 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo)) {
    $action = $_POST['action'] ?? 'login';
    $active_tab = $action === 'register' ? 'register' : ($action === 'trainer' ? 'trainer' : 'login');

    try {
        if ($action === 'register') {
            $name = trim($_POST['name'] ?? '');
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $plan = trim($_POST['plan'] ?? 'Gym Pro');
            $sessions = (int)($_POST['sessions'] ?? 12);
            $goal = trim($_POST['goal'] ?? 'General fitness');

            if (empty($name) || empty($email) || empty($password)) {
                $error_message = 'Please fill in all required fields.';
            } else {
                $stmt = $pdo->prepare("SELECT user_id FROM gymnuser WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error_message = 'An account with this email already exists.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO gymnuser (email, password_hash, role) VALUES (?, ?, 'member')");
                    $stmt->execute([$email, $hash]);
                    $newUserId = $pdo->lastInsertId();

                    $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, payload) VALUES (?, 'member_profile', ?, 'active', ?)")
                        ->execute([$newUserId, $name . ' Profile', json_encode(['member_code' => 'APX-' . sprintf('%04d', $newUserId), 'phone' => $phone, 'goal' => $goal])]);

                    $pdo->prepare("INSERT INTO gym_records (user_id, record_type, title, status, numeric_value, start_time, end_time, payload) VALUES (?, 'subscription', ?, 'active', ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), ?)")
                        ->execute([$newUserId, $plan, 300000.00, json_encode(['sessions_total' => $sessions, 'sessions_used' => 0])]);

                    $_SESSION['user_id'] = $newUserId;
                    header('Location: portal.php?user_id=' . $newUserId);
                    exit;
                }
            }
        } elseif ($action === 'login') {
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM gymnuser WHERE email = ? AND role = 'member' LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: portal.php?user_id=' . $user['user_id']);
                exit;
            } else {
                $error_message = 'Invalid member email or password.';
            }
        } elseif ($action === 'trainer') {
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            // Authenticate trainer from database table gymnuser
            $stmt = $pdo->prepare("SELECT * FROM gymnuser WHERE email = ? AND role = 'trainer' LIMIT 1");
            $stmt->execute([$email]);
            $trainer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($trainer && password_verify($password, $trainer['password_hash'])) {
                $_SESSION['user_id'] = $trainer['user_id'];
                // Redirect to trainer dashboard with active trainer user ID
                header('Location: trainer-dashboard.php?trainer=' . $trainer['user_id']);
                exit;
            } else {
                $error_message = 'Invalid trainer email or password.';
            }
        }
    } catch (\PDOException $ex) {
        $error_message = 'Database Error: ' . $ex->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign in | PURE GAIN</title>
<link href="../src/output.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script>
tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}
</script>
<style>
*{box-sizing:border-box}
.form-panel{grid-area:1/1;transition:opacity .45s ease,transform .55s cubic-bezier(.22,1,.36,1),visibility .45s}
.form-panel[data-state="out-left"]{opacity:0;transform:translateX(-36px);visibility:hidden;pointer-events:none}
.form-panel[data-state="out-right"]{opacity:0;transform:translateX(36px);visibility:hidden;pointer-events:none}
@keyframes rise{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.form-panel[data-state="active"] .rise{animation:rise .65s cubic-bezier(.22,1,.36,1) both;animation-delay:calc(var(--i,0)*70ms + 120ms)}
.hero-swap{transition:opacity .3s ease,transform .3s ease}
.hero-swap.out{opacity:0;transform:translateY(10px)}
.btn-shine{position:relative;overflow:hidden}
.btn-shine::after{content:"";position:absolute;top:0;left:-75%;width:50%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.35),transparent);transform:skewX(-20deg);transition:left .7s ease}
.btn-shine:hover::after{left:130%}
html,body{width:100%;max-width:100%;overflow-x:hidden}
.auth-layout{height:100vh;min-height:100vh;overflow:hidden}
.left-hero{height:100vh;min-height:100vh;overflow:hidden;position:relative}
.auth-scroll{height:100vh;min-height:100vh;overflow-y:auto;overflow-x:hidden;scrollbar-width:none}
.auth-scroll::-webkit-scrollbar{display:none}
@media (max-width:1023px){
  body{overflow:auto}
  .auth-layout{display:block!important;width:100%;height:auto;overflow:visible}
  .auth-scroll{width:100%;height:auto;padding:1.5rem 1rem 2.5rem!important;overflow:visible;display:flex;align-items:flex-start;justify-content:center}
}
.inp{width:100%;height:3rem;padding:0 1rem 0 2.9rem;border-radius:.75rem;background:#fff;border:1px solid #e2e8f0;font-size:.875rem;color:#1e293b;transition:border-color .2s,box-shadow .2s}
.inp:focus{outline:none;border-color:#38bdf8;box-shadow:0 0 0 4px #e0f2fe}
.ico{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.9rem;pointer-events:none}
</style>
</head>

<body class="font-sans text-slate-800 antialiased bg-white">
<div class="auth-layout grid lg:grid-cols-2">
  <section class="left-hero relative hidden lg:flex items-center bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('../assets/images/gim.jpg')"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/65 to-sky-900/50"></div>
    <div class="relative z-10 w-full px-14 xl:px-20 py-16">
      <div class="flex items-center mb-14">
        <img src="../assets/images/logos.png" alt="PURE GAIN logo" class="h-14 w-auto max-w-[220px] object-contain object-left"/>
      </div>
      <p id="hero-eyebrow" class="hero-swap text-xs font-bold uppercase tracking-[0.2em] text-sky-300 mb-3">Member Login</p>
      <h2 id="hero-title" class="hero-swap text-4xl xl:text-5xl font-extrabold text-white leading-[1.1] tracking-tight max-w-lg">Welcome back to PURE GAIN</h2>
      <p id="hero-sub" class="hero-swap mt-5 text-lg text-slate-300 max-w-md leading-relaxed">Premium supplements for every training goal, delivered to your doorstep.</p>
    </div>
  </section>

  <section class="auth-scroll relative flex items-start justify-center w-full px-5 sm:px-10 py-10 overflow-x-hidden">
    <div class="relative w-full max-w-[440px]">
      <div class="logo-row flex items-center justify-center mb-8">
        <img src="../assets/images/fav.png" alt="PURE GAIN" class="h-14 w-auto max-w-[240px] object-contain"/>
      </div>

      <?php if (!empty($error_message)): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl font-semibold">
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php endif; ?>

      <div class="tabs relative grid grid-cols-3 p-1 mb-8 rounded-2xl bg-slate-100" role="tablist">
        <span id="tab-pill" class="absolute top-1 bottom-1 left-1 rounded-xl bg-white shadow transition-transform duration-500 ease-[cubic-bezier(.22,1,.36,1)]" style="width:calc((100% - 8px)/3)"></span>
        <button data-mode="login" role="tab" type="button" class="tab-btn relative z-10 py-2.5 text-sm font-bold text-slate-900">Member</button>
        <button data-mode="trainer" role="tab" type="button" class="tab-btn relative z-10 py-2.5 text-sm font-bold text-slate-500">Trainer</button>
        <button data-mode="register" role="tab" type="button" class="tab-btn relative z-10 py-2.5 text-sm font-bold text-slate-500">Sign Up</button>
      </div>

      <div class="grid">
        <!-- SCREEN 1: MEMBER SIGN IN -->
        <div id="panel-login" class="form-panel" data-state="active">
          <div class="rise text-center mb-6">
            <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">Sign in to your account</h1>
          </div>
          <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="login">
            <div class="rise">
              <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email Address</label>
              <div class="relative field">
                <input name="email" type="email" required placeholder="you@example.com" class="inp"/>
                <i class="fa-regular fa-envelope ico"></i>
              </div>
            </div>
            <div class="rise">
              <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Password</label>
              <div class="relative field">
                <input name="password" type="password" required placeholder="••••••••" class="inp"/>
                <i class="fa-solid fa-lock ico"></i>
              </div>

<a href="forgot-password.php" class="text-xs font-semibold text-sky-600 hover:underline">Forgot password?</a>

            </div>
            <button type="submit" class="rise submit-btn btn-shine w-full h-12 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2">
              <span>Sign In</span><i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>

          
        </div>

        <!-- SCREEN 2: TRAINER SIGN IN -->
        <div id="panel-trainer" class="form-panel" data-state="out-right">
          <div class="rise text-center mb-6">
            <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">Trainer sign in</h1>
          </div>
          <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="trainer">
            <div class="rise">
              <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Work Email</label>
              <div class="relative field">
                <input name="email" type="email" required placeholder="coach@puregain.com" class="inp"/>
                <i class="fa-regular fa-envelope ico"></i>
              </div>
            </div>
            <div class="rise">
              <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Password</label>
              <div class="relative field">
                <input name="password" type="password" required placeholder="••••••••" class="inp"/>
                <i class="fa-solid fa-lock ico"></i>

<a href="forgot-password.php" class="text-xs font-semibold text-sky-600 hover:underline">Forgot password?</a>

              </div>
            </div>
            <button type="submit" class="rise submit-btn btn-shine w-full h-12 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2">
              <span>Sign In as Trainer</span><i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>
        </div>

        <!-- SCREEN 3: CREATE ACCOUNT -->
        <div id="panel-register" class="form-panel" data-state="out-right">
          <div class="rise text-center mb-6">
            <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">Create your member account</h1>
          </div>
          <form method="POST" class="space-y-3">
            <input type="hidden" name="action" value="register">
            <div class="rise">
              <label class="block text-[12px] font-semibold text-slate-700 mb-1">Full Name</label>
              <input name="name" type="text" required placeholder="John Doe" class="inp !pl-3"/>
            </div>
            <div class="rise">
              <label class="block text-[12px] font-semibold text-slate-700 mb-1">Email Address</label>
              <input name="email" type="email" required placeholder="you@example.com" class="inp !pl-3"/>
            </div>
            <div class="rise grid grid-cols-2 gap-2">
              <div>
                <label class="block text-[12px] font-semibold text-slate-700 mb-1">Phone Number</label>
                <input name="phone" type="text" placeholder="256700123456" class="inp !pl-3 text-xs"/>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-700 mb-1">Sessions in Pack</label>
                <input name="sessions" type="number" value="12" min="1" class="inp !pl-3 text-xs"/>
              </div>
            </div>
            <div class="rise grid grid-cols-2 gap-2">
              <div>
                <label class="block text-[12px] font-semibold text-slate-700 mb-1">Membership Plan</label>
                <select name="plan" class="inp !pl-3 text-xs">
                  <option>Pro Gym Subscription</option>
                  <option>Personal Training</option>
                </select>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-700 mb-1">Fitness Goal</label>
                <input name="goal" type="text" placeholder="Fat loss & strength" class="inp !pl-3 text-xs"/>
              </div>
            </div>
            <div class="rise">
              <label class="block text-[12px] font-semibold text-slate-700 mb-1">Password</label>
              <input name="password" type="password" required placeholder="At least 8 characters" class="inp !pl-3"/>
            </div>
            <button type="submit" class="rise submit-btn btn-shine w-full h-12 mt-2 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold shadow-lg shadow-sky-500/30 flex items-center justify-center gap-2">
              <span>Complete Sign Up & Enter Portal</span><i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
const ORDER=['login','trainer','register'];
let mode='<?= $active_tab ?>';
function setMode(next){
  if(!ORDER.includes(next))next='login';
  const ni=ORDER.indexOf(next);
  ORDER.forEach((m,i)=>{
    const el = document.getElementById('panel-'+m);
    if(el) el.dataset.state = i===ni ? 'active' : (i<ni ? 'out-left' : 'out-right');
  });
  const pill = document.getElementById('tab-pill');
  if(pill) pill.style.transform='translateX('+(ni*100)+'%)';
  document.querySelectorAll('.tab-btn').forEach(b=>{
    const on=b.dataset.mode===next;
    b.classList.toggle('text-slate-900',on);
    b.classList.toggle('text-slate-500',!on);
  });
  mode=next;
}
document.querySelectorAll('[data-mode]').forEach(el=>el.addEventListener('click',()=>setMode(el.dataset.mode)));
setMode(mode);
</script>
</body>
</html>