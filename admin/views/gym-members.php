<?php
// ============================================================
// Gym Users Management (table: gymnuser)
// Lists all users, allows editing profiles, changing passwords,
// uploading profile pictures, and automatically creating folders.
// ============================================================

// ---- CONFIG ------------------------------------------------    
$dbCandidates = [
    __DIR__ . '/../../includes/db_connect.php',
    __DIR__ . '/../includes/db_connect.php',
    __DIR__ . '/../../../includes/db_connect.php',
    __DIR__ . '/includes/db_connect.php',
];
$fallbackDashboardUrl = '/ITPD-GROUP-PROJECT-main/admin/dashboard.php';
$maxUploadSize        = 2 * 1024 * 1024; // 2 MB
$imageWebBase         = '../';

$projectRoot = realpath(__DIR__ . '/../..') ?: __DIR__;
foreach ([__DIR__ . '/../..', __DIR__ . '/..', __DIR__] as $cand) {
    if (is_dir($cand . '/includes')) { $projectRoot = realpath($cand); break; }
}
$uploadDirFs = $projectRoot . '/uploads/avatars/';
$uploadDirDb = 'uploads/avatars/';

$docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '');
$selfFs  = str_replace('\\', '/', realpath(__FILE__));
$selfUrl = ($docRoot !== '' && strpos($selfFs, $docRoot) === 0) ? substr($selfFs, strlen($docRoot)) : 'gym-members.php';

// ---- DATABASE --------------------------------------------------
if (!isset($pdo)) {
    foreach ($dbCandidates as $p) {
        if (file_exists($p)) { require_once $p; break; }
    }
}

// ---- 1. ACTIONS HANDLER (UPDATE & DELETE ONLY) ---------------
$openedDirectly = realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === realpath(__FILE__);

