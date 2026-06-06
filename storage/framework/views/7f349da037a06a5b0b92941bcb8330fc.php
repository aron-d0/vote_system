<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-white leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Dashboard Card -->
            <div class="bg-gray-800 shadow-lg sm:rounded-lg p-6 text-gray-200">
                
                <?php if(auth()->user()->is_admin): ?>
                    <h3 class="text-lg font-bold mb-6 text-white">Admin Panel</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        
                        <!-- Elections Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Manage Elections</h2>
                                    <p class="text-sm text-gray-300">Create, edit, and delete elections.</p>
                                </div>
                                <a href="<?php echo e(route('elections.index')); ?>" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>

                        <!-- Candidates Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Manage Candidates</h2>
                                    <p class="text-sm text-gray-300">Add, edit, or remove candidates.</p>
                                </div>
                                <a href="<?php echo e(route('candidates.index')); ?>" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>

                        <!-- Votes Card -->
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">View Votes</h2>
                                    <p class="text-sm text-gray-300">Check ballots and voting history.</p>
                                </div>
                                <a href="<?php echo e(route('votes.index')); ?>" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Voting Area for non-admins -->
                    <h3 class="text-lg font-bold mb-6 text-white">Voting Area</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">Start Voting</h2>
                                    <p class="text-sm text-gray-300">Cast your vote in active elections.</p>
                                </div>
                                <a href="<?php echo e(route('votes.create')); ?>" 
                                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Vote Now
                                </a>
                            </div>
                        </div>
                        <div class="bg-gray-700 border border-gray-600 p-6 rounded-lg shadow hover:shadow-lg transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-semibold text-lg text-white">My Ballots</h2>
                                    <p class="text-sm text-gray-300">View your submitted votes.</p>
                                </div>
                                <a href="<?php echo e(route('votes.index')); ?>" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md transition font-medium">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/dashboard.blade.php ENDPATH**/ ?>