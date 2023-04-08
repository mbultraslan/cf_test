<input type="hidden" name="user_ref" value="<?=$user ? $user['user_ref'] : '0'?>">
<div class="modal-body">
    <input type="hidden" name="userID" id="userID">
    <div class="mb-3">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="status" name="status" <?=$user && $user['status'] == 1 ? 'checked' : ''?>>
            <label class="custom-control-label" for="status" >User Status</label>
        </div>
    </div>

    <div class="mb-3">
        <label for="first_name" class="col-form-label">First Name:</label>
        <input type="text" class="form-control" name="first_name" id="first_name"  value="<?=$user ? $user['first_name'] : ''?>" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="col-form-label">Last Name:</label>
        <input type="text" class="form-control" name="last_name" id="last_name"  value="<?=$user ? $user['last_name'] : ''?>" required>
    </div>
    <div class="mb-3">
        <label for="username" class="col-form-label">Username:</label>
        <input type="text" class="form-control" name="username" id="username"  value="<?=$user ? $user['username'] : ''?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="col-form-label">Email:</label>
        <input type="email" class="form-control" name="email" id="email"  value="<?=$user ? $user['email'] : ''?>" required>
    </div>
    <div class="mb-3">
        <label for="mobile" class="col-form-label">Mobile:</label>
        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="07xxxxxxxxx"  value="<?=$user ? $user['mobile'] : ''?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="col-form-label">Password:</label>
        <input type="password" class="form-control" name="password" id="password"  required>
        <small>* Leave empty if you would like to keep the same</small>
    </div>
    <div class="mb-3">
        <label for="password_confirm" class="col-form-label">Password Confirm:</label>
        <input type="password" class="form-control" name="password_confirm" id="password_confirm" required>
    </div>
    <div class="mb-3">
        <label for="id_role" class="col-form-label">Role:</label>
        <select name="id_role" id="id_role" class="form-control" required>
            <option value="">-- Choose User Role --</option>
            <?php foreach ($roles as $role) : ?>
                <option value="<?= $role['id_role']; ?>" <?= $user && $user['id_role'] == $role['id_role'] ? 'selected' : '' ?> ><?= $role['role_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

</div>
<div class="modal-footer">
    <span onclick="users.processUser()" class="btn btn-primary"><?=$user ? 'Edit User' : 'Create User'?></span>
</div>