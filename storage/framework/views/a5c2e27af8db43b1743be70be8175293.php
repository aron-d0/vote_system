<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Cast Your Vote</h1>

<?php if($elections->isEmpty()): ?>
    <div class="rounded-lg bg-white shadow-sm p-6">
        <p class="text-gray-700">There are no active elections available right now.</p>
    </div>
<?php else: ?>
    <form id="ballot-form" action="<?php echo e(route('votes.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        <?php if(! isset($selectedElection)): ?>
            <div>
                <label for="election_id" class="block font-medium">Election</label>
                <select name="election_id" id="election_id" class="border p-2 w-full rounded" required>
                    <option value="">Select an election</option>
                    <?php $__currentLoopData = $elections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $election): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $alreadyVoted = in_array($election->id, $votedElectionIds ?? [], true); ?>
                        <option value="<?php echo e($election->id); ?>" <?php echo e(old('election_id') == $election->id ? 'selected' : ''); ?> <?php echo e($alreadyVoted ? 'disabled' : ''); ?>>
                            <?php echo e($election->title); ?><?php echo e($alreadyVoted ? ' (already voted)' : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-sm text-gray-500 mt-2">You may only vote once per election. Already-voted elections are disabled.</p>
                <?php $__errorArgs = ['election_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        <?php else: ?>
            <input type="hidden" name="election_id" value="<?php echo e($selectedElection->id); ?>">
            <div class="rounded-lg border bg-white p-4 shadow-sm">
                <h2 class="text-xl font-semibold"><?php echo e($selectedElection->title); ?></h2>
                <p class="text-sm text-gray-500">Voting for <?php echo e($selectedElection->title); ?>.</p>
            </div>
        <?php endif; ?>

        <?php $__currentLoopData = ($selectedElection ? collect([$selectedElection]) : $elections); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $election): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="election-section border rounded-lg p-4 bg-white shadow-sm" data-election-id="<?php echo e($election->id); ?>" <?php echo e(isset($selectedElection) ? '' : 'hidden'); ?>>
                <h2 class="text-lg font-semibold mb-3"><?php echo e($election->title); ?></h2>
                <p class="text-sm text-gray-500 mb-4">Choose one candidate for each position below.</p>

                <div class="grid gap-6">
                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">President</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            <?php $__empty_1 = true; $__currentLoopData = $election->candidates->where('position', App\Models\Candidate::POSITION_PRESIDENT); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="radio" name="president_candidate" value="<?php echo e($candidate->id); ?>" class="form-radio h-5 w-5 text-indigo-600" required <?php echo e(old('president_candidate') == $candidate->id ? 'checked' : ''); ?>>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold"><?php echo e($candidate->name); ?></div>
                                        <div class="text-sm text-gray-500">President candidate</div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500">No president candidates available.</p>
                            <?php endif; ?>
                        </div>
                        <?php $__errorArgs = ['president_candidate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">Vice President</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            <?php $__empty_1 = true; $__currentLoopData = $election->candidates->where('position', App\Models\Candidate::POSITION_VICE); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="radio" name="vice_president_candidate" value="<?php echo e($candidate->id); ?>" class="form-radio h-5 w-5 text-indigo-600" required <?php echo e(old('vice_president_candidate') == $candidate->id ? 'checked' : ''); ?>>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold"><?php echo e($candidate->name); ?></div>
                                        <div class="text-sm text-gray-500">Vice President candidate</div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500">No vice president candidates available.</p>
                            <?php endif; ?>
                        </div>
                        <?php $__errorArgs = ['vice_president_candidate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="rounded-lg border p-4 bg-gray-50">
                        <h3 class="font-semibold mb-3">Senators (Select up to 3 from 12 candidates)</h3>
                        <div class="grid gap-3 md:grid-cols-2">
                            <?php $__empty_1 = true; $__currentLoopData = $election->candidates->where('position', App\Models\Candidate::POSITION_SENATOR)->take(12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 cursor-pointer hover:border-indigo-500">
                                    <input type="checkbox" name="senator_candidates[]" value="<?php echo e($candidate->id); ?>" class="form-checkbox h-5 w-5 text-indigo-600 senator-checkbox" <?php echo e(is_array(old('senator_candidates')) && in_array($candidate->id, old('senator_candidates', [])) ? 'checked' : ''); ?>>
                                    <div class="space-y-1">
                                        <div class="text-lg font-semibold"><?php echo e($candidate->name); ?></div>
                                        <div class="text-sm text-gray-500">Senator candidate</div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500">No senator candidates available.</p>
                            <?php endif; ?>
                        </div>
                        <?php $__errorArgs = ['senator_candidates'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['senator_candidates.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p id="senator-count" class="text-sm text-gray-600 mt-2">Selected 0 of 3</p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="flex items-center gap-3 mt-4">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="want_print" value="1" class="form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded">
                Print a paper receipt after submitting your ballot
            </label>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit Ballot</button>
    </form>

    <script>
        const electionSelect = document.getElementById('election_id');
        const sections = document.querySelectorAll('.election-section');

        function updateElectionSections() {
            if (! electionSelect) {
                return;
            }

            const selectedId = electionSelect.value;

            sections.forEach(section => {
                const isVisible = section.dataset.electionId === selectedId;
                section.hidden = !isVisible;
                section.querySelectorAll('select, input').forEach(element => {
                    element.disabled = !isVisible;
                });
            });
        }

        if (electionSelect) {
            if (electionSelect.value === '' && electionSelect.options.length > 1) {
                for (let i = 0; i < electionSelect.options.length; i++) {
                    if (electionSelect.options[i].value) {
                        electionSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            electionSelect.addEventListener('change', updateElectionSections);
            updateElectionSections();
        }

        function updateSenatorCounter(section) {
            const checkboxes = section.querySelectorAll('.senator-checkbox');
            const countEl = section.querySelector('#senator-count');
            if (! countEl) return;
            let selected = 0;
            checkboxes.forEach(cb => { if (cb.checked) selected++; });
            countEl.textContent = `Selected ${selected} of 3`;
            checkboxes.forEach(cb => {
                cb.disabled = selected >= 3 && !cb.checked;
            });
        }

        sections.forEach(section => {
            section.addEventListener('change', function (e) {
                if (e.target.classList.contains('senator-checkbox')) {
                    updateSenatorCounter(section);
                }
            });
            updateSenatorCounter(section);
        });
    </script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/votes/create.blade.php ENDPATH**/ ?>