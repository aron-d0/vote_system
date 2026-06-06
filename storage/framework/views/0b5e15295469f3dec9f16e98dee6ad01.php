

<?php $__env->startSection('content'); ?>
<div class="py-12 bg-gray-900 min-h-screen">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 text-gray-200 shadow-md sm:rounded-lg p-8">
            <!-- Header -->
            <h1 class="text-3xl font-bold mb-6 text-white">Your Voter Verification</h1>

            <!-- QR Code Section -->
            <div class="bg-gray-700 p-8 rounded-lg text-center mb-6">
                <h2 class="text-lg font-semibold text-gray-300 mb-2">Voter ID QR Code</h2>
                <p class="text-sm text-gray-400 mb-4">Present this QR code at the voting station for verification</p>
                <img src="<?php echo e(auth()->user()->getQrCodeUrl()); ?>" 
                     alt="Voter QR Code" 
                     class="mx-auto w-40 h-40 border-4 border-gray-600 p-2 bg-white rounded-lg shadow-md">
            </div>

            <!-- Voter ID Section -->
            <div class="bg-gray-700 p-6 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-white mb-2">Your Voter ID</h3>
                <p class="text-xl font-mono text-green-400 break-all"><?php echo e(auth()->user()->generateVoterId()); ?></p>
                <button onclick="copyToClipboard('<?php echo e(auth()->user()->voter_id); ?>')" 
                        class="mt-3 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md transition">
                    📋 Copy Voter ID
                </button>
            </div>

            <!-- Info Section -->
            <div class="bg-blue-900 border border-blue-600 p-4 rounded-lg mb-6 text-blue-200">
                <h4 class="font-semibold mb-2">Important Information:</h4>
                <ul class="text-sm space-y-1 list-disc list-inside">
                    <li>Keep your Voter ID confidential</li>
                    <li>Use this QR code for voter verification at the polling station</li>
                    <li>Each voter can only vote once per election</li>
                    <li>Your voting records are secure and encrypted</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <button onclick="window.print()" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition">
                    🖨️ Print QR Code
                </button>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition text-center">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Voter ID copied to clipboard!');
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Marip\Herd\vote_system\resources\views/votes/voter-verification.blade.php ENDPATH**/ ?>