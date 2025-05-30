<?php

namespace App\View\Components;

use App\Services\ClinicInfoService; // Importa tu servicio
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClinicInfo extends Component
{
    public string $address;

    public array $attentionMonthRanges;

    public array $operatingHourPatterns;

    public array $monthsTranslation;

    public array $daysTranslation;

    /**
     * Create a new component instance.
     */
    public function __construct(ClinicInfoService $clinicInfoService)
    {
        $clinicData = $clinicInfoService->getClinicInfoForIndex();

        $this->address = isset($clinicData['direction']->direction) ? $clinicData['direction']->direction : 'No configurada';
        $this->attentionMonthRanges = $clinicData['attentionMonthRanges'] ?? [];
        $this->operatingHourPatterns = $clinicData['operatingHourPatterns'] ?? [];
        $this->monthsTranslation = $clinicData['monthsTranslation'] ?? [];
        $this->daysTranslation = $clinicData['daysTranslation'] ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.clinic-info');
    }
}