if ($openedDirectly && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $returnUrl = $_POST['return_url'] ?? '';
    if (!preg_match('#^/(?!/)[^\r\n]*$#', $returnUrl)) { $returnUrl = $fallbackDashboardUrl; }
    $returnUrl = preg_replace('/[?#].*$/', '', $returnUrl);

    $back = function (string $code) use ($returnUrl) {
        header('Location: ' . $returnUrl . '?user_msg=' . urlencode($code) . '#gym-members');
        exit;
    };

    if (!isset($pdo)) { $back('err_db'); }

    $action = $_POST['action'] ?? '';

    // --- DELETE USER FROM DATABASE ---
    if ($action === 'delete') {
        $userId = (int)($_POST['user_id'] ?? 0);
        if ($userId > 0) {
            try {
                $del = $pdo->prepare("DELETE FROM gymnuser WHERE user_id = ?");
                $del->execute([$userId]);
                $back('deleted');
            } catch (\PDOException $e) {
                error_log('Delete user database error: ' . $e->getMessage());
                $back('err_sql');
            }
        }
        $back('err_required');
    }

    // --- UPDATE EXISTING USER IN DATABASE ---
    if ($action === 'edit') {
        $userId      = (int)($_POST['user_id'] ?? 0);
        $trainerName = trim($_POST['trainer_name'] ?? '');
        $email       = strtolower(trim($_POST['email'] ?? ''));
        $role        = $_POST['role'] ?? 'member';
        $password    = $_POST['password'] ?? '';
        $trainerId   = ($_POST['trainer_id'] ?? '') !== '' ? (int)$_POST['trainer_id'] : null;
        $dob         = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;
        $experience  = trim($_POST['experience'] ?? '');
        $profilePic  = '';

        if ($userId <= 0 || $trainerName === '' || $email === '') { $back('err_required'); }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $back('err_email'); }

        try {
            // Check duplicate email across database
            $chk = $pdo->prepare("SELECT COUNT(*) FROM gymnuser WHERE email = ? AND user_id != ?");
            $chk->execute([$email, $userId]);
            if ($chk->fetchColumn() > 0) { $back('err_dup_email'); }

            // Check duplicate ID code across database if provided
            if ($trainerId !== null) {
                $idChk = $pdo->prepare("SELECT COUNT(*) FROM gymnuser WHERE trainer_id = ? AND user_id != ?");
                $idChk->execute([$trainerId, $userId]);
                if ($idChk->fetchColumn() > 0) { $back('err_dup_id'); }
            }

            // Handle profile picture upload & auto-create folder if missing
            if (isset($_FILES['profile_pic_file']) && $_FILES['profile_pic_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                $f = $_FILES['profile_pic_file'];
                if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > $maxUploadSize) { $back('err_upload'); }

                $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true) || @getimagesize($f['tmp_name']) === false) {
                    $back('err_image');
                }

                // Automatically create directory if it doesn't exist
                if (!is_dir($uploadDirFs)) {
                    @mkdir($uploadDirFs, 0755, true);
                }

                $newName = 'user_' . time() . '_' . random_int(1000, 9999) . '.' . $ext;
                if (!move_uploaded_file($f['tmp_name'], $uploadDirFs . $newName)) { $back('err_move'); }
                $profilePic = $uploadDirDb . $newName;
            }

            // --- EXECUTE UPDATE RECORD ---
            if ($profilePic !== '') {
                if (!empty($password)) {
                    $pwHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt =$pdo->prepare("UPDATE gymnuser SET role = ?, email = ?, password_hash = ?, trainer_id = ?, profile_pic = ?, trainer_name = ?, date_of_birth = ?, experience = ? WHERE user_id = ?");
                    $stmt->execute([$role, $email,$pwHash, $trainerId,$profilePic, $trainerName,$dob, $experience,$userId]);
                } else {
                    $stmt =$pdo->prepare("UPDATE gymnuser SET role = ?, email = ?, trainer_id = ?, profile_pic = ?, trainer_name = ?, date_of_birth = ?, experience = ? WHERE user_id = ?");
                    $stmt->execute([$role,$email, $trainerId,$profilePic, $trainerName,$dob, $experience,$userId]);
                }
            } else {
                if (!empty($password)) {
                    $pwHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt =$pdo->prepare("UPDATE gymnuser SET role = ?, email = ?, password_hash = ?, trainer_id = ?, trainer_name = ?, date_of_birth = ?, experience = ? WHERE user_id = ?");
                    $stmt->execute([$role,$email, $pwHash,$trainerId, $trainerName,$dob, $experience,$userId]);
                } else {
                    $stmt =$pdo->prepare("UPDATE gymnuser SET role = ?, email = ?, trainer_id = ?, trainer_name = ?, date_of_birth = ?, experience = ? WHERE user_id = ?");
                    $stmt->execute([$role, $email,$trainerId, $trainerName,$dob, $experience,$userId]);
                }
            }
            $back('updated');
        } catch (\PDOException $e) {
            error_log('User update database error: ' . $e->getMessage());$back('err_sql');
        }
    }
}

// ---- 2. MESSAGES ------------------------------------------------
$userMessages = [
    'updated'       => ['success', 'User updated successfully!'],
    'deleted'       => ['success', 'User deleted from database successfully.'],
    'err_required'  => ['error', 'Name and email are required.'],
    'err_email'     => ['error', 'Please enter a valid email address.'],
    'err_dup_email' => ['error', 'A user with this email already exists in the database.'],
    'err_dup_id'    => ['error', 'That ID code is already taken.'],
    'err_upload'    => ['error', 'Profile picture upload failed or exceeds 2 MB.'],
    'err_image'     => ['error', 'Invalid image format. Allowed: JPG, PNG, WEBP, GIF.'],
    'err_move'      => ['error', 'Could not save the picture. Check directory permissions.'],
    'err_db'        => ['error', 'Database connection not found.'],
    'err_sql'       => ['error', 'Database execution error. Check PHP error logs.'],
];
$userSuccess = $userError = '';$formSubmitted = false;
if (isset($_GET['user_msg'],$userMessages[$_GET['user_msg']])) {$formSubmitted = true;
    [$kind,$text] = $userMessages[$_GET['user_msg']];
    if ($kind === 'success') { $userSuccess =$text; } else { $userError =$text; }
}

