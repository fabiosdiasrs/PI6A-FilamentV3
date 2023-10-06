<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Aluno;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Pessoa;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\AlunoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AlunoResource\RelationManagers;
use App\Filament\Resources\AlunoResource\RelationManagers\PessoaRelationManager;

class AlunoResource extends Resource
{
    protected static ?string $model = Aluno::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Aluno')
                    ->tabs([
                        Tab::make('Dados do Aluno')
                            ->schema([
                                TextInput::make('nome')
                                    ->required()
                                    ->maxLength(125),
                                DatePicker::make('dt_nascimento')
                                    ->required()
                                    ->columnspan(1),
                                TextInput::make('ano_escolar')
                                    ->required()
                                    ->maxLength(125),
                                Select::make('Etnia')
                                    ->options([
                                        'p' => 'Pardos',
                                        'b' => 'Brancos',
                                        'n' => 'Negros',
                                        'i' => 'Indigenas',
                                        'a' => 'Amarelos',
                                    ])
                                    ->default('b')
                                    ->selectablePlaceholder(false),
                                Select::make('sexo')
                                    ->options([
                                        'm' => 'Masculino',
                                        'f' => 'Feminino',
                                        'o' => 'Outros',
                                    ])
                                    ->default('m')
                                    ->selectablePlaceholder(false),
                                Select::make('deficiencia_id')
                                    ->relationship('deficiencia','name'),
                                Toggle::make('alfabetizado')
                                    ->required(),
                                Toggle::make('is_deficient')
                                        ->label('É deficiente')
                                        ->required()
                            ])->Columns(3),
                        Tab::make('Endereço do Aluno')
                            ->schema([
                                Select::make('pais_id')
                                    ->relationship('pais', 'name')
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set) => $set('estado_id', null))
                                    ->required(),
                                Select::make('estado_id')
                                    ->options(fn(Get $get): Collection => Estado::query()
                                        ->where('pais_id', $get('pais_id'))
                                        ->pluck('name', 'id'))
                                    ->preload()
                                    ->label('Estado')
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set) => $set('cidade_id', null)),
                                Select::make('cidade_id')
                                    ->options(fn(Get $get): Collection => Cidade::query()
                                        ->where('estado_id', $get('estado_id'))
                                        ->pluck('name', 'id'))
                                    ->preload()
                                    ->label('Cidade')
                                    ->live(),
                                TextInput::make('rua')
                                    ->required()
                                    ->maxLength(125),
                                TextInput::make('cep')
                                    ->required()
                                    ->mask('99999-999')
                                    ->placeholder('xxxxx-xxx')
                                    ->maxLength(125),
                                TextInput::make('complemento')
                                    ->maxLength(125),
                                TextInput::make('Bairro')
                                    ->required()
                                    ->maxLength(125),
                                TextInput::make('numero')
                                    ->required()
                                    ->numeric(),
                            ]),
                        Tab::make('Documentos do Aluno')
                            ->schema([
                                TextInput::make('cpf')
                                ->mask('999.999.999-99')
                                ->placeholder('xxx.xxx.xxx-xx')
                                    ->maxLength(125),
                                TextInput::make('rg')
                                    ->mask('9999999999')
                                    ->placeholder('xxxxxxxxxx')
                                    ->required()
                                    ->maxLength(125),
                            ]),
                        Tab::make('Contatos do Aluno')
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(125),
                                TextInput::make('telefone')
                                    ->mask('(99)99999-9999')
                                    ->placeholder('(xx)xxxxx-xxxx')
                                    ->tel()
                                    ->required()
                                    ->maxLength(125),
                            ]),
                        Tab::make('Mãe')
                            ->schema([
                                Select::make('pessoa_id')
                                    ->relationship('pessoa','nome'),
                            ]),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('dt_nascimento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ano_escolar')
                    ->searchable(),
                    TextColumn::make('telefone')
                    ->searchable(),
                ToggleColumn::make('alfabetizado'),
                ToggleColumn::make('is_deficient')
                    ->label('Deficiente'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('alfabetizado'),
                TernaryFilter::make('is_deficient')
                    ->label('Deficiente'),

            ])
            ->actions([
                EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlunos::route('/'),
            'create' => Pages\CreateAluno::route('/create'),
            'edit' => Pages\EditAluno::route('/{record}/edit'),
        ];
    }
}
