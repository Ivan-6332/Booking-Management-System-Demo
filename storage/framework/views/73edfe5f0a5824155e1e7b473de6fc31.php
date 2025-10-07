<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Book Management System'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #6c757d;
            --accent-color: #f8f9fa;
            --hover-color: #3d5a8a;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Modern Navbar */
        .navbar {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
            box-shadow: var(--shadow);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            transform: translateY(-2px);
            color: #fff !important;
        }

        .nav-link {
            position: relative;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: rgba(255,255,255,0.2);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
        }

        /* Enhanced Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        /* Card Enhancements */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            background: white;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--hover-color) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.25rem;
        }

        /* Button Enhancements */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a6fa5 0%, #3d5a8a 100%);
            box-shadow: 0 2px 5px rgba(74, 111, 165, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3d5a8a 0%, #2e4573 100%);
            box-shadow: 0 4px 10px rgba(74, 111, 165, 0.4);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            box-shadow: 0 2px 5px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-2px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #000;
            box-shadow: 0 2px 5px rgba(255, 193, 7, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
        }

        /* Table Enhancements */
        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table thead {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }

        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }

        /* Form Enhancements */
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 111, 165, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        /* Badge Enhancements */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Content Wrapper */
        .content-wrapper {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--primary-color);
        }

        .page-header h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #6c757d;
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .content-wrapper {
                padding: 1rem;
            }

            .btn {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-book-reader"></i> Book Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('books.*') ? 'active' : ''); ?>" href="<?php echo e(route('books.index')); ?>">
                            <i class="fas fa-book"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('loans.*') ? 'active' : ''); ?>" href="<?php echo e(route('loans.index')); ?>">
                            <i class="fas fa-exchange-alt"></i> Loans
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> 
                <strong>Success!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> 
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-exclamation-triangle"></i> <strong>Please fix the following errors:</strong></h6>
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH F:\My Git Projects\CodeKongProjects\My test\your-laravel-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>