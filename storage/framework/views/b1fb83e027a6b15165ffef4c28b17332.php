

<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-users"></i> Users</h1>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New User
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('users.index')); ?>">
            <div class="row">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?php echo e(request('search')); ?>" placeholder="Search by name or email...">
                </div>
                <div class="col-md-4">
                    <label for="user_type" class="form-label">User Type</label>
                    <select class="form-select" id="user_type" name="user_type">
                        <option value="">All Types</option>
                        <option value="admin" <?php echo e(request('user_type') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="member" <?php echo e(request('user_type') == 'member' ? 'selected' : ''); ?>>Member</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users List -->
<?php if($users->count() > 0): ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>User Type</th>
                            <th>Current Loans</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->phone ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($user->user_type == 'admin' ? 'bg-primary' : 'bg-secondary'); ?>">
                                        <?php echo e(ucfirst($user->user_type)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($user->currentLoans->count() > 0): ?>
                                        <span class="badge bg-warning"><?php echo e($user->currentLoans->count()); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">None</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('users.loans', $user)); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-list"></i> Loans
                                        </a>
                                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                    <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline mt-1"
                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        <?php echo e($users->links()); ?>

    </div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No users found.
        <?php if(request('search') || request('user_type')): ?>
            Try adjusting your filters.
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\My Git Projects\CodeKongProjects\My test\your-laravel-project\resources\views/users/index.blade.php ENDPATH**/ ?>