

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Add Candidate</h1>

<form action="<?php echo e(route('candidates.store')); ?>" method="POST" class="space-y-4">
    <?php echo csrf_field(); ?>

    <div>
        <label class="block font-medium">Name</label>
        <input type="text" name="name" class="border p-2 w-full rounded" value="<?php echo e(old('name')); ?>" required>
    </div>

    <div>
        <label class="block font-medium">Election</label>
        <select name="election_id" class="border p-2 w-full rounded" required>
            <option value="">Select an election</option>
            <?php $__currentLoopData = $elections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $election): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($election->id); ?>" <?php echo e(old('election_id') == $election->id ? 'selected' : ''); ?>><?php echo e($election->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div>
        <label class="block font-medium">Position</label>
        <select name="position" class="border p-2 w-full rounded" required>
            <option value="">Select a position</option>
            <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($position); ?>" <?php echo e(old('position') == $position ? 'selected' : ''); ?>><?php echo e($position); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/candidates/create.blade.php ENDPATH**/ ?>