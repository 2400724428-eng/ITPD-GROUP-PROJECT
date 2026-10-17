<!-- views/add-user.php -->
<div id="screen-add-user" class="hidden screen-fade">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Add New User / Staff</h1>
    <p class="text-xs text-slate-500">Create a new admin, trainer, product manager, or member account.</p>
  </div>

  <!-- Form points to admin/api/process-add-user.php -->
  <form action="api/process-add-user.php" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-lg p-6 max-w-2xl space-y-4">
    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name / Trainer Name</label>
      <input type="text" name="trainer_name" placeholder="Enter full name" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
    </div>
    
    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
      <input type="email" name="email" placeholder="Enter email address" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Temporary Password</label>
      <input type="password" name="password" placeholder="Enter initial password" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Role</label>
      <select name="role" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
        <option value="admin">Admin</option>
        <option value="trainer">Trainer</option>
        <option value="product_manager">Product Manager</option>
        <option value="member">Member</option>
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Profile Picture</label>
      <input type="file" name="profile_pic" accept="image/*" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none">
    </div>

    <div class="pt-2">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 transition">Save User</button>
    </div>
  </form>
</div>