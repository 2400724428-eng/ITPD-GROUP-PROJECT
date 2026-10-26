<?php
// views/screen-settings.php
// Assumes dashboard.php already loaded $pdo, $currentUser, $displayName, $displayEmail, $displayRole, $roleLabel.

// Load or seed user_settings
$settingsDefaults = [
    'theme' => 'light', 'accent' => '#2563eb', 'density' => 'comfortable',
    'notify_email_orders' => 1, 'notify_inapp_orders' => 1,
    'notify_messages' => 1, 'notify_payments' => 1, 'notify_weekly' => 0,
    'digest_frequency' => 'instant',
    'timezone' => 'Africa/Kampala', 'date_format' => 'dmy',
    'twofa_enabled' => 0, 'twofa_secret' => null,
    'deactivated_at' => null,
];
$settings = $settingsDefaults;
if (isset($pdo) && !empty($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM user_settings WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        if ($r = $stmt->fetch()) $settings = array_merge($settingsDefaults, $r);
    } catch (Throwable $e) { /* defaults */ }
}

// Active sessions
$activeSessions = [];
if (isset($pdo)) {
    try {
        $s = $pdo->prepare("SELECT id, ip, user_agent, last_seen FROM user_sessions
                            WHERE user_id = :id ORDER BY last_seen DESC LIMIT 20");
        $s->execute([':id' => $_SESSION['user_id']]);
        $activeSessions = $s->fetchAll();
    } catch (Throwable $e) { $activeSessions = []; }
}

// Login history
$loginHistory = [];
if (isset($pdo)) {
    try {
        $h = $pdo->prepare("SELECT email, ip, success, created_at FROM login_attempts
                            WHERE user_id = :id OR email = :email
                            ORDER BY created_at DESC LIMIT 15");
        $h->execute([':id' => $_SESSION['user_id'], ':email' => $displayEmail]);
        $loginHistory = $h->fetchAll();
    } catch (Throwable $e) { $loginHistory = []; }
}

// Two-factor: current secret (or generate one to display)
$twofaSecret = $settings['twofa_secret'] ?? '';
if (!$twofaSecret) {
    // generate once so it can be shown in the QR
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $twofaSecret = '';
    for ($i = 0; $i < 16; $i++) $twofaSecret .= $alphabet[random_int(0, 31)];
}
$otpauthUrl = sprintf(
    'otpauth://totp/%s:%s?secret=%s&issuer=%s',
    rawurlencode('PURE GAIN'),
    rawurlencode($displayEmail),
    $twofaSecret,
    rawurlencode('PURE GAIN')
);
$qrSrc = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=' . rawurlencode($otpauthUrl);

$flashSuccess = $_SESSION['settings_success'] ?? '';
$flashError   = $_SESSION['settings_error']   ?? '';
unset($_SESSION['settings_success'], $_SESSION['settings_error']);
?>
<div id="screen-settings" class="screen-fade max-w-5xl hidden">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Settings</h1>
    <p class="text-sm text-slate-500 mt-0.5">Preferences, security, sessions, and account controls for <strong><?= htmlspecialchars($displayEmail) ?></strong>.</p>
  </div>

  <?php if ($flashSuccess): ?>
    <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2"><?= htmlspecialchars($flashSuccess) ?></div>
  <?php endif; ?>
  <?php if ($flashError): ?>
    <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2"><?= htmlspecialchars($flashError) ?></div>
  <?php endif; ?>

  <!-- Tab bar -->
  <div class="bg-white border border-slate-200 rounded-md shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-[200px_1fr]">

      <nav class="border-b sm:border-b-0 sm:border-r border-slate-200 p-3 space-y-1">
        <?php
        $tabs = [
          'general'    => 'General',
          'security'   => 'Security',
          'sessions'   => 'Sessions & Login History',
          'danger'     => 'Danger Zone',
        ];
        foreach ($tabs as $id => $label): ?>
          <button type="button" data-tab-btn="<?= $id ?>" onclick="showSettingsTab('<?= $id ?>')"
                  class="settings-tab w-full text-left px-3 py-2 text-sm rounded-md text-slate-700 hover:bg-slate-50">
            <?= $label ?>
          </button>
        <?php endforeach; ?>
      </nav>

      <div class="p-6">

        <!-- ================= GENERAL ================= -->
        <section data-tab-panel="general" class="hidden space-y-6">
          <form action="api/process-settings.php" method="POST" class="space-y-4">
            <input type="hidden" name="section" value="general">
            <h2 class="font-bold text-slate-900 mb-1">General Preferences</h2>

            <div class="flex items-center justify-between border border-slate-200 rounded-md px-3 py-2">
              <div>
                <div class="text-sm font-medium text-slate-800">Email Notifications</div>
                <div class="text-xs text-slate-500">New orders, sign-ups, and messages.</div>
              </div>
              <input type="checkbox" name="notify_email_orders" value="1" class="w-4 h-4" <?= !empty($settings['notify_email_orders']) ? 'checked' : '' ?>>
            </div>

            <div class="flex items-center justify-between border border-slate-200 rounded-md px-3 py-2">
              <div>
                <div class="text-sm font-medium text-slate-800">In-app Order Toast</div>
                <div class="text-xs text-slate-500">Show a pop-up toast when a new order arrives.</div>
              </div>
              <input type="checkbox" name="notify_inapp_orders" value="1" class="w-4 h-4" <?= !empty($settings['notify_inapp_orders']) ? 'checked' : '' ?>>
            </div>

            <div class="flex items-center justify-between border border-slate-200 rounded-md px-3 py-2">
              <div>
                <div class="text-sm font-medium text-slate-800">Pending Payment Reminders</div>
                <div class="text-xs text-slate-500">Daily digest of unpaid orders.</div>
              </div>
              <input type="checkbox" name="notify_payments" value="1" class="w-4 h-4" <?= !empty($settings['notify_payments']) ? 'checked' : '' ?>>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Timezone</label>
                <select name="timezone" class="w-full text-sm border border-slate-300 rounded-sm p-2">
                  <?php foreach (['Africa/Kampala','Africa/Nairobi','UTC','Europe/London','America/New_York'] as $tz): ?>
                    <option value="<?= $tz ?>" <?= $settings['timezone'] === $tz ? 'selected' : '' ?>><?= $tz ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Date Format</label>
                <select name="date_format" class="w-full text-sm border border-slate-300 rounded-sm p-2">
                  <option value="dmy" <?= $settings['date_format'] === 'dmy' ? 'selected' : '' ?>>DD/MM/YYYY</option>
                  <option value="ymd" <?= $settings['date_format'] === 'ymd' ? 'selected' : '' ?>>YYYY-MM-DD</option>
                </select>
              </div>
            </div>

            <div class="flex justify-end pt-3">
              <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow-sm">Save Preferences</button>
            </div>
          </form>
        </section>

        <!-- ================= SECURITY ================= -->
        <section data-tab-panel="security" class="hidden space-y-8">

          <!-- Change password -->
          <div>
            <h2 class="font-bold text-slate-900 mb-3">Change Password</h2>
            <form action="api/process-change-password.php" method="POST" class="space-y-3 max-w-md">
              <input type="password" name="current_password" required placeholder="Current password"
                     class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
              <input type="password" name="new_password" required minlength="6" placeholder="New password (min 6)"
                     class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
              <input type="password" name="confirm_password" required minlength="6" placeholder="Confirm new password"
                     class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
              <div class="flex justify-end">
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow-sm">Update Password</button>
              </div>
            </form>
          </div>

          <!-- Two-factor -->
          <div class="border-t border-slate-100 pt-6">
            <h2 class="font-bold text-slate-900 mb-1">Two-Factor Authentication (TOTP)</h2>
            <p class="text-xs text-slate-500 mb-4">
              Scan the QR code with Google Authenticator, Authy, or Microsoft Authenticator, then enter a 6-digit code to enable.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 items-start">
              <div class="border border-slate-200 rounded-md p-3 bg-white">
                <img src="<?= htmlspecialchars($qrSrc) ?>" alt="2FA QR" class="w-[180px] h-[180px]">
              </div>
              <div class="flex-1 space-y-3">
                <div>
                  <div class="text-xs font-semibold text-slate-600 uppercase mb-1">Or enter this secret manually</div>
                  <code class="block text-sm font-mono bg-slate-50 border border-slate-200 rounded p-2 break-all"><?= htmlspecialchars($twofaSecret) ?></code>
                </div>

                <?php if (!empty($settings['twofa_enabled'])): ?>
                  <div class="inline-flex items-center gap-2 text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-3 py-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    2FA is <strong>enabled</strong> on this account
                  </div>
                  <form action="api/process-2fa.php" method="POST">
                    <input type="hidden" name="action" value="disable">
                    <input type="password" name="password" required placeholder="Confirm password to disable"
                           class="w-full text-sm border border-slate-300 rounded-sm p-2 mb-2">
                    <button class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded shadow-sm">Disable 2FA</button>
                  </form>
                <?php else: ?>
                  <form action="api/process-2fa.php" method="POST" class="flex gap-2">
                    <input type="hidden" name="action" value="enable">
                    <input type="hidden" name="secret" value="<?= htmlspecialchars($twofaSecret) ?>">
                    <input type="text" name="code" required inputmode="numeric" pattern="\d{6}" maxlength="6"
                           placeholder="6-digit code"
                           class="w-32 text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow-sm">Enable 2FA</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </section>

        <!-- ================= SESSIONS & LOGIN HISTORY ================= -->
        <section data-tab-panel="sessions" class="hidden space-y-8">

          <!-- Active sessions -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <h2 class="font-bold text-slate-900">Active Sessions</h2>
              <form action="api/process-revoke-session.php" method="POST" onsubmit="return confirm('Log out from all other devices?')">
                <input type="hidden" name="action" value="revoke_all">
                <button class="px-3 py-1.5 text-xs font-semibold rounded bg-slate-800 text-white hover:bg-slate-900">Log Out Everywhere</button>
              </form>
            </div>
            <div class="border border-slate-200 rounded-md overflow-hidden">
              <table class="w-full text-xs">
                <thead class="bg-slate-50 text-slate-600">
                  <tr>
                    <th class="text-left px-3 py-2">IP</th>
                    <th class="text-left px-3 py-2">Device</th>
                    <th class="text-left px-3 py-2">Last Seen</th>
                    <th class="text-right px-3 py-2"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($activeSessions)): ?>
                    <tr><td colspan="4" class="px-3 py-3 text-center text-slate-400">No active sessions recorded.</td></tr>
                  <?php else: foreach ($activeSessions as $sess): ?>
                    <tr class="border-t border-slate-100">
                      <td class="px-3 py-2 font-mono text-slate-700"><?= htmlspecialchars($sess['ip'] ?: '—') ?></td>
                      <td class="px-3 py-2 text-slate-600 truncate max-w-[220px]"><?= htmlspecialchars($sess['user_agent'] ?: '—') ?></td>
                      <td class="px-3 py-2 text-slate-500"><?= htmlspecialchars($sess['last_seen']) ?></td>
                      <td class="px-3 py-2 text-right">
                        <?php if ($sess['id'] === (session_id() ? hash('sha256', session_id()) : '')): ?>
                          <span class="text-slate-400 italic">this device</span>
                        <?php else: ?>
                          <form action="api/process-revoke-session.php" method="POST" class="inline" onsubmit="return confirm('Revoke this session?')">
                            <input type="hidden" name="action" value="revoke_one">
                            <input type="hidden" name="session_id" value="<?= htmlspecialchars($sess['id']) ?>">
                            <button class="text-rose-600 hover:underline">Revoke</button>
                          </form>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Login history -->
          <div>
            <h2 class="font-bold text-slate-900 mb-3">Recent Login Attempts</h2>
            <div class="border border-slate-200 rounded-md overflow-hidden">
              <table class="w-full text-xs">
                <thead class="bg-slate-50 text-slate-600">
                  <tr>
                    <th class="text-left px-3 py-2">When</th>
                    <th class="text-left px-3 py-2">Email</th>
                    <th class="text-left px-3 py-2">IP</th>
                    <th class="text-left px-3 py-2">Result</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($loginHistory)): ?>
                    <tr><td colspan="4" class="px-3 py-3 text-center text-slate-400">No login attempts recorded yet.</td></tr>
                  <?php else: foreach ($loginHistory as $h): ?>
                    <tr class="border-t border-slate-100">
                      <td class="px-3 py-2 text-slate-500"><?= htmlspecialchars($h['created_at']) ?></td>
                      <td class="px-3 py-2 text-slate-700"><?= htmlspecialchars($h['email'] ?: '—') ?></td>
                      <td class="px-3 py-2 font-mono text-slate-700"><?= htmlspecialchars($h['ip'] ?: '—') ?></td>
                      <td class="px-3 py-2">
                        <?php if (!empty($h['success'])): ?>
                          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Success</span>
                        <?php else: ?>
                          <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-200">Failed</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ================= DANGER ZONE ================= -->
        <section data-tab-panel="danger" class="hidden space-y-6">
          <h2 class="font-bold text-rose-700">Danger Zone</h2>

          <?php if (!empty($settings['deactivated_at'])): ?>
            <div class="border border-amber-200 bg-amber-50 rounded-md p-4">
              <p class="text-xs text-amber-800 mb-3">
                Your account is currently <strong>deactivated</strong> since <?= htmlspecialchars($settings['deactivated_at']) ?>.
                You can reactivate it at any time.
              </p>
              <form action="api/process-deactivate.php" method="POST">
                <input type="hidden" name="action" value="reactivate">
                <button class="px-3 py-1.5 text-xs font-semibold rounded bg-emerald-600 text-white hover:bg-emerald-700">Reactivate Account</button>
              </form>
            </div>
          <?php else: ?>

            <!-- Deactivate -->
            <div class="border border-rose-200 bg-rose-50/60 rounded-md p-4">
              <h3 class="font-semibold text-rose-700 text-sm mb-1">Deactivate Account</h3>
              <p class="text-xs text-rose-600 mb-3">
                Your data is preserved, but you will be logged out and unable to log in until you reactivate.
                You can reactivate any time by logging back in (if allowed) or contacting support.
              </p>
              <form action="api/process-deactivate.php" method="POST"
                    onsubmit="return confirm('Deactivate your account? You will be logged out immediately.')">
                <input type="hidden" name="action" value="deactivate">
                <input type="password" name="password" required placeholder="Confirm password"
                       class="w-full sm:w-64 text-sm border border-rose-300 rounded-sm p-2 mb-2">
                <button class="px-3 py-1.5 text-xs font-semibold rounded bg-rose-600 text-white hover:bg-rose-700">Deactivate</button>
              </form>
            </div>

            <!-- Delete -->
            <div class="border border-red-300 bg-red-50 rounded-md p-4">
              <h3 class="font-semibold text-red-700 text-sm mb-1">Delete Account Permanently</h3>
              <p class="text-xs text-red-600 mb-3">
                This action <strong>cannot be undone</strong>. All your sessions, settings and login history will be deleted.
                Type your email address to confirm.
              </p>
              <form action="api/process-deactivate.php" method="POST"
                    onsubmit="return confirm('Permanently DELETE this account? This cannot be undone.')">
                <input type="hidden" name="action" value="delete">
                <input type="email" name="confirm_email" required
                       placeholder="<?= htmlspecialchars($displayEmail) ?>"
                       class="w-full sm:w-72 text-sm border border-red-300 rounded-sm p-2 mb-2">
                <input type="password" name="password" required placeholder="Confirm password"
                       class="w-full sm:w-64 text-sm border border-red-300 rounded-sm p-2 mb-2">
                <button class="px-3 py-1.5 text-xs font-semibold rounded bg-red-700 text-white hover:bg-red-800">Delete My Account</button>
              </form>
            </div>

          <?php endif; ?>
        </section>

      </div>
    </div>
  </div>
</div>

<script>
  function showSettingsTab(id) {
    document.querySelectorAll('[data-tab-panel]').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.settings-tab').forEach(b => {
      b.classList.remove('bg-blue-50','text-blue-700','font-semibold');
      b.classList.add('text-slate-700');
    });
    const panel = document.querySelector('[data-tab-panel="' + id + '"]');
    const btn   = document.querySelector('[data-tab-btn="' + id + '"]');
    if (panel) panel.classList.remove('hidden');
    if (btn) { btn.classList.add('bg-blue-50','text-blue-700','font-semibold'); btn.classList.remove('text-slate-700'); }
  }
  document.addEventListener('DOMContentLoaded', () => showSettingsTab('general'));
</script>