<?php
// views/screen-profile.php
// Uses values already computed in dashboard.php:
//   $currentUser, $displayName, $displayEmail, $displayRole, $roleLabel,
//   $initials, $profilePic

// Pull extra DB fields for this screen
$profilePhone = '';
$profileBio   = '';
$profileSpecialty = '';
if (isset($pdo) && !empty($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare(
            "SELECT phone, bio, specialty
             FROM gymnuser
             WHERE user_id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $row = $stmt->fetch();
        if ($row) {
            $profilePhone     = $row['phone']     ?? '';
            $profileBio       = $row['bio']       ?? '';
            $profileSpecialty = $row['specialty'] ?? '';
        }
    } catch (Throwable $e) { /* ignore */ }
}

$flashSuccess = $_SESSION['profile_success'] ?? '';
$flashError   = $_SESSION['profile_error']   ?? '';
unset($_SESSION['profile_success'], $_SESSION['profile_error']);
?>
<div id="screen-profile" class="screen-fade max-w-4xl hidden">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Your Profile</h1>
    <p class="text-sm text-slate-500 mt-0.5">Manage your personal account details, credentials, and administrator role.</p>
  </div>

  <?php if ($flashSuccess): ?>
    <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2">
      <?= htmlspecialchars($flashSuccess) ?>
    </div>
  <?php endif; ?>
  <?php if ($flashError): ?>
    <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
      <?= htmlspecialchars($flashError) ?>
    </div>
  <?php endif; ?>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm p-6 mb-6">
    <div class="flex items-center gap-4 pb-6 border-b border-slate-200">

      <!-- Avatar: image if available, else initials -->
      <?php if ($profilePic): ?>
        <img src="<?= htmlspecialchars($profilePic) ?>"
             alt="<?= htmlspecialchars($displayName) ?>"
             class="w-16 h-16 rounded-full object-cover shadow-sm border border-slate-200">
      <?php else: ?>
        <div class="w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-xl flex items-center justify-center shadow-sm">
          <?= htmlspecialchars($initials) ?>
        </div>
      <?php endif; ?>

      <div>
        <h2 class="text-base font-bold text-slate-900"><?= htmlspecialchars($displayName) ?></h2>
        <p class="text-xs text-slate-500"><?= htmlspecialchars($roleLabel) ?> &middot; PURE GAIN </p>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 mt-1.5">
          Active Account
        </span>
      </div>
    </div>

    <form action="api/process-update-profile.php" method="POST" enctype="multipart/form-data" class="space-y-4 pt-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Full Name</label>
          <input type="text" name="trainer_name" value="<?= htmlspecialchars($displayName) ?>" required
                 class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Address</label>
          <input type="email" name="email" value="<?= htmlspecialchars($displayEmail) ?>" required
                 class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Phone Number</label>
          <input type="text" name="phone" value="<?= htmlspecialchars($profilePhone) ?>" placeholder="+256 700 000000"
                 class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Role / Designation</label>
          <input type="text" value="<?= htmlspecialchars($roleLabel) ?>" disabled
                 class="w-full text-sm bg-slate-50 border border-slate-200 rounded-sm p-2 text-slate-500 cursor-not-allowed" />
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Specialty</label>
          <input type="text" name="specialty" value="<?= htmlspecialchars($profileSpecialty) ?>" placeholder="e.g. Strength & Conditioning"
                 class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Profile Picture</label>
          <input type="file" name="profile_pic" accept="image/*"
                 class="w-full text-xs border border-slate-300 rounded-sm p-2 bg-white focus:ring-1 focus:ring-blue-600 focus:outline-none" />
          <p class="text-[10px] text-slate-400 mt-1">JPG/PNG, max 2&nbsp;MB</p>
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Bio</label>
        <textarea name="bio" rows="3" placeholder="Short description about you"
                  class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none"><?= htmlspecialchars($profileBio) ?></textarea>
      </div>

      <div class="border-t border-slate-100 pt-4">
        <p class="text-xs font-semibold text-slate-700 uppercase mb-2">Change Password <span class="normal-case font-normal text-slate-400">(leave blank to keep current)</span></p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[11px] font-semibold text-slate-600 mb-1">New Password</label>
            <input type="password" name="new_password" placeholder="••••••••"
                   class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
          </div>
          <div>
            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Confirm New Password</label>
            <input type="password" name="confirm_password" placeholder="••••••••"
                   class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" />
          </div>
        </div>
      </div>

      <div class="flex justify-end pt-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>