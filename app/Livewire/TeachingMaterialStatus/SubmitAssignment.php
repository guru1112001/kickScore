<?php

namespace App\Livewire\TeachingMaterialStatus;


use App\Models\TeachingMaterial;
use App\Models\TeachingMaterialStatus;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class SubmitAssignment extends Component implements HasForms
{
    use InteractsWithForms;

    public $teaching_material;

    public ?array $data = [];

    public function mount($teaching_material_id, $batch_id): void
    {
        $this->teaching_material = TeachingMaterial::find($teaching_material_id);
        $material_submission_status = TeachingMaterialStatus::where([
            'user_id' => auth()->user()->id,
            'batch_id' => $batch_id,
            'teaching_material_id' => $teaching_material_id
        ])
            ->first();
        if ($material_submission_status) {
            //dd($material_submission_status);
            $this->form->fill($material_submission_status->toArray());
        } else {

            $s = $this->form->fill(
                [
                    'user_id' => auth()->user()->id,
                    'teaching_material_id' => $teaching_material_id,
                    'batch_id' => $batch_id
                ]
            );
            //dd($s);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id'),
                Forms\Components\Hidden::make('teaching_material_id'),
                Forms\Components\Hidden::make('batch_id'),

                Components\Card::make()
                    ->schema([
                        Components\Placeholder::make('week')
                            ->label('Assignment')
                            ->content($this->teaching_material->name)->columnSpan(2),

                        Components\Placeholder::make('maximum_attempts')
                            ->label('Maximum Attempts')
                            ->content($this->teaching_material->maximum_attempts == -1 ? 'No Limit' : $this->teaching_material->maximum_attempts),


                        Components\Placeholder::make('passingPercentage')
                            ->label('Passing Percentage')
                            ->content($this->teaching_material->passing_percentage . "%"),


                        Components\Placeholder::make('start_submission')
                            ->content($this->teaching_material->start_submission),

                        Components\Placeholder::make('stop_submission')
                            ->content($this->teaching_material->stop_submission),

                    ])->columns(2)  // This specifies that the card should have one column.
                    ->columnSpan([
                        'sm' => 2,
                        'lg' => 3
                    ]),  // Responsive design settings for the card's width
                //Component::html('<p class="text-sm text-gray-500">This is informational text.</p>'),
                Forms\Components\FileUpload::make('file')
                    ->deletable(false)
                    ->downloadable(),
            ])
            ->statePath('data')
            ->model(TeachingMaterialStatus::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = TeachingMaterialStatus::updateOrCreate(
            [
             //   'user_id' => $data['user_id'],
                'user_id' => auth()->user()->id,
                'teaching_material_id' => $data['teaching_material_id'],
                'batch_id' => $data['batch_id'],
            ],
            [
                'file' => $data['file'] ?? null,
            ]
        );
        //$record = TeachingMaterialStatus::create($data);

        $this->form->model($record)
            ->saveRelationships();


        Notification::make()
            ->title('Submitted!')
            ->body('Assignment Submitted Successfully')
            ->success()
            ->send();
        //$this->emit('$refresh');
        $this->redirectRoute('filament.administrator.resources.master.batches.view',
            [
                'record' => $data['batch_id'],
                'tenant' => Filament::getTenant()->id
            ]);
        return;
    }

    public function delete($id, $batch_id)
    {
        $material_submission_status = TeachingMaterialStatus::find($id);

        if ($material_submission_status) {
            $material_submission_status->delete();
            //$this->form->reset(); // Clearing form state after deletion
            session()->flash('message', 'Assignment deleted successfully.');
        } else {

            session()->flash('error', 'Assignment not found.');
        }

        Notification::make()
            ->title('Deleted!')
            ->body('Assignment Deleted Successfully')
            ->success()
            ->send();

        $this->redirectRoute('filament.administrator.resources.master.batches.view', [
            'record' => $batch_id,
            'tenant' => Filament::getTenant()->id
        ]);
        return;
//        $this->form->model($material_submission_status)
//            ->saveRelationships();
    }


    public function render(): View
    {
        return view('livewire.teaching-material-status.submit-assignment');
    }
}
