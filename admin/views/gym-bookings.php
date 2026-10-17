<?php
// gym-bookings.php — Dynamic Admin Class Bookings & Schedule Panel
$bookingsList = [];
if (isset($pdo)) {
    try {
        $stmtBookings = $pdo->query("SELECT * FROM gym_records WHERE record_type = 'class_booking' ORDER BY created_at DESC");
        while ($bRow = $stmtBookings->fetch(PDO::FETCH_ASSOC)) {
            $payload = [];
            if (!empty($bRow['payload'])) {
                $payload = json_decode($bRow['payload'], true) ?? [];
            }

            $memberName = $payload['member_name'] ?? ('Member #' . ($bRow['user_id'] ?? '11'));
            $trainerName = $payload['trainer_name'] ?? 'Coach James';
            $classTime = !empty($bRow['start_time']) ? date('D d M Y, g:i A', strtotime($bRow['start_time'])) : (!empty($bRow['created_at']) ? date('D d M Y, g:i A', strtotime($bRow['created_at'])) : 'Scheduled');

            $bookingsList[] = [
                'record_id' => $bRow['record_id'] ?? $bRow['id'] ?? 0,
                'class_name' => $bRow['title'] ?? 'Gym Class',
                'member_name' => $memberName,
                'trainer_name' => $trainerName,
                'time' => $classTime,
                'status' => ucfirst($bRow['status'] ?? 'Confirmed')
            ];
        }
    } catch (\PDOException $e) {
        $dbError = $e->getMessage();
    }
}
?>
<div id="screen-gym-bookings" class="screen-fade max-w-5xl hidden">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
      <h1 class="text-xl font-bold text-slate-900">Class Bookings & Schedule</h1>
      <p class="text-sm text-slate-500 mt-0.5">Monitor member class bookings, trainer schedules, and reservations.</p>
    </div>
    <span class="px-3 py-1 bg-sky-50 text-sky-700 text-xs font-bold rounded-full border border-sky-200">
      <?= count($bookingsList) ?> Total Member Bookings
    </span>
  </div>

  <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
            <th class="py-3.5 px-4">Class Name</th>
            <th class="py-3.5 px-4">Booked By Member</th>
            <th class="py-3.5 px-4">Trainer</th>
            <th class="py-3.5 px-4">Time Schedule</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm">
          <?php if (empty($bookingsList)): ?>
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400">No member class bookings recorded yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($bookingsList as $booking): ?>
              <tr class="hover:bg-slate-50">
                <td class="py-3.5 px-4 font-bold text-slate-900"><?= htmlspecialchars($booking['class_name']) ?></td>
                <td class="py-3.5 px-4 text-slate-700 font-medium"><?= htmlspecialchars($booking['member_name']) ?></td>
                <td class="py-3.5 px-4 text-slate-700"><?= htmlspecialchars($booking['trainer_name']) ?></td>
                <td class="py-3.5 px-4 text-xs text-slate-500"><?= htmlspecialchars($booking['time']) ?></td>
                <td class="py-3.5 px-4">
                  <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full"><?= htmlspecialchars($booking['status']) ?></span>
                </td>
                <td class="py-3.5 px-4 text-right">
                  <button onclick="alert('Viewing booking details for <?= htmlspecialchars($booking['member_name']) ?>')" class="text-xs font-medium text-blue-600 hover:text-blue-800">View Details</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>