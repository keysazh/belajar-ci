<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="table-responsive mt-3">
    <table class="table">
        <tr>
            <th style="width: 200px;">Username</th>
            <td>: <?= $username ?></td>
        </tr>
        <tr>
            <th>Role</th>
            <td>: <span class="badge bg-success"><?= $role ?></span></td>
        </tr>
        <tr>
            <th>Email</th>
            <td>: <?= $email ?></td>
        </tr>
        <tr>
            <th>Waktu Login</th>
            <td>: <?= $waktu_login ?></td>
        </tr>
        <tr>
            <th>Status Login</th>
            <td>: <span class="text-primary"><?= $status ?></span></td>
        </tr>
    </table>
</div>
<?= $this->endSection() ?>