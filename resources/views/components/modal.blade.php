
<div {{ $attributes(['class' => 'relative z-10 hidden', 'aria-labelledby' => 'modal-title', 'role' => 'dialog', 'aria-modal' => 'true']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-black text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="editForm">
                    @csrf
                    <div class="bg-white/5 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div >
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg my-2 py-2 font-semibold leading-6 text-white border-b border-white/10" id="modal-title">Edit Job Details</h3>
                                <div class="mt-2">
                                    <x-forms.input label="Title" name="job-title" />
                                    <x-forms.input label="Salary" name="job-salary" />
                                    <x-forms.input label="Location" name="job-location" />
                                    <input type="hidden" id="edit-job-id" name="job_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" id="saveUserBtn" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Update</button>
                        <button type="button" onclick="closeModal()" id="cancelEdit" class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-400 sm:mt-0 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        $('#editModal').hide();
    }
</script>
{{-- ---------------- --}}