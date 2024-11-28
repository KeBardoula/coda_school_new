<div class="mt-2 mb-2">
    <h1 class="text-center">Liste des utilisateurs</h1>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">E-mail</th>
            <th scope="col">Enabled</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <a href="index.php?component=users&action=toggle_enabled&id=<? echo $user['id']; ?>">
                    <td>
                        <i class="fa-solid <?php echo $user['enabled'] ? 'fa-check text-success' : 'fa-xmark text-danger'; ?>"></i>
                    </td>
                </a>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
</div>
