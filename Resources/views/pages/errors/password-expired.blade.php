<?php
use function Laravel\Folio\{withTrashed, middleware, name, render};
use Livewire\Volt\Component;
//withTrashed();
middleware(['auth']);
name('errors.password-expired');
//Expression "new class extends \Livewire\Volt\Component…" on a separate line does not do anything.
// @phpstan-ignore expr.resultUnused
new class extends Component {};

?>
<x-layouts.marketing>
    {{--  
    @volt('errors.password-expired')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 py-12">
        <h1>..</h1>
        
        
    </div>
    @endvolt
    --}}
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-md">

            @livewire(\Modules\User\Filament\Widgets\PasswordExpiredWidget::class)
        </div>
    </div>
</x-layouts.marketing>
