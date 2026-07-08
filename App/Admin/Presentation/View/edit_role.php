<?php
$assignedPermissions = $assignedPermissions ?? $rolePermissions ?? [];
$permissions = $permissions ?? [];
$role = $role ?? null;
$roleName = isset($role['name']) && $role['name'] !== '' ? $role['name'] : 'Unknown Role';
$roleId = is_array($role) && isset($role['id']) ? $role['id'] : '';

// Map out domain font icons for modern modular identity
$moduleIcons = [
    'User Management' => 'fa-users-gear',
    'Blood Requests'  => 'fa-droplet',
    'Notifications'   => 'fa-bell',
    'Profile'         => 'fa-user-shield',
    'Dashboard'       => 'fa-chart-pie',
    'Other'           => 'fa-cubes'
];
?>

<main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8 w-full max-w-7xl mx-auto min-h-screen select-none selection:bg-red-500 selection:text-white">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 text-sm">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Edit Role Matrix: <span class="text-red-600"><?= htmlspecialchars($roleName) ?></span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1">
                Configure and fine-tune localized structural framework access tokens across the deployment landscape.
            </p>
        </div>

        <button onclick="window.history.back();"
            class="group border border-slate-200 bg-white hover:bg-slate-50 active:scale-[0.98] text-slate-600 px-4 py-2 rounded-xl font-bold text-xs sm:text-sm shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 self-start sm:self-auto">
            <span>&larr;</span> Cancel & Go Back
        </button>
    </div>

    <form method="POST" action="/BloodConnect/public/admin/roles/update-permissions" class="space-y-6">
        <input type="hidden" name="role_id" value="<?= htmlspecialchars($roleId) ?>">

        <div class="bg-white border border-slate-100 p-4 sm:p-5 rounded-2xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" id="selectAll" class="w-5 h-5 rounded-md border-slate-300 text-red-600 focus:ring-red-500/20 transition-all cursor-pointer">
                <div>
                    <span class="text-sm font-black text-slate-800 group-hover:text-slate-900 transition-colors">Grant Global Domain Control</span>
                    <p class="text-[11px] text-slate-400 font-medium leading-none mt-0.5">Toggle and bind all available core permission parameters simultaneously.</p>
                </div>
            </label>

            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-500 hover:bg-red-600 active:scale-[0.99] text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-red-500/10 hover:shadow-lg hover:shadow-red-500/20 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk text-xs"></i> Save Matrix Permissions
            </button>
        </div>

        <?php
        $groups = [
            'User Management' => [],
            'Blood Requests'  => [],
            'Notifications'   => [],
            'Profile'         => [],
            'Dashboard'       => [],
            'Other'           => []
        ];

        foreach ($permissions as $permission) {
            $key = strtolower($permission['permission_key'] ?? '');
            if (str_contains($key, 'user')) {
                $groups['User Management'][] = $permission;
            } elseif (str_contains($key, 'blood_request') || str_contains($key, 'blood')) {
                $groups['Blood Requests'][] = $permission;
            } elseif (str_contains($key, 'notification')) {
                $groups['Notifications'][] = $permission;
            } elseif (str_contains($key, 'profile')) {
                $groups['Profile'][] = $permission;
            } elseif (str_contains($key, 'dashboard')) {
                $groups['Dashboard'][] = $permission;
            } else {
                $groups['Other'][] = $permission;
            }
        }
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php foreach ($groups as $title => $items): ?>
                <?php if (!empty($items)): ?>
                    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm hover:shadow-md hover:scale-[1.01] transition-all duration-300 flex flex-col h-full overflow-hidden">

                        <div class="flex items-center justify-between border-b border-slate-50 pb-3 mb-4 shrink-0">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid <?= $moduleIcons[$title] ?? 'fa-cubes' ?>"></i>
                                </span>
                                <h2 class="font-extrabold text-slate-900 tracking-tight text-sm sm:text-base truncate">
                                    <?= htmlspecialchars($title) ?>
                                </h2>
                            </div>

                            <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-100 text-[11px] font-bold text-slate-600 transition-colors cursor-pointer shrink-0">
                                <input type="checkbox" class="group-select w-3.5 h-3.5 rounded border-slate-300 text-red-600 focus:ring-0 transition-all cursor-pointer">
                                All
                            </label>
                        </div>

                        <div class="space-y-2.5 flex-grow">
                            <?php foreach ($items as $permission):
                                // Dynamic state checking calculation logic
                                $isChecked = in_array($permission['permission_id'], $assignedPermissions) || in_array($permission['permission_key'], $assignedPermissions);
                            ?>
                                <label class="flex items-start gap-3 p-3 border border-slate-100 rounded-xl bg-slate-50/40 hover:bg-slate-50/90 transition-all duration-150 cursor-pointer group">
                                    <input type="checkbox"
                                        class="permission-checkbox w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500/10 mt-0.5 transition-all cursor-pointer"
                                        name="permissions[]"
                                        value="<?= htmlspecialchars($permission['permission_id']) ?>"
                                        <?= $isChecked ? 'checked' : '' ?>>
                                    <div class="min-w-0">
                                        <span class="text-xs sm:text-sm font-semibold text-slate-700 group-hover:text-slate-900 transition-colors block">
                                            <?= htmlspecialchars($permission['permission_name']) ?>
                                        </span>
                                        <?php if (!empty($permission['permission_key'])): ?>
                                            <span class="text-[10px] font-mono font-medium text-slate-400 tracking-tight block truncate mt-0.5">
                                                <?= htmlspecialchars($permission['permission_key']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </form>
</main>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const mainSelectAll = document.getElementById('selectAll');
        const allPermissions = document.querySelectorAll('.permission-checkbox');
        const groupSelects = document.querySelectorAll('.group-select');

        // Run dynamic baseline update evaluation check on launch parameters
        updateMainSelectAll();
        updateModuleSelectAllStates();

        // Main Select All trigger event listener processing
        mainSelectAll.addEventListener('change', function() {
            allPermissions.forEach(permission => {
                permission.checked = this.checked;
            });
            groupSelects.forEach(group => {
                group.checked = this.checked;
            });
        });

        // Individual Module Card Header Selection Listener Action Group
        groupSelects.forEach(groupSelect => {
            groupSelect.addEventListener('change', function() {
                const container = this.closest('.bg-white');
                const permissions = container.querySelectorAll('.permission-checkbox');

                permissions.forEach(permission => {
                    permission.checked = this.checked;
                });
                updateMainSelectAll();
            });
        });

        // Individual Selection Row Input Interceptor Listener Loops
        allPermissions.forEach(permission => {
            permission.addEventListener('change', function() {
                const container = this.closest('.bg-white');
                const groupCheckbox = container.querySelector('.group-select');
                const groupPermissions = container.querySelectorAll('.permission-checkbox');
                const checkedCount = container.querySelectorAll('.permission-checkbox:checked').length;

                groupCheckbox.checked = checkedCount === groupPermissions.length;
                updateMainSelectAll();
            });
        });

        // Evaluation Processing Method tracking across entire matrix landscape
        function updateMainSelectAll() {
            if (!mainSelectAll) return;
            const totalChecked = document.querySelectorAll('.permission-checkbox:checked').length;
            mainSelectAll.checked = (totalChecked === allPermissions.length) && allPermissions.length > 0;
        }

        // Evaluation Engine monitoring targeted modular inner cards balance parameters
        function updateModuleSelectAllStates() {
            groupSelects.forEach(groupSelect => {
                const container = groupSelect.closest('.bg-white');
                const totalPerms = container.querySelectorAll('.permission-checkbox');
                const totalChecked = container.querySelectorAll('.permission-checkbox:checked');
                groupSelect.checked = (totalPerms.length === totalChecked.length) && totalPerms.length > 0;
            });
        }
    });
</script>