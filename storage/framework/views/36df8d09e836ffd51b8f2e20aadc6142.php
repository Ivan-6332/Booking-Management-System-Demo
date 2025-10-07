

<?php $__env->startSection('title', $book->title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-book"></i> <?php echo e($book->title); ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Author:</strong> <?php echo e($book->author); ?></p>
                        <p><strong>Category:</strong> <?php echo e($book->category->name); ?></p>
                        <p><strong>Price:</strong> $<?php echo e(number_format($book->price, 2)); ?></p>
                        <p><strong>Stock:</strong> 
                            <span class="badge <?php echo e($book->stock > 0 ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($book->stock); ?> <?php echo e($book->stock == 1 ? 'copy' : 'copies'); ?>

                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Added:</strong> <?php echo e($book->created_at->format('M d, Y')); ?></p>
                        <p><strong>Last Updated:</strong> <?php echo e($book->updated_at->format('M d, Y')); ?></p>
                        <p><strong>Available Copies:</strong> <?php echo e($book->availableCopies()); ?></p>
                        <p><strong>Currently Borrowed:</strong> <?php echo e($book->currentLoans->count()); ?></p>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(route('books.edit', $book)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Book
                        </a>
                        <?php if($book->stock > 0): ?>
                            <a href="<?php echo e(route('loans.create', $book)); ?>" class="btn btn-success">
                                <i class="fas fa-hand-point-right"></i> Borrow This Book
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-ban"></i> Out of Stock
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <form action="<?php echo e(route('books.destroy', $book)); ?>" method="POST" class="d-inline ms-2"
                          onsubmit="return confirm('Are you sure you want to delete this book?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Book
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-exchange-alt"></i> Current Loans</h5>
            </div>
            <div class="card-body">
                <?php if($book->currentLoans->count() > 0): ?>
                    <?php $__currentLoopData = $book->currentLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-bottom pb-2 mb-2">
                            <p class="mb-1"><strong><?php echo e($loan->user->name); ?></strong></p>
                            <p class="mb-1 text-muted small">
                                Borrowed: <?php echo e($loan->borrowed_at->format('M d, Y')); ?><br>
                                Due: <?php echo e($loan->due_date->format('M d, Y')); ?>

                                <?php if($loan->isOverdue()): ?>
                                    <span class="text-danger">(<?php echo e($loan->daysOverdue()); ?> days overdue)</span>
                                <?php endif; ?>
                            </p>
                            <form action="<?php echo e(route('loans.return', $loan)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-outline-primary btn-sm"
                                        onclick="return confirm('Mark this book as returned?')">
                                    <i class="fas fa-undo"></i> Return
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">No current loans for this book.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Books
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\My Git Projects\CodeKongProjects\My test\your-laravel-project\resources\views/books/show.blade.php ENDPATH**/ ?>