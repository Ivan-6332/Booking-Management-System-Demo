

<?php $__env->startSection('title', 'Book Loans'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-exchange-alt"></i> Book Loans</h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('loans.index')); ?>">
            <div class="row">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="borrowed" <?php echo e(request('status') == 'borrowed' ? 'selected' : ''); ?>>Borrowed</option>
                        <option value="returned" <?php echo e(request('status') == 'returned' ? 'selected' : ''); ?>>Returned</option>
                        <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">All Users</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" 
                                    <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('loans.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loans List -->
<?php if($loans->count() > 0): ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>User</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Returned Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($loan->book->title); ?></strong><br>
                                    <small class="text-muted">by <?php echo e($loan->book->author); ?></small>
                                </td>
                                <td><?php echo e($loan->user->name); ?></td>
                                <td><?php echo e($loan->borrowed_at->format('M d, Y')); ?></td>
                                <td>
                                    <?php echo e($loan->due_date->format('M d, Y')); ?>

                                    <?php if($loan->isOverdue()): ?>
                                        <br><small class="text-danger"><?php echo e($loan->daysOverdue()); ?> days overdue</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($loan->returned_at): ?>
                                        <?php echo e($loan->returned_at->format('M d, Y')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Not returned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($loan->status == 'borrowed'): ?>
                                        <?php if($loan->isOverdue()): ?>
                                            <span class="badge bg-danger">Overdue</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Borrowed</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge bg-success">Returned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($loan->status == 'borrowed'): ?>
                                        <form action="<?php echo e(route('loans.return', $loan)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                    onclick="return confirm('Mark this book as returned?')">
                                                <i class="fas fa-undo"></i> Return
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">Completed</span>
                                    <?php endif; ?>
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
        <?php echo e($loans->links()); ?>

    </div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No loans found.
        <?php if(request('status') || request('user_id')): ?>
            Try adjusting your filters.
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\My Git Projects\CodeKongProjects\My test\your-laravel-project\resources\views/loans/index.blade.php ENDPATH**/ ?>