<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntretienResource\Pages;
use App\Filament\Resources\EntretienResource\RelationManagers;
use App\Models\Entretien;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EntretienResource extends Resource
{
    protected static ?string $model = Entretien::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make("Hier")
                        ->schema([
                            // ...
                            Forms\Components\Select::make('employee_id')
                                ->relationship('employee', "last_name")
                                ->searchable(),
                            Forms\Components\Radio::make('type')
                                ->options([
                                    'pro' => 'Professionnel tous les 2 ans',
                                    'bilan' => 'Bilan tous les 6 ans',
                                ])
                                ->label("L’entretien est de type :")

                                // ->required()
                                ->columnSpan(3),
                            Forms\Components\Radio::make('formation_relisee')
                                ->boolean()
                                // ->required()
                                ->label("Des formations ont-elles été réalisées ?")

                                ->columnSpan(2),
                            Forms\Components\TextInput::make("precision_formation")
                                ->label("")
                                ->placeholder("Si oui, précisez...")
                                ->columnSpan(1),
                            Forms\Components\Radio::make('certification_relisee')
                                ->boolean()
                                // ->required()
                                ->label("Des certifications* ou éléments de certifications ont-ils été acquis ?")

                                ->columnSpan(2),
                            Forms\Components\TextInput::make("precision_certification")
                                ->label("")
                                ->placeholder("Si oui, précisez...")
                                ->columnSpan(1),
                            Forms\Components\Radio::make('autre_relisee')
                                ->boolean()
                                // ->required()
                                ->label("D’autres actions ont-elles été menées (bilan de compétences, coaching, CIF, conseil en évolution professionnelle…..) ou des compétences acquises ?")
                                // ->inline()
                                // ->inlineLabel()
                                ->columnSpan(3),
                            Forms\Components\TextInput::make("precision_autre")
                                ->label("")
                                ->placeholder("Si oui, précisez...")
                                ->columnSpan(1),
                            Forms\Components\Hidden::make('filler')->columnSpan(2),
                            Forms\Components\Radio::make('progression_relisee')
                                ->boolean()
                                // ->required()
                                ->label("Y’a-t-il eu progression salariale ou professionnelle, dans l’emploi ou dans l’entreprise ?")
                                ->columnSpan(2),
                            Forms\Components\TextInput::make("precision_progression")
                                ->label("")
                                ->placeholder("Si oui, précisez...")
                                ->columnSpan(1),



                        ])->columns(3),
                    Wizard\Step::make('Aujourd\'hui')
                        ->schema([
                            Forms\Components\Textarea::make('aspiration_court')
                                ->label('Aspiration du salarié à court terme :'),
                            Forms\Components\Textarea::make('aspiration_court_observation')
                                ->label('Observations de l’employeur :'),
                            Forms\Components\Textarea::make('aspiration_moyen')
                                ->label('Aspiration du salarié à court terme :'),
                            Forms\Components\Textarea::make('aspiration_moyen_observation')
                                ->label('Observations de l’employeur :'),
                            Forms\Components\Textarea::make('atouts_freins')
                                ->label('Aspiration du salarié à court terme :'),
                            Forms\Components\Textarea::make('atouts_freins_observation')
                                ->label('Observations de l’employeur :'),

                        ])->columns(2),
                    Wizard\Step::make('Demain')
                        ->schema([
                            // ...
                            Forms\Components\TextInput::make('future_formation')
                                ->label('Formation'),
                            Forms\Components\Textarea::make('future_formation_dispositif')
                                ->label('Dispositif utilisé'),
                            Forms\Components\Textarea::make('future_formation_modalite')
                                ->label('Modalités'),
                            Forms\Components\DatePicker::make('future_formation_date'),

                            Forms\Components\TextInput::make('future_certification')
                                ->label('Certification : diplômes et titres professionnelle, CQP...'),
                            Forms\Components\Textarea::make('future_certification_dispositif')
                                ->label('Dispositif utilisé'),
                            Forms\Components\Textarea::make('future_certification_modalite')
                                ->label('Modalités'),
                            Forms\Components\DatePicker::make('future_certification_date'),

                            Forms\Components\TextInput::make('future_autre')
                                ->label('Autres actions (préciser)'),
                            Forms\Components\Textarea::make('future_autre_dispositif')
                                ->label('Dispositif utilisé'),
                            Forms\Components\Textarea::make('future_autre_modalite')
                                ->label('Modalités'),
                            Forms\Components\DatePicker::make('future_autre_date'),

                            Forms\Components\TextInput::make('future_progression')
                                ->label('Progression dans l\'emploi ou l\'entreprise (salarial ou dans l\'em loi)'),
                            Forms\Components\Textarea::make('future_progression_dispositif')
                                ->label('Dispositif utilisé'),
                            Forms\Components\Textarea::make('future_progression_modalite')
                                ->label('Modalités'),
                            Forms\Components\DatePicker::make('future_progression_date'),
                        ])->columns(4),
                    Wizard\Step::make('Obligation')
                        ->schema([
                            // ...
                            Forms\Components\Radio::make("cpf")
                                ->boolean()

                                ->label("Avez-vous présenté le CPF (compte personnel formation à votre salarié) ?")
                                ->inline(),
                            Forms\Components\Radio::make("cpf_abondement")
                                ->boolean()
                                ->label("Avez-vous parlé de la possibilité du principe de l’abondement sur le CPF à votre salarié ?")
                                ->inline(),
                            Forms\Components\Radio::make("cep")
                                ->boolean()
                                ->label("Avez-vous présenté le CEP (conseil en évolution professionnelle) à votre salarié ?")
                                ->inline(),
                        ]),
                    Wizard\Step::make('Conclusion')
                        ->schema([
                            // ...

                            Forms\Components\Textarea::make('conclusion_employee')
                                ->label('Conclusion de l\'employee :'),
                            Forms\Components\Textarea::make('conclusion_superieur')
                                ->label('Conclusion du Responsable :'),
                        ]),
                ])->columnSpan(1)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('employee.last_name')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('first_name')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('last_name')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('department.name')->sortable(),
                // Tables\Columns\TextColumn::make('date_hired')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntretiens::route('/'),
            'create' => Pages\CreateEntretien::route('/create'),
            'edit' => Pages\EditEntretien::route('/{record}/edit'),
        ];
    }
}
