

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Candidates</h1>

    <!-- Add Candidate -->
    <a href="<?php echo e(route('candidates.create')); ?>" 
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
        + Add Candidate
    </a>

    <!-- Candidates List -->
    <div class="mt-6 grid gap-6 md:grid-cols-2">
        <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border rounded-lg bg-white dark:bg-gray-800 shadow hover:shadow-lg transition p-6">
                <!-- Candidate Info -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <?php echo e($candidate->name); ?>

                    </h2>
                    <p class="text-sm text-gray-500">
                        <?php echo e($candidate->position); ?> — <?php echo e($candidate->election->title); ?>

                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex flex-wrap gap-2">
                    <!-- Edit -->
                    <a href="<?php echo e(route('candidates.edit', $candidate->id)); ?>" 
                       class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow 
                              hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        Edit
                    </a>

                    <!-- Delete -->
                    <form action="<?php echo e(route('candidates.destroy', $candidate->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow 
                                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/candidates/index.blade.php ENDPATH**/ ?>