// ---- 3. LOAD ALL USERS FROM DATABASE -----------------------------
$usersList = [];
if (isset($pdo)) {
    try {
        $uStmt =$pdo->query("SELECT * FROM gymnuser ORDER BY user_id DESC");
        $usersList =$uStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log('Fetch users from database error: ' . $e->getMessage());
    }
}
?>

<div id="screen-gym-members" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Gym Users Management</h1>
      <p class="text-sm text-slate-500 mt-0.5">Manage existing users, edit profiles, update passwords, and manage permissions[cite: 4].</p>
    </div>
  </div>

  <?php if (!empty($userSuccess)): ?>
    <div class="p-3 mb-4 rounded-lg bg-emerald-50 text-emerald-700 font-medium text-xs border border-emerald-200">
      <?php echo htmlspecialchars($userSuccess); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($userError)): ?>
    <div class="p-3 mb-4 rounded-lg bg-rose-50 text-rose-600 font-medium text-xs border border-rose-200">
      <?php echo htmlspecialchars($userError); ?>
    </div>
  <?php endif; ?>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">User</th>
            <th class="py-3.5 px-4">Role</th>
            <th class="py-3.5 px-4">Email</th>
            <th class="py-3.5 px-4">Experience / DOB</th>
            <th class="py-3.5 px-4">ID Code</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($usersList)): ?>
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-500 italic text-xs">No users found in database.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($usersList as$u): 
              $uPic = !empty($u['profile_pic']) ? ((strpos($u['profile_pic'], 'http') === 0) ?$u['profile_pic'] : $imageWebBase . ltrim($u['profile_pic'], '/')) : '';
              $uName =$u['trainer_name'] ?? 'Unnamed User';
              $uEmail =$u['email'] ?? '';
              $uRole =$u['role'] ?? 'member';
              $uExp =$u['experience'] ?? '';
              $uDob =$u['date_of_birth'] ?? '';
              $uCode =$u['trainer_id'] ?? '';
              $uId = (int)$u['user_id'];
            ?>
              <tr class="hover:bg-slate-50 transition">
                <td class="py-3.5 px-4 font-medium text-slate-900 flex items-center gap-3">
                  <?php if (!empty($uPic)): ?>
                    <img src="<?php echo htmlspecialchars($uPic); ?>" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-xs shrink-0"/>
                  <?php else: ?>
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0 border border-blue-100">
                      <i class="fa-solid fa-user"></i>
                    </div>
                  <?php endif; ?>
                  <span class="truncate"><?php echo htmlspecialchars($uName); ?></span>
                </td>
                <td class="py-3.5 px-4">
                  <span class="px-2 py-0.5 text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 rounded-full uppercase">
                    <?php echo htmlspecialchars(str_replace('_', ' ', $uRole)); ?>
                  </span>
                </td>
                <td class="py-3.5 px-4 text-xs text-slate-500"><?php echo htmlspecialchars($uEmail); ?></td>
                <td class="py-3.5 px-4 text-slate-600 text-xs">
                  <?php echo $uExp ? htmlspecialchars($uExp) : ($uDob ? htmlspecialchars(date('M d, Y', strtotime($uDob))) : 'N/A'); ?>
                </td>
                <td class="py-3.5 px-4">
                  <?php if ($uCode): ?>
                    <span class="px-2 py-0.5 text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-200 rounded-full">
                      #<?php echo htmlspecialchars($uCode); ?>
                    </span>
                  <?php else: ?>
                    <span class="text-xs text-slate-400">N/A</span>
                  <?php endif; ?>
                </td>
                <td class="py-3.5 px-4 text-right space-x-2">
                  <button type="button" onclick="openUserModal(<?php echo htmlspecialchars(json_encode([
                    'user_id' => $uId,
                    'trainer_name' => $uName,
                    'email' => $uEmail,
                    'role' => $uRole,
                    'trainer_id' => $uCode,
                    'experience' => $uExp,
                    'date_of_birth' => $uDob
                  ])); ?>)" class="text-xs font-medium text-blue-600 hover:text-blue-800">Edit / Password</button>
                  <button type="button" onclick="deleteUser(<?php echo $uId; ?>, '<?php echo htmlspecialchars($uName, ENT_QUOTES); ?>')" class="text-xs font-medium text-rose-600 hover:text-rose-800">Delete</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- EDIT USER MODAL -->
