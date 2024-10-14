<?php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
// use QuestionBankResource\Pages\ListQuestionBank;
use App\Models\QuestionBank;
use Filament\Facades\Filament;
// use App\Filament\Clusters\CourseMaster;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionBankResource\Pages\EditQuestionBank;
use App\Filament\Resources\QuestionBankResource\Pages\ListQuestionBanks;
use App\Filament\Resources\QuestionBankResource\Pages\CreateQuestionBank;
// use App\Filament\Clusters\CourseMaster\Resources\QuestionBankResource\Pages;
// use App\Filament\Clusters\CourseMaster\Resources\QuestionBankResource\RelationManagers;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;
    protected static ?string $navigationGroup = 'Trivia';
    protected static ?string $label = 'Quiz';

    protected static ?string $navigationIcon = 'icon-quiz';

    // protected static ?string $cluster = CourseMaster::class;
    // protected static ?int $navigationSort = 0;
    // protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                ->schema([
                    TextInput::make('name')
                    ->required()
                    ->placeholder('Enter the name ')
                    ->label('Quiz name'),
                    FileUpload::make('image')
                    ->label('Quiz Image'),
                    // ->directory('question_banks/images')
                    // ->image(),
                ])->columnSpan(2)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                    Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                    ->width(300)
                    ->height(100)
                    // ->square()
                    ,
                    Tables\Columns\TextColumn::make('name')
                    ->label('Quiz name')
                    ->extraAttributes(['class'=>'my-quiz'])
                    // ->description(fn(QuestionBank $record) => "QB ID:" . $record->id)
                    ->searchable(),
                ]),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                    
            ])->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            ->recordUrl(
                fn(QuestionBank $record): string => route('filament.administrator.resources.questions.index',
                    ['question_bank_id' => $record])
            )
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //QuestionBankResource::getRelations()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionBanks::route('/'),
            // 'questions' => Pages\ManageQuestions::route('/'),
            'create' => CreateQuestionBank::route('/create'),
            'edit' => EditQuestionBank::route('/{record}/edit'),
            // 'view' => Pages\ManageQuestions::route('/{record}/questions'),
            // 'view' => RelationManagers\QuestionsRelationManager::route('/{record}/questions'),
        ];
    }
}
