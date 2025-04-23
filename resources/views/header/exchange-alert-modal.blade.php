<div class="modal fade alertModal" id="productAlertModal" tabindex="-1" aria-labelledby="productAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 p-0">
                <h5 class="modal-title" id="productAlertModalLabel">
                    Set a Price Alert
                </h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body p-0 mt-3">
                <form id="" method="POST" action="{{ route('alerts.store') }}">
                    @csrf
                    {{-- product_id --}}
                    <input type="hidden" name="metal_id" value="{{ $metal_id }}">
                    {{-- type --}}
                    <input type="hidden" name="type" value="2">
                    {{-- currency --}}
                    <input type="hidden" name="currency" value="{{ $metal_currency }}">
                    {{-- user_id --}}
                    <div class="mb-3">
                        <label for="alert_type" class="form-label required">Alert Type</label>
                        <select class="form-select" name="alert_type" id="alert_type">
                            <option value="price_reaches">Price reaches</option>
                            <option value="price_rises_above">Price rises above</option>
                            <option value="price_drops_to">Price drops to</option>
                            <option value="change_is_over">Change is over</option>
                            <option value="change_is_under">Change is under</option>
                            <option value="24h_change_is_over">24H change is over</option>
                        </select>
                        @error('alert_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label required">Value</label>
                        <input type="number" class="form-control @error('value') is-invalid @enderror" name="value" id="value" placeholder="Enter the amount" value="{{ old('value') }}">
                        @error('value')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Frequecy Select --}}
                    <div class="mb-3">
                        <label for="frequency" class="form-label required">Frequency</label>
                        <select class="form-select" name="frequency" id="frequency">
                            {{-- real time, daily, weekly, monthly --}}
                            <option value="real_time">Real Time</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        @error('frequency')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" id="create-alert-button">
                        Create Alert
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
