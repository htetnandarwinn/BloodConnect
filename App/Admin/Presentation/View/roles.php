<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-2xl font-bold mb-6">
        Roles & Permissions
    </h2>

    <table class="min-w-full">

        <thead>
            <tr class="border-b">
                <th class="text-left p-3">Role</th>
                <th class="text-center p-3">Users</th>
                <th class="text-center p-3">Permissions</th>
                <th class="text-center p-3">Action</th>
            </tr>
        </thead>

        <tbody>

            <?php $roles = isset($roles) && is_array($roles) ? $roles : []; foreach ($roles as $role): ?>

                <tr class="border-b">

                    <td class="p-3 font-semibold">
                        <?= htmlspecialchars($role['name']) ?>
                    </td>

                    <td class="text-center">
                        <?= $role['total_users'] ?>
                    </td>

                    <td class="text-center">
                        <?= $role['total_permissions'] ?>
                    </td>

                    <td class="text-center">
                        <a href="/BloodConnect/public/admin/roles/<?= $role['id'] ?>"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Manage
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>