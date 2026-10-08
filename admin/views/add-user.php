<!-- views/add-user.php -->
<div id="screen-add-user" class="hidden screen-fade">
  <div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Add New User</h1>
    <p class="text-xs text-slate-500">Create a new system administrator or staff account.</p>
  </div>

  <!-- Form content goes here -->
  <form action="" method="POST" class="bg-white border border-slate-200 rounded-lg p-6 max-w-2xl space-y-4">
    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
      <input type="text" name="fullname" placeholder="Enter full name" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
    </div>
    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
      <input type="email" name="email" placeholder="Enter email address" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600" required>
    </div>
    <div>
      <label class="block text-xs font-semibold text-slate-700 mb-1">Role</label>
      <select name="role" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-600">
        <option value="administrator">Administrator</option>
        <option value="staff">Staff</option>
      </select>
    </div>
    <div class="pt-2">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 transition">Save User</button>
    </div>
  </form>
</div>