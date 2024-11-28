<div class="mt-2 mb-2">
    <h1 class="text-center">Liste des utilisateurs</h1>
</div>
<?php if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
    <div class="row">
        <?php foreach ($users as $user): ?>
            <form method="POST" action="<?php echo BASE_URL_USERS . '&action=editate&id=' . $user['id']; ?>">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8 mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" class="form-control text-center" id="id" aria-describedby="idHelp" name="id" value="<?php echo $user['id']; ?>" disabled>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur :</label>
                        <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="username" value="<?php echo $user['username']; ?>">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="password" class="form-label">Mot de passe :</label>
                        <input type="text" class="form-control" id="password" aria-describedby="passwordHelp" name="password" value="<?php echo $user['password']; ?>">
                    </div>
                    <div class="col-4 mb-3">
                        <label for="email" class="form-label">E-mail :</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" name="update_button" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
<?php } elseif (isset($_GET['action']) && $_GET['action'] == 'create') { ?>
    <div class="row">
        <form method="POST" action="<?php echo BASE_URL_USERS . '&action=created'; ?>">
            <div class="row">
                <div class="col-3 mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur :</label>
                    <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="username" required>
                </div>
                <div class="col-3 mb-3">
                    <label for="email" class="form-label">E-mail :</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                </div>
                <div class="col-3 mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" aria-describedby="passwordHelp" name="password" required>
                </div>
                <div class="col-3 mb-3">
                    <label for="confirm" class="form-label">Confirmer le mot de passe :</label>
                    <input type="password" class="form-control" id="confirm" aria-describedby="confirmHelp" name="confirm" required>
                </div>
            </div>
            <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="enabled" role="switch" id="enabled">
                    <label class="form-check-label" for="enabled">Activer</label>
                </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" name="create_button" class="btn btn-primary">Créer</button>
                <button type="reset" name="reset_button" class="btn btn-primary">Annuler</button>
            </div>
        </form>
    </div>
<?php } else {?>
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
                            <a href="<?php echo BASE_URL_USERS . '&action=toggle_enabled&id=' . $user['id']; ?>">
                                <i class="fa-solid <?php echo $user['enabled'] ? 'fa-check text-success' : 'fa-xmark text-danger'; ?>"></i>
                            </a>
                        </td>
                        <td>
                            <a class="link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=delete&id=' . $user['id']; ?>">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                            <a class="link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=edit&id=' . $user['id']; ?>">
                                <i class="fa-solid fa-pen ms-2 text-warning"></i>
                            </a>
                            <a class="link-offset-2 link-underline link-underline-opacity-0" href="<?php echo BASE_URL_USERS . '&action=create&id=' . $user['id']; ?>">
                                <i class="fa-solid fa-plus ms-2 text-primary"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } ?>