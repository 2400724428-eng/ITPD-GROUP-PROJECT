<?php
// Live data for the Trainers screen (expects $pdo from the admin page; falls back to db_connect.php)
if (!isset($pdo)) {
    foreach ([__DIR__.'/includes/db_connect.php', __DIR__.'/../includes/db_connect.php', __DIR__.'/../../includes/db_connect.php'] as $__p) {
        if (file_exists($__p)) { require_once $__p; break; }
    }
}
$gtTrainers = []; $gtMembers = []; $gtError = '';
if (isset($pdo)) {
    try {
        $nm = function($r){ return $r['trainer_name'] ?? ucfirst(explode('@', $r['email'] ?? 'user')[0]); };
        foreach ($pdo->query("SELECT * FROM gymnuser WHERE LOWER(role)='trainer' ORDER BY user_id") as $r) {
            $gtTrainers[(int)$r['user_id']] = ['name'=>$nm($r), 'phone'=>$r['phone'] ?? 'N/A', 'spec'=>$r['specialization'] ?? '—', 'members'=>[]];
        }
        $asg = [];
        foreach ($pdo->query("SELECT member_id, trainer_id, package_name FROM gym_trainer_assignments") as $a) { $asg[(int)$a['member_id']] = $a; }
        foreach ($pdo->query("SELECT * FROM gymnuser WHERE LOWER(role)='member' ORDER BY created_at DESC") as $r) {
            $id = (int)$r['user_id']; $tid = isset($asg[$id]) ? (int)$asg[$id]['trainer_id'] : 0;
            $gtMembers[$id] = ['name'=>$nm($r), 'trainer_id'=>$tid, 'package'=>$asg[$id]['package_name'] ?? ''];
            if ($tid && isset($gtTrainers[$tid])) $gtTrainers[$tid]['members'][] = $gtMembers[$id]['name'];
        }
    } catch (PDOException $e) { $gtError = $e->getMessage(); }
}
?>
<div id="screen-gym-trainers" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Trainer Management & Allocations</h1>
      <p class="text-sm text-slate-500 mt-0.5">Oversee fitness instructors, assign personal trainers to members, and manage staff schedules.</p>
    </div>
    <div class="flex items-center gap-2">
      <button onclick="openAllocate()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs rounded shadow-sm transition">
        + Allocate Trainer
      </button>
      <button onclick="alert('Add New Trainer Modal')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded shadow-sm transition">
        + Add Trainer
      </button>
    </div>
  </div>

  <?php if ($gtError): ?><div class="mb-4 p-3 text-xs bg-rose-50 border border-rose-200 text-rose-700 rounded"><?= htmlspecialchars($gtError) ?></div><?php endif; ?>

  <!-- Trainers Table -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden mb-8">
    <div class="px-5 py-4 border-b border-slate-200 font-semibold text-sm text-slate-800">Active Instructors & Staff</div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Trainer Name</th>
            <th class="py-3.5 px-4">Specialization</th>
            <th class="py-3.5 px-4">Contact</th>
            <th class="py-3.5 px-4">Assigned Members</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (!$gtTrainers): ?>
            <tr><td colspan="5" class="py-6 px-4 text-center text-slate-400">No trainers found.</td></tr>
          <?php endif; ?>
          <?php foreach ($gtTrainers as $tid => $t): ?>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900"><?= htmlspecialchars($t['name']) ?></td>
            <td class="py-3.5 px-4 text-slate-700"><?= htmlspecialchars($t['spec']) ?></td>
            <td class="py-3.5 px-4 text-xs text-slate-500"><?= htmlspecialchars($t['phone']) ?></td>
            <td class="py-3.5 px-4 text-slate-700"><?= $t['members'] ? htmlspecialchars(implode(', ', $t['members'])) : '<span class="text-slate-400">None yet</span>' ?></td>
            <td class="py-3.5 px-4 text-right">
              <a href="trainer-dashboard.php?trainer=<?= $tid ?>" target="_blank" class="text-xs font-medium text-blue-600 hover:text-blue-800">Open dashboard</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Member assignments -->
  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden mb-8">
    <div class="px-5 py-4 border-b border-slate-200 font-semibold text-sm text-slate-800">Member Assignments</div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Member</th>
            <th class="py-3.5 px-4">Trainer</th>
            <th class="py-3.5 px-4">Package</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (!$gtMembers): ?>
            <tr><td colspan="4" class="py-6 px-4 text-center text-slate-400">No members found.</td></tr>
          <?php endif; ?>
          <?php foreach ($gtMembers as $mid => $m): $has = $m['trainer_id'] && isset($gtTrainers[$m['trainer_id']]); ?>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-4 font-medium text-slate-900"><?= htmlspecialchars($m['name']) ?></td>
            <td class="py-3.5 px-4">
              <?php if ($has): ?><span class="text-slate-700"><?= htmlspecialchars($gtTrainers[$m['trainer_id']]['name']) ?></span>
              <?php else: ?><span class="px-2 py-0.5 text-xs font-semibold rounded bg-amber-50 text-amber-700 border border-amber-200">Pending</span><?php endif; ?>
            </td>
            <td class="py-3.5 px-4 text-xs text-slate-500"><?= htmlspecialchars($m['package'] ?: '—') ?></td>
            <td class="py-3.5 px-4 text-right space-x-3">
              <button onclick="openAllocate(<?= $mid ?>, <?= (int)$m['trainer_id'] ?>)" class="text-xs font-medium text-blue-600 hover:text-blue-800"><?= $has ? 'Reassign' : 'Assign' ?></button>
              <?php if ($has): ?><button onclick="unassignMember(<?= $mid ?>)" class="text-xs font-medium text-rose-600 hover:text-rose-800">Unassign</button><?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ALLOCATE TRAINER MODAL (Hidden by default) -->
  <div id="allocate-modal" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-sm shadow-lg max-w-md w-full p-6 border border-slate-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-slate-900">Assign Trainer to Member</h3>
        <button type="button" onclick="document.getElementById('allocate-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-sm font-bold">✕</button>
      </div>
      <form id="allocate-form" onsubmit="submitAllocation(event)" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Select Gym Member</label>
          <select name="member_id" id="alloc-member" required class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
            <?php foreach ($gtMembers as $mid => $m): ?><option value="<?= $mid ?>"><?= htmlspecialchars($m['name']) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Select Trainer / Instructor</label>
          <select name="trainer_id" id="alloc-trainer" required class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none">
            <?php foreach ($gtTrainers as $tid => $t): ?><option value="<?= $tid ?>"><?= htmlspecialchars($t['name']) ?> (<?= htmlspecialchars($t['spec']) ?>)</option><?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Allocation Package / Sessions</label>
          <input type="text" name="package_name" placeholder="e.g., 4 Personal Training Sessions" class="w-full text-sm border border-slate-300 rounded-sm p-2 focus:ring-1 focus:ring-blue-600 focus:outline-none" required />
        </div>
        <div class="flex justify-end space-x-2 pt-2">
          <button type="button" onclick="document.getElementById('allocate-modal').classList.add('hidden')" class="px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded shadow-sm">Confirm Allocation</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  function openAllocate(memberId, trainerId) {
    if (memberId) document.getElementById('alloc-member').value = memberId;
    if (trainerId) document.getElementById('alloc-trainer').value = trainerId;
    document.getElementById('allocate-modal').classList.remove('hidden');
  }
  async function gtPost(data) {
    const r = await fetch('api/gym-trainers-action.php', { method: 'POST', body: new URLSearchParams(data) });
    const j = await r.json();
    if (!j.success) throw new Error(j.error || 'Request failed');
  }
  async function submitAllocation(e) {
    e.preventDefault();
    const d = Object.fromEntries(new FormData(e.target)); d.action = 'allocate';
    try { await gtPost(d); location.reload(); } catch (err) { alert(err.message); }
  }
  async function unassignMember(id) {
    if (!confirm('Unassign this member? They will show as Pending.')) return;
    try { await gtPost({ action: 'unassign', member_id: id }); location.reload(); } catch (err) { alert(err.message); }
  }
  </script>
</div>