<div id="user-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-white rounded-xl shadow-xl border border-slate-200 max-w-lg w-full p-6 sm:p-7 overflow-y-auto max-h-[90vh]">
    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
      <h3 class="text-base font-bold text-slate-900">Edit User Profile & Password</h3>
      <button onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
    </div>

    <form action="<?php echo htmlspecialchars($selfUrl); ?>" method="POST" enctype="multipart/form-data" class="space-y-3.5">
      <input type="hidden" name="action" value="edit"/>
      <input type="hidden" name="user_id" id="form-user-id" value=""/>
      <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? ''); ?>"/>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Full Name</label>
        <input type="text" id="modal-name" name="trainer_name" required class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Email Address</label>
        <input type="email" id="modal-email" name="email" required class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Role</label>
        <select id="modal-role" name="role" class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600" required>
          <option value="admin">Admin</option>
          <option value="trainer">Trainer</option>
          <option value="product_manager">Product Manager</option>
          <option value="member">Member</option>
        </select>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">New Password <span class="text-slate-400 font-normal normal-case">(Leave blank to keep existing password)</span></label>
        <input type="password" id="modal-password" name="password" placeholder="••••••••" class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">ID Code</label>
          <input type="number" id="modal-trainer-id" name="trainer_id" class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Experience</label>
          <input type="text" id="modal-experience" name="experience" class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
        </div>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Date of Birth</label>
        <input type="date" id="modal-dob" name="date_of_birth" class="w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-600"/>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Update Profile Picture (Auto-creates folder if missing)</label>
        <input type="file" name="profile_pic_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"/>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
        <button type="button" onclick="closeUserModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-lg transition">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg shadow-sm transition">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- HIDDEN DELETE FORM -->
<form id="delete-user-form" action="<?php echo htmlspecialchars($selfUrl); ?>" method="POST" class="hidden">
  <input type="hidden" name="action" value="delete">
  <input type="hidden" name="user_id" id="delete-user-id" value="">
  <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? ''); ?>">
</form>

<script>
  function openUserModal(data) {
    const modal = document.getElementById('user-modal');
    const userId = document.getElementById('form-user-id');
    const nameInput = document.getElementById('modal-name');
    const emailInput = document.getElementById('modal-email');
    const roleInput = document.getElementById('modal-role');
    const trainerIdInput = document.getElementById('modal-trainer-id');
    const expInput = document.getElementById('modal-experience');
    const dobInput = document.getElementById('modal-dob');
    const pwdInput = document.getElementById('modal-password');

    if (data) {
      userId.value = data.user_id;
      nameInput.value = data.trainer_name || '';
      emailInput.value = data.email || '';
      roleInput.value = data.role || 'member';
      trainerIdInput.value = data.trainer_id || '';
      expInput.value = data.experience || '';
      dobInput.value = data.date_of_birth || '';
      pwdInput.value = '';
    }
    if (modal) modal.classList.remove('hidden');
  }

  function closeUserModal() {
    const m = document.getElementById('user-modal');
    if (m) m.classList.add('hidden');
  }

  function deleteUser(id, name) {
    if (confirm(`Are you sure you want to permanently delete user "${name}" from the database?`)) {
      document.getElementById('delete-user-id').value = id;
      document.getElementById('delete-user-form').submit();
    }
  }

  <?php if ($formSubmitted): ?>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof showScreen === 'function') { showScreen('gym-members'); }
    else { const s = document.getElementById('screen-gym-members'); if (s) s.classList.remove('hidden'); }
  });
  <?php endif; ?>
</script>