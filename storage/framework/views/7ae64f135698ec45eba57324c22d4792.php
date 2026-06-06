

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Results for <?php echo e($election->title); ?>

    </h1>

    <?php $__currentLoopData = [App\Models\Candidate::POSITION_PRESIDENT, App\Models\Candidate::POSITION_VICE, App\Models\Candidate::POSITION_SENATOR]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mb-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2"><?php echo e($position); ?> Results</h2>
            <?php
                $positionCandidates = $groupedCandidates->get($position, collect())->sortByDesc('votes_count');
                $winnersForPosition = $winners->get($position, collect());
                $slotLabel = $position === App\Models\Candidate::POSITION_SENATOR ? 'Top 3 winners' : 'Winner';
            ?>

            <p class="text-sm text-gray-500 mb-4"><?php echo e($slotLabel); ?></p>

            <?php if($positionCandidates->isEmpty()): ?>
                <p class="text-gray-500">No candidates registered for this position.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 rounded-lg">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Candidate</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Votes</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $positionCandidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t <?php echo e($winnersForPosition->contains('id', $candidate->id) ? 'bg-green-50 dark:bg-green-900/30' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'); ?>">
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100"><?php echo e($candidate->name); ?></td>
                                    <td class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-200"><?php echo e($candidate->votes_count); ?></td>
                                    <td class="px-4 py-2">
                                        <?php if($winnersForPosition->contains('id', $candidate->id)): ?>
                                            <span class="inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">
                                                Winner
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded-full">
                                                Runner-up
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/elections/results.blade.php ENDPATH**/ ?>