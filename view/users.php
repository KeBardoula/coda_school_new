<div class="mt-2 mb-2">
    <h1 class="text-center">Liste des utilisateurs</h1>
</div>
<?php if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
    <div class="row">
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Identifiant</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php  echo (isset($user['username'])) ? $user['username'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"  value="<?php  echo (isset($user['email'])) ? $user['email'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" <?php echo isset($_GET['id']) ? null : 'required'; ?>>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirmation du mot de passe</label>
                <input type="password" name="confirm" id="confirm" class="form-control" <?php echo isset($_GET['id']) ? null : 'required'; ?>>
            </div>
            <div class="mb-3 form-check form-switch">
                <input
                        type="checkbox"
                        class="form-check-input"
                        id="enabled"
                        name="enabled"
                        <?php echo ($user['id'] === $_SESSION['user_id']) ? 'disabled' : null; ?>
                    <?php  echo (isset($user['enabled']) && $user['enabled']) ? 'checked' : null; ?>
                >
                <label class="form-check-label" for="enabled">Actif</label>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <button
                        type="submit"
                        class="btn <?php echo isset($_GET['id']) ? 'btn-warning' : 'btn-primary'; ?>"
                        name="<?php echo isset($_GET['id']) ? 'edit_button' : 'create_button'; ?>"
                >
                    <?php  echo isset($_GET['id']) ? 'Modifier' : 'Créer'; ?>
                </button>
            </div>
        </form>
    </div>
<?php } else {?>
    <a class="btn btn-primary link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=edit'; ?>">
        <i class="fa-solid fa-plus ms-2 "></i>
        Ajouter un utilisateur
    </a>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">E-mail</th>
                <th scope="col">Actif</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php if($user['id'] !== $_SESSION['user_id']) : ?>
                                <a href="<?php echo BASE_URL_USERS . '&action=toggle_enabled&id=' . $user['id']; ?>">
                                    <i class="fa-solid <?php echo $user['enabled'] ? 'fa-check text-success' : 'fa-xmark text-danger'; ?>"></i>
                                </a>
                            <?php else : ?>
                                <i class="fa-solid <?php echo $user['enabled'] ? 'fa-check text-success' : 'fa-xmark text-danger'; ?>"
                                title="Désactivation impossible sur votre compte !"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user['id'] !== $_SESSION['user_id']) : ?>
                                <a class="link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=delete&id=' . $user['id']; ?>"
                                onclick="return confirm('Etes-vous sûr de vouloir supprimer ?');">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </a>
                            <?php endif; ?>
                            <a class="link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=edit&id=' . $user['id']; ?>">
                                <i class="fa-solid fa-pen ms-2 text-warning"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } ?>
