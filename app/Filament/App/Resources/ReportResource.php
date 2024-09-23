<?php

namespace App\Filament\App\Resources;

use App\Enums\MunicipalityEnum;
use App\Filament\App\Resources\ReportResource\Pages;
use App\Filament\App\Resources\ReportResource\RelationManagers;
use App\Models\ActivityType;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use App\Models\Project;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Reportes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Proyecto')
                    ->columnSpanFull()
                    ->required()
                    ->placeholder(fn(Forms\Get $get): string => empty($get('area_id')) ? 'Primero selecciona un proyecto' : 'Selecciona una opcion')
                    ->options(Project::where('area_id', Auth::user()->area_id)->pluck('description', 'id')),
                Forms\Components\Hidden::make('area_id')
                    ->default(Auth::user()->area_id),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\Repeater::make('Actividades')
                    ->relationship('activities')
                    ->label('Actividades')
                    ->required()
                    ->collapsible()
                    ->columnSpanFull()
                    ->addActionLabel('Agrega otra actividad')
                    ->schema([
                        Forms\Components\TextInput::make('activity_name')
                            ->placeholder('Escriba el nombre de la actividad')
                            ->required()
                            ->label('Nombre de la actividad'),
                        Forms\Components\Select::make('category_id')
                            ->label('Categoria')
                            ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona una categoria' : 'Selecciona una opción')
                            ->options(Category::query()->pluck('name', 'id')),
                        Forms\Components\Textarea::make('activity_goal')
                            ->placeholder('Escriba las metas de las actividad')
                            ->required()
                            ->label('Metas de la actividad'),
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Escriba la descripción')
                            ->required()
                            ->label('Descripción'),
                        Forms\Components\Select::make('activity_type_id')
                            ->label('Tipo de actividad')
                            ->required()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('activity_type_id')) ? 'Primero Selecciona un tipo de actividad' : 'Selecciona una opción')
                            ->options(ActivityType::query()->pluck('name', 'id')),
                        Forms\Components\Select::make('discipline_id')
                            ->label('Tipo de disciplina')
                            ->required()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('discipline_id')) ? 'Primero Selecciona un tipo de disciplina' : 'Selecciona una opción')
                            ->options(Discipline::query()->pluck('name', 'id')),
                        Forms\Components\TextInput::make('author_name')
                            ->label('Nombre del autor')
                            ->required()
                            ->placeholder('Escribe el nombre del autor')
                            ->columnSpan(2),
                        Forms\Components\DatePicker::make('initial_date')
                            ->label('Fecha inicial')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha final')
                            ->required(),
                        Forms\Components\TextInput::make('name_space_held')
                            ->label('Nombre del lugar donde se realizó')
                            ->required()
                            ->placeholder('Escriba el nombre del lugar donde se realizó')
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('locality')
                            ->label('Localidad')
                            ->required(),
                        Forms\Components\Select::make('municipality')
                            ->label('Municipio')
                            ->required()
                            ->options(MunicipalityEnum::class),
                        //Personas

                        Forms\Components\Section::make('Población atendida')
                            ->columns(1)
                            ->schema([
                                Forms\Components\TextInput::make('total')
                                    ->columnSpanFull()
                                    ->placeholder('Escriba la cantidad de personas total')
                                    ->required()
                                    ->integer()
                                    ->label('Total de personas'),
                                Forms\Components\Fieldset::make('Personas')
                                    ->schema([
                                        Forms\Components\TextInput::make('women_total')
                                            ->placeholder('Escriba la cantidad de personas femeninas')
                                            ->required()
                                            ->integer()
                                            ->label('Total de mujeres')
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('men_total')
                                            ->placeholder('Escriba la cantidad de personas masculinas')
                                            ->integer()
                                            ->required()
                                            ->label('Total de hombres')
                                            ->columnSpan(2),

                                    ]),


                                Forms\Components\Fieldset::make('Niñas y niños')
                                    ->schema([
                                        Forms\Components\TextInput::make('children_girls')
                                            ->label('Femenino'),
                                        Forms\Components\TextInput::make('children_boys')
                                            ->label('Masculino'),
                                    ]),
                                Forms\Components\Fieldset::make('Jóvenes')
                                    ->schema([
                                        Forms\Components\TextInput::make('youth_women')
                                            ->label('Femenino'),
                                        Forms\Components\TextInput::make('youth_men')
                                            ->label('Masculino'),
                                    ]),
                                Forms\Components\Fieldset::make('Adultos')
                                    ->schema([
                                        Forms\Components\TextInput::make('adult_women')
                                            ->label('Femenino'),
                                        Forms\Components\TextInput::make('adult_men')
                                            ->label('Masculino'),
                                    ]),
                                Forms\Components\Fieldset::make('Personas mayores')
                                    ->schema([
                                        Forms\Components\TextInput::make('senior_women')
                                            ->label('Femenino'),
                                        Forms\Components\TextInput::make('senior_men')
                                            ->label('Masculino'),
                                    ])

                            ]),

                        Forms\Components\Section::make('Grupo social')
                            ->collapsed()
                            ->description('De ser el caso, grupo social al que va dirigido.')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('social_women')
                                    ->placeholder('Escriba la cantidad de mujeres')
                                    ->label('Mujeres'),
                                Forms\Components\TextInput::make('social_childrens')
                                    ->label('Niños, niñas y jóvenes'),
                                Forms\Components\TextInput::make('social_seniors')
                                    ->placeholder('Escriba la cantidad de adultos mayores')
                                    ->label('Adultos mayores'),
                                Forms\Components\TextInput::make('social_indigenous')
                                    ->label('Indígenas'),
                                Forms\Components\TextInput::make('social_disabled')
                                    ->placeholder('Escriba la cantidad de discapacitados')
                                    ->label('Discapacitados'),
                                Forms\Components\TextInput::make('social_migrants')
                                    ->placeholder('Escriba la cantidad de migrantes')
                                    ->label('Migrantes'),
                                Forms\Components\TextInput::make('social_afrodescendants')
                                    ->placeholder('Escriba la cantidad de afrodescendientes')
                                    ->label('Afrodescendientes'),
                                Forms\Components\TextInput::make('social_incarcerated')
                                    ->label('En reclusión'),
                                Forms\Components\TextInput::make('social_lgbtttiq')
                                    ->placeholder('Escriba la cantidad de personas lgbt+')
                                    ->label('LGBTQ+'),

                            ]),
                        Forms\Components\Select::make('finnancing_source_id')
                            ->label('Fuente de financiamiento')
                            ->columnSpanFull()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('finnancing_source_id')) ? 'Primero Selecciona un tipo de financiamiento' : 'Selecciona una opción')
                            ->options(FinnancingSource::query()->pluck('name', 'id')),

                        Forms\Components\Hidden::make('area_id')
                            ->default((int) Auth::user()->area_id),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.description'),
                Tables\Columns\TextColumn::make('area.name'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pendiente' => 'gray',
                        'En Proceso' => 'warning',
                        'Rechazado' => 'danger',
                        'Aceptado' => 'success'
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
