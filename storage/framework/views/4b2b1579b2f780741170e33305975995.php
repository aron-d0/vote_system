<?php $__env->startSection('content'); ?>
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Elections</h1>

    <!-- Add Election -->
    <a href="<?php echo e(route('elections.create')); ?>" 
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
        + Add Election
    </a>

    <!-- Elections Grid -->
    <div class="mt-6 grid gap-6 md:grid-cols-2">
        <?php $__currentLoopData = $elections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $election): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border rounded-lg bg-white dark:bg-gray-800 shadow hover:shadow-lg transition p-6">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            <?php echo e($election->title); ?>

                        </h2>
                        <p class="text-sm text-gray-500">
                            <?php echo e(optional($election->start_at)->format('M d, Y H:i')); ?> 
                            &ndash; 
                            <?php echo e(optional($election->end_at)->format('M d, Y H:i')); ?>

                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <!-- Edit -->
                        <a href="<?php echo e(route('elections.edit', $election->id)); ?>" 
                           class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow 
                                  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            Edit
                        </a>

                        <!-- Results -->
                        <?php if(auth()->user()->is_admin): ?>
                            <a href="<?php echo e(route('elections.results', $election->id)); ?>" 
                               class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md shadow 
                                      hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                                Results
                            </a>
                        <?php endif; ?>

                        <!-- Vote / Closed -->
                        <?php if($election->isActive()): ?>
                            <a href="<?php echo e(route('votes.election.create', $election->id)); ?>" 
                               class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow 
                                      hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                Vote
                            </a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm font-semibold text-gray-400 bg-gray-100 rounded-md">
                                Closed
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description -->
                <?php if($election->description): ?>
                    <p class="mt-3 text-gray-700 dark:text-gray-300"><?php echo e($election->description); ?></p>
                <?php endif; ?>

                <!-- Delete -->
                <form action="<?php echo e(route('elections.destroy', $election->id)); ?>" method="POST" class="mt-4">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow 
                                   hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                        Delete
                    </button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/elections/index.blade.php ENDPATH**/ ?>