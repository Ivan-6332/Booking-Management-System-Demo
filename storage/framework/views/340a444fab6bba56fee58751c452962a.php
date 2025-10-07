

<?php $__env->startSection('title', 'Books'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-book"></i> Books</h1>
    <a href="<?php echo e(route('books.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('books.index')); ?>">
            <div class="row">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?php echo e(request('search')); ?>" placeholder="Search by title or author...">
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" 
                                    <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Books List -->
<?php if($books->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($book->title); ?></h5>
                        <p class="card-text">
                            <strong>Author:</strong> <?php echo e($book->author); ?><br>
                            <strong>Category:</strong> <?php echo e($book->category->name); ?><br>
                            <strong>Price:</strong> $<?php echo e(number_format($book->price, 2)); ?><br>
                            <strong>Stock:</strong> 
                            <span class="badge <?php echo e($book->stock > 0 ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($book->stock); ?> <?php echo e($book->stock == 1 ? 'copy' : 'copies'); ?>

                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="<?php echo e(route('books.show', $book)); ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="<?php echo e(route('books.edit', $book)); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <?php if($book->stock > 0): ?>
                                <a href="<?php echo e(route('loans.create', $book)); ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-hand-point-right"></i> Borrow
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-ban"></i> Out of Stock
                                </button>
                            <?php endif; ?>
                        </div>
                        <form action="<?php echo e(route('books.destroy', $book)); ?>" method="POST" class="mt-2" 
                              onsubmit="return confirm('Are you sure you want to delete this book?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?php echo e($books->links()); ?>

    </div>
<?php else: ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No books found.
        <?php if(request('search') || request('category')): ?>
            Try adjusting your filters.
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\My Git Projects\CodeKongProjects\My test\your-laravel-project\resources\views/books/index.blade.php ENDPATH**/ ?>