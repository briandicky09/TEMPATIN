{{-- Notion Style Notification Alerts --}}
@if(session('success'))
    <div class="container mt-4 mb-2">
        <div class="p-3 rounded d-flex align-items-center justify-content-between" style="background-color: #edf7ee; border: 1px solid rgba(22, 101, 52, 0.2); color: #166534; font-size: 13.5px; font-weight: 500; border-radius: var(--radius-cards);">
            <div class="d-flex align-items-center">
                <i class="fa fa-check-circle mr-2" style="font-size: 16px; color: #166534;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="close p-0 ml-3" data-dismiss="alert" aria-label="Close" style="opacity: 0.6; font-size: 18px; line-height: 1; background: none; border: none; color: #166534;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-4 mb-2">
        <div class="p-3 rounded d-flex align-items-center justify-content-between" style="background-color: #fee2e2; border: 1px solid rgba(153, 27, 27, 0.2); color: #991b1b; font-size: 13.5px; font-weight: 500; border-radius: var(--radius-cards);">
            <div class="d-flex align-items-center">
                <i class="fa fa-exclamation-circle mr-2" style="font-size: 16px; color: #991b1b;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="close p-0 ml-3" data-dismiss="alert" aria-label="Close" style="opacity: 0.6; font-size: 18px; line-height: 1; background: none; border: none; color: #991b1b;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="container mt-4 mb-2">
        <div class="p-3 rounded d-flex align-items-start justify-content-between" style="background-color: #fee2e2; border: 1px solid rgba(153, 27, 27, 0.2); color: #991b1b; font-size: 13.5px; border-radius: var(--radius-cards);">
            <div class="d-flex align-items-start">
                <i class="fa fa-exclamation-triangle mr-2 mt-1" style="font-size: 16px; color: #991b1b;"></i>
                <ul class="mb-0 pl-2" style="line-height: 1.5;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="close p-0 ml-3" data-dismiss="alert" aria-label="Close" style="opacity: 0.6; font-size: 18px; line-height: 1; background: none; border: none; color: #991b1b;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
