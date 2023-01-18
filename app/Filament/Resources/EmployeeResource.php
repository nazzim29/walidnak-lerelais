<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeOverview;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                        Forms\Components\Radio::make('sexe')->options(['homme' => 'Homme', 'femme' => 'Femme'])->inline()->columnSpan(2)->required(),
                        Forms\Components\TextInput::make('first_name')->label("Prenom")->required()->maxLength(255),
                        Forms\Components\TextInput::make('last_name')->label("Nom")->required()->maxLength(255),
                        Forms\Components\TextInput::make("phone_number")->label("Numero de telephone")->required(),
                        Forms\Components\DatePicker::make('date_entree')->minDate(now()),
                        Forms\Components\DatePicker::make('birth_date')->label("Date de naissance")->required(),
                        Forms\Components\Select::make('contrat')
                        ->label("Type de contrat")
                        ->options([
                            'cdi' => "CDI",
                            "cdd" => "CDD",
                            "cddi" => "CDDI"
                        ]),
                        Forms\Components\TextInput::make('emploi')
                        ->label("Emploi actuel")
                        ->required(),
                        Forms\Components\Select::make('department_id')
                        ->label("Departement")
                        ->relationship('department', 'name')->required(),
                        Forms\Components\DatePicker::make('date_hired')
                        ->required()
                        ->label("Date d'ancienetté"),
                        ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),
                TextColumn::make('department.name')->sortable(),
                TextColumn::make('date_hired')->date(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('department')->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            EmployeeResource\RelationManagers\EntretiensRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            // EmployeeStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
