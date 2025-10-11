@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Transfer Money</h4>
                </div>
                <div class="card-body">
                    {{-- Error Display --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5>Please fix the following errors:</h5>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('transfer.store') }}" method="POST" id="transferForm">
                        @csrf

                        <!-- Transfer Type -->
                        <div class="mb-4">
                            <label class="form-label">Transfer Type *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check card p-3 h-100">
                                        <input class="form-check-input" type="radio" name="transfer_type" 
                                               id="local_transfer" value="local" checked>
                                        <label class="form-check-label fw-bold" for="local_transfer">
                                            <i class="fas fa-users me-2"></i>Local Transfer
                                        </label>
                                        <small class="text-muted">Transfer to other Arkard Bank users</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check card p-3 h-100">
                                        <input class="form-check-input" type="radio" name="transfer_type" 
                                               id="international_transfer" value="international">
                                        <label class="form-check-label fw-bold" for="international_transfer">
                                            <i class="fas fa-globe me-2"></i>International Transfer
                                        </label>
                                        <small class="text-muted">Transfer to banks worldwide</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Local Transfer Fields -->
                        <div id="localFields">
                            <!-- Recipient Account Number -->
                            <div class="mb-3">
                                <label for="recipient_account_number" class="form-label">Recipient Account Number *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="recipient_account_number" 
                                           name="recipient_account_number" 
                                           value="{{ old('recipient_account_number') }}" 
                                           placeholder="Enter account number">
                                    <button type="button" id="validateAccount" class="btn btn-outline-primary">
                                        Validate
                                    </button>
                                </div>
                            </div>

                            <!-- Recipient Name (auto-filled or manual) -->
                            <div class="mb-3">
                                <label for="recipient_name" class="form-label">Recipient Name *</label>
                                <input type="text" class="form-control" id="recipient_name" 
                                       name="recipient_name" value="{{ old('recipient_name') }}" 
                                       placeholder="Recipient name will auto-fill after validation">
                            </div>
                        </div>

                        <!-- International Transfer Fields (Hidden by Default) -->
                        <div id="internationalFields" style="display: none;">
                            <!-- Recipient Name -->
                            <div class="mb-3">
                                <label for="int_recipient_name" class="form-label">Recipient Name *</label>
                                <input type="text" class="form-control" id="int_recipient_name" 
                                       name="recipient_name" value="{{ old('recipient_name') }}" 
                                       placeholder="Enter recipient's full name">
                            </div>

                            <!-- Bank Name -->
                            <div class="mb-3">
                                <label for="bank_name" class="form-label">Bank Name *</label>
                                <input type="text" class="form-control" id="bank_name" 
                                       name="bank_name" value="{{ old('bank_name') }}" 
                                       placeholder="Enter recipient's bank name">
                            </div>

                            <!-- Bank Country -->
                            <div class="mb-3">
                                <label for="bank_country" class="form-label">Bank Country *</label>
                                <input type="text" class="form-control" id="bank_country" 
                                       name="bank_country" value="{{ old('bank_country') }}" 
                                       placeholder="Enter bank country">
                            </div>

                            <!-- Bank Address -->
                            <div class="mb-3">
                                <label for="bank_address" class="form-label">Bank Address *</label>
                                <textarea class="form-control" id="bank_address" name="bank_address" 
                                          rows="2" placeholder="Enter bank address">{{ old('bank_address') }}</textarea>
                            </div>

                            <!-- SWIFT Code -->
                            <div class="mb-3">
                                <label for="swift_code" class="form-label">SWIFT/BIC Code *</label>
                                <input type="text" class="form-control" id="swift_code" 
                                       name="swift_code" value="{{ old('swift_code') }}" 
                                       placeholder="Enter SWIFT or BIC code">
                            </div>

                            <!-- IBAN -->
                            <div class="mb-3">
                                <label for="iban" class="form-label">IBAN/Account Number *</label>
                                <input type="text" class="form-control" id="iban" 
                                       name="iban" value="{{ old('iban') }}" 
                                       placeholder="Enter IBAN or account number">
                            </div>

                            <!-- Intermediary Bank (Optional) -->
                            <div class="mb-3">
                                <label for="intermediary_bank" class="form-label">Intermediary Bank (Optional)</label>
                                <input type="text" class="form-control" id="intermediary_bank" 
                                       name="intermediary_bank" value="{{ old('intermediary_bank') }}" 
                                       placeholder="Enter intermediary bank if required">
                            </div>
                        </div>

                        <!-- Common Fields -->
                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount ($) *</label>
                            <input type="number" step="0.01" class="form-control" id="amount" 
                                   name="amount" value="{{ old('amount') }}" 
                                   min="0.01" placeholder="0.00" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="2" placeholder="Add a note for this transfer">{{ old('description') }}</textarea>
                        </div>

                        <!-- Account Balance -->
                        <div class="alert alert-info">
                            <strong>Your Balance:</strong> {{ Auth::user()->formatted_balance }}
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Send Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const localFields = document.getElementById('localFields');
    const internationalFields = document.getElementById('internationalFields');
    const localRadio = document.getElementById('local_transfer');
    const internationalRadio = document.getElementById('international_transfer');
    const submitBtn = document.getElementById('submitBtn');
    const recipientNameInput = document.getElementById('recipient_name');
    const intRecipientNameInput = document.getElementById('int_recipient_name');

    // Toggle between local and international fields
    function toggleTransferType() {
        if (localRadio.checked) {
            localFields.style.display = 'block';
            internationalFields.style.display = 'none';
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Transfer';
            
            // Set required attributes for local fields
            document.getElementById('recipient_account_number').required = true;
            recipientNameInput.required = true;
            
            // Remove required attributes from international fields
            document.getElementById('bank_name').required = false;
            document.getElementById('bank_country').required = false;
            document.getElementById('bank_address').required = false;
            document.getElementById('swift_code').required = false;
            document.getElementById('iban').required = false;
            
        } else {
            localFields.style.display = 'none';
            internationalFields.style.display = 'block';
            submitBtn.innerHTML = '<i class="fas fa-globe me-2"></i>Submit for Approval';
            
            // Remove required attributes from local fields
            document.getElementById('recipient_account_number').required = false;
            recipientNameInput.required = false;
            
            // Set required attributes for international fields
            document.getElementById('bank_name').required = true;
            document.getElementById('bank_country').required = true;
            document.getElementById('bank_address').required = true;
            document.getElementById('swift_code').required = true;
            document.getElementById('iban').required = true;
        }
    }

    // Add event listeners to radio buttons
    localRadio.addEventListener('change', toggleTransferType);
    internationalRadio.addEventListener('change', toggleTransferType);

    // Initialize on page load
    toggleTransferType();

    // Sync recipient name between both fields
    function syncRecipientNames() {
        if (localRadio.checked) {
            intRecipientNameInput.value = recipientNameInput.value;
        } else {
            recipientNameInput.value = intRecipientNameInput.value;
        }
    }

    recipientNameInput.addEventListener('input', syncRecipientNames);
    intRecipientNameInput.addEventListener('input', syncRecipientNames);

    // Account validation (only for local transfers)
    document.getElementById('validateAccount').addEventListener('click', function() {
        if (!localRadio.checked) return;

        const accountNumber = document.getElementById('recipient_account_number').value;
        
        if (!accountNumber) {
            alert('Please enter an account number');
            return;
        }

        this.disabled = true;
        this.innerHTML = 'Validating...';

        fetch('{{ route("transfer.validate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                account_number: accountNumber
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.account_name) {
                recipientNameInput.value = data.account_name;
                intRecipientNameInput.value = data.account_name;
                alert('Account validated successfully!');
            } else if (data.error) {
                alert(data.error);
            } else {
                alert('Account validation failed.');
            }
        })
        .catch(error => {
            alert('Validation service temporarily unavailable.');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Validate';
        });
    });

    // Form submission confirmation for international transfers
    document.getElementById('transferForm').addEventListener('submit', function(e) {
        if (internationalRadio.checked) {
            const confirmed = confirm('International transfers require staff approval and may take 1-3 business days to process. Continue?');
            if (!confirmed) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection